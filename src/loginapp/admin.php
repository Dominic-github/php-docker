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
    </head>
    <body>

    <h1>Home Page</h1>
       <?php 
       if (isset($_SESSION['username']) && $_SESSION['username']){
           echo 'Bạn đã đăng nhập với tên là '.$_SESSION['username']."<br/>";
           echo 'Click vào đây để <a href="logout.php">Logout</a>';
       }
       else{
           echo 'Bạn chưa đăng nhập'."<br/>";
           echo 'Click vào đây để <a href="login.php">đăng nhập</a>';
       }
       ?>
    </body>
</html>