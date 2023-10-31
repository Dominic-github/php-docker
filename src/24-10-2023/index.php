<?php 
  
class Product{
    public $ProductID;
    public $ProductName;
    public $Description;
    public $Price;
    public $StockQuantity;
    public function __constructor($customerID, $ProductName,$Description,$Price,$StockQuantity){
      $this->ProductID= $ProductID;
      $this->ProductName = $ProductName;
      $this->Description= $Description;
      $this->Price= $Price;
      $this->StockQuantity= $StockQuantity;
    }
}
header('Content-Type: text/html; charset=UTF-8');

include_once('connectDB.php');

$query = mysqli_query($conn,"SELECT *  FROM Products");


if(isset($_POST['delete'])){

}


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
  <h1 class="header">Danh sách Sản Phẩm</h1>

  <input type="text" class="input"/>
  <button class="btn btn-primary">Search</button> 


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



while($row = mysqli_fetch_assoc($query) ):

?>
    <tr class='products'>
      <th scope="row"><?=$row["ProductID"]?></th>
      <td><input type='text' class="input notChange" readonly value='<?=$row["ProductName"]?>'/></td>
      <td><input type='text' class="notChange" readonly value="<?=$row["Description"]?>"/></td>
      <td><input type='number' class="notChange" readonly value="<?=$row["Price"]?>"/></td>
      <td><input type='number' class="notChange" readonly value="<?=$row["StockQuantity"]?>"/></td>
      <td class="actions">

        <form  method="post" action="index.php">
          <input type="submit" class='btn btn-primary changeProduct' name='change' value="Sửa"/>

          <input type="submit" class='btn btn-primary deleteProduct' name='delete' value="Xóa" />
        </form>
      </td>
    </tr>
 <?php  endwhile?>


  </tbody>
</table>

<script>

  let changeButton = document.querySelectorAll('.changeProduct')

  // let productList = document.querySelectorAll('.')

  
changeButton.forEach((btn)=>{

btn.addEventListener("click", ()=>
{
    btn.value = btn.value == "Sửa" ? "Xong" : "Sửa" 
    // btn.innerHTML = btn.value    
    btn.type = btn.type == "submit" ? "button" : "submit" 
 
})
})

</script>


</main>
</body>
</html>
