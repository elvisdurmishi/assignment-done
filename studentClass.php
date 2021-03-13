<?php
    require_once "header.php"
?>  

<?php 
    require_once "./includes/dbh.inc.php";
    require_once "./includes/functions.inc.php";

    $student = $_SESSION["studentuid"];
    $className = lcfirst($_SESSION["classname"]);
    $creator = $_SESSION["creator"];

    $asgmtData = getAsgmt($conn, $className, $creator);
    $asgmtId = "assignmentId";
    $asgmtTitle = "assignmentTitle";
    $asgmtCreator = "assignmentCreator";
    $asgmtTime = "assignmentTimestamp";
    $asgmtDue = "assignmentDue";

    $quizData = getQuiz($conn, $className, $creator);
    $quizId = "quizId";
    $quizTitle = "quizTitle";
    $quizCreator = "quizCreator";
    $quizTime = "quizTimestamp";
    $quizDue = "quizDue";
    $quizQnr = "quizQuestionNr";
    
    if(isset($_SESSION["studentuid"])){
        $className = ucfirst($className);
        echo "<div class=\"container grid\">";
        echo "<h1 class=\"title inline-title\">".$className."</h1>";
        echo "<h1 class=\"secondary-title\">Assignments</h1>";

    // Tregon te gjitha Detyrat
    while($row = mysqli_fetch_assoc($asgmtData)){
        echo "<div class=\"wide-card red-card\">";
        echo "<a class=\"wide-card-link\" href=\"./includes/openassignment.inc.php?asgmtid=".$row[$asgmtId]."\">";
        echo "<div class=\"wide-card-body\">";
        echo "<div class=\"small-circle\"><i class=\"fas center color fa-bookmark fa-1x\"></i></div>";
        echo "<div class=\"wide-card-content\">";
        echo "<h1 class=\"wide-card-title\">".$row[$asgmtCreator]." posted a new material: ".$row[$asgmtTitle]."</h1>";
        echo "<p class=\"wide-card-info\">Posted on: ".$row[$asgmtTime]."</p>";
        echo "<p class=\"wide-card-info\">Due: ".$row[$asgmtDue]."</p>";
        echo "</div>";
        echo "</div>";
        echo "</a>";
        echo "</div>";
    }


    // Tregon te gjitha quizet
        echo "<h1 class=\"secondary-title\">Quiz</h1>";
    while($row = mysqli_fetch_assoc($quizData)){
        echo "<div class=\"wide-card red-card\">";
        echo "<a class=\"wide-card-link\" href=\"./includes/openquiz.inc.php?quizid=".$row[$quizId]."&quiztitle=".$row[$quizTitle]."&quizqnr=".$row[$quizQnr]."\">";
        echo "<div class=\"wide-card-body\">";
        echo "<div class=\"small-circle\"><i class=\"fas center color fa-pen-square fa-2x\"></i></div>";
        echo "<div class=\"wide-card-content\">";
        echo "<h1 class=\"wide-card-title\">".$row[$quizCreator]." posted a new material: ".$row[$quizTitle]."</h1>";
        echo "<p class=\"wide-card-info\">Posted on: ".$row[$quizTime]."</p>";
        echo "<p class=\"wide-card-info\">Due: ".$row[$quizDue]."</p>";
        echo "</div>";
        echo "</div>";
        echo "</a>";
        echo "</div>";
    }
        echo "</div>";
    }else {
        header("location: ./index.php");
    }
    
?>    

<?php 
    require_once "footer.php"
?>