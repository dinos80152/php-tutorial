# Adding Topics

* Create a way for users to add their own topics to the database

  Now we are adding some interactivity to our site!

## Steps

1. Create a new file, called `add.php` in the `public` directory

    Then we will add an HTML form:

    ```html
    <h2>New Topic</h2>
    <form action="add.php" method="POST">
        <label>
            Title: <input type="text" name="title">
        </label>
        <br>
        <label>
            Description:
            <br>
            <textarea name="description" cols="50" rows="20"></textarea>
        </label>
        <br>
        <input type="submit" value="Add Topic">
    </form>
    ```

    You can browse to this file at <http://localhost:8080/add.php>

    When you click on "Add Topic", the form will be submitted back to the server

    Adding the following will let you see what was sent

    ```php
    <?php
        var_dump($_POST);
    ?>
    ```

    > We are using a `POST` action in our `<form>`, therefore the data will be available in the `$_POST` super global.

1. Now that we have our data, we can go ahead and save it in our database.

    Add the following the top of `add.php`:

    ```php
    <?php
    require 'TopicData.php';

    if (isset($_POST) && sizeof($_POST) > 0) {
        $data = new TopicData();
        $data->add($_POST);
    }
    ```

    Submitting the form in your browser will now show this:

    ```
    Fatal error: Call to undefined method TopicData::add() in /var/www/suggestotron/public/add.php on line 6
    ```

    Don't worry! This is because we haven't added a `TopicData->add()` method yet. We will do that next!

1. Going back to our `TopicData` class, add the `add` method:

    > For security, we are using a prepared query to ensure our data is escaped securely before sending it to our database

    ```php
    public function add($data)
    {
        $query = $this->connection->prepare(
            "INSERT INTO topics (
                title,
                description
            ) VALUES (
                :title,
                :description
            )"
        );

        $data = [
            ':title' => $data['title'],
            ':description' => $data['description']
        ];

        $query->execute($data);
    }
    ```

    > Notice how we're using the same `INSERT` SQL code from earlier

1. If you submit your form now, you will see another error:

    ```
    Fatal error: Call to a member function prepare() on a non-object in /var/www/suggestotron/public/TopicData.php on line 20
    ```

    This is because we **forgot** to call `TopicData->connect()`. Wouldn't it be nice if we didn't even *have* to remember this?

    We can do this by using a special method called `__construct`. This is known as the constructor and is *automaticlly called* whenever we create a `new` instance of the class.

    ```php
    public function __construct()
    {
        $this->connect();
    }
    ```

    Now, whenever we call `new TopicData()` it will automatically connect to the database

1.  **Now** when you submit your form, it will save the topic, yay! You can verify this by looking at `index.php`, <http://localhost:8080>

1. We can automatically forward our users to the list by using the `header()` method with a `Location: /url` argument.

    Add the following after the call to `$data->add($_POST)`:

    ```php
    header("Location: /");
    exit;
    ```

    Once we send the header, we must be sure to `exit;` so no other code is run.

## Explanation

Our users can now add their own topics, no SQL knowledge required!

We taking the users input from an HTML form, `$_POST`, and using `INSERT` to add it to our database.

next_step "editing_topics"