# Editing Topics

* Allow users to edit topics

  Let users change existing data

## Steps

1. Let us add an edit link for each Topic

    In `index.php` change our foreach to include the link:

    ```php
    <?php
    foreach ($topics as $topic) {
        echo "<h3>" .$topic['title']. " (ID: " .$topic['id']. ")</h3>";
        echo "<p>";
        echo nl2br($topic['description']);
        echo "</p>";
        echo "<p><a href='/edit.php?id=" .$topic['id']. "'>Edit</a></p>";
    }
    ```

    The link has been added at the end of our `foreach`. The link has an argument for the `id`.

    > URL arguments are known as `GET` arguments. They are added to the URL after a `?` and can be found in the `$_GET` superglobal array (just like `$_POST`). Multiple arguments are separated by an `&`.

1. Next create another new page, `edit.php`, and add an edit form. This will look almost identical to your new topic form:

    ```html
    <h2>Edit Topic</h2>
    <form action="edit.php" method="POST">
        <label>
            Title: <input type="text" name="title" value="<?=$topic['title'];?>">
        </label>
        <br>
        <label>
            Description:
            <br>
            <textarea name="description" cols="50" rows="20"><?=$topic['description'];?></textarea>
        </label>
        <br>
        <input type="hidden" name="id" value="<?=$topic['id'];?>">
        <input type="submit" value="Edit Topic">
    </form>
    ```

    We use echo tags `<?=$variable;?>` to output the current values into the form, and a hidden input to submit the topics ID back to the server, so we know which one we are editing.

1. Then we need to fetch the requested topic, so that we can fill in the data.

    We do this, by adding a `getTopic()` method to our `TopicData` class.

    ```php
    public function getTopic($id)
    {
        $sql = "SELECT * FROM topics WHERE id = :id LIMIT 1";
        $query = $this->connection->prepare($sql);

        $values = [':id' => $id];
        $query->execute($values);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
    ```

    Here, we introduce a `LIMIT 1` to ensure only one row is returned. We then use `$query->fetch(PDO::FETCH_ASSOC)` to return just the single row as an array.

    ```bash
    array(3) {
        ["id"]=>
        string(1) "3"
        ["title"]=>
        string(18) "Complete PHPBridge"
        ["description"]=>
        string(20) "Because I am awesome"
    }
    ```

1. Now that you have a way to get the topic, we can use it in `edit.php` by adding the following at the top:

    ```php
    <?php
    require 'TopicData.php';

    $data = new TopicData();
    $topic = $data->getTopic($_GET['id']);
    ```

    At this point, you should be able to see your topic data in the edit form, but if you submit the form nothing will change (yet).

1. We don't yet have any error checking in case a user tries to visit a link with a bad ID, or without an ID. Go ahead and play with the URL to see what happens!

    Here are some example URLs:

    * No ID: <http://localhost:8080/edit.php>
    * Invalid ID: <http://localhost:8080/edit.php?id=1337>

1. We can handle this by adding some extra checks in to your code:

    ```php
    <?php
    require 'TopicData.php';

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "You did not pass in an ID.";
        exit;
    }

    $data = new TopicData();
    $topic = $data->getTopic($_GET['id']);

    if ($topic === false) {
        echo "Topic not found!";
        exit;
    }
    ```

    We use `isset`, and `empty` to check that the variable exists, and has a value

    We also check, to make sure that we did not get a `false` response from `TopicData->getTopic()` which would mean that no topic was found

1. Now that we have our form, we can go ahead and update the row in the database. First, lets add an `TopicData->update()` method

    ```php
    public function update($data)
    {
        $query = $this->connection->prepare(
            "UPDATE topics
                SET
                    title = :title,
                    description = :description
                WHERE
                    id = :id"
        );

        $data = [
            ':id' => $data['id'],
            ':title' => $data['title'],
            ':description' => $data['description']
        ];

        return $query->execute($data);
    }
    ```

1. Finally, like with adding topics, we need to call it in `edit.php` by adding the following under the `require 'TopicData.php';`:

    ```php
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $data = new TopicData();
        if ($data->update($_POST)) {
            header("Location: /index.php");
            exit;
        } else {
            echo "An error occurred";
            exit;
        }
    }
    ```

    Once you've made this change, check it out in your browser!

    <http://localhost:8080/edit.php?id=2>

## Explanation

Similar to when our users created topics, we take our users input, `$_POST`, but this time we perform an `UPDATE` SQL command.

Also, we've started to add some input validation, which is critical for security!

next_step "deleting_topics"