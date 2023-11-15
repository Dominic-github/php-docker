<?php
session_start();
include('../middleware/adminMiddleware.php');
include_once('../config/connectDB.php');


if(isset($_SESSION['auth'])){
  $user_id = $_SESSION['auth_user']['user_id'];
  $getOrder = mysqli_query($conn,"SELECT *  FROM Orders  ORDER BY 	order_date DESC ");
}
$getOrderDetail = mysqli_query($conn,"SELECT *  FROM OrderDetails 
                                    join Orders 
                                    on OrderDetails.order_id = Orders.order_id
                                    join Products 
                                    on OrderDetails.product_id = Products.product_id
                                    ORDER BY 	order_date DESC
                                    ");


if(isset($_POST['delete-order'])){
  $order_id = $_GET['id'];
  $deleteOderDetail = "DELETE FROM OrderDetails WHERE order_id = $order_id";
  $deleteOrder = "DELETE FROM Orders WHERE order_id = $order_id";

  if(mysqli_query($conn,$deleteOderDetail) ){
    if(mysqli_query($conn,$deleteOrder))
    {
        redirect("order-list.php", "Delete Order is success", "success");

    }else{
       redirect("order-list.php", mysqli_error($conn),"error");
    }
  }else{
       redirect("order-list.php", mysqli_error($conn),"error");
  }

}


if(isset($_POST['search'])){
  $value = $_POST['text_search'];
  $string = "SELECT *  FROM Orders WHERE order_id like '%$value%' OR Like '%$value%' ";
  $query = mysqli_query($conn,$string);
}else{
  $query = mysqli_query($conn,"SELECT *  FROM Products");
}


include('includes/header.php');
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex">
          <h4 class="col-md-2">All Order</h4>
    
          <form class="input-group" action="product-list.php" method="post">
            <div class="form-outline">
              <input type="search" name="text_search" id="form1" class="form-control" placeholder="Search product" />
            </div>
  <button type="submit" name="search" class="btn btn-primary">
    <i class="fas fa-search"></i>
  </button>
</form>

<form class="input-group" action="functions/actions.php" method="post">
          
          <button type="submit" name="export-product-csv" class="btn btn-primary ms-md-auto pe-md-4">
            Export
          </button>
            </form>

        </div>
        <div class="card-body">
          <table class="table table-striped">

          <thead>

            <tr>
              <th>STT</th>
              <th>Name</th>
              <th>Customer</th>
              <th>Products</th>
              <th>Time</th>
              <th>Total Amount</th>
              <th>Actions</th>
            </tr>

            <tbody>
              <?php
              $index = 0;
              while($order = mysqli_fetch_assoc($getOrder) ){
                $product_name = "";
                $order_id = $order['order_id'];
                $count = 0;
                $customer_id = $order['customer_id'] ? $order['customer_id']: 'null';
                $user_id_customer = $order['user_id'] ? $order['user_id']: 'null';

                if( mysqli_num_rows($getOrderDetail) > 1){
             while($product = mysqli_fetch_assoc($getOrderDetail)){

               $getOrderNumber = mysqli_query($conn, "SELECT COUNT(*) as count_order FROM OrderDetails Where order_id= '$order_id' ");

               if(mysqli_num_rows($getOrderNumber) > 0){
                 $data = mysqli_fetch_array($getOrderNumber);
                 $product_detail_count = $data['count_order'] ;
               }else{
                 $product_detail_count = 0;
               }
              if($user_id_customer != 'null'){
               $getUser= mysqli_query($conn, "SELECT * FROM Users Where user_id = '$user_id_customer' ");
                $user = mysqli_fetch_assoc($getUser);
                $full_name = $user['full_name'];
              }else{
                $getCustomer= mysqli_query($conn, "Select * from Customers where customer_id = '$customer_id' ");
                $customer = mysqli_fetch_assoc($getCustomer);
                $full_name = $customer['full_name'];
              }
                 $count++;

                  if(strlen($product_name) >= 10 ){
                    $product_name = substr($product_name, 0, -2);  
                    $product_name= $product_name.',...';  
                    break; 
                  }else{
                  $product_name .= $product['product_name'].', ';  
                  }
                  if($count == $product_detail_count){
                    $product_name = substr($product_name, 0, -1);  
                    $product_name= $product_name.'...';  
                    break; 
                  }
                }
                } 
                if($product_detail_count == 1){
                  $product_name = $product['product_name'];
                }
              ?>
                  <tr class='products'>
                       <th scope="row"><?=$index?></th>
                        <td><?=$product_name?></td>
                        <td><?=$full_name?></td>
                        <td><?=$product_detail_count?></td>
                        <td><?=$order['order_date']?></td>
                        <td><?=$order['total_amount']?></td>
                       <td class="actions">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsModal-<?=$order["order_id"]?>">
                             Details 
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="detailsModal-<?=$order["order_id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Order : <?=$product_name?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>


                                 <form action="functions/exportPDF.php?id=<?=$order["order_id"]?>" method="POST">
                                  <div class="modal-body">

                                  <div class="form-group mt-1">

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
                                              $index2 = 0;

                                                    $getProducts = "SELECT *  FROM OrderDetails 
                                                      join Orders 
                                                      on OrderDetails.order_id = Orders.order_id
                                                      join Products 
                                                      on OrderDetails.product_id = Products.product_id
                                                      where
                                                      OrderDetails.order_id = '$order_id'
                                                      ORDER BY 	Orders.order_date DESC
                                                      ";

                                  $product_list_id = "";
                                  $subTotal = 0;
                                  $query = mysqli_query($conn,$getProducts);
                                  while($product_list = mysqli_fetch_assoc($query)){
                                    $product_list_id = $product_list_id == '' ? $product_list['product_id']: $product_list_id.','.$product_list['product_id'];
                                  }

                                  $getProduct= mysqli_query($conn, "SELECT * FROM Products where product_id in ($product_list_id) ");
                                  $query = mysqli_query($conn,$getProducts);

                                  while ($product = mysqli_fetch_assoc($getProduct)  ) {
                                    $product_list = mysqli_fetch_assoc($query);
                                      $quantity = $product_list['quantity'];
                                      $subTotal = $product_list['subtotal'];
                  ?>

                                    <tr class='products'>
                                      <th scope="row"><?=$index2?></th>
                                      <td>'<?=$product["product_name"]?>'</td>
                                      <td>"<?=$quantity?>"</td>
                                      <td>"<?=$subTotal?>"</td>
                                             </tr>
                                  <?php
                                    $index2++;
                                    }
                                    ?>
                                          </tbody>
                                      </table>
                                  </div>

                                  <div class="form-group mt-2 d-flex flex-row-reverse">
                                    <label  class="" for="">Total: <?=$order['total_amount']?>VND</label>
                                  </div>

                                  </div>


                                  <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="export-order" class="btn btn-primary">Export</button>
                                   </form>
                                  </div>
                                </div>
                              </div>
                            </div>



                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal-<?=$order["order_id"]?>">
                              Delete
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal-<?=$order["order_id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    Are you sure, want to delete Order: <?=$product_name?>
                                  </div>
                                  <div class="modal-footer">
                                    <form action="order-list.php?id=<?=$order["order_id"]?>" method="POST">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" name="delete-order" class="btn btn-primary">Yes</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>


                       </td>



                </tr>
              
              <?php $index++; 
              } ?>
              <tr>
              </tr>
            </tbody>
          </thead>
          </table>

        </div>
      </div>
    </div> 
  </div>
</div>


<?php include('./includes/footer.php')?>
