<?php
session_start();
require_once "dbh.inc.php";
require_once "functions.inc.php";

if(isset($_SESSION["staffuid"])){
    if(isset($_GET["class"])){
        $className = $_GET["class"];
        openClass($className);
    }else{
        header("location: ../staffIndex.php");
        exit();
    }
}else if (isset($_SESSION["studentuid"])){
    if(isset($_GET["class"])){
        $className = $_GET["class"];
        $creator = $_GET["creator"];
        openClassStudent($className, $creator);
    }else{
        header("location: ../staffIndex.php");
        exit();
    }
}

