<?php 
session_start();
include('../../config/connectDB.php');
include('../../functions/myfunctions.php');


if(isset($_POST['add-product'])){

  $product_name=$_POST['product_name'];
  $desc=$_POST['desc'];
  $price=$_POST['price'];
  $quantity=$_POST['quantity'];

  if($product_name && $desc && $price && $quantity){

    $query = "INSERT into Products(product_name, description, price, stock_quantity) VALUES ('$product_name', '$desc', '$price', '$quantity')";
  

    if(mysqli_query($conn,$query)){
      redirect("../add-product.php", "Add Pruduct is Successfully","success");
    }else{
      redirect("../add-product.php", mysqli_error($conn),"error");
    }
  }else{
    redirect("../add-product.php", "Please enter in full", "warning");
  }

}

if(isset($_POST['delete-product'])){
  $id = $_GET['id'];
  $query = "DELETE FROM Products WHERE product_id = $id";

  if(mysqli_query($conn,$query)){
      redirect("../product-list.php", "Remove is Successfully","success");
  }else{
      redirect("../product-list.php", "Remove is Error","error");

  }
}

if(isset($_POST['change-product'])){
  $id = $_GET['id'];

  $product_name=$_POST['product_name'];
  $desc=$_POST['desc'];
  $price=$_POST['price'];
  $quantity=$_POST['quantity'];

  if($product_name && $desc && $price && $quantity){

    $query = "Update Products
              SET product_name = '$product_name', description = '$desc', price = '$price', stock_quantity = '$quantity' 
              WHERE product_id='$id'";
  

    if(mysqli_query($conn,$query)){
      redirect("../product-list.php", "Add Pruduct is Successfully","success");
    }else{
      redirect("../product-list.php", mysqli_error($conn),"error");
    }
    }else{
      redirect("../product-list.php", "Please enter in full", "warning");
    }
}

if(isset($_POST['add-user'])){

  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $fullname=mysqli_real_escape_string($conn, $_POST['fullname']);
  $password=mysqli_real_escape_string($conn, $_POST['password']);
  $confirm_password=mysqli_real_escape_string($conn, $_POST['confirm_password']);
  $email=mysqli_real_escape_string($conn, $_POST['email']);
  $role=mysqli_real_escape_string($conn, $_POST['role']);

  $role_id;

   //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
  if (!$username || !$password || !$fullname || !$email || !$confirm_password || !$role) {
    redirect("../add-user.php", "Enter complate information","warning");
  }
  $role_id = $role == "Admin" ? 1 : 2;

  //Kiểm tra tên đăng nhập này đã có người dùng chưa
  if (mysqli_num_rows(mysqli_query($conn,"SELECT username FROM Users WHERE username='$username'")) > 0){
    redirect("../add-user.php", "Username is already","error");
  }

  //Kiểm tra email đã tồn tại chưa
  
  $check_email_query = "SELECT email FROM Users WHERE email='$email' ";
  $check_email_query_run = mysqli_query($conn, $check_email_query);
  if(mysqli_num_rows($check_email_query_run) > 0){
    redirect("../add-user.php", "Email is already","error");
  }
  
  //Kiểm tra mật khẩu
  if($password != $confirm_password){
    redirect("../add-user.php", "Passwords do not match","error");
  }

  $password = md5($password);
  $query = "INSERT into Users(username, password, full_name, email, role_id) VALUES ('$username', '$password', '$fullname', '$email', 2)";
  if(mysqli_query($conn,$query)){

    redirect("../add-user.php", "Add User is Successfully","success");
    
  }else{
    redirect("../add-user.php", mysqli_error($conn),"error");
  }
}


if(isset($_POST['change-user'])){

  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $fullname=mysqli_real_escape_string($conn, $_POST['fullname']);
  $password=mysqli_real_escape_string($conn, $_POST['password']);
  $confirm_password=mysqli_real_escape_string($conn, $_POST['confirm_password']);
  $email=mysqli_real_escape_string($conn, $_POST['email']);
  $role=mysqli_real_escape_string($conn, $_POST['role']);

  $role_id;

   //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
  if (!$username || !$password || !$fullname || !$email || !$confirm_password || !$role) {
    redirect("../user-list.php", "Enter complate information","warning");
  }
  $role_id = $role == "Admin" ? 1 : 2;

  
  //Kiểm tra mật khẩu
  if($password != $confirm_password){
    redirect("../user-list.php", "Passwords do not match","error");
  }
  $password = md5($password);

  $query = "Update Users
              SET username = '$username', email = '$email', full_name = '$full_name', password= '$password',role_id = '$role_id' 
              WHERE user_id='$id'";

  if(mysqli_query($conn,$query)){
    redirect("../user-list.php", "Change User is Successfully","success");
    
  }else{
    redirect("../user-list.php", mysqli_error($conn),"error");
  }
}


