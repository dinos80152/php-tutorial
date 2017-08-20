# Multiple Controllers

* Allow our app to grow using multiple controllers
* Automatically route to controllers and actions
* Allow easy setup of routes via configuration

## Multiple Features : Multiple Controllers

As our application grows, we can continue to add more actions to our `\\Suggestotron\\Controller\\Topics` controller but this would make it harder to maintain.

To help our future selves, we should allow for us to separate our features in to multiple controllers.

This means our router needs to be able to tell which controller is being requested, and to call the correct one.

## Steps

1. We are going to start with the configuration as it will determine how our code needs to work.

    Our configuration needs to determine several things:

    * The URL to match
    * The default action, if none is specified
    * The default controller, if none is specified
    * An error controller for when an error is encountered

    Our configuration file, `routes.php`, might look like this:

    ```php
    <?php
    return [
        'default' => '/topic/list',
        'errors' => '/error/:code',
        'routes' => [
            '/topic(/:action(/:id))' => [
                'controller' => '\\Suggestotron\\Controller\\Topics',
                'action' => 'list',
            ],
            '/:controller(/:action)' => [
                'controller' => '\\Suggestotron\\Controller\\:controller',
                'action' => 'index',
            ]
        ]
    ];
    ```

    Here we have defined two routes. Within the path specified, we have variables, which if specified in the URL, will replace the default values within each route.

    In our first route, `/topic(/:action(/:id))`, if a user browses to `/topic/add`, then the `action` will be set to `add`. If they go to just `/topic`, it will be set to the default, `list`.

    In our second route, we have two placeholders, `:controller`, and `:action`. This means that we can now dynamically choose the controller based on the route itself.

    If the were to browse to `/vote`, it will use the `\\Suggestotron\\Controller\\Vote` controller, and call the default `index` action.

1. Now that we have our config, we can use it to re-write our `\\Suggestotron\\Router->start()` method:

    ```php
    class Router {
        protected $config;

        public function start($route)
        {
            $this->config = \\Suggestotron\\Config::get('routes');
    ```

    In our config we defined a default, so our first step is to check if we need to use it:

    ```php
    if (empty($route) || $route == '/') {
        if (isset($this->config['default'])) {
            $route = $this->config['default'];
        } else {
            $this->error();
        }
    }
    ```

    ## Try... Catch

    To help with error handling, we can wrap our code in a `try { } catch { }` block. Whenever an error is encountered, the code within the `catch { }` block is run instead.

1. We are going to use a `try... catch` around our routing, in case something goes wrong!

    ```php
    try {

    } catch (\\Suggestotron\\Controller\\Exception $e) {

    }
    ```

    Inside our `try` block, we will iterate over each of the defined routes, trying to find a match for the URL:

    > Here we are using a regular expression with `preg_replace()` and `preg_match()`. **Regular expressions is a way to match patterns in text.** *We are using a complicated one here, so don't worry if you don't yet understand it!*

    ```php
    try {
        foreach ($this->config['routes'] as $path => $defaults) {
            $regex = '@' . preg_replace(
                '@:([\\w]+)@',
                '(?P<$1>[^/]+)',
                str_replace(')', ')?', (string) $path)
            ) . '@';
            $matches = [];
            if (preg_match($regex, $route, $matches)) {
    ```

    If we find a match, we merge the defaults from our config, with the values specified in the URL:

    ```php
    $options = $defaults;
    foreach ($matches as $key => $value) {
        if (is_numeric($key)) {
            continue;
        }

        $options[$key] = $value;
        if (isset($defaults[$key])) {
            if (strpos($defaults[$key], ":$key") !== false) {
                $options[$key] = str_replace(":$key", $value, $defaults[$key]);
            }
        }
    }
    ```

    Then finally, we check that we have a controller and action, and if valid, we call it:

    ```php
            if (isset($options['controller']) && isset($options['action'])) {
                    $callable = [$options['controller'], $options['action'] . 'Action'];
                    if (is_callable($callable)) {
                        $callable = [new $options['controller'], $options['action'] . 'Action'];
                        $callable($options);
                        return;
                    } else {
                        $this->error();
                    }
                } else {
                    $this->error();
                }
            }
        }
    }
    ```

1. We then call `$this->error()` in our `catch` block:

    ```php
    catch (\\Suggestotron\\Controller\\Exception $e) {
        $this->error();
    }
    ```

1. We must also define the `\\Suggestotron\\Router->error()` method:

    ```php
    public function error()
    {
        if (isset($this->config['errors'])) {
            $route = $this->config['errors'];
            $this->start($route);
        } else {
            echo "An unknown error occurred, please try again!";
        }

        exit;
    }
    ```

