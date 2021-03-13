<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
      integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp"
      crossorigin="anonymous"
    >
    <link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Assignment Done</title>
</head>
<body>
    <nav>
        <div class="logo">
            <?php
            if(isset($_SESSION["staffid"])){
                if(isset($_SESSION["classname"])){
                    echo "<a class=\"nav-link\" href=\"./includes/classclose.inc.php\"><h3 class=\"logo\">Assignment <span class=\"logo-span\">done</span></h3></a>";
                }else
                echo "<a class=\"nav-link\" href=\"staffIndex.php\"><h3 class=\"logo\">Assignment <span class=\"logo-span\">done</span></h3></a>";
            }else if(isset($_SESSION["studentid"])){
                echo "<a class=\"nav-link\" href=\"includes/classclose.inc.php\"><h3 class=\"logo\">Assignment <span class=\"logo-span\">done</span></h3></a>";
            }else {
                echo "<a class=\"nav-link\" href=\"index.php\"><h3 class=\"logo\">Assignment <span class=\"logo-span\">done</span></h3></a>";
            }
            ?>
        </div>
        <div class="nav-list">
            <div class="nav-items">
                <?php
                if(isset($_SESSION["staffid"])){
                    if(isset($_SESSION["classname"])){
                        echo "<a class=\"nav-link\" href=\"./staffClass.php?class=".$_SESSION["classname"]."\">Home</a>";
                    }else
                    echo "<a class=\"nav-link\" href=\"staffIndex.php\">Home</a>";
                }else if(isset($_SESSION["studentid"])){
                    if(isset($_SESSION["classname"])){
                        echo "<a class=\"nav-link\" href=\"./studentClass.php?class=".$_SESSION["classname"]."\">Home</a>";
                    }else
                    echo "<a class=\"nav-link\" href=\"studentIndex.php\">Home</a>";
                }else {
                    echo "<a class=\"nav-link\" href=\"index.php\">Home</a>";
                }

                if(isset($_SESSION["staffid"])){
                    if(isset($_SESSION["classname"])){
                        echo "<a class=\"nav-link\" href=\"pjestaret.php\">Pjestaret</a>";
                        echo "<a class=\"nav-link\" href=\"createAssignment.php\">Posto Detyre</a>";
                        echo "<a class=\"nav-link\" href=\"createQuiz.php\">Posto Provim</a>";
                    }
                    echo "<a class=\"nav-link\" href=\"./includes/logout.inc.php\">Logout</a>";
                }
                else if(isset($_SESSION["studentid"])){
                    echo "<a class=\"nav-link\" href=\"./includes/logout.inc.php\">Logout</a>";
                }else {
                    echo "<a class=\"nav-link\" href=\"register.php\">Register</a>";
                    echo "<a class=\"nav-link\" href=\"loginStaff.php\">Login as Staff</a>";
                    echo "<a class=\"nav-link\" href=\"loginStudent.php\">Login as Student</a>";
                }
                ?>
            </div>
        </div>
    </nav>