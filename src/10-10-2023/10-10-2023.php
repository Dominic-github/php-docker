<?php

// Bai 1, 2, 3

class Animal{
  public $name;
  public function __construct($name) {
    $this->name = $name;
  }

  public function eat(){
    return 'eating';
  }
}

interface Sound{
  public function makeSound();
  
}

class Dog extends Animal implements Sound{
  public function makeSound() {
    echo "$this->name: Gauw \n";
  }
  public function eat(){
    return "$this->name eating dog's food \n";
  }
}
class Cat extends Animal implements Sound{
  public function makeSound() {
    echo "$this->name: Meow \n";
  }
  public function eat(){
    return "$this->name eating cat's food \n";
  }
}
class Bird extends Animal implements Sound{
  public function makeSound() {
    echo "$this->name: Chipp \n";
  }
  public function eat(){
    return "$this->name eating bird's food \n";
  }
}

$dog = new Dog("tobi");
$cat = new Cat("sushi");
$bird= new Bird("lala");

$animals = array($dog, $cat, $bird);


foreach ($animals as $animal) {
    $animal->makeSound();
    echo $animal->eat();
}


// Bai 4

abstract class Shape{

  abstract public function calculateArea();

}


interface Drawable{
  public function draw();
}


class Circle extends Shape implements Drawable{
  public $r; 

  public function __construct($r){
    $this->r = $r;
  } 
  public function calculateArea(){
    return $this->r * 3.14;
  }

  public function draw(){
    echo "drawing Circle";
  }

}
  
class Rectangle extends Shape  implements Drawable{
  public $a;
  public $b;

  public function __construct($a, $b){
    $this->a = $a;
    $this->b = $b;
  } 
  public function calculateArea(){
    return $this->a * $this->b;
  }

  public function draw(){
    echo "drawing Rectangle";
  }

}
  
  
class Triangl extends Shape implements Drawable{

  public $a;
  public $b;
  public $c;

  public function __construct($a, $b, $c){
    $this->a = $a;
    $this->b = $b;
    $this->c = $c;
  } 
  public function half_circumference(){
    return ($this->a + $this->b + $this->c) / 2;
  }

  public function calculateArea(){
    $p = $this->half_circumference();
    // return sqrt($p * ( $p - $this->a) * ($p -$this->b) ( $p -$this->c));
    return 5;
  }

  public function draw(){
    echo "drawing Triangl";
  }

}

$circle = new Circle(2);
$rectangle = new Rectangle(2,3);
$triangl = new Triangl(2,3,4);

$shapes = array($circle, $rectangle, $triangl);

foreach ($shapes as $shape) {
  echo "calculateArea: ";
  echo  $shape->calculateArea(); 
  echo "\n";
}


# bai 5
#

trait Contact{
  public $contact;
}
trait Address{
  public $address;
}
class Home {
  use Contact,Address;
  public function __construct($contact, $address){
    $this->contact = $contact;
    $this->address= $address;
  }

  public function getInfo(){
    echo "Contact: {$this->contact} \n";
    echo "Address: {$this->address} \n";
  }
}
class Office{
  use Contact,Address;
  public function __construct($contact, $address){
    $this->contact = $contact;
    $this->address= $address;
  }
  public function getInfo(){
    echo "Contact: {$this->contact} \n";
    echo "Address: {$this->address} \n";
  }
}

$home = new Home("123", "hanoi");
$office = new Office("456", "hanoi");
$home->getInfo();
$office->getInfo();


// Bai 6

class Image{

  public $image;

  public function __construct($image){
    $this->image = $image;
  }

  public function dowloadImage($image){
    // $this->image = $image;
  }
  public function showImage(){
    // echo "fils is {$this->image} \n";
  }
}

class JpegImage extends Image{
  public function dowloadImage($image){
    $this->image = $image;
  }
  public function showImage(){
    echo "fils is {$this->image} \n";
  }
} 
class PngImag extends Image{
  public function dowloadImage($image){
    $this->image = $image;
  }
  public function showImage(){
    echo "fils is {$this->image} \n";
  }
}

$JpegImage = new JpegImage("bird.jpeg");
$JpegImage->showImage();
$JpegImage->dowloadImage("dog.jpeg");
$JpegImage->showImage();

$PngImag = new JpegImage("cat.jpeg");
$PngImag->showImage();


  
?>
