<?php 
session_start();
include('config/connectDB.php');
include('functions/myfunctions.php');

$cart_list_id = $_SESSION['cart_list_id'] ? $_SESSION['cart_list_id']: '' ;
$query = mysqli_query($conn,"SELECT *  FROM Products where product_id in ($cart_list_id) ");

# Variable global
if(!isset($_SESSION['total-cart'])){
  $_SESSION['total-cart'] = formatNumber(0);
}

if(isset($_POST['delete-cart'])){
  $id = $_GET['id'];
  $findID = array_key_first($_SESSION['quantity_list']) == $id ? $id.',' : ','.$id;
  if($_SESSION['cart_number'] == 1){
    $findID = $id;
  }
  $_SESSION['cart_list_id'] = str_replace($findID, "", $_SESSION['cart_list_id']);
  unset($_SESSION['quantity_list'][$id]);

  $_SESSION['cart_number']--;
}

if(isset($_POST['order-cart'])){

  $total = (int)$_SESSION['total-cart'];

  if(isset($_SESSION['auth_user'])){

    # user id
    $user_id = $_SESSION['auth_user']['user_id'];

    # Create Order   
     $createOrder = "INSERT into Orders(user_id, total_amount) VALUES ('$user_id', '$total')";

    if(!mysqli_query($conn,$createOrder)){
       redirect("cart-list.php", mysqli_error($conn),"error");
    }
  }else{
    if(isset($_SESSION['auth_customer'])) {
    $customer_id = $_SESSION['auth_customer']['customer_id'];
     $createOrder = "INSERT into Orders(customer_id, total_amount) VALUES ('$customer_id', '$total')";

    if(!mysqli_query($conn,$createOrder)){
       redirect("cart-list.php", mysqli_error($conn),"error");
    }
    }else{
      $first_name = $_POST['first_name'] ? $_POST['first_name']: ""; 
      $last_name = $_POST['last_name'] ? $_POST['last_name']: ""; 
      $email = $_POST['email'] ? $_POST['email']: ""; 
      $phone = $_POST['phone'] ? $_POST['phone']: ""; 
      $full_name = $first_name.' '.$last_name;
  # Create customer
    if($first_name && $last_name && $email && $phone){
      $insertCustomer = "INSERT into Customers(first_name, last_name, email, phone) VALUES ('$first_name', '$last_name', '$email', '$phone')";
      if(!mysqli_query($conn,$insertCustomer)){
        redirect("cart-list.php", mysqli_error($conn),"error");
      }
    }else{
      redirect("cart-list.php", "Please enter in full", "warning");
    }

    $customer_id = mysqli_insert_id($conn);

    $_SESSION['auth_customer'] = [
      'customer_id' => $customer_id,
      'first_name' => $first_name,
      'last_name' => $last_name,
      'email' => $email,
      'phone' => $phone,
      'full_name' => $full_name,
    ];
    # Get customer id
    # Create Order   
     $createOrder = "INSERT into Orders(customer_id, total_amount) VALUES ('$customer_id', '$total')";

    if(!mysqli_query($conn,$createOrder)){
       redirect("cart-list.php", mysqli_error($conn),"error");
    }


    }
  }
  # Get order id
  $order_id = mysqli_insert_id($conn);

  # Create Order_deltail   
  $cart_list_id = $_SESSION['cart_list_id'] ? $_SESSION['cart_list_id']: '' ;
  $getProduct= mysqli_query($conn,"SELECT *  FROM Products where product_id in ($cart_list_id) ");

  while($row = mysqli_fetch_assoc($getProduct)){
    $product_id = $row['product_id'];
    $quantity = $_SESSION["quantity_list"][$row["product_id"]];
    $subtotal = $_SESSION["quantity_list"][$row["product_id"]]  * $row["price"];

    $createOrderDeltail = "INSERT into OrderDetails(order_id, product_id,quantity, subtotal) VALUES ('$order_id', '$product_id', '$quantity', '$subtotal')";
    if(!mysqli_query($conn,$createOrderDeltail)){
       redirect("cart-list.php", mysqli_error($conn),"error");
    }
  }
  
  if(!isset($_SESSION['auth_user'])){
    $getOrderList = mysqli_query($conn, "SELECT COUNT(*) as count_order FROM Orders where customer_id = '$customer_id' ");
    $data = mysqli_fetch_array($getOrderList);
    $_SESSION["order_number"] = $data['count_order'] ;
  }else{
   $user_id= $_SESSION['auth_user']['user_id'];
   $getOrderNumber = mysqli_query($conn, "SELECT COUNT(*) as count_order FROM Orders Where user_id = '$user_id' ");
   if(mysqli_num_rows($getOrderNumber) > 0){
     $data = mysqli_fetch_array($getOrderNumber);
     $_SESSION["order_number"] = $data['count_order'] ;
   }else{
     $_SESSION["order_number"] = 0;
   }
  }

  # Reset Cart
  $_SESSION["cart_number"] = 0;
  $_SESSION["cart_list_id"] = "";
  $_SESSION["quantity_list"] = [];

  redirect("cart-list.php", "Order is success","success");

}




include('includes/header.php')

?>

