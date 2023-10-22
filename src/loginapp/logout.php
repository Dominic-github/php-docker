<?php session_start(); 
 
if (isset($_SESSION['username'])){
    unset($_SESSION['username']); // xóa session login
}
?>
<h3>Logout Success</h3>
<a href="admin.php">HOME Page</a>