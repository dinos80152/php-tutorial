<?php

include('User.php');
include('user_helper.php');

$user = new User;

$start_time = microtime(true);

$users = $user->findByNameUsingStrpos('abcd'); // NO.1
// $users = $user->findByNameUsingPreg('abcd'); //NO.2

// $users = $user->findByNameUsingForWithCount('abcd'); // NO.1
// $users = $user->findByNameUsingForWithNonCount('abcd'); // NO.2
// $user->findByNameUsingForWithCountWithoutQuote('abcd'); //NO.3

// $users = $user->all();

// foreach($users as $user) {
    // hasNameUsingEmpty($user['name']); // NO.1
    // hasNameUsingStrlen($user['name']); // NO.2
    // hasNameUsingEqual($user['name']); // NO.3

    // $has_more_data = hasMoreDataUsingIsset($user); // No.1
    // $has_more_data = hasMoreDataUsingIsArray($user); // No.2

    // hasUserUsingEmpty($user); // No.1
    // hasUserUsingEmptyArray($user); // No.2
    // hasUserUsingCount($user); // No.3
// }

// upperFirstCharByFor($users); // No.1
// upperFirstCharByForeach($users); // No.2
// upperFirstCharByArrayMap($users); // No.3

$end_time = microtime(true);

echo $end_time - $start_time;

echo "\n";

echo "total: " . count($users);