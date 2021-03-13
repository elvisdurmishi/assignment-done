<?php

session_start();
require_once "dbh.inc.php";
require_once "functions.inc.php";

$studentuid = $_SESSION["studentuid"];

if (isset($_POST["submit"])){
    $comment = $_POST["comment"];
    $grade = $_POST["grade"];
    $studentuid = $_POST["studentuid"];

    if(emptyInputLogin($comment,$grade, $studentuid) !== false){
        header("location: ../viewAssignment.php?error=emptygrade");
        exit();
    }
    gradeStudent($conn, $comment, $grade, $studentuid);
}