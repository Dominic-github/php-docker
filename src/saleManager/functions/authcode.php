<?php 
session_start();
include('../config/connectDB.php');

if(isset($_POST['register_btn'])){

  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $full_name=mysqli_real_escape_string($conn, $_POST['full_name']);
  $password=mysqli_real_escape_string($conn, $_POST['password']);
  $confirm_password=mysqli_real_escape_string($conn, $_POST['confirm_password']);
  $email=mysqli_real_escape_string($conn, $_POST['email']);

   //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
  if (!$username || !$password || !$full_name|| !$email || !$confirm_password) {
    $_SESSION['message'] = "enter complate information";
    header('location: ../register.php');
    exit;
  }
      
  //Kiểm tra tên đăng nhập này đã có người dùng chưa
  if (mysqli_num_rows(mysqli_query($conn,"SELECT username FROM Users WHERE username='$username'")) > 0){
    $_SESSION['message'] = "Username is already";
    header('Location: ../register.php');
    exit;
  }

  //Kiểm tra email đã tồn tại chưa
  
  $check_email_query = "SELECT email FROM Users WHERE email='$email' ";
  $check_email_query_run = mysqli_query($conn, $check_email_query);
  if(mysqli_num_rows($check_email_query_run) > 0){
    $_SESSION['message'] = "Email is already";
    header('Location: ../register.php');
    exit;
  }
  
  //Kiểm tra mật khẩu
  if($password != $confirm_password){
    $_SESSION['message'] = "Passwords do not match";
    header('Location: ../register.php');
    exit;
  }

  $password = md5($password);
  $query = "INSERT into Users(username, password, full_name, email, role_id) VALUES ('$username', '$password', '$fullname', '$email', 2)";
  if(mysqli_query($conn,$query)){

    $_SESSION['message'] = "Registered Successfully";
    header('Location: ../login.php');
    exit;
    
  }else{
    $_SESSION['message'] = mysqli_error($conn);
    header('Location: ../register.php');
    exit;
  }
}


if(isset($_POST['login_btn'])){

  $username_email = mysqli_real_escape_string($conn, $_POST['username_email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $password = md5($password);

   //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
  if (!$username_email || !$password ) {
    $_SESSION['message'] = "Enter complate information";
    header('Location: ../login.php');
    exit;
  }

  $query ="SELECT * FROM Users WHERE ( username='$username_email' OR email='$username_email') AND password='$password' " ;

  $query_run = mysqli_query($conn, $query);

  if(mysqli_num_rows($query_run) > 0){
    unset($_SESSION['auth_customer']);

    $_SESSION['auth'] = true;

    $userdata = mysqli_fetch_array($query_run);
    $user_id = $userdata['user_id'];
    $username = $userdata['username'];
    $email = $userdata['email'];
    $full_name= $userdata['full_name'];
    $role_id = $userdata['role_id'];
    $_SESSION['auth_user'] = [
      'user_id' => $user_id,
      'username' => $username,
      'email' => $email,
      'full_name' => $full_name
    ];

    $_SESSION['role_id'] = $role_id;

    if($role_id == 1){
      $_SESSION['message'] = "Welcome to Dashboard";
      header('Location: ../admin/index.php');
    }else{
      $_SESSION['message'] = "Logged is Successfully";
      header('Location: ../index.php');
    }

  }else{
    $_SESSION['message'] = "Username, email or password is incorrect";
    header('Location: ../login.php');
  }





}


?>
