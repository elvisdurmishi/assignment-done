<?php 
    require_once "header.php"
?>

<?php
    require_once "./includes/dbh.inc.php";
    require_once "./includes/functions.inc.php";
    
    $classname = $_SESSION["classname"];
    $staffname = $_SESSION["staffname"];
    $staffsurname = $_SESSION["staffsurname"];
    $creator = $_SESSION["staffuid"];

    $resultData = getstudentInfo($conn, $classname, $creator);

    $id = 1;

    echo "<div class=\"container grid\">";
    if(isset($_GET["error"])){
        if ($_GET["error"] == "rolestaff"){
            echo "<p>Staff nuk mund te fshij veten!</p>";
        }
    }
    echo "<table>";
    $classUppercase = ucfirst($classname);
    echo "<caption> Pjestaret e klases \"$classUppercase\" </caption>";
    echo "<thead>";
    print ("<tr>");
        print("<td> ID </td>");
        print("<td> Name </td>");
        print("<td> Surname </td>");
        print("<td> User ID</td>");
        print("<td> Role </td>");
        print("<td> Delete User </td>");
    print ("</tr>");
    print ("<tr>");

        print("<td> $id </td>");
        print("<td> $staffname </td>");
        print("<td> $staffsurname </td>");
        print("<td> $creator </td>");
        print("<td> staff </td>");
        print("<td> </td>");

        print ("</tr>");
    echo "</thead>";
    while($row = mysqli_fetch_assoc($resultData)){
        $id++;
        print ("<tr>");

        print("<td> $id </td>");
        print("<td> ".$row["stuclassStudent"]." </td>");
        print("<td> ".$row["stuclassSurname"]." </td>");
        print("<td> ".$row["stuclassStudentUid"]." </td>");
        print("<td> student </td>");
        print("<td> <a href=\"./includes/deleteUserFromClass.inc.php?classuserid=".$row["stuclassStudentUid"]."\" class=\"btn no-decoration\">Delete</a> </td>");

        print ("</tr>");
    }
    echo "</table>";
?>
    </div>
<?php 
    require_once "footer.php"
?>