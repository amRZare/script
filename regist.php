<?php
//check for errors
$error_arr = array();    //empty array to save errors
if(isset($_GET['error_field'])){
    $error_array = explode(",", $_GET['error_field']);
}
?>

<html>
     <body>
        <form method="post" action="processes.php">

          <lable for="name">Name</lable>
          <input type="text" name="name" id="name"/> <?php if (in_array("name", $error_arr)) //error massege for error name
echo "* Please enter your name "; ?><br/>                                   

            <label for="email">Email</label>
            <input type="email" name="email" id="email" /> <?php if (in_array("email", $error_arr))  //error massege for error email
echo "* Please enter your Email ";  ?> <br/>
           
            <label for="password">password</label>
            <input type="password" name="password" id="password" /><?php if (in_array("password", $error_arr))
echo "* Please enter password not less than 6 characters"; ?> <br/>
        
            <label for="gender" >Gender</label> 
            <input type="radio" name="gender" value="male"> male
            <input type="radio" name="gender" value="female"> female <br />
            <input type="submit" name="submite" value="register">
        </form>
    </body>
</html>
