<?php 
  

include_once('connectDB.php');



if(isset($_POST['search'])){

}

if(isset($_POST['change'])){
  // $tensp=
  // $description=
  // $price=
  // $stock_quantity=

}

if(isset($_POST['delete'])){

  $id = $_GET['id'];
  $query = "DELETE FROM Products WHERE product_id = $id";

  if(mysqli_query($conn,$query)){
    $message = "Xóa thành công sản phẩm có id: $id";
    echo "<script type='text/javascript'>alert('$message');</script>"; 
  }

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
   <a class="btn btn-primary" href="admin.php">Back</a>
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
      <th scope="col">Hành động</th>
    </tr>
  </thead>
  <tbody>
  


<?php 

$index = 0;

while($row = mysqli_fetch_assoc($query) ):

?>
    <tr class='products'>
      <th scope="row"><?=$row["product_id"]?></th>
      <td><input type='text' class="input notChange" readonly value='<?=$row["product_name"]?>'/></td>
      <td><input type='text' class="notChange" readonly value="<?=$row["description"]?>"/></td>
      <td><input type='number' class="notChange" readonly value="<?=$row["price"]?>"/></td>
      <td><input type='number' class="notChange" readonly value="<?=$row["stock_quantity"]?>"/></td>
      <td class="actions">

        <form  method="post" action="listProducts.php?id=<?=$row["product_id"]?>">
          <input type="submit" class='btn btn-primary changeProduct' id='<?=$index?>' name='change' value="Sửa"/>

          <input type="submit" class='btn btn-primary deleteProduct' id="<?=$index?>" name='delete' value="Xóa" />
        </form>
      </td>
    </tr>
 <?php  $index++; endwhile?>


  </tbody>
</table>

<script>

  let changeButton = document.querySelectorAll('.changeProduct')

  let productList = document.querySelectorAll('.products input')


  
changeButton.forEach((btn)=>{

btn.addEventListener("click", ()=>
{
  let index = 0;
    
    let id = btn.id
    btn.value = btn.value == "Sửa" ? "Xong" : "Sửa" 
    btn.type = btn.type == "submit" ? "button" : "submit" 
    for(let index = id * 6; index < id * 6 + 4; index++ ){
      productList[index].classList.contains('notChange') ? productList[index].classList.remove('notChange'):productList[index].classList.add('notChange')
      productList[index].readOnly = !productList[index].readOnly;

    }


 
})
})

</script>


</main>
</body>
</html>

