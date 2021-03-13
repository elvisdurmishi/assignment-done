<?php

session_start();
require_once "dbh.inc.php";
require_once "functions.inc.php";
$quizId = $_SESSION["quizid"];

if(isset($_SESSION["staffuid"])){
    if(isset($_POST["submit"])){
        $oldtitle = $_SESSION["oldtitle"];
        $title = $_POST["title"];
        $classname = $_SESSION["classname"];
        $due = $_POST["duedate"];
        $description = $_POST["description"];
        updateQuizInfo($conn, $quizId, $title, $due, $description);
    }
}