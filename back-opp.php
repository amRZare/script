<?php

//validation
$error_fild = [];

if (!(isset($_POST['name']) && !empty($_POST['name']))) {
    $error_fild[] = 'name';
}
if (!(isset($_POST['email']) && filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))) {
    $error_fild[] = 'email';
}
if (!(isset($_POST['password']) && strlen($_POST['password']) > 5)) {
    $error_fild[] = 'password';
}

if ($error_fild) {
    header('location:front/form-oop.php?error_fild= ,'.implode(',', $error_fild));
    exit;
}

//connect to DBl
$connect = new mysqli('localhost', 'amr', 'p@ssword', 'db');
  if ($connect->connect_error) {
      die('connect error'.$connect->connect_error); //check connection
  }
//Escape any sepcial characters to avoid sQl Injection
$Name = $connect->real_escape_string($_POST['name']);
$Email = $connect->real_escape_string($_POST['email']);
$Password = $connect->real_escape_string($_POST['password']);

//Insert the Data
$query = " INSERT INTO `user2` (`name`,`email`,`password`)
         VALUES('".$Name."','".$Email."','".$Password."')";
if ($connect->query($query) == true) {
    printf("%d Row inserted.\n", $connect->affected_rows);
    echo "you'r in the home";
}
//close connection
$connect->close();
