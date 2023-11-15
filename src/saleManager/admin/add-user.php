<?php
session_start();
include('includes/header.php');
include('../middleware/adminMiddleware.php');
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
        <h4>Add User</h4>
        <form action="functions/actions.php" method="post" enctype="multipart/form-data">
          <label for="formFileLg" class="form-label">Add with file csv</label>
          <input class="form-control form-control-lg" name="file" id="file" type="file"accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
          <button type="submit" name="add-user-csv" class="btn btn-primary mt-2">Add User</button>
      </form>
       </div>
        <div class="card-body">

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
        <form action="functions/actions.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter username">
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" placeholder="Enter email">
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" placeholder="Enter fullname">
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password">
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password"class="form-control" placeholder="Confirm password">
          </div>
          <div class="form-group">
            <div class="form-check">
            <input class="form-check-input" type="radio" name="role" value="Admin" id="" >
            <label class="form-check-label" for="flexRadioDefault1">
            Admin
            </label>
            <input class="form-check-input" type="radio" name="role" value="User" id="" checked >
            <label class="form-check-label" for="flexRadioDefault2">
              User
            </label>
          </div>

          <button type="submit" name="add-user" class="btn btn-primary">Add User</button>
    </form>
      </div>
    </div>
    </div>

        </div>
    </div> 
  </div>
</div>


<?php include('./includes/footer.php')?>
