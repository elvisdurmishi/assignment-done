<?php

session_start();
require_once "dbh.inc.php";
require_once "functions.inc.php";

$creator = $_SESSION["staffuid"];
$classname = $_SESSION["classname"];
$asgmtid = $_SESSION["asgmtid"];
$oldatch = $_SESSION["oldatch"];

    if(isset($_POST["submit"])){
        $title = $_POST["title"];
        $due = $_POST["duedate"];
        $description = $_POST["description"];
        if($_POST['deleteAtch'] == 'NewAtch'){
            unlink("../files/".$oldatch);
            $atch = $_FILES["atch"]["name"];
            $tmp = $_FILES["atch"]["tmp_name"];
            move_uploaded_file($tmp, "../files/".$atch);
            updateAssisgnmentWithAtch($conn, $asgmtid, $title, $due, $description, $atch);
        }else{
            updateAssignment($conn, $asgmtid, $title, $due, $description);
        }
    }
