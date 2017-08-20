# Pretty URLs

* Get rid of the unsightly ".php" in our URLs, modernizing our app!
* Reduce duplication of code

Modern web applications use magical URLs that don't map 1:1 with files, to make them more dynamic and maintainable.

> Different web servers (e.g. Nginx, Apache) must be configured differently for this to work, but the most popular ones all support it

## Dynamic URLs

By default with our PHP server, if we enter a URL that does not exist, we are sent to `index.php`

We can then look at the `$_SERVER` super-global to find out the page they requested. This value lives in `$_SERVER['PATH_INFO']`

For example, if we visit <http://localhost:8080/add>, `$_SERVER['PATH_INFO']` is set to `/add`

## Steps

1. We will start by creating a Router class. This will take the dynamic URL and map it to our application code:

    ```php
    <?php
    namespace Suggestotron;

    class Router {
        public function start($route)
        {
            $path = realpath("./" . $route . ".php");

            if (file_exists($path)) {
                require $path;
            } else {
                require 'error.php';
            }
        }
    }
    ```

    This will look for a file with the same name as the route and include it, or include an `error.php` file

1. Now we need to re-purpose our `index.php` to use our router, instead of simply showing our list. First, we will move our list to `list.php`:

    ```php
    <?php
    require_once '../src/Suggestotron/Config.php';
    \\Suggestotron\\Config::setDirectory('../config');

    $config = \\Suggestotron\\Config::get('autoload');
    require_once $config['class_path'] . '/Suggestotron/Autoloader.php';

    $data = new \\Suggestotron\\TopicData();

    $topics = $data->getAllTopics();

    $template = new \\Suggestotron\\Template("../views/base.phtml");
    $template->render("../views/index/list.phtml", ['topics' => $topics]);
    ```

1. We then move our template from `views/index/index.phtml` to `views/index/list.phtml`, and update our links to point to `/edit` and `/delete`:

    ```html
    <a href="/edit?id=<?=$topic['id']; ?>" class="btn btn-primary">Edit</a>
    <a href="/delete?id=<?=$topic['id']; ?>" class="btn btn-danger" data-container="">Delete</a>
    ```

    Also, we should update our link to `add.php` in the base template (`base.phtml`):

    ```html
    <a href="/add" class="btn btn-default">
        <span class="glyphicon glyphicon-plus-sign"></span>
        Add Topic
    </a>
    ```

    Finally, update the `<form>` actions in `views/index/add.phtml` and `views/index/edit.phtml`, to point to the correct URLs.

1. Then, we can make the necessary changes to our `index.php`:

    ```php
    <?php
    require_once '../src/Suggestotron/Config.php';
    \\Suggestotron\\Config::setDirectory('../config');

    $config = \\Suggestotron\\Config::get('autoload');
    require_once $config['class_path'] . '/Suggestotron/Autoloader.php';

    if (!isset($_SERVER['PATH_INFO']) || empty($_SERVER['PATH_INFO']) || $_SERVER['PATH_INFO'] == '/') {
        $route = 'list';
    } else {
        $route = $_SERVER['PATH_INFO'];
    }

    $router = new \\Suggestotron\\Router();
    $router->start($route);
    ```

1. Now, if you visit the site, and click around, you will see our URLs are much nicer

    Additionally, we can start to remove some duplicated code, we no longer need to setup our config and our autoloader in each of these files

    Go ahead and remove the following, and you'll see the site still works!

    ```php
    require_once '../src/Suggestotron/Config.php';
    \\Suggestotron\\Config::setDirectory('../config');

    $config = \\Suggestotron\\Config::get('autoload');
    require_once $config['class_path'] . '/Suggestotron/Autoloader.php';
    ```

## Explanation

By programmitically handling our URLs, we can create pretty URLs in any structure we want, without needing to create complex directory structures.

This allows us to share common code between many pages — similiar to our templates — and reduce our applications complexity.

next_step "getting_dry"