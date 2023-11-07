<?php 
session_start();
include('config/connectDB.php');

$username = $_SESSION['username'];
$query = mysqli_query($conn,"SELECT *  FROM Users Where username = '$username' ");

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

      </div>
      </div>
      </div>
      </div>

<?php include('includes/footer.php')?>
