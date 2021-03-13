<?php

session_start();
require_once "dbh.inc.php";
require_once "functions.inc.php";

$quizId = $_SESSION["quizid"];
$questionnr = $_SESSION["questionnr"];
$i = 1;

if(isset($_POST["submit"])){
    while($i <= $questionnr){
        $question = $_POST["question".$i];
        $alt1 = $_POST["question".$i."-alt1"];
        $alt2 = $_POST["question".$i."-alt2"];
        $alt3 = $_POST["question".$i."-alt3"];
        $alt4 = $_POST["question".$i."-alt4"];
        $rightAnswer = $_POST["quizAnswer".$i];
        $questionNumber = $i;

        updateQuestion($conn, $question, $alt1, $alt2, $alt3, $alt4, $rightAnswer, $questionNumber, $quizId);
        $i++;
    }
    header("location: ../staffClass.php");
    exit();
}
