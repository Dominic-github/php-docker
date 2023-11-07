<?php 
session_start();
include('config/connectDB.php');
$query = mysqli_query($conn,"SELECT *  FROM Products");
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
        unset($_SESSION['message']);
        ?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4>All Products</h4>
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



      </div>
    </div>
  </div>
</div>
<?php include('includes/footer.php')?>
