<?php 

session_start();
include('../config/connectDB.php');
include('myfunctions.php');
require_once('../middleware/dompdf/autoload.inc.php');
use Dompdf\Dompdf;

if(isset($_POST['export-order'])){
// instantiate and use the dompdf class
$order_id = $_GET['id'];

if(isset($_SESSION['auth'])){
  $user_id = $_SESSION['auth_user']['user_id'];
  $getUser = mysqli_query($conn,"SELECT *  FROM Users where user_id = '$user_id'");
  $getOrder = mysqli_query($conn,"SELECT *  FROM Orders where user_id = '$user_id'  ORDER BY 	order_date DESC ");
}else{
  $customer_id = $_SESSION['auth_customer']['customer_id'];
  $getCustomer= mysqli_query($conn,"SELECT *  FROM Customers where customer_id = '$customer_id'");
  $getOrder = mysqli_query($conn,"SELECT *  FROM Orders where customer_id = '$customer_id'  ORDER BY 	order_date DESC ");
}

// $getCustomer= mysqli_query($conn,"SELECT *  FROM Customers where customer_id = '$customer_id'");

$dompdf = new Dompdf();
$html = '';
$html .= '

<head>
<style>
@font-face{
  font-family: "DejaVu";
  src: url("../middleware/fonts/DejaVu.ttf");
}
  *{
    width: 100vw;
    height: 100vh;
    font-family: "Dejavu Sans"
  }
  footer{
    display: flex;
    justify-content: space-between;
  }

  .styled-table {
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
    font-family: DejaVu;
    width: 100%;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}
  .styled-table thead tr {
    background-color: #009879;
    color: #ffffff;
    text-align: left;
}
  .styled-table th,
.styled-table td {
    padding: 12px 15px;
}
  .styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
}
  .styled-table tbody tr.active-row {
    font-weight: bold;
    color: #009879;
}


</style>
</head>
<body >
<div styles="">
  <div>
    <h1 align="left">PHP Ecomercce</h1>
    
    <h1 align="center" style="color: gray" >
      Invoice
    </h1>
  </div>
';

if(isset($_SESSION['auth'])){
  $user = mysqli_fetch_assoc($getUser); 
  $order= mysqli_fetch_assoc($getOrder); 

  $full_name = $user['full_name'];
  $email= $user['email'];
  $phone= '';
  $time = $order['order_date'];
}else{
  $customer = mysqli_fetch_assoc($getCustomer); 
  $order= mysqli_fetch_assoc($getOrder); 
  $full_name = $customer['full_name'];
  $email= $customer['email'];
  $phone= $customer['phone'];
  $time = $order['order_date'];
}



$html .= '
  <main class="">
    <div class="main_header" style="
                         ">
      <div class="">
         <h3>Billed To:</h3>
        <p>FullName: '.$full_name.'</p>
        <p>Email: '.$email.'</p>
        <p>Phone: '.$phone.'</p>
      </div>
      <div class="">
         <h3>Order:</h3>
        <p>OrderID: '.$order_id.' </p>
        <p>Issued: '.$time.'</p>
        
      </div>
    </div>
    <table class="styled-table">
    <thead>
        <tr>
            <th>STT</th>
            <th>Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
';



$index = 0; 
$getProducts= "SELECT *  FROM OrderDetails 
join Products 
on OrderDetails.product_id = Products.product_id
where
OrderDetails.order_id = '$order_id'
";
$product_list_id = "";
$subTotal = 0;
$query = mysqli_query($conn,$getProducts);

while($product_list = mysqli_fetch_assoc($query)){
$product_list_id = $product_list_id == '' ? $product_list['product_id']: $product_list_id.','.$product_list['product_id'];
}

$getProduct= mysqli_query($conn, "SELECT * FROM Products where product_id in ($product_list_id) ");
$query = mysqli_query($conn,$getProducts);


while ($product = mysqli_fetch_assoc($getProduct)  ) {
$product_list = mysqli_fetch_assoc($query);

$quantity = $product_list['quantity'];
$subTotal = $product_list['subtotal'];

   $html.=
      '<tr>
            <td>'.$index.'</td>
            <td>'.$product["product_name"].'</td>
            <td>'.$product["description"].'</td>
            <td>'.$quantity.'</td>
            <td>'.$subTotal.'VND</td>
       </tr>';
$index++;
}   

$html.='
  </tbody>    
</table>
  </main>
  <footer class="">
      <h2 align="right" style="margin-right: 20px;">Total: '.$order["total_amount"].'VND</h2>
  </footer>
</div>
</body>
';
}


$dompdf->loadHtml($html);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();

redirect("../order-list.php","Export is success", "success");

?>
