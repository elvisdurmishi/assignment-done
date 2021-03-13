<?php
require_once "header.php";
?>

<?php
  require_once "./includes/dbh.inc.php";
  require_once "./includes/functions.inc.php";
  $creator = $_SESSION["creator"];
  $title = $_SESSION["quiztitle"];
$quizData = getQuizData($conn, $creator, $title);
while($row = mysqli_fetch_assoc($quizData)){
 echo "<div class=\"container flex grid\">";
 echo "<div class=\"small-circle primary\"><i class=\"far center white fa-2x fa-clipboard\"></i></div>";
 echo "<div class=\"asgmt\">";
 echo "<div class=\"asgmt-header\"> ";
 echo "<h1 class=\"secondary-title\">".$row["quizTitle"]."</h2>";
 echo "<p>".$row["quizCreator"]." • ".$row["quizTimestamp"]."</p>";
 echo "<p right-title> Due ".$row["quizDue"]."</p>";
 echo "<hr>";
 echo "</div>";
 echo "<div class=\"asgmt-body\">";
 echo "<p>".$row["quizDescription"]."</p>";
 echo "</div>";
 echo "</div>";
 echo "</div>";
}
?>

<div class="container grid">
<form action="./includes/questions.inc.php" method="POST" onkeydown="return event.key != 'Enter';">
<div class="question">
<h1 class="secondary-title">Quiz Questions</h2>
    <hr>
    <?php
    $questions = $_SESSION["questionnr"];
    $i = 1;
    while($i <= $questions){
    echo "".$i.". <input type=\"text\" name=\"q".$i."\" class=\"question-input\" placeholder=\"Question ".$i."\" id=\"q1\">";
    for($j = 1 ; $j <= 4 ; $j++){
    echo "<div class=\"alternatives\">";
        echo "<div style=\"flex: 1 1 0%\" class=\"input-alt\">";
            echo "<i  class=\"far fa-circle\"></i>";
            echo "<input type=\"text\" placeholder=\"Option ".$j."\" class=\"option\" name=\"q".$i."-a".$j."\" id=\"q".$i."-a".$j."\">";
        echo "</div>";
    echo "</div>";
    }
    echo "<input class=\"question-input\" style=\"width: 30%;\" placeholder=\"Right Answer Number\" type=\"number\" name=\"rightanswer-q".$i."\" id=\"rightanswer-q".$i."\"> <br>";
    echo "<hr>"; 
    $i++;
    }
    ?>
    <button class="btn" type="submit" name="submit">Post</button>
</div>
</form>
</div>

<?php
require_once "footer.php";
?>