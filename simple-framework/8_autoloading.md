# Autoloading

**We keep repeating ourselves!**

  In each of our files we have these repetetive `require "../src/Suggestotron/*.php"` lines. What if we could get rid of them?

* Make our code simpler, and easier to write, using autoloading

  An autoloader will automatically load your classes when you need them!

## Steps

1. An autoloader is just a simple function that will automatically find and load a class based on its name

    We will place our autoloader in `src/Suggestotron/Autoloader.php`:

    ```php
    <?php
    namespace Suggestotron;

    class Autoloader {
        public function load($className)
        {
            $file = __DIR__  . "/../" . str_replace("\\\\", "/", $className) . '.php';

            if (file_exists($file)) {
                require $file;
            } else {
                return false;
            }
        }

        public function register()
        {
            spl_autoload_register([$this, 'load']);
        }
    }

    $loader = new Autoloader();
    $loader->register();
    ```

    > This autoloader is as simple as possible, but will *not* handle every situation. We highly recommend learning about [Composer](http://getcomposer.org) as it will automate most of this for you!

1. We can replace all our other `require` statements, with a single `require` for the autoloader itself:

    ```php
    require '../src/Suggestotron/Autoloader.php';
    ```

    Make this change in `index.php`, `add.php`, `edit.php` and `delete.php`.

## Explanation

Now that we have an autoloader, every time we use `new \\Some\\ClassName` it will try to autoload by passing the name to the `\\Suggestotron\\Autoloader->load()` method automatically.

next_step "configuration"