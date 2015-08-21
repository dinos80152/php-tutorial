<?php
class User
{

    private $users = [];

    public function __construct()
    {
        $this->setUsers();
    }

    private function setUsers()
    {
        $this->users = json_decode(file_get_contents('users.json'), true);
    }

    public function all()
    {
        return $this->users;
    }

    public function findByNameUsingStrpos($name)
    {

        $user_matches = array_filter($this->users, function ($user) use ($name) {
            return strpos($user['name'], $name) !== false;
        });

        return $user_matches;
    }

    public function findByNameUsingPreg($name)
    {

        $user_matches = array_filter($this->users, function ($user) use ($name) {
            return preg_match("/$name/", $user['name']);
        });

        return $user_matches;
    }

    public function findByNameUsingForWithCount($name)
    {
        $user_matches = [];

        $user_amount = count($this->users);
        for ($i = 0; $i < $user_amount; $i++) {
            if(strpos($this->users[$i]['name'], $name)) {
                array_push($user_matches, $this->users[$i]);
            }
        }

        return $user_matches;
    }

    public function findByNameUsingForWithNonCount($name)
    {
        $user_matches = [];

        for ($i = 0; $i < count($this->users); $i++) {
            if(strpos($this->users[$i]['name'], $name)) {
                array_push($user_matches, $this->users[$i]);
            }
        }

        return $user_matches;
    }

    public function findByNameUsingForWithCountWithoutQuote($name)
    {
        $user_matches = [];

        $user_amount = count($this->users);
        for ($i = 0; $i < $user_amount; $i++) {
            if(strpos($this->users[$i][name], $name)) {
                array_push($user_matches, $this->users[$i]);
            }
        }

        return $user_matches;
    }
}