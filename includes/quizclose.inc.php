<?php
session_start();
unset($_SESSION['questionnr']);
unset($_SESSION['quizcreator']);
unset($_SESSION['quiztitle']);
unset($_SESSION['quizdescription']);
unset($_SESSION['quiztimestamp']);
unset($_SESSION['quizduedate']);
unset($_SESSION["quizid"]);
unset($_SESSION["quizname"]);
unset($_SESSION["questionsnr"]);

header("location: ../staffClass.php?class=".$_SESSION["classname"]);
exit();