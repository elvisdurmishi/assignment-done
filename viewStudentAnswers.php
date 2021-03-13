<?php
require_once "header.php"
?>

<?php
require_once "./includes/dbh.inc.php";
require_once "./includes/functions.inc.php";

$quizId = $_SESSION["quizid"];
$studentUid = $_SESSION["studentuid"];
$studentname = $_SESSION["studentname"];
$studentsurname = $_SESSION["studentsurname"];

$questionData = getQuestionData($conn, $quizId);
$quizQuestionNr = "quizQuestionsQuestionNr";
$quizQuestion = "quizQuestionsQuestion";
$quizTitle = "quizTitle";
$quizCreator = "quizCreator";
$quizTime = "quizTimestamp";
$quizDue = "quizDue";
$quizDescription = "quizDescription";
$quizData = getQuizInfo($conn, $quizId);

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
       echo "<div class=\"container grid\">";
       echo "<h1 class=\"secondary-title\">".$studentname." ".$studentsurname." answers</h2>";
       echo "<i class=\"fas green fa-circle\"></i>";
       echo "<p class=\"inline-block\">Right Student Answer</p>";
       echo "<i class=\"fas red fa-circle\"></i>";
       echo "<p class=\"inline-block\">Wrong Student Answer</p>";
       echo "<i class=\"far green fa-dot-circle\"></i>";
       echo "<p class=\"inline-block\">Right Answer</p>";
       $j = 1;
       $piket = 0;
while($rows = mysqli_fetch_assoc($questionData)){
    echo "<div class=\"view-questions\">";
    echo "<p class=\"inline-block\">".$rows[$quizQuestionNr]."</p>";
    echo "<p class=\"inline-block\">".$rows[$quizQuestion]."</p>";
    $i = 1;
    $quizAnswerData = getStudentAnswers($conn, $quizId, $studentUid, $j);
    while($row = mysqli_fetch_assoc($quizAnswerData)){
        $answer = $row["studentAnswer"];
    }
    while($i <= 4){
        if($rows["quizQuestionsQAnswer"] == $answer && $i==$rows["quizQuestionsQAnswer"]){
            echo "<i class=\"fas green fa-circle\"></i>";
            echo "<p class=\"inline-block\">".$rows["quizQuestionsAlt".$i]."</p>";
            $piket++;
        }else if($i == $answer){
            echo "<i class=\"fas red fa-circle\"></i>";
            echo "<p class=\"inline-block\">".$answer."</p>";
        }else if($i == $rows["quizQuestionsQAnswer"]){
            echo "<i class=\"far green fa-dot-circle\"></i>";
            echo "<p class=\"inline-block\">".$rows["quizQuestionsAlt".$i]."</p>";
        }else {
            echo "<i class=\"far fa-circle\"></i>";
            echo "<p class=\"inline-block\">".$rows["quizQuestionsAlt".$i]."</p>";
            }
        $i++;
    }
    echo "</div>";
    $j++;
}
$j = $j-1;
    echo "<p class=\"inline-block\">Points ".$piket."/".$j."</p>";
?>

<?php
require_once "footer.php"
?>