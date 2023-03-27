<?php

//validation
$error_field = [];

if (!(isset($_POST['name']) && !empty($_POST['name']))) {
    $error_field[] = 'name';
}

if (!(isset($_POST['email']) && filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))) {
    $error_field[] = 'email';
}

if (!(isset($_POST['password']) && strlen($_POST['password']) > 5)) {
    $error_field[] = 'password';
}

if ($error_field) {
    header('location:regist.php?error_field= '.join(',', $error_field));
    exit;
}

//connect to DB
//$connect = mysqli_connect("ip", "user_name", "password", "DB name");
$conn = mysqli_connect('localhost', 'amr', 'p@ssword', 'site');
if (!$conn) {
    echo mysqli_connect_error();
    exit;
}

//Escape any sepcial characters to avoid sQl Injection
$Name = mysqli_escape_string($conn, $_POST['name']);
$Email = mysqli_escape_string($conn, $_POST['email']);
$Password = mysqli_escape_string($conn, $_POST['password']);

//Insert the Data
$query = " INSERT INTO `users`(`name`,`email`,`password`) VALUES ('".$Name."','".$Email."','".$Password."');";
if (mysqli_query($conn, $query)) {
    echo '------- thankyou man ------';
} else {
    // echo $query;
    echo mysqli_error($conn);
}

//close connection

mysqli_close($conn);
