<?php 

class Product{
    public $ProductID;
    public $ProductName;
    public $Description;
    public $Price;
    public $StockQuantity;
    public function __constructor($customerID, $ProductName,$Description,$Price,$StockQuantity){
      $this->ProductID= $ProductID;
      $this->ProductName = $ProductName;
      $this->Description= $Description;
      $this->Price= $Price;
      $this->StockQuantity= $StockQuantity;
    }
}


class Customer{

    public function __constructor(){

    }
}

class Order{

    public function __constructor(){

    }
}

class OrderDetail{

    public function __constructor(){

    }

}
?>
