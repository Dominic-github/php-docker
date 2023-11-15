<?php 

function redirect($url, $message, $status){
  $_SESSION['message'] = $message;
  header('Location: '.$url);
  $_SESSION['status'] = $status;
  exit;
}

function formatNumber($value){
  return number_format((float)$value, 2, '.', ''); 
}

?>
