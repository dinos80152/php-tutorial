# Creating a Database

* Lets create our Suggestotron database add some example data

## steps

1. Run the MySQL command line tool

    ```bash
    mysql -u root -p"
    ```

    You will be prompted for a password. The password is `root`.

    > Using the root username for a real website is a *bad idea*. For more information on adding a new user, see [this tutorial](https://www.digitalocean.com/community/articles/how-to-create-a-new-user-and-grant-permissions-in-mysql).

1. Create your database

    ```sql
    CREATE DATABASE suggestotron;
    USE suggestotron;
    ```

1. Next, create our table, it's going to look like this:
        model_diagram header: 'topics', fields: %w(id title description)

    ```sql
    CREATE TABLE topics (
        id INT unsigned NOT NULL AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        description TEXT NULL,
        PRIMARY KEY(id)
    );
    ```

1. Now we can insert our test data
    ```sql
    INSERT INTO topics (
        title,
        description
    ) VALUES (
        'Make Rainbow ElePHPants',
        'Create an elePHPant with rainbow fur'
    );

    INSERT INTO topics (
        title,
        description
    ) VALUES (
        'Make Giant Kittens',
        'Like kittens, but larger'
    );

    INSERT INTO topics (
        title,
        description
    ) VALUES (
        'Complete PHPBridge',
        'Because I am awesome'
    );
    ```

    After each `INSERT` you will see something like:

    ```bash
    Query OK, 1 row affected (0.02 sec)
    ```

1. To view our data, we can `SELECT` it from the table:
    ```sql
    SELECT * FROM topics;
    ```

    ```bash
    +----+-------------------------+--------------------------------------+
    | id | title                   | description                          |
    +----+-------------------------+--------------------------------------+
    |  1 | Make Rainbow ElePHPants | Create an elePHPant with rainbow fur |
    |  2 | Make Giant Kittens      | Like kittens, but larger             |
    |  3 | Complete PHPBridge      | Because I am awesome                 |
    +----+-------------------------+--------------------------------------+
    3 rows in set (0.00 sec)
    ```

1. We are done with the database for now. To quit, type the following:

    ```bash
    \q
    ```

## Explanation

You have now create your first database, your first table, *and* your first rows of data!

We will be accessing this data via our PHP code in our application. Not only will our application be able to read it, but it will be able to create new data, edit, and delete existing data.

next_step "creating_a_data_class"