if(isset($_POST['delete-user'])){
  $id = $_GET['id'];
  $query = "DELETE FROM Users WHERE user_id= $id";

  if(mysqli_query($conn,$query)){
      redirect("../user-list.php", "Remove is Successfully","success");
  }else{
      redirect("../user-list.php", "Remove is Error","error");

  }
}

if(isset($_POST['add-user-csv'])){

    
    $filename=$_FILES["file"]["tmp_name"];    
     if($_FILES["file"]["size"] > 0)
     {
        $file = fopen($filename, "r");
          while (($getData = fgetcsv($file)) !== FALSE)
           {
            $username  = $getData[0];
            $fullname = $getData[1];
            $email = $getData[2];
            $password = md5($getData[3]);
            $role_id = $getData[4];

  $query = "INSERT into Users(username, password, full_name, email, role_id) VALUES ('$username', '$password', '$fullname', '$email', $role_id)";

          mysqli_query($conn,$query);
           }
       }

    redirect("../add-user.php", "Add User is Successfully","success");
      
           fclose($file);  
  }

  if(isset($_POST[ 'export-user-csv' ])){
    $filename = "users_" . date('Y-m-d') . ".csv"; 
    $delimiter = ","; 
    $f = fopen('php://memory', 'w'); 
    $fields = array('ID', 'Username', 'Passowrd', 'Fullname', 'Email', 'RoleID'); 

    fputcsv($f, $fields, $delimiter); 

    $result = $conn->query("SELECT * FROM Users ORDER BY user_id DESC"); 

if ($result->num_rows > 0) { 

    while ($row = $result->fetch_assoc()) { 

        $lineData = array($row['user_id'], $row['username'], $row['password'], $row['full_name'], $row['email'], $row['role_id']); 

        fputcsv($f, $lineData, $delimiter); 

    } 

} 

fseek($f, 0); 

header('Content-Type: text/csv'); 

header('Content-Disposition: attachment; filename="' . $filename . '";'); 

fpassthru($f); 

   redirect("../user-list.php", "Export is Successfully","success");
  }



if(isset($_POST['add-product-csv'])){

    
    $filename=$_FILES["file"]["tmp_name"];    
     if($_FILES["file"]["size"] > 0)
     {
        $file = fopen($filename, "r");
          while (($getData = fgetcsv($file)) !== FALSE)
           {
            $product_name= $getData[0];
            $desc= $getData[1];
            $price= $getData[2];
            $quantity= $getData[3];

  $query = "INSERT into Products(product_name, description, price,  stock_quantity) 
         VALUES ('$product_name', '$desc', '$price', '$quantity')";

          mysqli_query($conn,$query);
           }
       }

    redirect("../add-product.php", "Add User is Successfully","success");
      
           fclose($file);  
  }

  if(isset($_POST[ 'export-product-csv' ])){
    $filename = "products_" . date('Y-m-d') . ".csv"; 
    $delimiter = ","; 
    $f = fopen('php://memory', 'w'); 
    $fields = array('ID', 'ProductName', 'Description', 'Price', 'Quantity'); 

    fputcsv($f, $fields, $delimiter); 

    $result = $conn->query("SELECT * FROM Products ORDER BY product_id DESC"); 

if ($result->num_rows > 0) { 

    while ($row = $result->fetch_assoc()) { 

        $lineData = array($row['product_id'], $row['product_name'], $row['description'], $row['price'], $row['stock_quantity']); 

        fputcsv($f, $lineData, $delimiter); 

    } 

} 

fseek($f, 0); 

header('Content-Type: text/csv'); 

header('Content-Disposition: attachment; filename="' . $filename . '";'); 

fpassthru($f); 

   redirect("../user-list.php", "Export is Successfully","success");
  }


