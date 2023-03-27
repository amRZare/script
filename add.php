<?php

$error_fild = [];

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
        //connect to DB
        $connect = new mysqli('localhost', 'amr', 'p@ssword', 'site');
        if ($connect->connect_error) {
            die('connect error'.$connect->connect_error); //check connection
        }
        //Escape any sepcial characters to avoid sQl Injection
        $Name = $connect->real_escape_string($_POST['name']);
        $Email = $connect->real_escape_string($_POST['email']);
        $Password = sha1($_POST['password']);
        $admin = isset($_POST['admin']) ? 1 : 0;

        //uploads files
$uploads_dir = $_SERVER['DOCUMENT_ROOT'].'/uploads'; //upload file directory
$avatar = '';  //for no file uploaded
if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
    $temp_name = $_FILES['avatar']['temp_name'];
    $avatar = basename($_FILES['avatar']['name']);
    move_uploaded_file($temp_name, "$uploads_dir/$Name.$avatar"); //for move file from temp to my new directory
} else {
    echo "files can't uploaded";
    exit;
}

        //Insert the Data
        $query = " INSERT INTO `users` (`name`,`email`,`password`,`admin`) VALUES('".$Name."','".$Email."','".$Password."','".$admin."')";
        if ($connect->query($query) == true) {
            header('location:list.php');  //redirect to list.php to show new user
            exit;
        } else {
            echo  $connect->connect_error;
        }

        //close connection
        mysqli_close($connect);
    } //error field
} //if $_server
?>

<html>
    <head>
        <title>
            Admin :: Add User </title>
    </head>

     <body>
           <form method="post" enctype="multipart/form-data">

           <label for="name">Name</label>
           <input type="text" name="name" id="name" value="<?= isset($_POST['name']) ? $_POST['name'] : ''; ?>"
           /><?php if (in_array('name', $error_fild)) {
    echo '*please inter name';
} ?> 
                                                     
   
<br />
          
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value=" <?=(isset($_POST['email'])) ? $_POST['email'] : ''; ?>"/>
                                      <?php if (in_array('email', $error_fild)) {
    echo  '*please inter your email';
} ?>
                 

<br />
            <label for="password" >password</label>
            <input type="password" name="password" id="password" /><?php if (in_array('password', $error_fild)) {
    echo '*please inter your password';
} ?>
<br/>
            
         <input type="checkbox" name="admin" <?=isset($_POST['admin']) ? 'checked' : ''; ?> />Admin
<br />
        <label for="avatar">Avatar</label>
         <input type="file" id="avatar" name="avatar">
<br />
         <input type="submit" name="submit" value="Add User" />      
           </form>
    </body>
</html>

