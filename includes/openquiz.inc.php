<?php

session_start();
require_once "dbh.inc.php";
require_once "functions.inc.php";

$classname= $_SESSION["classname"];
$creator = $_SESSION["staffuid"];
$quizTitle = $_GET["quiztitle"];
$questionsNumber = $_GET["quizqnr"];
$_SESSION["questionsnr"] = $questionsNumber;


if(isset($_GET["quizid"])){
    $quizId = $_GET["quizid"];
    openQuiz($quizId, $quizTitle, $classname);
}else if(isset($_GET["deletequiz"])){
    $quizId = $_GET["deletequiz"];
    deleteQuizQuestions($conn, $quizId);
    deleteQuizStudentAnswers($conn, $quizId);
    deleteQuiz($quizId, $conn);
}else if(isset($_SESSION["studentuid"])){
    if(isset($_GET["quizid"])){
        $quizId = $_GET["quizid"];
        openQuiz($quizId, $classname);
    }
}else{
    header("location: ../staffClass.php?class=".$classname);
    exit();
}




