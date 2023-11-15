<?php 
// ob_start();
// session_start();
//
if(isset($_SESSION['cart_number']) && $_SESSION['cart_number'] < 0){
  $_SESSION['cart_number'] = 0;
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container">
    <a class="navbar-brand" href="index.php">PHP ECOMMERCE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart-list.php">Cart(<span style="color:yellow;"><?= isset($_SESSION['cart_number']) ? $_SESSION['cart_number'] : 0?></span>)</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="order-list.php">Order(<span style="color:yellow;"><?= isset($_SESSION['order_number']) ? $_SESSION['order_number'] : 0?></span>)</a>
        </li>
        <?php 
        if(isset($_SESSION['auth'])){
        ?>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $_SESSION['auth_user']['full_name'];?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="infomation.php">Infomation</a></li>
            <li><a class="dropdown-item" href="#">Setting</a></li>
          <?php 
          if($_SESSION['role_id'] == 1){
          ?>
            <li><a class="dropdown-item" href="admin/index.php">AdminPage</a></li>
          <?php
          }
          ?>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>

        <?php
        }else{
        ?>

        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>

        <?php
        }
        ?>
      </ul>
    </div>
  </div>
</nav>
