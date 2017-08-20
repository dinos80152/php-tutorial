# Deleting Topics

* Be able to delete topics from the database

  Now nobody will see your mistakes!

> Deleting is very similar to editing or creating, so we'll make this brief!

## Steps

1. First, we modify our `foreach` to include a Delete link, pointing to `delete.php`:

    ```php
    <?php
    foreach ($topics as $topic) {
        echo "<h3>" .$topic['title']. " (ID: " .$topic['id']. ")</h3>";
        echo "<p>";
        echo nl2br($topic['description']);
        echo "</p>";
        echo "<p>";
        echo "<a href='/edit.php?id=" .$topic['id']. "'>Edit</a>";
        echo " | ";
        echo "<a href='/delete.php?id=" .$topic['id']. "'>Delete</a>";
        echo "</p>";
    }
    ```

1. Then we create `delete.php`, which will delete the topic, and then redirect back to `index.php` again

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

    if ($data->delete($_GET['id'])) {
        header("Location: /index.php");
        exit;
    } else {
        echo "An error occurred";
    }
    ```

1. Finally, we add our `TopicData->delete()` method:

    ```php
    public function delete($id) {
        $query = $this->connection->prepare(
            "DELETE FROM topics
                WHERE
                    id = :id"
        );

        $data = [
            ':id' => $id,
        ];

        return $query->execute($data);
    }
    ```

1. Once again, you can check this out in your browser. Try going to topic list and deleting the new topic you added earlier:

    <http://localhost:8080/>

## Explanation

By now, you've should have a pretty good handle on how this works.

You're able to create, retrieve, update, and delete rows from the database, this is known as **CRUD**, and is something you will find in almost every application.

next_step "styling_suggestotron"