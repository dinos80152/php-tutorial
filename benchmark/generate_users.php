<?php

$users = [];

for($i = 0; $i < 100000; $i++) {
    $users[$i] = [
        'id' => $i + 1,
        'name' => naming('')
    ];

    if($i % 10 === 0) {
        $users[$i]['more'] = [];
    }
}

file_put_contents('users.json', json_encode($users));

function naming($name)
{
    $char_str = 'abcdefghijklmnopqrstuvwxyz';

    static $chars = [];
    static $name_length;

    if(empty($chars)) {
        $chars = str_split($char_str);
    }

    if(strlen($name) >= $name_length) {
        $name_length = mt_rand(0, 10);
        return $name;
    } else {
        return naming($name . $chars[mt_rand(0, 25)]);
    }
}