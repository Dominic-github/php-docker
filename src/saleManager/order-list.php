<?php 
session_start();
include('config/connectDB.php');
include('functions/myfunctions.php');

if(isset($_SESSION['auth'])){
  $user_id = $_SESSION['auth_user']['user_id'];
  $getOrder = mysqli_query($conn,"SELECT *  FROM Orders where user_id = '$user_id'  ORDER BY 	order_date DESC ");
}else{
if(isset($_SESSION['auth_customer'])){
  $customer_id = $_SESSION['auth_customer']['customer_id'];
  $getOrder = mysqli_query($conn,"SELECT *  FROM Orders where customer_id = '$customer_id'  ORDER BY 	order_date DESC ");
}else{
  $customer_id = null;
  $getOrder = mysqli_query($conn,"SELECT *  FROM Orders where  customer_id = '$customer_id'  ORDER BY 	order_date DESC ");
}
}
$getOrderDetail = mysqli_query($conn,"SELECT *  FROM OrderDetails 
                                    join Orders 
                                    on OrderDetails.order_id = Orders.order_id
                                    join Products 
                                    on OrderDetails.product_id = Products.product_id
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



include('includes/header.php')?>

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
        ?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4>All orders</h4>
        </div>
        <div class="card-body">
          <table class="table table-striped">

          <thead>

            <tr>
              <th>STT</th>
              <th>Name</th>
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
                if( mysqli_num_rows($getOrderDetail) > 1){
                while($product = mysqli_fetch_assoc($getOrderDetail)){

               $getOrderNumber = mysqli_query($conn, "SELECT COUNT(*) as count_order FROM OrderDetails Where order_id= '$order_id' ");

               if(mysqli_num_rows($getOrderNumber) > 0){
                 $data = mysqli_fetch_array($getOrderNumber);
                 $product_detail_count = $data['count_order'] ;
               }else{
                 $product_detail_count = 0;
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

                }else{
                  $product = mysqli_fetch_assoc($getOrderDetail);
                  $product_name = $product['product_name'];
                }
              ?>
                  <tr class='products'>
                       <th scope="row"><?=$index?></th>
                        <td><?=$product_name?></td>
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
                                              $index = 0;
                                                  $getProducts= "SELECT *  FROM OrderDetails 
                                                    join Products 
                                                    on OrderDetails.product_id = Products.product_id
                                                    where
                                                    OrderDetails.order_id = '$order_id'
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
                                      <th scope="row"><?=$index?></th>
                                      <td>'<?=$product["product_name"]?>'</td>
                                    

                                      <td>"<?=$quantity?>"</td>
                                      <td>"<?=$subTotal?>"</td>
                                             </tr>
                                  <?php
                                    $index++;
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



      </div>
    </div>
  </div>
</div>
<?php include('includes/footer.php')?>

