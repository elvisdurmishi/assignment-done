<?php 
require_once "header.php"
?>

<?php
require_once "./includes/dbh.inc.php";
require_once "./includes/functions.inc.php";

$className = $_SESSION["classname"];
$creator = $_SESSION["staffuid"];
$asgmtId = $_GET["editasmgt"];
$_SESSION["asgmtid"] = $asgmtId;

$resultData = getAsgmtData($conn, $asgmtId, $className, $creator);

$asgmtDescription = "assignmentDescription";
$asgmtTitle = "assignmentTitle";
$asgmtDue = "assignmentDue";
$asgmtCreator = "assignmentCreator";
$asgmtTime = "assignmentTimestamp";
$asgmtAtch = "assignmentAtch";

$asgmtTempAtach = $asgmtAtch;


if(isset($_SESSION["staffid"])){
    echo "<div class=\"container flex grid\">";
    echo "<div class=\"small-circle primary\"><i class=\"far center white fa-2x fa-clipboard\"></i></div>";
    
    while($row = mysqli_fetch_assoc($resultData)){

    echo "<div class=\"asgmt\">";
    echo "<form action=\"./includes/editAssignment.inc.php\" enctype=\"multipart/form-data\" method=\"POST\">";
    echo "<div class=\"asgmt-header\"> ";
    echo "<h1 class=\"secondary-title\"><input type=\"text\" class=\"option\" value=\"$row[$asgmtTitle]\" name=\"title\" id=\"title\"></h2>";
    echo "<p> $row[$asgmtCreator] • ".substr($row[$asgmtTime], 0, 6).", ".substr($row[$asgmtTime], 12, 25)."</p>";
    echo "<p right-title> Due <input class=\"radio-btn\" type=\"datetime-local\" id=\"duedate\" name=\"duedate\" value=\"$row[$asgmtDue]\" min=\"$row[$asgmtDue]\"></p>";
    echo "<hr>";
    echo "</div>";
    echo "<div class=\"asgmt-body-staff\">";
    echo "<p>Description <input type=\"text\" class=\"option option-wide\" value=\"$row[$asgmtDescription]\" name=\"description\" id=\"description\"></p>";
    echo "<a class=\"asgmt-atch\" href=\"./files/$row[$asgmtAtch]\">";
    $_SESSION["oldatch"] = $row[$asgmtAtch];
    echo "<i class=\"far primary-font fa-clipboard fa-2x\"></i>";
    echo "<hr class=\"vertical-rule\">";
    echo "<div class=\"atch-info\">";
    echo "<p>$row[$asgmtAtch]</p>";
    echo "<p class=\"gray uppercase\">PDF</p>";
    echo "</div>";
    echo "</a>";
    echo "<p>Attachment</p>";
    echo "<input type=\"file\" accept=\"application/pdf\" name=\"atch\"><br>";
    echo "<input class=\"radio-btn\" type=\"checkbox\" id=\"deleteAtch\" name=\"deleteAtch\" value=\"NewAtch\">";
    echo "<label for=\"deleteAtch\"> Select if you want to upload a new file.</label><br>";
    echo "</div>";
    echo "</div>";
    echo "<button class=\"btn\" type=\"submit\" name=\"submit\">Update</button>";
    echo "</form>";
    echo "</div>";
    }
}

?>
<?php 
require_once "footer.php"
?>