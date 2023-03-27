<?php

$error_fild = [];

 //connect to DB
        $connect = new mysqli('localhost', 'amr', 'p@ssword', 'site');
        if ($connect->connect_error) {
            die('connect error'.$connect->connect_error); //check connection
        }
 //select the user
 // edit.php?id=1 => GET_['id']
 $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
 $Select = ' SELECT * FROM `users` WHERE `users` . `id`= '.$id.' LIMIT  1 ';
 $result = $connect->query($Select);
 $row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //validation
    if (!(isset($_POST['name']) && !empty($_POST['name']))) {
        $error_fild[] = 'name';
    }
    if (!(isset($_POST['email']) && filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))) {
        $error_fild[] = 'email';
    }
    if (!(isset($_POST['password']) && strlen($_POST['password']) > 5)) {
        $error_fild[] = 'password';
    }

    if (!$error_fild) {
        //Escape any special characters to avoid sQl Injection
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $Name = $connect->real_escape_string($_POST['name']);
        $Email = $connect->real_escape_string($_POST['email']);
        $Password = (!empty($_POST['password'])) ? sha1($_POST['password']) : $row(['password']);
        $admin = (isset($_POST['admin'])) ? 1 : 0;

        //UPDATE DATA (edit user)

        $query = " UPDATE `users` SET `name`='".$Name."' , `email`='".$Email."' , `password`='".$Password."' , `admin`= ".$admin."
        WHERE `users`.`id`= ".$id ;
        /*" UPDATE  `users` 
        SET (`name`,`email`,`password`,`admin`)  VALUE ('".$Name."','".$Email."','".$Password."','".$admin."')
        WHERE  `users` .`id` =".$id;*/

        if ($connect->query($query) == true) {
            header('location:list.php');   //redirect to list.php to show new user
            exit;
        } else {
            echo  $connect->connect_error;
        }
    } //error field
} //if $_server

        //close connection
        $result->free_result();
        $connect->close();
?>

<html>
    <head>
        <title>
            Admin :: Edit User </title>
    </head>

     <body>
           <form  method="post" >

           <label for="name">Name</label>
           <input type="text" name="name" id="name" value="<?= (isset($row['name'])) ? $row['name'] : ''; ?>"/>
         <?php if (in_array('name', $error_fild)) {
    echo '*please inter name';
} ?> 

        <!--add hidden input-->
        <input type="hidden" name="id" id="id" value="<?= (isset($row['id'])) ? $row['id'] : ''; ?> " /><br />

          
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value=" <?=(isset($row['email'])) ? $row['email'] : ''; ?> "/>
                                      <?php if (in_array('email', $error_fild)) {
    echo  '*please inter your email';
} ?><br />


            <label for="password" >password</label>
            <input type="password" name="password" id="password" /><?php if (in_array('password', $error_fild)) {
    echo '*please inter your password';
} ?><br/>
      
       <input type="checkbox" name="admin" <?=isset($row['admin']) ? 'checked' : ''; ?> />Admin    <br />

         <input type="submit" name="submit" value="Edit User" />   

        </form>
    </body>
</html>

