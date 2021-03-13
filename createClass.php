<?php 
 include_once "header.php";
?>
<?php
    if(isset($_SESSION["staffid"])){
        include_once "./includes/createClassForm.inc.php";
    }else{
        header("location: ./index.php");
        exit();
    }
?>
    
<?php 
    include_once "footer.php";
?>