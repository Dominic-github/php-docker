<?php
ob_start();
include('includes/header.php');
include('../middleware/adminMiddleware.php');
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <h4>Add Order</h4>
        </div>
        <div class="card-body">

        <form action="functions/actions.php" method="post">
            <div class="form-group">
              <label for="">Customer</label>
              <input type="text" name='customer_name' class="form-control" placeholder="Enter name product">
            </div>
                <div class="form-group">
              <label for="">ProductName</label>
              <input type="text" name='product_name' class="form-control"  placeholder="Enter description">
            </div>
            <div class="form-group">
              <label for="">Quantity</label>
              <input type="number" name='quantity' class="form-control"  placeholder="Enter price">
            </div>
            <button type="submit" name="add-order" class="btn btn-primary mt-3">Submit</button>
          </form>

        </div>
      </div>
    </div> 
  </div>
</div>


<?php include('./includes/footer.php')?>