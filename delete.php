<?php

//connect to DB

$connect = new mysqli('localhost', 'amr', 'p@ssword', 'site');
if ($connect->connect_error) {
    die('connect failed'.$connect->connect_error);
}

//select user from GET
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$query = 'DELETE FROM `users` WHERE `users`.`id`='.$id.' LIMIT 1';
if ($connect->query($query)) {
    header('location:list.php');
    exit;
} else {
    echo $connect->connect_error;
}

//close query
$connect->close();
