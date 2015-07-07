<?php
function hasMoreDataUsingIsset($user) {
    return isset($user['more']) && is_array($user['more']);
}

function hasMoreDataUsingIsArray($user) {
    return is_array($user['more']);
}

function isArrayEmptyUsingCount($array) {
    return count($array) === 0;
}

function isArrayEmptyUsingEmpty($array) {
    return empty($array);
}

function hasNameUsingEmpty($name)
{
    return !empty($name);
}

function hasNameUsingEqual($name)
{
    return !$name == "";
}

function hasNameUsingStrlen($name)
{
    return strlen($name);
}

function hasUserUsingCount($user)
{
    return !count($user) === 0;
}

function hasUserUsingEmpty($user)
{
    return !empty($user);
}

function hasUserUsingEmptyArray($user)
{
    return !$user === [];
}

function upperFirstCharByFor($users)
{
    $user_amount = count($users);
    for($i = 0; $i < $user_amount; $i++) {
        $users[$i]['name'] = ucfirst($users[$i]['name']);
    }
    return $users;
}

function upperFirstCharByForeach($users)
{
    foreach($users as &$user) {
        $user['name'] = ucfirst($user['name']);
    }
    return $users;
}

function upperFirstCharByArrayMap($users)
{
    array_walk($users, function (&$user) {
        $user['name'] = ucfirst($user['name']);
    });

    return $users;
}