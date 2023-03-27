<?php
$v_array = [];
if (isset($_GET['error_fild'])) {
    $v_array = explode(',', $_GET['error_fild']);
}
?>
<html>
     <body>
           <form method="post" action="back,db/back-opp.php">

            <lable for="name">Name</lable>
            <input type="text" name="name" id="name"/><?php
            if (in_array('name', $v_array)) {
                echo
'*please inter your name';
            } ?><br/>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" /> <?php if (in_array('email', $v_array)) {
                echo
'*please inter your mail';
            } ?><br/>

            <label for="password">password</label>
            <input type="password" name="password" id="password" /><?php if (in_array('password', $v_array)) {
                echo
'*please inter your password';
            } ?><br/>

            <label for="gender" >Gender</label><br/>
            <input type="radio" name="gender" value="male"> male
            <input type="radio" name="gender" value="fmale"> fmale
            <input type="submit" name="submite" value="register">


           </form>
    </body>
</html>
