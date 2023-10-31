<?php 
if( empty(session_id()) && !headers_sent()){
    session_start();
} 

include_once('connectDB.php');


if(isset($_POST['search'])){

}

$query = mysqli_query($conn,"SELECT *  FROM Products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
  <link rel="stylesheet" href="style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>Quản lý Sản Phẩm</title>
</head>
    <body>


       <?php 
       if (isset($_SESSION['username']) && $_SESSION['username']){
           echo"<div class='header'>";
           echo "<h1>User Page</h1>";
           echo '<a class="logout" href="logout.php">Logout</a>';
           echo"</div>";
       }else{
           echo 'Bạn chưa đăng nhập'."<br/>";
           echo 'Click vào đây để <a href="login.php">đăng nhập</a>';
       }
        ?>

  <?php if (isset($_SESSION['username']) && $_SESSION['username']): ?>

  <h1 class="header">Danh sách Sản Phẩm</h1>

<form action="listProducts.php" method="post">
  <input type="text" class="input"/>
  <button class="btn btn-primary" name="search">Search</button> 
</form>

<main>
  <table class="table">
  <thead>
    <tr>
      <th scope="col">Mã Sản Phẩm</th>
      <th scope="col">Tên Sản Phẩm</th>
      <th scope="col">Mô tả</th>
      <th scope="col">Giá</th>
      <th scope="col">Số Lượng</th>
    </tr>
  </thead>
  <tbody>
  

<?php while($row = mysqli_fetch_assoc($query) ): ?>
    <tr class='products'>
      <th scope="row"><?=$row["product_id"]?></th>
      <td><input type='text' class="input notChange" readonly value='<?=$row["product_name"]?>'/></td>
      <td><input type='text' class="notChange" readonly value="<?=$row["description"]?>"/></td>
      <td><input type='number' class="notChange" readonly value="<?=$row["price"]?>"/></td>
      <td><input type='number' class="notChange" readonly value="<?=$row["stock_quantity"]?>"/></td>
      <td class="actions">

      </td>
    </tr>
 <?php  endwhile?>


  </tbody>
</table>


</main>

       
       <?php endif ?>
    </body>
</html>

