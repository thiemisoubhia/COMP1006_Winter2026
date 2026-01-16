<?php 
require "header.php"; 
//inclunding car as require
require_once "car.php";
//inclunding connect as require
require_once "connect.php";


echo "<p> Follow the instructions outlined in instructions.txt to complete this lab. Good luck & have fun!😀 </p>";

//STEP 3
/*3.) Instantiate a new instance of a car object and echo the car information in the browser (/2 marks)*/

//creating a new instace of car
$car_one = new Car("Nissan", 2015, "Rogue");
//echo the car informations calling the method
echo $car_one->getInformations();

//STEP 6
/*6.) Add a multi-line comment in index.php reflecting on which parts of the lab you found easy and which parts were challening. (/2 marks)*/

/*The parts of this lab that I found easy were creating the Car class,
instantiating a new object, and calling its methods to display information.
I am comfortable with basic OOP concepts such as constructors and methods.
The trickiest part for me was deciding between using require and include.*/

require "footer.php"; 