<?php 
session_start();

if(isset($_SESSION['auth'])){
  unset($_SESSION['auth']);
  unset($_SESSION['auth_user']);
  unset($_SESSION['order_number']);
  unset($_SESSION['cart_number']);
  unset($_SESSION['cart_list_id']);
  unset($_SESSION['quantity_list']);
  $_SESSION['message'] = "Logged out Successfully";
}
header('Location: index.php')

?>
