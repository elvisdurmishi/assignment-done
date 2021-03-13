<?php

session_start();
unset($_SESSION['classname']);
unset($_SESSION["role"]);
unset($_SESSION['asgmtid']);
unset($_SESSION["quizid"]);
unset($_SESSION["quizname"]);
unset($_SESSION["creator"]);
session_unset();
session_destroy();

header("location: ../index.php");
exit();