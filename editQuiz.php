<?php
require_once "header.php";
?>

<?php
require_once "./includes/dbh.inc.php";
require_once "./includes/functions.inc.php";

$className = $_SESSION["classname"];
$creator = $_SESSION["staffuid"];
$_SESSION["quizid"] = $_GET["editquiz"];
$quizId = $_GET["editquiz"];
$_SESSION["oldtitle"] = $_GET["quiztitle"];

$quizData = getQuizInfo($conn, $quizId);

if(isset($_SESSION["staffid"])){
    $quizTitle = "quizTitle";
    $quizCreator = "quizCreator";
    $quizTime = "quizTimestamp";
    $quizDue = "quizDue";
    $quizDescription = "quizDescription";

while($row = mysqli_fetch_assoc($quizData)){
 echo "<div class=\"container flex grid\">";
 echo "<div class=\"small-circle primary\"><i class=\"far center white fa-2x fa-clipboard\"></i></div>";
 echo "<div class=\"asgmt\">";
 echo "<form action=\"./includes/editQuiz.inc.php\" method=\"POST\">";
 echo "<div class=\"asgmt-header\"> ";
 echo "<input type=\"text\" class=\"option\" value=\"$row[$quizTitle]\" name=\"title\" id=\"title\">";
 echo "<p>".$row[$quizCreator]." • ".$row[$quizTime]."</p>";
 echo "<p right-title> Due <input type=\"datetime-local\" id=\"duedate\" name=\"duedate\" value=\"$row[$quizDue]\" min=\"$row[$quizDue]\"></p>";
 echo "<hr>";
 echo "</div>";
 echo "<div class=\"asgmt-body\">";
 echo "<p>Description<input type=\"text\" class=\"option option-wide\" value=\"$row[$quizDescription]\" name=\"description\" id=\"description\"></p>";
 echo "</div>";
 echo "</div>";
 echo "<button class=\"btn\" type=\"submit\" name=\"submit\">Update</button>";
 echo "</form>";
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
    if(isset($_GET["error"])){
        if ($_GET["error"] == "quiztaken"){
            echo "<p class=\"center-p\">A quiz with the same name already exists!</p>";
        }
     } 
    echo "<h1 class=\"secondary-title\">Questions</h2>";
    echo "<form action=\"./includes/editQuestions.inc.php\" method=\"POST\">";
    $j = 1;
    while($row = mysqli_fetch_assoc($questionData)){
        echo "<div class=\"view-questions\">";
        echo "<p class=\"inline-block\">".$row[$quizQuestionNr]."</p>";
        echo "<p class=\"inline-block\"><input type=\"text\" class=\"option option-wide\" value=\"$row[$quizQuestion]\" name=\"question".$j."\" id=\"question".$j."\"></p>";
        $i = 1;
        echo "<br>";
        while($i <= 4){
            if($i == $row[$quizAnswer]){
                echo "<i class=\"fas green fa-circle\"></i>";
                echo "<p class=\"inline-block\"><input type=\"text\" class=\"option option-wide\" value=\"".$row["quizQuestionsAlt".$i]."\" name=\"question".$j."-alt".$i."\" id=\"question".$j."-alt".$i."\"></p>";
                echo "<br>";
            }else {
                echo "<i class=\"far fa-circle\"></i>";
                echo "<p class=\"inline-block\"><input type=\"text\" class=\"option option-wide\" value=\"".$row["quizQuestionsAlt".$i]."\" name=\"question".$j."-alt".$i."\" id=\"question".$j."-alt".$i."\"></p>";
                echo "<br>";
            }
            $i++;
        }
        echo "<p>Right answer</p>";
        echo "<input type=\"number\" class=\"option\" value=\"$row[$quizAnswer]\" name=\"quizAnswer".$j."\" id=\"quizAnswer".$j."\">";
        echo "<br>";
        echo "<hr>";
        echo "</div>";
        $j++;
    }
    $j = $j - 1;
    $_SESSION["questionnr"] = $j;
    echo "<br>";
    echo "<button class=\"btn\" type=\"submit\" name=\"submit\">Update Questions</button>";
    echo "<br>";
    echo "<hr>";
    echo "</div>";
}
?>

<?php
require_once "footer.php";
?>