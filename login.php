<?php
//session
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'post') {
    //CONNECT DB
    $CONN = new mysqli('localhost', 'amr', 'p@ssword', 'site');
    if ($CONN->connect_error) {
        die('field connect'.$CONN->connect_error);
    }
    //Escape any special character to SQL injection
    $email = mysqli_escape_string($CONN, $_POST['email']);
    $password = sha1($_POST['password']);

    //select query
    $query = "SELECT * FROM `users` WHERE `email`='".$email."' and `password`='".$password."' LIMIT 1";
    $result = $CONN->query($query);
    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['email'] = $row['email'];
        header('location: /web/admin/list.php');
        exit();
    } else {
        $errors = ' Invalid email or password ';
    }
    //clos connection
    mysqli_free_result($result);
    $CONN->close();
}
?>


<html>
    <head>
        <title> login </title>
    </head>

    <body>
           <?php if (isset($errors)) echo $errors; ?>  <!--check for any errors-->
    
 
        <form method="post">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?=(isset($_POST['email'])) ? $_POST['email'] : ''; ?>"  />
               <br/>
            
            <label for="password" >password</label>
            <input type="password" name="password" id="password" />   <br/>
            <br/>

            <input type="submit" name="submit" value="login"/>
        </form>
    </body>
</html> 