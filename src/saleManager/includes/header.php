<!Doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" >

  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <title>HomePage</title>
  </head>
  <body>

    <?php
  
include('config/connectDB.php');

    $_SESSION["cart_number"] = isset($_SESSION["cart_number"]) ? $_SESSION["cart_number"] :0;
    $_SESSION["cart_list_id"] = isset($_SESSION["cart_list_id"]) ?$_SESSION["cart_list_id"] : "";
    $_SESSION["quantity_list"] = isset($_SESSION["quantity_list"]) ? $_SESSION["quantity_list"]: [];
    $_SESSION["order_number"] = isset($_SESSION["order_number"])? $_SESSION["order_number"] : 0;
     if(isset($_SESSION['auth_user'])){
       $user_id= $_SESSION['auth_user']['user_id'];
       $getOrderNumber = mysqli_query($conn, "SELECT COUNT(*) as count_order FROM Orders Where user_id = '$user_id' ");
       if(mysqli_num_rows($getOrderNumber) > 0){
         $data = mysqli_fetch_array($getOrderNumber);
         $_SESSION["order_number"] = $data['count_order'] ;
       }else{
         $_SESSION["order_number"] = 0;
       }
     }elseif(isset($_SESSION['auth_customer'])){
       $customer_id = $_SESSION['auth_customer']['customer_id'];
       $getOrderNumber = mysqli_query($conn, "SELECT COUNT(*) as count_order FROM Orders Where customer_id = '$customer_id' ");
       if(mysqli_num_rows($getOrderNumber) > 0){
         $data = mysqli_fetch_array($getOrderNumber);
         $_SESSION["order_number"] = $data['count_order'] ;
       }else{
         $_SESSION["order_number"] = 0;
       }
     }else{
         $_SESSION["order_number"] = 0;
     }

  include('navbar.php')?>
