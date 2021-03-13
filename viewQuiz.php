<?php
require_once "header.php";
?>

<?php
require_once "./includes/dbh.inc.php";
require_once "./includes/functions.inc.php";

$className = $_SESSION["classname"];
$title = $_SESSION["quiztitle"];
$quizId = $_SESSION["quizid"];

if(isset($_SESSION["staffid"])){
    $creator = $_SESSION["staffuid"];
    $quizData = getQuizInfo($conn, $quizId);
    $quizTitle = "quizTitle";
    $quizCreator = "quizCreator";
    $quizTime = "quizTimestamp";
    $quizDue = "quizDue";
    $quizDescription = "quizDescription";

while($row = mysqli_fetch_assoc($quizData)){
 echo "<div class=\"container flex grid\">";
 echo "<div class=\"small-circle primary\"><i class=\"far center white fa-2x fa-clipboard\"></i></div>";
 echo "<div class=\"asgmt\">";
 echo "<div class=\"asgmt-header\"> ";
 echo "<h1 class=\"secondary-title\">".$row[$quizTitle]."</h2>";
 echo "<p>".$row[$quizCreator]." • ".$row[$quizTime]."</p>";
 echo "<p right-title> Due ".$row[$quizDue]."</p>";
 echo "<hr>";
 echo "</div>";
 echo "<div class=\"asgmt-body\">";
 echo "<p>".$row[$quizDescription]."</p>";
 echo "</div>";
 echo "</div>";
 echo "</div>";
    }
    $quizQuestionNr = "quizQuestionsQuestionNr";
    $quizQuestion = "quizQuestionsQuestion";
    $quizAlt1 = "quizQuestionsAlt1";
    $quizAlt2 = "quizQuestionsAlt2";
    $quizAlt3 = "quizQuestionsAlt3";
    $quizAlt4 = "quizQuestionsAlt4";
    $quizAnswer = "quizQuestionsQAnswer";
    $questionData = getQuestionData($conn, $quizId);
    echo "<div class=\"container grid\">";
    echo "<h1 class=\"secondary-title\">Questions</h2>";
    while($row = mysqli_fetch_assoc($questionData)){
        echo "<div class=\"view-questions\">";
        echo "<p class=\"inline-block\">".$row[$quizQuestionNr]."</p>";
        echo "<p class=\"inline-block\">".$row[$quizQuestion]."</p>";
        $i = 1;
        while($i <= 4){
            if($i == $row[$quizAnswer]){
                echo "<i class=\"fas green fa-circle\"></i>";
                echo "<p class=\"inline-block\">".$row["quizQuestionsAlt".$i]."</p>";
            }else {
                echo "<i class=\"far fa-circle\"></i>";
                echo "<p class=\"inline-block\">".$row["quizQuestionsAlt".$i]."</p>";
            }
            $i++;
        }
        echo "</div>";
    }
    echo "<h1 class=\"secondary-title\">Student Answers</h2>";
    $resultData = getstudentInfo($conn, $className, $creator);
    while($row = mysqli_fetch_assoc($resultData)){
    $quizAnswerData = getStudentAnswer($conn, $quizId, $row["stuclassStudentUid"]);
    while($row = mysqli_fetch_assoc($quizAnswerData)){
        echo "<div class=\"wide-card red-card\">";
        echo "<a class=\"wide-card-link\" href=\"./includes/openStudentQuiz.inc.php?quizid=".$row["quizId"]."&studentuid=".$row["studentUid"]."&studentname=".$row["studentName"]."&studentsurname=".$row["studentSurname"]."\">";
        echo "<div class=\"wide-card-body\">";
        echo "<div class=\"small-circle\"><i class=\"fas center color fa-bookmark fa-1x\"></i></div>";
        echo "<div class=\"wide-card-content\">";
        echo "<h1 class=\"wide-card-title\">".$row["studentName"]." ".$row["studentSurname"]." submited quiz answers</h1>";
        echo "<p class=\"wide-card-info\">Posted on: ".$row["submitTimestamp"]."</p>";
        echo "</div>";
        echo "</div>";
        echo "</a>";
        echo "</div>";
    }
    }
    echo "</div>";
}else if(isset($_SESSION["studentuid"])){
    $questionsnumber = $_SESSION["questionsnr"];
    $studentuid = $_SESSION["studentuid"];
    $creator = $_SESSION["creator"];
    $quizData = getQuizInfo($conn, $quizId);
    $quizTitle = "quizTitle";
    $quizCreator = "quizCreator";
    $quizTime = "quizTimestamp";
    $quizDue = "quizDue";
    $quizDescription = "quizDescription";

while($row = mysqli_fetch_assoc($quizData)){
 echo "<div class=\"container flex grid\">";
 echo "<div class=\"small-circle primary\"><i class=\"far center white fa-2x fa-clipboard\"></i></div>";
 echo "<div class=\"asgmt\">";
 echo "<div class=\"asgmt-header\"> ";
 echo "<h1 class=\"secondary-title\">".$row[$quizTitle]."</h2>";
 echo "<p>".$row[$quizCreator]." • ".$row[$quizTime]."</p>";
 echo "<p right-title> Due ".$row[$quizDue]."</p>";
 $due = $row[$quizDue];
 echo "<hr>";
 echo "</div>";
 echo "<div class=\"asgmt-body\">";
 echo "<p>".$row[$quizDescription]."</p>";
 echo "</div>";
 echo "</div>";
 echo "</div>";
    }
    $quizQuestionNr = "quizQuestionsQuestionNr";
    $quizQuestion = "quizQuestionsQuestion";
    $quizAlt1 = "quizQuestionsAlt1";
    $quizAlt2 = "quizQuestionsAlt2";
    $quizAlt3 = "quizQuestionsAlt3";
    $quizAlt4 = "quizQuestionsAlt4";
$questionData = getQuestionData($conn, $quizId);
$quizSubmited = getStudentQuiz($conn, $quizId, $studentuid);
$submited = false;
    while($row = mysqli_fetch_assoc($quizSubmited)){
        $submited = true;
    }

echo "<div class=\"container grid\">";
    $currentTime = date("Y-m-d"). "T" . date("h:i");
    
    if($submited == true){
        echo "<h1 class=\"secondary-title\">Result</h2>";
        $pointsdata = quizPoints($conn, $studentuid, $quizId);
        $points = 0;
        while($row = mysqli_fetch_assoc($pointsdata)){
            if($row["quizQuestionsQAnswer"] == $row["studentAnswer"]){
                $points++;
            }else {
                echo "<p>You made a mistake on question ".$row["questionNr"].".</p>";
            }
        }
        echo "<p>Points: ".$points."/".$questionsnumber."</p>";
    }else if($due < $currentTime){
        echo "<p>Quiz is not taking answers anymore!</p>";
    }else if($submited == false){
    echo "<h1 class=\"secondary-title\">Questions</h2>";
    echo "<form action=\"./includes/submitquiz.inc.php\" method=\"post\">";
    $i = 1;
    while($row = mysqli_fetch_assoc($questionData)){
        echo "<div class=\"view-questions\">";
        echo "<p class=\"inline-block\">".$row[$quizQuestionNr]."</p>";
        echo "<p class=\"inline-block\">".$row[$quizQuestion]."</p>";
        echo "<br>";
        $j = 1;
        while($j <= 4){
        echo "<input class=\"radio-button\" type=\"radio\" id=\"q".$i."-a".$j."\" name=\"question".$i."\" value=\"".$j."\">";
        echo "<label for=\"q".$i."-a".$j."\">".$row["quizQuestionsAlt".$j]."</label>";
        echo "<br>";
        $j++;
        }
        echo "</div>";
        $i++;
    }
    echo "<button class=\"btn\" type=\"submit\" name=\"submit\">Submit Quiz</button>";
    echo "</form>";
    }
    echo "</div>";
}

    

?>


<?php
require_once "footer.php";
?>