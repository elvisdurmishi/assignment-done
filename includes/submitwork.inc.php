<?php

session_start();
require_once "dbh.inc.php";
require_once "functions.inc.php";

$asgmtid = $_SESSION["asgmtid"];
$classname = $_SESSION["classname"];
$creator = $_SESSION["creator"];
$studentname = $_SESSION["studentname"];
$studentsurname = $_SESSION["studentsurname"];
$studentuid = $_SESSION["studentuid"];

if (isset($_POST["submit"])){
    $description = $_POST["description"];
    $deliveredtime = $_POST["timestamp"];
    $atch = $_FILES["atch"]["name"];
    $temp = explode(".", $_FILES["atch"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);
    move_uploaded_file($_FILES["atch"]["tmp_name"], "../studentwork/".$newfilename);

    if(emptyWork($description, $newfilename, $deliveredtime) !== false){
        header("location: ../viewAssignment.php?error=emptyinput");
        exit();
    }
    deliverWork($conn, $asgmtid, $classname, $creator, $description, $deliveredtime, $newfilename, $studentname, $studentsurname, $studentuid);
}else {
    header("location: ../viewAssignment.php");
}