<?php


if(isset($_POST['submitAdd'])){

    include_once('connectDB.php');


    $username=$_POST['username'];
    $password=$_POST['password'];
    $repassword=$_POST['repassword'];
    $email=$_POST['email'];
    $fullname=$_POST['fullname'];
    $role=$_POST['role'];


    $role_id;



     //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
     if (!$username || !$password || !$fullname || !$email || !$repassword ||!$role) {
      echo "Vui lòng nhập đầy đủ thông tin. <a href='javascript: history.go(-1)'>Trở lại</a>";
      exit;
    }

    $role_id = $role == "Admin" ? 1 : 2;
    //Kiểm tra tên đăng nhập này đã có người dùng chưa
    if (mysqli_num_rows(mysqli_query($conn,"SELECT username FROM Users WHERE username='$username'")) > 0){
      echo "Tên đăng nhập này đã có người dùng. Vui lòng chọn tên đăng nhập khác. <a href='javascript: history.go(-1)'>Trở lại</a>";
      exit;
    }

    if($password != $repassword){
      echo "Mật khẩu không giống nhau. Vui lòng nhập lại. <a href='javascript: history.go(-1)'>Trở lại</a>";
      exit;
    }

    $password = md5($password);


    $query = "INSERT into Users(username, password, full_name, email, role_id) VALUES ('$username', '$password', '$fullname', '$email', $role_id)";
    if(mysqli_query($conn,$query)){
     $message = "Thêm người dùng thành công ";
      echo "<script type='text/javascript'>alert('$message');</script>"; 
    }else{
      $message = "Error: " . $query . "<br>" . mysqli_error($conn);
      echo "<script type='text/javascript'>alert('$message');</script>"; 
    }
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
   <a class="btn btn-primary" href="admin.php">Back</a>
    <h1 class="header">Thêm User</h1>

<main>

<form action="addUser.php" method="post">
  <div class="form-group">
    <label for="">Username</label>
    <input type="text" name='username' class="form-control" aria-describedby="emailHelp" placeholder="Nhập tên người dùng">
  </div>
    <div class="form-group">
    <label for="">FullName</label>
    <input type="text" name='fullname' class="form-control" aria-describedby="emailHelp" placeholder="Nhập tên đầy đủ">
  </div>

  <div class="form-group">
    <label for="">Password</label>
    <input type="password" name='password' class="form-control" aria-describedby="emailHelp" placeholder="Nhập mật khẩu">
  </div>

  <div class="form-group">
    <label for="">Re Password</label>
    <input type="password" name='repassword' class="form-control"  aria-describedby="emailHelp" placeholder="Nhập lại mật khẩu">
  </div>

  <div class="form-group">
    <label for="">Email</label>
    <input type="email" name='email' class="form-control" placeholder="Nhập email">
  </div>

  <div class="form-group">
    <div class="form-check">
    <input class="form-check-input" type="radio" name="role" value="Admin" id="" checked>
    <label class="form-check-label" for="flexRadioDefault1">
     Admin
    </label>
    </div>
    <div class="form-check">
    <input class="form-check-input" type="radio" name="role" value="User" id="flexRadioDefault2" >
    <label class="form-check-label" for="flexRadioDefault2">
      User
    </label>
  </div>
  
</div>
  <button type="submit" name="submitAdd" class="btn btn-primary">Submit</button>
</form>
</main>
</body>
</html>


