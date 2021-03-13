<?php
session_start();
unset($_SESSION['asgmtid']);
header("location: ../staffClass.php?class=".$_SESSION["classname"]);
exit();
