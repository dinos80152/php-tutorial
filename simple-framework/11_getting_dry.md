# Getting Dry

* Make our code more DRY by combining similar functionality

## DRY — Don't Repeat Yourself

As developers we try not to repeat ourselves. As you've seen, doing similar things multiple times, means that we have update multiple places when we want to make changes.

By trying to be more DRY, we reduce the number of places where changes need to be made.

## Introducing Controllers

If you try to use one of our old URLs (e.g. <http://localhost:8080/add.php>) you will notice it is now broken!

Because we now have a router, our users should not be accessing these files directly anymore — we *can* solve this by moving the files out of the `public` directory.

**However**, there is another way: Controllers — a special class for containing functionality relating to a specific thing — like Topics.

## Steps

1. Our controller — which could be one of many — will live in the class, `\\Suggestotron\\Controller\\Topics`, and will have one method for each action (list, add, edit, delete) that our application has:

    ```php
    <?php
    namespace Suggestotron\\Controller;

    class Topics {
        public function listAction()
        {

        }

        public function addAction()
        {

        }

        public function editAction()
        {

        }

        public function deleteAction()
        {

        }
    }
    ```

    Our router will call these methods, instead of including our `.php` files.

1. Next, we can migrate the contents of our `.php` files to their respective methods. For example, the `listAction()` would look like this:

    ```php
    public function listAction() {
        $data = new \\Suggestotron\\TopicData();

        $topics = $data->getAllTopics();

        $template = new \\Suggestotron\\Template("../views/base.phtml");
        $template->render("../views/index/list.phtml", ['topics' => $topics]);
    }
    ```

1. Once you have completed all the methods, you will notice there is a lot of repeated code, specifically:

    ```php
    $data = new \\Suggestotron\\TopicData();
    ```

    and:

    ```php
    $template = new \\Suggestotron\\Template("../views/base.phtml");
    ```

    To remove this duplication, we can move those lines to their own method, and assign the objects to properties.

    Because **all** of our actions need this, we can do it automatically in the special `__construct()` method:

    ```php
    protected $data;
    protected $template;

    public function __construct()
    {
        $this->data = new \\Suggestotron\\TopicData();
        $this->template = new \\Suggestotron\\Template("../views/base.phtml");
    }
    ```

    Now we just update the actions, to remove those duplicated lines, and instead of `$data` or `$template` we use `$this->data` and `$this->template` respectively.

    For example, our `addAction` will look like this:

    ```php
    public function addAction()
    {
        if (isset($_POST) && sizeof($_POST) > 0) {
            $this->data->add($_POST);
            header("Location: /");
            exit;
        }

        $this->template->render("../views/index/add.phtml");
    }
    ```

    Notice how small it is now! Just 6 lines of code!

1. Additionally, we have a lot of duplicate paths like `../views/`. Like our Autoloader, we should put this in our configuration.

    Rather than add a whole new file for this, let's just add it to our `config/site.php`:

    ```php
    <?php
    return [
        'title' => 'Suggestotron!',
        'view_path' => realpath('../views')
    ];
    ```

    You probably already noticed that our calls the `$this->template->render()` are very similar in each action.

    We can create a new helper method to simplify this:

    ```php
    protected function render($template, $data = array())
    {
        $config = \\Suggestotron\\Config::get('site');

        $this->template->render($config['view_path'] . "/" . $template, $data);
    }
    ```

    Now update your actions to use the new method instead of `$this->template->render():`

    ```php
    public function listAction()
    {
        $topics = $this->data->getAllTopics();

        $this->render("index/list.phtml", ['topics' => $topics]);
    }
    ```

1. The last thing we need to do is to update the path to the base template, because this needs the config also, lets move that to a property and update our `__construct()` method:

    ```php
    protected $config;

    public function __construct()
    {
        $this->config = \\Suggestotron\\Config::get('site');
        $this->data = new \\Suggestotron\\TopicData();
        $this->template = new \\Suggestotron\\Template($this->config['view_path'] . "/base.phtml");
    }
    ```

    Don't forget to replace `$config` with `$this->config` in our `render()` method.

1. To use our controller, we just update our router:

    ```php
    public function start($route)
    {
        // If our route starts with a /, remove it
        if ($route{0} == "/") {
            $route = substr($route, 1);
        }

        $controller = new \\Suggestotron\\Controller\\Topics();

        $method = [$controller, $route . 'Action'];

        if (is_callable($method)) {
            return $method();
        }

        require 'error.php';
    }
    ```

1. Finally, if you didn't already, you can remove the old `.php` files (except `index.php`!)

## Explanation

By implementing a Controller we have further simplified our code. It should be a goal to keep your code as simple as possible: Future you will thank you.

next_step "multiple_controllers"