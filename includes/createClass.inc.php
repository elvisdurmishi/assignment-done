<?php

if (isset($_POST["submit"])){
    
    $name = $_POST["name"];
    $description = $_POST["description"];
    $icon = $_POST["icon"];
    $color = $_POST["color"];
    $creator = $_POST["creator"];
    $teacherName = $_POST["teacherName"];

    require_once "dbh.inc.php";
    require_once "functions.inc.php";

    if(emptyInputClass($name, $description, $icon, $color) !== false){
        header("location: ../createClass.php?error=emptyinput");
        exit();
    }

    if(invalidClassName($name) !== false){
        header("location: ../createClass.php?error=invalidclassname");
        exit();
    }

    if(classExists($conn, $name) !== false){
        header("location: ../createClass.php?error=classtaken");
        exit();
    }

    createClass($conn, $name, $description, $icon, $color, $creator);
} else{
    header("location: ../createClass.php");
    exit();
}