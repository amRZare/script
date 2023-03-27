<?php
//connect to database from php

//start connect
$ser = "localhost";
$user = "amr";
$pass = "p@ssword";
$db = "site";
$conn = mysqli_connect($ser,$user,$pass,$db);
if(! $conn){
    die("connection failed:" . mysqli_connect_error());
} 
echo "connected sucssfully"."<br/>"."<br/>";


//operation & query
$query = " SELECT * FROM `users` ";

$result = mysqli_query($conn,$query);

// data saved in $result we need loop to type it
while($raw = mysqli_fetch_assoc($result)){
    echo "Id:" . $raw['id']  . "<br/>" ;
    echo "Name:" .  $raw['name'] . "<br />" ;
    echo "Email:" . $raw['email']  . "<br/>" ;
    echo str_repeat("-", 100)  . "<br/>";
}

//closed connection
mysqli_free_result($result);
mysqli_close($conn);
