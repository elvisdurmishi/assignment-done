<?php 
require_once "header.php"
?>

<?php
require_once "./includes/dbh.inc.php";
require_once "./includes/functions.inc.php";

$className = $_SESSION["classname"];
$asgmtId = $_SESSION["asgmtid"];

$asmgtDescription = "assignmentDescription";
$asgmtTitle = "assignmentTitle";
$asgmtDue = "assignmentDue";
$asgmtCreator = "assignmentCreator";
$asgmtTime = "assignmentTimestamp";
$asgmtAtch = "assignmentAtch";

$asgmtTempAtach = $asgmtAtch;


if(isset($_SESSION["staffid"])){
    $creator = $_SESSION["staffuid"];
    $resultData = getAsgmtData($conn, $asgmtId, $className, $creator);
    echo "<div class=\"container flex grid\">";
    echo "<div class=\"small-circle primary\"><i class=\"far center white fa-2x fa-clipboard\"></i></div>";
    
    $result = getstudentInfo($conn, $className, $creator);
    $studentCount = 0;
    while($row = mysqli_fetch_assoc($result)){
        $studentCount++;
    }

    $studentResult = getWork($conn, $asgmtId, $className, $creator);
    $turnedIn = 0;
    while($row = mysqli_fetch_assoc($studentResult)){
        $turnedIn++;
    }
    
    while($row = mysqli_fetch_assoc($resultData)){

    echo "<div class=\"asgmt\">";
    echo "<div class=\"asgmt-header\"> ";
    echo "<h1 class=\"secondary-title\">$row[$asgmtTitle]</h2>";
    echo "<p> $row[$asgmtCreator] • ".substr($row[$asgmtTime], 0, 6).", ".substr($row[$asgmtTime], 12, 25)."</p>";
    echo "<p right-title> Due $row[$asgmtDue]</p>";
    echo "<hr>";
    echo "</div>";
    echo "<div class=\"asgmt-body-staff\">";
    echo "<p>$row[$asmgtDescription]</p>";
    echo "<a class=\"asgmt-atch\" href=\"./files/$row[$asgmtAtch]\">";
    echo "<i class=\"far primary-font fa-clipboard fa-2x\"></i>";
    echo "<hr class=\"vertical-rule\">";
    echo "<div class=\"atch-info\">";
    echo "<p>$row[$asgmtAtch]</p>";
    echo "<p class=\"gray uppercase\">PDF</p>";
    echo "</div>";
    echo "</a>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<div class=\"container grid\">";
    if(isset($_GET["error"])){
        if ($_GET["error"] == "emptygrade"){
            echo "<p class=\"center\">Fill in all fields!</p>";
        }else if ($_GET["error"] == "graded"){
            echo "<p class=\"center\">Work Graded!</p>";
        }
    }
    echo "<h1 class=\"secondary-title inline-title\">Student Work</h2>";
    echo "<h3 class=\"right-title inline-title\">Turned in: ".$turnedIn."/".$studentCount."</h3>";
    $gradeWork = getWork($conn, $asgmtId, $className, $creator);
    echo "<div class=\"grid-container\">";
        while($row = mysqli_fetch_assoc($gradeWork)){
            echo "<div class=\"student-work round-border padding-4x\">";
            echo "<h1 class=\"secondary-title\">".$row["workName"]." ".$row["workSurname"]."</h2>";
            echo "<p>Description: ".$row["workDescription"]."</p>";
            echo "<a class=\"asgmt-atch option-wide\" href=\"./studentwork/".$row["workAtch"]."\">";
            echo "<div class=\"atch-info\">";
            echo "<p>".$row["workAtch"]."</p>";
            echo "<p class=\"gray uppercase\">PDF</p>";
            echo "</div>";
            echo "</a>";
            if($row["workComment"] == null && $row["workGrade"] == null){
                echo "<form action=\"./includes/gradestudent.inc.php\" method=\"post\">";
                echo "<input type=\"text\" style=\"display: none;\" value=\"".$row["workStudentUid"]."\" name=\"studentuid\" id=\"studentuid\">";
                echo "<p>Coment: <input type=\"text\" placeholder=\"Comment...\" class=\"option option-wide\" name=\"comment\" id=\"comment\"></p>";
                echo "<p>Grade: <input type=\"number\" placeholder=\"Grade 1-10\" class=\"option option-wide\" min=\"1\" max=\"10\" name=\"grade\" id=\"grade\"></p>";
                echo "<button class=\"btn\" type=\"submit\" name=\"submit\">Grade Student</button>";
                echo "</form>";
            }else {
                echo "<p>Coment: ".$row["workComment"]."</p>";
                echo "<p>Grade: ".$row["workGrade"]."/10</p>";
            }
            echo "</div>";      
        }
        echo "</div>";  
    }
}else if (isset($_SESSION["studentuid"])){
    $studentuid = $_SESSION["studentuid"];
    $creator = $_SESSION["creator"];
    $resultData = getAsgmtData($conn, $asgmtId, $className, $creator);
    $workSubmited = getWorkStudent($conn, $asgmtId, $className, $creator, $studentuid);
    $submited = false;
    while($row = mysqli_fetch_assoc($workSubmited)){
        $submited = true;
    }

    echo "<div class=\"container flex grid\">";
    echo "<div class=\"small-circle primary\"><i class=\"far center white fa-2x fa-clipboard\"></i></div>";
    
    while($row = mysqli_fetch_assoc($resultData)){

    echo "<div class=\"asgmt\">";
    echo "<div class=\"asgmt-header\"> ";
    echo "<h1 class=\"secondary-title\">$row[$asgmtTitle]</h2>";
    echo "<p> $row[$asgmtCreator] • ".substr($row[$asgmtTime], 0, 6).", ".substr($row[$asgmtTime], 12, 25)."</p>";
    echo "<p right-title> Due $row[$asgmtDue]</p>";
    echo "<hr>";
    echo "<p>$row[$asmgtDescription]</p>";
    echo "</div>";
    echo "<div class=\"asgmt-body\">";
    echo "<a class=\"asgmt-atch\" href=\"./files/$row[$asgmtAtch]\">";
    echo "<i class=\"far primary-font fa-clipboard fa-2x\"></i>";
    echo "<hr class=\"vertical-rule\">";
    echo "<div class=\"atch-info\">";
    echo "<p>$row[$asgmtAtch]</p>";
    echo "<p class=\"gray uppercase\">PDF</p>";
    echo "</div>";
    echo "</a>";
    $currentTime = date("Y-m-d"). "T" . date("h:i");
    if($submited == true){
        $work = getWorkStudent($conn, $asgmtId, $className, $creator, $studentuid);
        while($row = mysqli_fetch_assoc($work)){
        echo "<div class=\"container round-border grid container-content\">";
        echo "<h1 class=\"secondary-title\">Work Submited</h2>";
        echo "<p>Description: ".$row["workDescription"]."</p>";
        echo "<a class=\"asgmt-atch option-wide\" href=\"./studentwork/".$row["workAtch"]."\">";
        echo "<div class=\"atch-info\">";
        echo "<p>".$row["workAtch"]."</p>";
        echo "<p class=\"gray uppercase\">PDF</p>";
        echo "</div>";
        echo "</a>";
        echo "<p>Coment: ".$row["workComment"]."</p>";
        echo "<p>Grade: ".$row["workGrade"]."/10</p>";
        if($row["workComment"] == null && $row["workGrade"] == null){
            echo "<a href=\"./includes/deletework.inc.php?action=unsubmit&atch=".$row["workAtch"]."\" class=\"btn no-decoration\">Unsubmit</a>";
            }
        }
    }else if($row[$asgmtDue] < $currentTime){
        echo "<div class=\"container round-border grid container-content\">";
        echo "<h1 class=\"secondary-title\">Late</h2>";
        echo "<p>You should've submited the work at ".$row[$asgmtDue]."</p>";
    }else if($submited == false){
        echo "<div class=\"container round-border grid container-content\">";
        echo "<h1 class=\"secondary-title\">Submit your Work</h2>";
        echo "<form action=\"./includes/submitwork.inc.php\" enctype=\"multipart/form-data\" method=\"POST\">";
        echo "<div class=\"container-content\">";
        echo "<div class=\"field\">";
        echo "<p>Description </p>";
        echo "<textarea id=\"description\" name=\"description\" placeholder=\"Description\" rows=\"4\" cols=\"35\"></textarea>";
        echo "</div>";
        $date = date("M d, Y") . " " . date("h:i:sa");
        echo "<input type=\"text\" value=\"$date\" readonly style=\"display: none;\" name=\"timestamp\" id=\"timestamp\">";
        echo "<div class=\"field\">";
        echo "<p>Attachment</p>";
        echo "<input type=\"file\" accept=\"application/pdf\" name=\"atch\">";
        echo "</div>";
        echo "<button class=\"btn\" type=\"submit\" name=\"submit\">Turn In</button>";
        if(isset($_GET["error"])){
            if ($_GET["error"] == "emptyinput"){
                echo "<p>Fill in all fields!</p>";
            }else if ($_GET["error"] == "none"){
                echo "<p>Work submited!</p>";
            }
        }
        echo "</div>";
        echo "</form>";
    }else if($submited == true){
        $work = getWorkStudent($conn, $asgmtId, $className, $creator, $studentuid);
        while($row = mysqli_fetch_assoc($work)){
        echo "<div class=\"container round-border grid container-content\">";
        echo "<h1 class=\"secondary-title\">Work Submited</h2>";
        echo "<p>Description: ".$row["workDescription"]."</p>";
        echo "<a class=\"asgmt-atch option-wide\" href=\"./studentwork/".$row["workAtch"]."\">";
        echo "<div class=\"atch-info\">";
        echo "<p>".$row["workAtch"]."</p>";
        echo "<p class=\"gray uppercase\">PDF</p>";
        echo "</div>";
        echo "</a>";
        echo "<p>Coment: ".$row["workComment"]."</p>";
        echo "<p>Grade: ".$row["workGrade"]."/10</p>";
        if($row["workComment"] == null && $row["workGrade"] == null){
            echo "<a href=\"./includes/deletework.inc.php?action=unsubmit&atch=".$row["workAtch"]."\" class=\"btn no-decoration\">Unsubmit</a>";
            }
        }
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    }
}

?>

<?php 
require_once "footer.php"
?>