1. Now that we have a configured default, we should update `index.php` to no-longer handle this:

    Replace the following:

    ```php
    if (!isset($_SERVER['PATH_INFO']) || empty($_SERVER['PATH_INFO']) || $_SERVER['PATH_INFO'] == '/') {
        $route = 'list';
    } else {
        $route = $_SERVER['PATH_INFO'];
    }
    ```

    With this:

    ```php
    $route = null;
    if (isset($_SERVER['PATH_INFO'])) {
        $route = $_SERVER['PATH_INFO'];
    }
    ```

1. Our first new controller, is going to be our error controller, `\\Suggestotron\\Controller\\Errors`, **however**, now that we will have multiple controllers, this is a good time to refactor again!

    We will first create a base controller, `\\Suggestotron\\Controller`:

    ```php
    <?php
    namespace Suggestotron;

    class Controller {
        protected $config;
        protected $template;

        public function __construct()
        {
            $this->config = \\Suggestotron\\Config::get('site');
            $this->template = new \\Suggestotron\\Template($this->config['view_path'] . "/base.phtml");
        }


        protected function render($template, $data = array())
        {
            $this->template->render($this->config['view_path'] . "/" . $template, $data);
        }
    }
    ```

    Here we have consolidated our common constructor, and our `render()` methods that all controllers will need.

1. Our error controller, will then `extend` our base controller, which means that it will inherit all of it's properties and methods.

    ```php
    <?php
    namespace Suggestotron\\Controller;

    class Error extends \\Suggestotron\\Controller {
        public function indexAction($options)
        {
            header("HTTP/1.0 404 Not Found");
            $this->render("/errors/index.phtml", ['message' => "Page not found!" ]);
        }
    }
    ```

    This simple controller sends the 404 error header, and then renders the appropriate view, `errors/index` which looks like this:

    ```html
    <div class="alert alert-danger">
        <?=$this->message;?>
    </div>
    ```

1. We can now take advantage of the options passed to the action via the URL, making our URLs even prettier!

    We need to update `\\Suggestotron\\Controller\\Topics` so that each action can take an argument, `$options`, and for our edit/delete methods, we can now switch to using `$options['id']` instead of `$_GET['id']`.

    Additionally, be sure to correct any `header()` redirects, to point to the new locations:

    For example, the delete action, will look like this:

    ```php
    public function deleteAction($options)
    {
        if (!isset($options['id']) || empty($options['id'])) {
            echo "You did not pass in an ID.";
            exit;
        }

        $topic = $this->data->getTopic($options['id']);

        if ($topic === false) {
            echo "Topic not found!";
            exit;
        }

        if ($this->data->delete($options['id'])) {
            header("Location: /");
            exit;
        } else {
            echo "An error occurred";
        }
    }
    ```

    ## Prettier URLs

    With these new changes, our URLs are now as follows:

    * **List Topics:** <http://localhost:8080/> *or* <http://localhost:8080/topic/list>
    * **New Topic:** <http://localhost:8080/topic/add>
    * **Edit Topic:** <http://localhost:8080/topic/edit/1> (where `1` is our topic ID)
    * **Delete Topic:** http://localhost:8080/topic/delete/1 (where `1` is our topic ID)

    We should update our views, to reflect these new URLs.

1. In our `base.phtml`, our *Add Topic* link, should now point to `/topic/add`:

    ```html
    <a href="/topic/add" class="btn btn-default">
        <span class="glyphicon glyphicon-plus-sign"></span>
        Add Topic
    </a>
    ```

1. In our `index/list.phtml`, our links should be updated:

    ```html
    <a href="/topic/edit/<?=$topic['id']; ?>" class="btn btn-primary">Edit</a>
    <a href="/topic/delete/<?=$topic['id']; ?>" class="btn btn-danger" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-title="Are you sure?" data-content=" This cannot be undone!">Delete</a>
    ```

    Notice how we now use `/topic/<action>/<id>` as our URL, *no more `GET` arguments!*

1. Almost there! We just need to update our `<form>` tags.

    In `index/add.phtml`:

    ```html
    <form action="/topic/add" method="POST">
    ```

    In `index/edit.phtml`:

    ```html
    <form action="/topic/edit" method="POST">
    ```

1. Our final step, is to update our existing controller, `\\Suggestotron\\Controller\\Topics`, to use the new base controller:

    Just like with `\\Suggestotron\\Controller\\Errors`, we `extend` the base controller.

    ```php
    class Topics extends \\Suggestotron\\Controller {
    ```

    Then we can start removing the now-duplicated code.

    ```php
    protected $template;
    protected $config;
    ```

    Our constructor can be simplified too:

    ```php
    public function __construct()
    {
        parent::__construct();
        $this->data = new \\Suggestotron\\TopicData();
    }
    ```

    > We use a special method called, `parent::__construct()` to call the `\\Suggestotron\\Controller->__construct()` method.

    We can also remove the `render()` function entirely.

## Explanation

By adding the ability for multiple controllers, we have given ourselves a structure in to which we can continue to add new features to our application easily.

next_step "introducing_models"
