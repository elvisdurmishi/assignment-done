<?php

if(isset($_POST["submit"])){
    session_start();
    require_once "dbh.inc.php";
    require_once "functions.inc.php";


    $classname = $_SESSION["classname"];
    $questionnr = $_SESSION["questionnr"];
    $creator = $_SESSION["creator"];
    $title = $_SESSION["quiztitle"];
    $quizData = getQuizData($conn, $creator, $title);
    while($row = mysqli_fetch_assoc($quizData)){
        $quizId = $row["quizId"];
    }
    $i = 1;
    while ($i <= $questionnr){
        $question = $_POST["q".$i];
        $alt1 = $_POST["q".$i."-a1"];
        $alt2 = $_POST["q".$i."-a2"];
        $alt3 = $_POST["q".$i."-a3"];
        $alt4 = $_POST["q".$i."-a4"];
        $rightAnswer = $_POST["rightanswer-q".$i];
        $questionNumber = $i;
        insertQuestion($conn, $quizId, $questionNumber, $question, $alt1, $alt2, $alt3, $alt4, $rightAnswer, $classname);
        sleep(0.2);
        $i++;
    }

    header("location: ./quizclose.inc.php");
    exit();
} else{
    header("location: ../error.php");
    exit();
}
