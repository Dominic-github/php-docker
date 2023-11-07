<?php 

function redirect($url, $message, $status){
  $_SESSION['message'] = $message;
  header('Location: '.$url);
  $_SESSION['status'] = $status;
  exit;
}

?>