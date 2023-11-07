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
            <h4>Add Customer</h4>
        <form action="functions/actions.php" method="post" enctype="multipart/form-data">
          <label for="formFileLg" class="form-label">Add with file csv</label>
          <input class="form-control form-control-lg" name="file" id="file" type="file"accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
          <button type="submit" name="add-customer-csv" class="btn btn-primary mt-2">Add Customer</button>
      </form>
        </div>
        <div class="card-body">

        <form action="functions/actions.php" method="post">
            <div class="form-group">
              <label for="">First Name</label>
              <input type="text" name='first_name' class="form-control" placeholder="Enter name product">
            </div>
                <div class="form-group">
              <label for="">Last Name</label>
              <input type="text" name='last_name' class="form-control"  placeholder="Enter description">
            </div>
            <div class="form-group">
              <label for="">Email</label>
              <input type="email" name='email' class="form-control"  placeholder="Enter price">
            </div>
                <div class="form-group">
              <label for="">Phone</label>
              <input type="number" name='phone' class="form-control" placeholder="Enter quantity">
            </div>
            <button type="submit" name="add-customer" class="btn btn-primary mt-3">Submit</button>
          </form>

        </div>
      </div>
    </div> 
  </div>
</div>


<?php include('./includes/footer.php')?>