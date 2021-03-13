<?php
session_start();
require_once "dbh.inc.php";
require_once "functions.inc.php";

$quizId = $_SESSION["quizid"];
$classname = $_SESSION["classname"];
$studentname = $_SESSION["studentname"];
$studentsurname = $_SESSION["studentsurname"];
$studentuid = $_SESSION["studentuid"];
$questionnr = $_SESSION["questionsnr"];
$i = 1;

if (isset($_POST["submit"])){
    $timestamp = date("Y-m-d"). "T" . date("h:i");
    while ($i <= $questionnr){
    $currentQuestion = $i;
    $question = "question".$i;
    if(emptyQuestion($question) !== false){
        header("location: ../viewQuiz.php?error=emptyinput");
        exit();
        }
    $answer = $_POST["question".$i];
    submitQuiz($conn, $studentuid, $studentname, $studentsurname, $quizId, $currentQuestion, $answer, $timestamp, $classname);
    $i++;
    }
    header("location: ../viewQuiz.php?error=submited");
    exit();
}else {
    header("location: ../viewQuiz.php");
}