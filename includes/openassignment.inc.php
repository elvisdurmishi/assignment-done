<?php

session_start();
require_once "dbh.inc.php";
require_once "functions.inc.php";

$classname= $_SESSION["classname"];
$creator = $_SESSION["staffuid"];

if(isset($_SESSION["staffuid"])){
    if(isset($_GET["asgmtid"])){
        $asgmtId = $_GET["asgmtid"];
        openAssignment($asgmtId, $classname);
    }else if(isset($_GET["deleteasgmt"])){
        $asgmtId = $_GET["deleteasgmt"];
        deleteFile($asgmtId, $conn);
        deleteStudentWorkFile($conn, $asgmtId, $classname, $creator);
        deleteStudentSubmitions($conn, $asgmtId, $classname, $creator);
        deleteAssignment($asgmtId, $classname, $conn);
    }else{
        header("location: ../staffClass.php?class=".$classname);
        exit();
    }
}else if(isset($_SESSION["studentuid"])){
    if(isset($_GET["asgmtid"])){
        $asgmtId = $_GET["asgmtid"];
        openAssignment($asgmtId, $classname);
    }
}





