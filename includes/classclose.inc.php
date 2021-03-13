<?php
session_start();
if($_SESSION["staffuid"]){
    unset($_SESSION['classname']);
    unset($_SESSION["role"]);
    unset($_SESSION['asgmtid']);
    unset($_SESSION["quizid"]);
    unset($_SESSION["quizname"]);
    header("location: ../staffIndex.php");
}else if ($_SESSION["studentuid"]){
    unset($_SESSION['classname']);
    unset($_SESSION["role"]);
    unset($_SESSION['asgmtid']);
    unset($_SESSION["quizid"]);
    unset($_SESSION["quizname"]);
    unset($_SESSION["creator"]);
    header("location: ../studentIndex.php");
}


exit();
