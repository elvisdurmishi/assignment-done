<?php

require_once "./dbh.inc.php";
require_once "./functions.inc.php";

session_start();

if(isset($_POST["submit"])){
    if (emptyQuiz($_POST["title"], $_POST["description"], $_POST["creator"], $_POST["timestamp"], $_POST["duedate"], $_POST["question-nr"])){
        header("location: ../createQuiz.php?error=emptyinput");
        exit();
    }

    $title = $_POST["title"];
    $description = $_POST["description"];
    $creator = $_POST["creator"];
    $timestamp = $_POST["timestamp"];
    $duedate = $_POST["duedate"];
    $_SESSION["questionnr"] = $_POST["question-nr"];
    $questionnr = $_POST["question-nr"];
    $_SESSION["creator"] = $creator;
    $_SESSION["quiztitle"] = $title;
    $classname = $_SESSION["classname"];

    insertQuizData($conn, $classname, $creator, $title, $description, $timestamp, $duedate, $questionnr);
    header("location: ../quizQuestions.php");    
}else {
    header("location: ../createQuiz.php?error=wronginput");
}
