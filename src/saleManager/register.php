<?php
session_start();
include('includes/header.php')?>

<div class="py-5"></div>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
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
    <div class="card">
      <div class="card-header">
          <h4>Registration Form</h4>
      </div>
      <div class="card-body">
        <form action="functions/authcode.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter your username">
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email">
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Full Name</label>
            <input type="text" name="fullname" class="form-control" placeholder="Enter your fullname">
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter password">
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password"class="form-control" placeholder="Confirm password">
          </div>
          <button type="submit" name="register_btn" class="btn btn-primary">Register</button>
    </form>
      </div>
    </div>
    </div>
  </div>
</div>




<?php include('includes/footer.php')?>
