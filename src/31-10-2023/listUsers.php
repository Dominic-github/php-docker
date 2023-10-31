<?php 
  

include_once('connectDB.php');

if(isset($_POST['search'])){

}


if(isset($_POST['delete'])){

  $id = $_GET['id'];
  $query = "DELETE FROM Users WHERE user_id = $id";

  if(mysqli_query($conn,$query)){
    $message = "Xóa thành công người dùng có id: $id";
    echo "<script type='text/javascript'>alert('$message');</script>"; 
  }

}





$query = mysqli_query($conn,"SELECT *  FROM Users");

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
  <title>Quan ly</title>
</head>
<body>
   <a class="btn btn-primary" href="admin.php">Back</a>
  <h1 class="header">Danh sách người dùng</h1>

<form action="listUser.php" method="post">
  <input type="text" class="input"/>
  <button class="btn btn-primary" name="search">Search</button> 
</form>

<main>
  <table class="table">
  <thead>
    <tr>
      <th scope="col">Mã Người dùng</th>
      <th scope="col">Tên người dùng</th>
      <th scope="col">Tên đầy đủ</th>
      <th scope="col">Email</th>
      <th scope="col">Role</th>
      <th scope="col">Hành động</th>
    </tr>
  </thead>
  <tbody>
  


<?php 



while($row = mysqli_fetch_assoc($query)):

?>
    <tr class='products'>
      <th scope="row"><?=$row["user_id"]?></th>
      <td><input type='text' class="input notChange" readonly value='<?=$row["username"]?>'/></td>
      <td><input type='text' class="notChange" readonly value="<?=$row["full_name"]?>"/></td>
      <td><input type='text' class="notChange" readonly value="<?=$row["email"]?>"/></td>
      <td><input type='text' class="notChange" readonly value="<?=$row["role_id"] == 1 ? 'Admin' : 'User'?>"/></td>
      <td class="actions">

        <form  method="post" action="listUsers.php?id=<?=$row["user_id"]?>">
          <input type="submit" class='btn btn-primary changeProduct' name='change' value="Sửa"/>

          <input type="submit" class='btn btn-primary deleteProduct' name='delete' value="Xóa" />
        </form>
      </td>
    </tr>
 <?php  endwhile?>


  </tbody>
</table>


</main>
</body>
</html>


