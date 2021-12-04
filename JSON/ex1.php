<?php

class obj{
    public $name;
    public $age;
    public $city;
}

$myObj = new obj;

$myObj->name = "John";
$myObj->age = 30;
$myObj->city = "New York";

$myJSON = json_encode($myObj);

echo $myJSON;

