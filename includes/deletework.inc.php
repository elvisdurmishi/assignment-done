<?php

session_start();
require_once "dbh.inc.php";
require_once "functions.inc.php";

$asgmtid = $_SESSION["asgmtid"];
$classname = $_SESSION["classname"];
$creator = $_SESSION["creator"];
$studentuid = $_SESSION["studentuid"];

if(isset($_GET["action"])){
    if($_GET["action"] == "unsubmit"){
        $atch = $_GET["atch"];
        unsubmitWork($conn, $asgmtid, $classname, $creator, $studentuid, $atch);
    }
}
