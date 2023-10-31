<?php 
  //Khai báo utf-8 để hiển thị được tiếng việt
header('Content-Type: text/html; charset=UTF-8');

  if (isset($_POST['register'])){

    //Kết nối tới database
    include_once('connectDB.php');
     
    //Lấy dữ liệu nhập vào
    $email = addslashes($_POST['txtEmail']);
    $username = addslashes($_POST['txtUsername']);
    $fullname = addslashes($_POST['txtFullname']);
    $password = addslashes($_POST['txtPassword']);
    $repassword = addslashes($_POST['txtRePassword']);

     //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
     if (!$username || !$password || !$fullname || !$email || !$repassword) {
      echo "Vui lòng nhập đầy đủ thông tin. <a href='javascript: history.go(-1)'>Trở lại</a>";
      exit;
    }
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


    $query = "INSERT into Users(username, password, full_name, email, role_id) VALUES ('$username', '$password', '$fullname', '$email', 2)";
    if(mysqli_query($conn,$query)){
      echo "Bạn đã đăng ký thành công. Vui lòng<a href='login.php'> đăng nhập</a>";
    }else{
      echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    die();
  }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Trang đăng ký</title>
    </head>
    <body>
        <h1>Trang đăng ký thành viên</h1>
        <form action="register.php?do=register" method="POST">
            <table cellpadding="0" cellspacing="0" border="1">
                <tr>
                    <td>
                        Tên đăng nhập : 
                    </td>
                    <td>
                        <input type="text" name="txtUsername" size="50" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Email: 
                    </td>
                    <td>
                        <input type="email" name="txtEmail" size="50" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Tên đầy đủ : 
                    </td>
                    <td>
                        <input type="text" name="txtFullname" size="50" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Mật khẩu :
                    </td>
                    <td>
                        <input type="password" name="txtPassword" size="50" />
                    </td>
                </tr>
                <tr>
                    <td>
                    Nhập lại mật khẩu :
                    </td>
                    <td>
                        <input type="password" name="txtRePassword" size="50" />
                    </td>
                </tr>
               
            </table>
            <input type="submit" name='register' value="Đăng ký" />
            <input type="reset" value="Nhập lại" />
        </form>
    </body>
</html>
