<?php

session_start();

if (isset($_POST["submit"])){

    $classname = $_SESSION["classname"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $creator = $_POST["creator"];
    $timestamp = $_POST["timestamp"];
    $duedate = $_POST["duedate"];

    $atch = $_FILES["atch"]["name"];
    // $tmp = $_FILES["atch"]["tmp_name"];
    // move_uploaded_file($tmp, "../files/".$atch);
    $temp = explode(".", $_FILES["atch"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);
    move_uploaded_file($_FILES["atch"]["tmp_name"], "../files/".$newfilename);

    require_once "dbh.inc.php";
    require_once "functions.inc.php";

    if(emptyInputAsgmt($title, $description, $creator, $timestamp, $duedate, $newfilename) !== false){
        header("location: ../createAssignment.php?error=emptyinput");
        exit();
    }

    createAssignment($conn, $classname, $title, $description, $creator, $timestamp, $duedate, $newfilename);

} else{
    header("location: ../register.php");
    exit();
}
