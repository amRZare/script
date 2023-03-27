<?php

session_start();
$_SESSION = []; //empty session
session_destroy(); //delete session file from server
header('location: /web/admin/login.php'); //return session file to login page
