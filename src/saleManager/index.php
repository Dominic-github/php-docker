<?php 
ob_start();
session_start();
include('config/connectDB.php');
include('functions/myfunctions.php');

$_SESSION['isRegister'] = true;

if(isset($_POST['add-to-cart'])){
  $id = $_GET['id'];
  $quantity = $_POST['quantity'];

  if(isset($_SESSION['quantity_list'][$id])){
    $_SESSION["quantity_list"][$id] = $_SESSION["quantity_list"][$id] + $quantity;
  }else{
    $_SESSION["cart_number"]++;
    $_SESSION["quantity_list"][$id] = $quantity;
    $_SESSION['cart_list_id'] = $_SESSION['cart_list_id'] == '' ? $id : $_SESSION['cart_list_id'].','.$id;
  }
  redirect("index.php", "Add to cart is success", "success");
}

if(isset($_POST['search'])){
  $value = $_POST['text_search'];
  $string = "SELECT *  FROM Products WHERE product_id like '%$value%' OR product_name Like '%$value%' ";
  $query = mysqli_query($conn,$string);
}else{
  $query = mysqli_query($conn,"SELECT *  FROM Products");
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
        <div class="card-header d-flex align-items-center justify-content-between">
          <h4 class="col-md-2">All Products</h4>

          <div>

          <form class="input-group" action="index.php" method="post">
            <div class="form-outline">
              <input type="search" name="text_search" id="form1" class="form-control" placeholder="Search products" />
            </div>
          <button type="submit" name="search" class="btn btn-primary">
            <i class="fas fa-search"></i>
           </button>
            </form>
        </div>
        </div>

        <div class="card-body">
          <table class="table table-striped">

          <thead>

            <tr>
              <th>STT</th>
              <th>Name</th>
              <th>Desc</th>
              <th>Price</th>
              <th>Stock Quantity</th>
              <th>Actions</th>
            </tr>

            <tbody>
              <?php
              $index = 0;
              while($row = mysqli_fetch_assoc($query) ){
              ?>
                  <tr class='products'>
                       <th scope="row"><?=$index?></th>
                       <td>'<?=$row["product_name"]?>'</td>
                       <td>"<?=$row["description"]?>"</td>
                       <td>"<?=$row["price"]?>"</td>
                       <td>"<?=$row["stock_quantity"]?>"</td>
                       <td class="actions">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeModal-<?=$row["product_id"]?>">
                          Order
                        </button>
                            <!-- Modal -->
                            <div class="modal fade" id="changeModal-<?=$row["product_id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">ADD TO CART</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                 <form action="index.php?id=<?=$row["product_id"]?>" method="POST">
                                  <div class="modal-body">

                                  <div class="form-group">
                                      <label for="">Name Product: <?=$row["product_name"]?></label>
                                  </div>

                                  <div class="form-group mt-1">
                                      <label for="">Stock quantity: <?=$row["stock_quantity"]?></label>
                                  </div>

                                  <div class="form-group mt-1">
                                    <label for="">Enter quantity:</label>
                                    <input required min="1" max="<?=$row["stock_quantity"]?>" type="number" name='quantity' class="form-control"  value="" placeholder="Enter quantity want to order">
                                  </div>
                                  <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="add-to-cart" class="btn btn-primary">Add to Cart</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                      </td>
                     </tr>
              
              <?php $index++; } ?>
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