<div class="py5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

       <?php
       if(isset($_SESSION['message'])){
       ?>
       <div class="alert alert-warning alert-dismissible fade show" role="alert">
         <strong>Hey!</strong> <?= $_SESSION['message']; ?>.
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
        }
        unset($_SESSION['message']);
        ?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4>Cart</h4>
        </div>
        <div class="card-body">
          <table class="table table-striped">

          <thead>

            <tr>
              <th>STT</th>
              <th>Name</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>SubTotal</th>
              <th>Actions</th>
            </tr>

            <tbody>
              <?php
              $index = 0;
              $_SESSION['total-cart'] = formatNumber(0);
        if($_SESSION['cart_number'] > 0) {
              while($row = mysqli_fetch_assoc($query) ){

                if($_SESSION["quantity_list"][$row["product_id"]] > $row["stock_quantity"]){
                    $_SESSION["quantity_list"][$row["product_id"]] = $row["stock_quantity"];
                }

                $subTotal = formatNumber($_SESSION["quantity_list"][$row["product_id"]]  * $row["price"]);
                $_SESSION['total-cart'] += $subTotal; 
                $_SESSION['total-cart'] = formatNumber($_SESSION['total-cart']);
              ?>
                  <tr class='products'>
                       <th scope="row"><?=$index?></th>
                       <td>'<?=$row["product_name"]?>'</td>
                       <td>"<?=$_SESSION["quantity_list"][$row["product_id"]]?>"</td>
                       <td>"<?=$row["price"]?>"</td>
                       <td>"<?=$subTotal?>"</td>
                       <td class="actions">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal-<?=$row["product_id"]?>">
Delete
                         </button>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal-<?=$row["product_id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">ADD TO CART</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                 <form action="cart-list.php?id=<?=$row["product_id"]?>" method="POST">
                                  <div class="modal-body">

                                  <div class="form-group">
                                      <label for=""> Are you sure delete <?=$row["product_name"]?></label>
                                  </div>

                                  <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="delete-cart" class="btn btn-primary">Delete</button>
                                   </form>
                                  </div>
                                </div>
                              </div>
                     </td>
                     </tr>
              
              <?php $index++; }
              } ?>
              <tr>
              </tr>
            </tbody>
          </thead>
          </table>
                <div class="d-flex justify-content-between">


                    <h4>Total: <?=$_SESSION['total-cart']?>VND</h4>
                    
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal">
Order
                         </button>
                            <!-- Modal -->
                            <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Order</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  
                                 <form action="cart-list.php" method="POST">
                          
                                  <div class="modal-body">
                                  
                                  <div class="form-group mt-1">
                                    <label for="">Order list:</label>

                                      <table class="table table-striped">

                                        <thead>

                                          <tr>
                                            <th>STT</th>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th>SubTotal</th>
                                          </tr>

                                          <tbody>
                                              <?php
                                              $index = 0;
                                        $query = mysqli_query($conn,"SELECT *  FROM Products where product_id in ($cart_list_id) ");
                                        if($_SESSION['cart_number'] > 0) {
                                              while($row = mysqli_fetch_assoc($query) ){

                                                if($_SESSION["quantity_list"][$row["product_id"]] > $row["stock_quantity"]){
                                                    $_SESSION["quantity_list"][$row["product_id"]] = $row["stock_quantity"];
                                                }

                                                $subTotal = formatNumber($_SESSION["quantity_list"][$row["product_id"]]  * $row["price"]);
                                              ?>
                                                  <tr class='products'>
                                                       <th scope="row"><?=$index?></th>
                                                       <td>'<?=$row["product_name"]?>'</td>
                                                       <td>"<?=$_SESSION["quantity_list"][$row["product_id"]]?>"</td>
                                                       <td>"<?=$subTotal?>"</td>
                                                     </td>
                                                     </tr>
                                              <?php $index++; }
                                              } ?>

                                              <tr>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </div>
                                  <?php

                                  if(isset($_SESSION['auth_user'])){
                                  ?>

                                  <div class="form-group mt-1">
                                  <label for="">Full Name: <?=$_SESSION['auth_user']['full_name']?></label>
                                  </div>
                                  <div class="form-group mt-1">
                                    <label for="">Email: <?=$_SESSION['auth_user']['email']?></label>
                                  </div>

                                  <?php
                                  }elseif(isset($_SESSION['auth_customer'])){
                                  ?>
                                    <div class="form-group mt-1">
                                    <label for="">Full Name: <?=$_SESSION['auth_customer']['full_name']?></label>
                                    </div>
                                    <div class="form-group mt-1">
                                      <label for="">Email: <?=$_SESSION['auth_customer']['email']?></label>
                                    </div>
                                    <div class="form-group mt-1">
                                      <label for="">Phone: <?=$_SESSION['auth_customer']['phone']?></label>
                                    </div>
                                  <?php
                                  }else{
                                  ?> 
                                  <div class="form-group mt-1">
                                    <label for="">First Name:</label>
                                    <input required type="text" name='first_name' class="form-control"  value="" placeholder="Enter your first name">
                                  </div>

                                  <div class="form-group mt-1">
                                    <label for="">Last Name:</label>
                                    <input required type="text" name='last_name' class="form-control"  value="" placeholder="Enter your last name">
                                  </div>

                                  <div class="form-group mt-1">
                                    <label for="">Email:</label>
                                    <input required type="email" name='email' class="form-control"  value="" placeholder="Enter email">
                                  </div>

                                  <div class="form-group mt-1">
                                    <label for="">Phone:</label>
                                    <input required type="phone" name='phone' class="form-control"  value="" placeholder="Enter phone">
                                  </div>
                                  <?php 
                                  }
                                  ?>

                                  <div class="form-group mt-2 d-flex flex-row-reverse">
                                  <label  class="" for="">Total: <?=$_SESSION['total-cart']?>VND</label>
                                  </div>
                                  <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="order-cart" class="btn btn-primary">Saves Order</button>
                                   </form>
                                  </div>
                                </div>
                              </div>
                </div>

                      
        </div>
      </div>
    </div> 
  </div>
</div>



      </div>
    </div>
  </div>
</div>
<?php include('includes/footer.php')?>
