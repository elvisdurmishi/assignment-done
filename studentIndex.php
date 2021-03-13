<?php 
 include_once "header.php";
?>
<?php 

require_once "./includes/dbh.inc.php";
require_once "./includes/functions.inc.php";

$studentuid = $_SESSION["studentuid"];
$studentid = $_SESSION["studentid"];
$studentname = $_SESSION["studentname"];
$studentClasses = getStudentClasses($conn, $studentuid);
    
if(isset($_SESSION["studentid"])){
    
   echo "<div class=\"container flex grid\">";
   echo "<h1 class=\"title\">Welcome <em>".$_SESSION["studentname"]."</em></h1>";
   echo "<form action=\"./includes/joinClass.inc.php\" method=\"POST\">";
   echo "<input type=\"text\" placeholder=\"Class Code\" name=\"classcode\" id=\"classcode\">";
   echo "<button type=\"submit\" name=\"submit\" class=\"btn\">Join Class</button>";
   echo "</form>";
   echo "</div>";

    echo "<div class=\"container grid\">";
    if(isset($_GET["error"])){
        if ($_GET["error"] == "bad"){
            echo "<p>Code is not correct!</p>";
            }
        else if ($_GET["error"] == "none"){
            echo "<p>Joined Class Successfully!</p>"; 
        }
        else if ($_GET["error"] == "useralreadyinclass"){
            echo "<p>You are already in this class!</p>"; 
        }
        else if ($_GET["error"] == "emptyinput"){
            echo "<p>The code field is empty!</p>"; 
        }
        else if ($_GET["error"] == "classdoesntexist"){
            echo "<p>The code is incorrect or the class doesn't exist!</p>"; 
        }
    }
    echo "<h1 class=\"title\">Classes</h1>";
    echo "<div class=\"grid-container\">";
    while($row = mysqli_fetch_assoc($studentClasses)){
            $row["classesName"] = ucfirst($row["classesName"]);
            print ("<div class=\"card " .$row["classesColor"]. "-card\">");
            print ("<div class=\"card-body\">");
            print ("<div class=\"circle\"><i class=\"fas center " .$row["classesColor"]." fa-". $row["classesIcon"] ." fa-2x\"></i></div>");
            print ("<h2 class=\"class-title\">".$row["classesName"]."</h2>");
            print ("<p class=\"class-description\">".$row["classesDescription"]."</p>");
            print ("</div>");
            $row["classesName"] = lcfirst($row["classesName"]);
            print ("<a href=\"./includes/openclass.inc.php?class=".$row["classesName"]."&creator=".$row["classesCreator"]."\" class=\"card-link\">Open Class</a>");
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