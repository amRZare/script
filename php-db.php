<?php

//Use Mysqli "OOP"

$name_server = 'localhost';
$user = 'amr';
$password = 'p@ssword';
$database = 'db';

//Create Connection:
      $conn = new mysqli($name_server, $user, $password, $database);

// CHECK CONNECTION
       if ($conn->connect_error) {
           die('connection failed'.mysqli_connect_error());
       }

                  echo 'connected';
                                   echo '<br/>';

// CREAT_DATABASE:
      /*$db="CREATE DATABASE `db`";
//CHECK DB CREATED
          if($conn->query($db)=== TRUE){
             echo "database created sucssfuly";
         }else{
           echo "error created database" . $conn->error; }*/

//CREATE TABLE =>
    $table = 'CREATE TABLE `user2`(
        id INT  AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(200) ,
        email VARCHAR(255) NOT NULL UNIQUE,
        password CHAR(40) NOT NULL ,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        update_at DATETIME DEFAULT CURRENT_TIMESTAMP           
             )';

//CHECK TABLE CREATED:
       if ($conn->query($table) === true) {
           echo 'table created sucssfuly';
       } else {
           echo  'error created database'.$conn->error;
       }

//close the connection
      $conn->close();
