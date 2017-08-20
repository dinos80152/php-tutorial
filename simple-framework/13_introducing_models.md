# Introducing Models

* Refactor our database connection code, so we can re-use the connections in many places

A `model` is just a fancy name for a class that specifically encapsulates all functionality related to a thing, e.g. topics, votes, or users.

Our `\\Suggestotron\\TopicData` class, is an example of a model class.

## Managing Database Connections

Currently, we create the database connection every time we instantiate `\\Suggestotron\\TopicData`. However, what if we want multiple instances of the object? What we need the database connection in other models?

We should instead, have a single way to create a single shared connection, that any object can easily re-use.

## Steps

1. We are going to create what is known as a singleton class, which is responsible for managing our connection.

    We will call this class, `\\Suggestotron\\Db`.

    ```php
    <?php
    namespace Suggestotron;

    class Db {
        static protected $instance = null;

        protected $connection = null;
        protected function __construct() {
            $config = \\Suggestotron\\Config::get('database');

            $this->connection = new \\PDO("mysql:host=" .$config['hostname']. ";dbname=" .$config['dbname'], $config['username'], $config['password']);
        }

        public function getConnection()
        {
            return $this->connection;
        }

        static public function getInstance()
        {
            if (!(static::$instance instanceof static)) {
                static::$instance = new static();
            }

            return static::$instance->getConnection();
        }
    }
    ```

    This class sets `__construct()` to protected, which means that it cannot be instantiated outside of this class (or it's children) and therefore requires the use of `\\Suggestotron\\Db::getInstance()` to create a new object.

    `\\Suggestotron\\Db::getInstance()` will check for an existing copy and return that instead if one exists. Otherwise, it creates and stores a new instance.

1. To use our new class, we simply replace all instances of `$this->connection` with `\\Suggestotron\\Db::getInstance()` in our `\\Suggestotron\\TopicData` class, and remove the existing database connection code.

    We can completely remove the following code:

    ```php
    protected $connection = null;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        $config = \\Suggestotron\\Config::get('database');

        $this->connection = new \\PDO("mysql:host=" .$config['hostname']. ";dbname=" .$config['dbname'], $config['username'], $config['password']);
    }
    ```

    Then, our `getAllTopics()` method for instance, will look something like this:

    ```php
    public function getAllTopics()
    {
        $query = \\Suggestotron\\Db::getInstance()->prepare("SELECT * FROM topics");
        $query->execute();
        return $query;
    }
    ```

1. To better organize our code, we're going to rename our `\\Suggestotron\\TopicData` class to identify it as a model, in the same way we do controllers. Therefore, it will be called `\\Suggestotron\\Model\\Topics`.

    First, we will move the file to `/Suggestotron/Model/Topics.php`, and then we will update the namespace, and the class name:

    ```php
    <?php
    namespace Suggestotron\\Model;

    class Topics {
    PHP

    message "Finally, update our `\\Suggestotron\\Controller\\Topics` to use our renamed class."

    source_code :php, <<-PHP
    class Topics extends \\Suggestotron\\Controller {
        protected $data;

        public function __construct()
        {
            parent::__construct();
            $this->data = new \\Suggestotron\\Model\\Topics();
        }
    ```

## Explanation

* You can now access the database connection from **anywhere** using `\\Suggestotron\\Db::getInstance()`.
* Also, our models are now consistently named, similar to controllers.

next_step "completing_suggestotron"