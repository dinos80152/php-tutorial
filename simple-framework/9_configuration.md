# Configuration

* Create a simple, global, configuration file to allow you to easily customize your application

  A configuration file is critical for allowing you to do things like moving your site between servers

## Steps

1. The first thing we will do is add a `config` directory, at the same level as `src` and `views`, and place an `autoload.php` file within it:

    ```php
    <?php
    return [
        'class_path' => realpath('../src')
    ];
    ?>
    ```

1. Next, we will create our `\\Suggestotron\\Config` class in `src/Suggestotron/Config.php`:

    ```php
    <?php
    namespace Suggestotron;

    class Config {
        static public $directory;
        static public $config = [];

        static public function setDirectory($path)
        {
            self::$directory = $path;
        }

        static public function get($config)
        {
            $config = strtolower($config);

            self::$config[$config] = require self::$directory . '/' . $config . '.php';

            return self::$config[$config];
        }
    }
    ```

    To use the `\\Suggestotron\\Config` class we must still include it manually, to setup everything else

    ```php
    <?php
    require_once '../src/Suggestotron/Config';
    \\Suggestotron\\Config::setDirectory('../config');
    ```

    Once you have done this, the configuration is available everywhere using:

    ```php
    $config = \\Suggestotron\\Config::get('autoload');
    ```

1. Next, we will update our autoloader to use the configuration settings:

    ```php
    $config = \\Suggestotron\\Config::get('autoload');

    $file = $config['class_path'] . '/' . str_replace("\\\\", "/", $className) . '.php';
    ```

1. Then, update each of our `index.php`, `add.php`, `edit.php`, `delete.php` files to use the config:

    ```php
    <?php
    require_once '../src/Suggestotron/Config.php';
    \\Suggestotron\\Config::setDirectory('../config');

    $config = \\Suggestotron\\Config::get('autoload');
    require_once $config['class_path'] . '/Suggestotron/Autoloader.php';
    ```

1. Other configuration options, might be your database, for example. Now create a `config/database.php`:

    ```php
    <?php
    return [
        "username" => "root",
        "password" => "root",
        "hostname" => "localhost",
        "dbname" => "suggestotron",
    ];
    ```

1. Then just update our `\\Suggestotron\\TopicData` class to use the configuration:

    ```php
    public function connect()
    {
        $config = \\Suggestotron\\Config::get('database');

        $this->connection = new \\PDO("mysql:host=" .$config['hostname']. ";dbname=" .$config['dbname'], $config['username'], $config['password']);
    }
    ```

1. Let us add one more configuration file, for customizing our Suggestotron, `config/site.php`:

    ```php
    <?php
    return [
        "title" => "Suggestotron"
    ];
    ```

1. Finally, lets update our base template, `views/base.phtml`:

    At the top, first get the configuration:

    ```php
    <?php
    $config = \\Suggestotron\\Config::get('site');
    ?>
    <!doctype html>
    ```

    Then, update the `<title>` to use the configuration option:

    ```php
    <title><?=$config['title'];?></title>
    ```

    Now, if you change the configuration file, your page title will automatically update everywhere. Go ahead, play!

next_step "pretty_urls"