if(isset($_POST['add-customer'])){

 $first_name=$_POST['first_name'];
  $last_name=$_POST['last_name'];
  $email=$_POST['email'];
  $phone=$_POST['phone'];

  if($first_name && $last_name && $email && $phone){

    $query = "INSERT into Customers(first_name, last_name, email, phone) VALUES ('$first_name', '$last_name', '$email', '$phone')";
  

    if(mysqli_query($conn,$query)){
      redirect("../add-customer.php", "Add Customer is Successfully","success");
    }else{
      redirect("../add-customer.php", mysqli_error($conn),"error");
    }
  }else{
    redirect("../add-customer.php", "Please enter in full", "warning");
  }

}

if(isset($_POST['delete-customer'])){
  $id = $_GET['id'];
  $query = "DELETE FROM Customers WHERE customer_id= $id";

  if(mysqli_query($conn,$query)){
      redirect("../customer-list.php", "Remove is Successfully","success");
  }else{
      redirect("../customer-list.php", "Remove is Error","error");

  }
}

if(isset($_POST['change-customer'])){
  $id = $_GET['id'];

  $first_name=$_POST['first_name'];
  $last_name=$_POST['last_name'];
  $email=$_POST['email'];
  $phone=$_POST['phone'];

  if($first_name && $last_name && $email && $phone){

    $query = "Update Products
              SET first_name = '$first_name', last_name= '$last_name', email= '$email', phone= '$phone' 
              WHERE product_id='$id'";
  

    if(mysqli_query($conn,$query)){
      redirect("../customer-list.php", "Add Customer is Successfully","success");
    }else{
      redirect("../customer-list.php", mysqli_error($conn),"error");
    }
    }else{
      redirect("../customer-list.php", "Please enter in full", "warning");
    }
}

if(isset($_POST['add-customer-csv'])){

    
    $filename=$_FILES["file"]["tmp_name"];    
     if($_FILES["file"]["size"] > 0)
     {
        $file = fopen($filename, "r");
          while (($getData = fgetcsv($file)) !== FALSE)
           {
            $first_name= $getData[0];
            $last_name= $getData[1];
            $email= $getData[2];
            $phone= $getData[3];

  $query = "INSERT into Customers(product_name, description, price,  stock_quantity) 
         VALUES ('$first_name', '$last_name', '$email', '$phone')";

          mysqli_query($conn,$query);
           }
       }

    redirect("../add-customer.php", "Add Customer is Successfully","success");
      
           fclose($file);  
  }

  if(isset($_POST[ 'export-customer-csv' ])){
    $filename = "customers_" . date('Y-m-d') . ".csv"; 
    $delimiter = ","; 
    $f = fopen('php://memory', 'w'); 
    $fields = array('ID', 'FirstName', 'LastName', 'Email', 'Phone'); 

    fputcsv($f, $fields, $delimiter); 

    $result = $conn->query("SELECT * FROM Customers ORDER BY customer_id DESC"); 

if ($result->num_rows > 0) { 

    while ($row = $result->fetch_assoc()) { 

        $lineData = array($row['customer_id'], $row['first_name'], $row['last_name'], $row['email'], $row['phone']); 

        fputcsv($f, $lineData, $delimiter); 

    } 

} 

fseek($f, 0); 

header('Content-Type: text/csv'); 

header('Content-Disposition: attachment; filename="' . $filename . '";'); 

fpassthru($f); 

   redirect("../customer-list.php", "Export is Successfully","success");
  }




if(isset($_POST['add-order'])){

  $customer_name =$_POST['customer_name'];
  $product_name=$_POST['product_name'];
  $quantity=$_POST['quantity'];
  $username = 'admin';

  if($product_name && $username &&  $quantity){

    $selectUser = "Select * from Users where username = '$username'";
    $selectProduct= "Select * from Products where product_name = '$product_name' ";
    $selectCustomer= "Select * from Customers where  first_name = '$customer_name'";
    
    $user = mysqli_fetch_assoc(mysqli_query($conn,$selectUser)); 
    $product = mysqli_fetch_assoc(mysqli_query($conn,$selectProduct)); 
    $customer = mysqli_fetch_assoc(mysqli_query($conn,$selectCustomer)); 

    $user_id = $user['user_id'];
    $customer_id=$customer['customer_id']; 
    $total_amount = $product['price'] * $quantity;

    $query = "Insert Into Orders(customer_id, user_id, total_amount)
        Values('$user_id', '$customer_id', '$total_amount') "; 

    if(mysqli_query($conn,$query)){
      redirect("../add-order.php", "Add Order is Successfully","success");
    }else{
      redirect("../add-order.php", mysqli_error($conn),"error");
    }
  }else{
    redirect("../add-order.php", "Please enter in full", "warning");
  }

}


?>