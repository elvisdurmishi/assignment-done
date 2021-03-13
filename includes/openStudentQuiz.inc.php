<?php

session_start();
require_once "dbh.inc.php";
require_once "functions.inc.php";

$classname= $_SESSION["classname"];
$creator = $_SESSION["staffuid"];
$quizTitle = $_GET["quizid"];
$studentUid = $_GET["studentuid"];
$studentname = $_GET["studentname"];
$studentsurname = $_GET["studentsurname"];


if(isset($_GET["quizid"])){
    $quizId = $_GET["quizid"];
    openStudentSubmition($conn, $quizId, $studentUid, $studentname, $studentsurname);
}else{
    header("location: ../viewQuiz.php");
    exit();
}




