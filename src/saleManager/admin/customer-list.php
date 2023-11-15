<?php
session_start();
include('../middleware/adminMiddleware.php');

include_once('../config/connectDB.php');

if(isset($_POST['search'])){
  $value = $_POST['text_search'];
  $string = "SELECT *  FROM Customers WHERE customer_id like '%$value%' OR first_name Like '%$value%' OR last_name Like '%$value%'";
  $query = mysqli_query($conn,$string);
}else{
  $query = mysqli_query($conn,"SELECT *  FROM Customers");
}

include('includes/header.php');
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex">
          <h4 class="col-md-2">All Customers</h4>
    
          <form class="input-group" action="product-list.php" method="post">
            <div class="form-outline">
              <input type="search" name="text_search" id="form1" class="form-control" placeholder="Search product" />
            </div>
  <button type="submit" name="search" class="btn btn-primary">
    <i class="fas fa-search"></i>
  </button>
</form>

            <form class="input-group" action="functions/actions.php" method="post">
          
          <button type="submit" name="export-customer-csv" class="btn btn-primary ms-md-auto pe-md-4">
            Export
          </button>
            </form>

        </div>

        <div class="card-body">
          <table class="table table-striped">

          <thead>

            <tr>
              <th>ID</th>
              <th>FirstName</th>
              <th>LastName</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Actions</th>
            </tr>

            <tbody>
              <?php
              $index = 0;

              while($row = mysqli_fetch_assoc($query) ){
              ?>
                  <tr class='products'>
                       <th scope="row"><?=$row["customer_id"]?></th>
                       <td>'<?=$row["first_name"]?>'</td>
                       <td>"<?=$row["last_name"]?>"</td>
                       <td>"<?=$row["email"]?>"</td>
                       <td>"<?=$row["phone"]?>"</td>
                       <td class="actions">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeModal-<?=$row["customer_id"]?>">
                              Change
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="changeModal-<?=$row["customer_id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Change Product ID: <?=$row["customer_id"]?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                 <form action="functions/actions.php?id=<?=$row["customer_id"]?>" method="POST">
                                  <div class="modal-body">
                                  <div class="form-group">
                                      <label for="">First Name</label>
                                      <input type="text" name='first_name' class="form-control" value="<?=$row["product_name"]?>" placeholder="Enter name product">
                                    </div>
                                        <div class="form-group">
                                      <label for="">Last Name</label>
                                      <input type="text" name='last_name' class="form-control"  value="<?=$row["description"]?>" placeholder="Enter description">
                                    </div>
                                    <div class="form-group">
                                      <label for="">Email</label>
                                      <input type="email" name='email' class="form-control" value="<?=$row["price"]?>" placeholder="Enter price">
                                    </div>
                                        <div class="form-group">
                                      <label for="">Phone</label>
                                      <input type="number" name='phone' class="form-control" value="<?=$row["stock_quantity"]?>" placeholder="Enter quantity">
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                                        <button type="submit" name="change-customer" class="btn btn-primary">Save changes</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>


                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal-<?=$row["customer_id"]?>">
                              Delete
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal-<?=$row["customer_id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    Are you sure, want to delete product ID: <?=$row["customer_id"]?>
                                  </div>
                                  <div class="modal-footer">
                                    <form action="functions/actions.php?id=<?=$row["customer_id"]?>" method="POST">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" name="delete-customer" class="btn btn-primary">Yes</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                        </div>
                       </td>
                     </tr>
              
              <?php } ?>
              <tr>
                <td></td>
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
