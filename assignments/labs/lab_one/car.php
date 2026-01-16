<?php
declare(strict_types=1);
/*2.) Create a PHP file called car.php. In this file, create a class to represent a car. Properties should include make, model and year and include a method to return this information. Use include/require to include this code in index.php. Add comments to explain your code. (/5 marks)*/

//STEP 2
//creating a car class

Class Car{
    //inclunding car properties
    public string $make;
    public int $year;
    public string $model;

    //constructor
    public function __construct(string $make, int $year, string $model){
        $this->make = $make;
        $this->year = $year;
        $this->model = $model;
    }

    //method to return
    public function getInformations(): string{
        return "Make : {$this->make} | Model: {$this->model} | Year: {$this->year}";
    }
}


?>