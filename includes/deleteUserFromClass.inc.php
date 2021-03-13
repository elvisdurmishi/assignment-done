<?php

require_once "dbh.inc.php";
require_once "functions.inc.php";
session_start();
if(isset($_SESSION["classname"]) && isset($_GET["classuserid"])){
    $studentuid = $_GET["classuserid"];
    $classname = $_SESSION["classname"];
    $creator = $_SESSION["staffuid"];
    require_once "dbh.inc.php";
    require_once "functions.inc.php";
    deleteStudentAssignments($conn, $studentuid, $classname);
    deleteStudentQuizWork($conn, $studentuid, $classname);
    deleteUser($studentuid, $classname, $creator, $conn);
}

