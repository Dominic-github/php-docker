<?php
session_start();
include('includes/header.php');
include('../middleware/adminMiddleware.php');

include_once('../config/connectDB.php');

if(isset($_POST['search'])){
  $value = $_POST['text_search'];
  $string = "SELECT *  FROM Products WHERE product_id like '%$value%' OR product_name Like '%$value%' ";
  $query = mysqli_query($conn,$string);
}else{
  $query = mysqli_query($conn,"SELECT *  FROM Products");
}

?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex">
          <h4 class="col-md-2">All Products</h4>
    
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
              <th>ID</th>
              <th>Name</th>
              <th>Desc</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Actions</th>
            </tr>

            <tbody>
              <?php
              $index = 0;

              while($row = mysqli_fetch_assoc($query) ){
              ?>
                  <tr class='products'>
                       <th scope="row"><?=$row["product_id"]?></th>
                       <td>'<?=$row["product_name"]?>'</td>
                       <td>"<?=$row["description"]?>"</td>
                       <td>"<?=$row["price"]?>"</td>
                       <td>"<?=$row["stock_quantity"]?>"</td>
                       <td class="actions">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeModal-<?=$row["product_id"]?>">
                              Change
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="changeModal-<?=$row["product_id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Change Product ID: <?=$row["product_id"]?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                 <form action="functions/actions.php?id=<?=$row["product_id"]?>" method="POST">
                                  <div class="modal-body">
                                  <div class="form-group">
                                      <label for="">Name Product</label>
                                      <input type="text" name='product_name' class="form-control" value="<?=$row["product_name"]?>" placeholder="Enter name product">
                                    </div>
                                        <div class="form-group">
                                      <label for="">Description</label>
                                      <input type="text" name='desc' class="form-control"  value="<?=$row["description"]?>" placeholder="Enter description">
                                    </div>
                                    <div class="form-group">
                                      <label for="">price</label>
                                      <input type="number" name='price' class="form-control" value="<?=$row["price"]?>" placeholder="Enter price">
                                    </div>
                                        <div class="form-group">
                                      <label for="">Quantity</label>
                                      <input type="number" name='quantity' class="form-control" value="<?=$row["stock_quantity"]?>" placeholder="Enter quantity">
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                                        <button type="submit" name="change-product" class="btn btn-primary">Save changes</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>


                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal-<?=$row["product_id"]?>">
                              Delete
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal-<?=$row["product_id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    Are you sure, want to delete product ID: <?=$row["product_id"]?>
                                  </div>
                                  <div class="modal-footer">
                                    <form action="functions/actions.php?id=<?=$row["product_id"]?>" method="POST">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" name="delete-product" class="btn btn-primary">Yes</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                        </div>
                       </td>
                     </tr>
              
              <?php } ?>
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
