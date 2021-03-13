<?php
session_start();
require_once "./dbh.inc.php";
require_once "./functions.inc.php";

$studentname = $_SESSION["studentname"];
$studentuid = $_SESSION["studentuid"];
$studentsurname = $_SESSION["studentsurname"];

if(isset($_POST["submit"])){
    $encryptedcode = $_POST["classcode"];
    $decriptedcode = decipher($encryptedcode, 3);
    $codeArr = explode(":", $decriptedcode);
    $classname = $codeArr[0]; 
    $creator = $codeArr[1];
    if(userAlreadyRegistered($conn, $classname, $creator, $studentuid) !== false){
        header("location: ../studentIndex.php?error=useralreadyinclass");
        exit();
    }else if (emptyClassCode($conn, $classname, $creator, $studentuid) !== false ){
        header("location: ../studentIndex.php?error=emptyinput");
        exit();
    }
    $classExists = getClassData($conn, $classname, $creator);
    while ($row = mysqli_fetch_assoc($classExists)){
        if($classname == $row["classesName"] && $creator == $row["classesCreator"]){
            joinclass($conn, $classname, $creator, $studentname, $studentuid, $studentsurname);
        }
    }
    header("location: ../studentIndex.php?error=classdoesntexist");
    exit();
}else {
    header("location: ../studentIndex.php?error=bad");
    exit();
}