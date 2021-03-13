<?php 
 include_once "header.php";
?>
<?php 

require_once "./includes/dbh.inc.php";
require_once "./includes/functions.inc.php";

$sql = "SELECT * FROM classes WHERE classesCreator = ?";
    $stmt = mysqli_stmt_init($conn);
    $creator = $_SESSION["staffuid"];
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./staffIndex.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $creator);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    
if(isset($_SESSION["staffid"])){
    
   echo "<div class=\"container flex grid\">";
   echo "<h1 class=\"title\">Welcome <em>".$_SESSION["staffuid"]."</em></h1>";
   echo "<a href=\"./createClass.php\" class=\"btn no-decoration\">Create Class</a>";
   echo "</div>";

    echo "<div class=\"container grid\">";
    echo "<h1 class=\"title\">Classes</h1>";
    echo "<div class=\"grid-container\">";
    while($row = mysqli_fetch_assoc($resultData)){
            $row["classesName"] = ucfirst($row["classesName"]);
            print ("<div class=\"card " .$row["classesColor"]. "-card\">");
            print ("<div class=\"card-body\">");
            print ("<div class=\"circle\"><i class=\"fas center " .$row["classesColor"]." fa-". $row["classesIcon"] ." fa-2x\"></i></div>");
            print ("<h2 class=\"class-title\">".$row["classesName"]."</h2>");
            print ("<p class=\"class-description\">".$row["classesDescription"]."</p>");
            print ("</div>");
            $row["classesName"] = lcfirst($row["classesName"]);
            print ("<a href=\"./includes/openclass.inc.php?class=".$row["classesName"]."\" class=\"card-link\">Open Class</a>");
            print ("</div>");
    }

}else {
    header("location: ./index.php");
}
?>
        </div>
    </div>
<?php 
    include_once "footer.php";
?>