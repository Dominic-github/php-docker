<?php 
if( empty(session_id()) && !headers_sent()){
    session_start();
} 
?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="style.css">
    </head>
    <body>


       <?php 
       if (isset($_SESSION['username']) && $_SESSION['username']){
           echo"<div class='header'>";
           echo "<h1>Admin Page</h1>";
           echo '<a class="logout" href="logout.php">Logout</a>';
           echo"</div>";
       }else{
           echo 'Bạn chưa đăng nhập'."<br/>";
           echo 'Click vào đây để <a href="login.php">đăng nhập</a>';
       }
        ?>

       <?php 
       if (isset($_SESSION['username']) && $_SESSION['username']){
           echo"<div class='list-actions'>";
           echo '<a class="btn btn-primary" href="addProduct.php">Add Product</a>';
           echo '<a class="btn btn-primary" href="listProducts.php">List Product</a>';
           echo '<a class="btn btn-primary" href="addUser.php">Add User</a>';
           echo '<a class="btn btn-primary" href="listUsers.php">List Users</a>';
           echo"</div>";
       }
        ?>
    </body>
</html>
