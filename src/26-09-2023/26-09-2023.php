<?php
?>


        <form action="user" method="post">
        <h1>Nhap san pham</h1>
            <label for="">Ten san pham</label>
            <input type="text" name="tensp" value="" />
        <br/>

            <label for="">so luong</label>
            <input type="text" name="soluong" value="" />

        <br/>
            <label for="">da ban</label>
            <input type="text" name="daban" value="" />

        <br/>
            <label for="">ton kho</label>
            <input type="text" name="tonkho" value="" />
<button>Them</button>
        </form>


  <div class="htsp">

  <h1>San pham ban chay nhat</h1>
<?php

$loaisp = array(
  array(1,'traicay'),
  array(2,'banh'),
  array(3,'do uong')

);
$sanpham = array(
 array(1,'tao',14,100),
 array(2,'coca',120,210),
 array(3,'pepsi',11,100),
 array(4,'banh trung thu',44,100),
 array(5,'banh tao',74,100),
 array(6,'cam',94,100),
);

$maxSL = $sanpham[0][2];
$id = 0;

  for ($row = 0; $row < 6; $row++) {
      if($maxSL <= $sanpham[$row][2]){
          $maxSL = $sanpham[$row][2];
          $id = $row;
      }
  }

echo "Id: ";
echo $sanpham[$id][0];
echo "<br>";
echo "Ten san pham: ";
echo $sanpham[$id][1];
echo "<br>";
echo "Da ban: ";
echo $sanpham[$id][2];
echo "<br>";
echo "Ton kho: ";
echo $sanpham[$id][3];

?>
   
 </div>
