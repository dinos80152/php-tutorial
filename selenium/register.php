<?php
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];

$name = $firstName . ' ' . $lastName;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <?php echo $name; ?>
</body>
</html>