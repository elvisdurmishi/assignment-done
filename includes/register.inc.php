<?php

if (isset($_POST["submit"])){
    
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $username = $_POST["uid"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdrepeat = $_POST["pwdrepeat"];
    $role = $_POST["role"];

    require_once "dbh.inc.php";
    require_once "functions.inc.php";

    // Ridrejton perdoruesin tek faqja e rregjistrimmit nese harron nje fushe pa input
    if(emptyInputRegister($name, $surname, $username, $email, $pwd, $pwdrepeat, $role) !== false){
        header("location: ../register.php?error=emptyinput");
        exit();
    }

    if(invalidUid($username) !== false){
        header("location: ../register.php?error=invaliduid");
        exit();
    }
    
    if(pwdMatch($pwd, $pwdrepeat) !== false){
        header("location: ../register.php?error=passwordsdontmatch");
        exit();
    }

    if(uidExists($conn, $username, $email, $role) !== false){
        header("location: ../register.php?error=usernametaken");
        exit();
    }

    createUser($conn, $name, $surname, $username, $email, $pwd, $role);

} else{
    header("location: ../register.php");
    exit();
}
