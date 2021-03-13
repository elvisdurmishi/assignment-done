<?php 
    include_once "header.php";
?>

    <div class="container">
        <div class="container-content">
        <div class="circle"><i class="fas center fa-chalkboard-teacher fa-3x"></i></div> 
        <h1 class="title">Staff Log In</h1>
        <form action="./includes/loginStaff.inc.php" method="post">
            <div class="field">
                <p>Username </p>
                <input type="text" name="uid" placeholder="Username or Email" id="uid"> 
            </div>
            <div class="field">
                <p>Password </p>
                <input type="password" name="pwd" placeholder="Password" id="pwd">
            </div>
            <button class="btn" type="submit" name="submit">Log In</button>
        </form>
        <?php
            if(isset($_GET["error"])){
                if ($_GET["error"] == "emptyinput"){
                    echo "<p>Fill in all fields!</p>";
                }
                else if ($_GET["error"] == "wronglogin"){
                    echo "<p>Incorrect username or password!</p>";
                }
            }
        ?>
        </div>
    </div>

<?php 
    include_once "footer.php";
?>