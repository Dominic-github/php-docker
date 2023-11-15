<?php
session_start();
include('functions/myfunctions.php');

if(isset($_SESSION['auth'])){
  redirect("index.php", "You are already logged In", "warning");
}

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
      ?>
    <div class="card">
      <div class="card-header">
          <h4>Login Form</h4>
      </div>
      <div class="card-body">
        <form action="functions/authcode.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Username or Email</label>
            <input required type="text" name="username_email" class="form-control" placeholder="Enter your username">
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input required type="password" name="password" class="form-control" placeholder="Enter password">
          </div>
          <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
    </form>
      </div>
    </div>
    </div>
  </div>
</div>




<?php include('includes/footer.php')?>
