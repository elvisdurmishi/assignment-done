<?php

session_start();
$quizTitle = $_GET["quiztitle"];
if(isset($_SESSION["staffuid"]) && isset($_SESSION["classname"])){
    require_once "dbh.inc.php";
    require_once "functions.inc.php";
    $classname = $_SESSION["classname"];
    $creator = $_SESSION["staffuid"];
    deleteFileClass($classname, $conn);
    deleteQuizQuestionTable($classname, $conn);
    deleteQuizAnswersTable($classname, $conn);
    deleteQuizClass($classname, $conn);
    deleteStudentsWorkFiles($conn, $classname);
    deleteAssignmentClass($classname, $conn);
    deleteStudentsFromClass($classname, $creator, $conn);
    deleteClass($classname, $conn);
}else{
    header("location: ../staffIndex?error=cantdeleteclass.php");
    exit();
}
