<?php


if(isset($_POST['submitAdd'])){

  include_once('connectDB.php');

  $tensp=$_POST['tensp'];
  $chitietsp=$_POST['chitietsp'];
  $giasp=$_POST['giasp'];
  $soluongsp=$_POST['soluongsp'];

  if($tensp && $chitietsp && $giasp && $soluongsp){

    $query = "INSERT into Products(ProductName, Description, Price, StockQuantity) VALUES ('$tensp', '$chitietsp', '$giasp', '$soluongsp')";
  

    if(mysqli_query($conn,$query)){
      echo "Nhập sản phẩm thành công. <a href='javascript: history.go(-1)'>Trở lại</a>";
    }else{
      echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

  }
  die();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
  <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>Document</title>
</head>
<body>
    <h1 class="header">Thêm Sản Phẩm</h1>

<main>
<form action="addProduct.php" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Tên Sản Phẩm</label>
    <input type="text" name='tensp' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập tên sản phẩm">
  </div>
      <div class="form-group">
    <label for="exampleInputEmail1">Thông tin chi tiết</label>
    <input type="text" name='chitietsp' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập thông tin chi tiết sản phẩm">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Giá</label>
    <input type="number" name='giasp' class="form-control" id="exampleInputPassword1" placeholder="Nhập giá sản phẩm">
  </div>
      <div class="form-group">
    <label for="exampleInputEmail1">Số Lượng</label>
    <input type="number" name='soluongsp' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập số lượng ản phẩm">
  </div>
  <button type="submit" name="submitAdd" class="btn btn-primary">Submit</button>
</form>
</main>
</body>
</html>
