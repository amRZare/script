<?php
session_start();
if(isset($_SESSION['id'])){
    echo '<p> Welcome '.$_SESSION['email'].' <a href="/web/admin/logout.php"> logout </a></p>';
}else{
    header("location: web/admin/login.php");
    exit;
}
//first part from code {connection , query}

//connect to DB =>{db}
$connect = new mysqli('localhost', 'amr', 'p@ssword', 'site');
if (!$connect) {
    die('connect error'.mysqli_connect_error());
}

//select all users
$query = 'SELECT * FROM `users`';

//search about name or email
if (isset($_GET['search'])) {
    $Search = mysqli_escape_string($connect, $_GET['search']);
    $query .= "  WHERE `users` . `name` LIKE '%".$Search."%' OR `users` . `email` LIKE '%".$Search."%' ";
}
//$result=mysqli_query($connect,$query);  OR
$Result = $connect->query($query);
?>    

<html>
    <head>
        <title> Admin :: List Users </title>
    </head>
    <body>
        <h1> List Of Users </h1>

        <!-- create search box-->
        <form method="GET">
            <input type="text" name="search" placeholder="Enter {Name} or {Email} to search "/>
            <input type="submit" value="search">
            
        </form>

<!-- create table in html (it's have all users)--> 
<table>
    <thead> <!--(table head) it's html tag used to define elememnts of head table -->
          <tr> <!--(table row)-->
             <th>Id</th>
             <th>Name</th>
             <th>Email</th> <!--(cell)-->
             <th>avatar</th>
             <th>Admin</th>
             <th>Actions</th> <!--(action)-> SCRUD oprations -->
          </tr>
     </thead>

<?php
//loop on row
while ($row = mysqli_fetch_assoc($Result)) {
    ?>
       <tr>
          <td> <?= $row['id']; ?> </td>
          <td> <?= $row['name']; ?> </td>
          <td> <?= $row['email']; ?> </td>
          <td><?php if ($row['avatar']) {?> <img src="/uploads/<?=$row['avatar']; ?>"
style="width: 100px; height: 100px;"/> <?php } else { ?> <img src="/uploads/noimage.png"
style="width: 100px; height: 100px;"/> <?php } ?>
</td>
          <td> <?= ($row['admin']) ? 'Yes' : 'No'; ?> </td>
          <td><a href="edit.php?id=<?=$row['id']; ?>">Edit</a> | <a href="delete.php?id=
                                             <?=$row['id']; ?>">Delete</a></td>
       </tr>    
<?php
}
?>

</tbody>
      <tfoot>
        <tr>
            <td colspan="2" style="text-align: center; "><?php mysqli_num_rows($Result); ?><br/>
* add user</a></td>
           <td colspan="2" style="text-align: end;" ><a href="add.php"><br/>Add User </a></td>
        </tr>
      </tfoot> 
   </table>
 </body>
</html>

<?php
// close connection
$Result->free_result();
mysqli_close($connect);
?>