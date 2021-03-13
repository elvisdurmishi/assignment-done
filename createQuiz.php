<?php 
 include_once "header.php";
?>

<?php

if(isset($_SESSION["staffid"])){
   echo "<div class=\"container grid\">";
   echo "<h1 class=\"secondary-title inline-title\">Create Quiz</h1>";
   echo "<h1 class=\"secondary-title right-title inline-title\">".$_SESSION["staffuid"]."</h1>";
}
?>

        <div class="container-content">
        <div class="circle"><i class="fas center fa-book-reader fa-3x"></i></div> 
        <h1 class="title">Quiz</h1>
        <form action="./includes/quiz.inc.php" method="post">
            <div class="field">
                <p>Title </p>
                <input type="text" name="title" placeholder="Title" id="title">
            </div>
            <div class="field">
                <p>Description </p>
                <textarea id="description" name="description" placeholder="Description" rows="4" cols="50"> </textarea>
            </div>
            <div class="field">
                <p>Questions </p>
                <input type="number" placeholder="Nr of Questions" name="question-nr" id="question-nr">
            </div>
            <div class="field">
                <p>Creator</p>
                <?php 
                    echo "<select class=\"select-field\" name=\"creator\" id=\"creator\">";
                    echo "<option value=".$_SESSION["staffuid"].">".$_SESSION["staffuid"]."</option>";
                    echo "</select>";
                ?>
            </div>
            <div class="field">
                <p>Time </p>
                <?php 
                $date = date("M d, Y") . " " . date("h:i:sa");
                echo "<input type=\"text\" value=\"$date\" readonly name=\"timestamp\" id=\"timestamp\">"
                ?>
            </div>
            <div class="field">
                <p>Due Date </p>
                <?php 
                $date = date("Y-m-d"). "T" . date("h:i");
                echo "<input type=\"datetime-local\" id=\"duedate\" name=\"duedate\" value=\"$date\" min=\"$date\">";
                ?>
            </div>
            <button class="btn" type="submit" name="submit">Next</button>
        </form>
    </div>
        <?php
            if(isset($_GET["error"])){
                if ($_GET["error"] == "emptyinput"){
                    echo "<p class=\"center-p\">Fill in all fields!</p>";
                }
            }
        ?>
<?php 
 include_once "footer.php";
?>