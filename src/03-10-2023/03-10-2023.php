<?php

$loaisp = array(
  array(1,'traicay'),
  array(2,'banh'),
  array(3,'do uong')

);
$sanpham = array(
 array(1,'tao',14,100,1),
 array(2,'coca',120,210,3),
 array(3,'pepsi',11,100,3),
 array(4,'banh trung thu',44,100,2),
 array(5,'banh tao',74,100,2),
 array(6,'cam',94,100,1),
);

$maxSL = $sanpham[0][2];
$id = 0;

  for ($row = 0; $row < 6; $row++) {
      if($maxSL <= $sanpham[$row][2]){
          $maxSL = $sanpham[$row][2];
          $id = $row;
      }
  }

// echo "Id: ";
// echo $sanpham[$id][0];
// echo "<br>";
// echo "Ten san pham: ";
// echo $sanpham[$id][1];
// echo "<br>";
// echo "Da ban: ";
// echo $sanpham[$id][2];
// echo "<br>";
// echo "Ton kho: ";
// echo $sanpham[$id][3];
//


$loaisp = array(
  array(1,'traicay'),
  array(2,'banh'),
  array(3,'do uong')

);
$sanpham = array(
 array(1,'tao',14,100,1),
 array(2,'coca',120,210,3),
 array(3,'pepsi',11,100,3),
 array(4,'banh trung thu',44,100,2),
 array(5,'banh tao',74,100,2),
 array(6,'cam',94,100,1),
);



try {

  $myfile = fopen("sanpham.txt", "w") or die("Unable to open file!");
}catch (\Throwable $th) {
  echo $th;
}

$text = "";


  for($row = 0; $row < 6; $row++) {
      for($col = 0; $col < 5 ; $col++){

          if(is_numeric($sanpham[$row][0])){
            $text.= (string)$sanpham[$row][$col] ."\t";
          }

      }
      $text.="\n";
  }



try {
  fwrite($myfile,$text);
} catch (\Throwable $th) {
  echo $th;
}


fclose($myfile);

?>
   
