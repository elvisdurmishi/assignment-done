<?php 
 include_once "header.php";
?>
    <div class="container">
        <div class="container-content">
        <div class="circle"><i class="fas center fa-users fa-3x"></i></div> 
        <h1 class="title">Register</h1>
        <form action="./includes/register.inc.php" method="post">
            <div class="field">
                <p>Name </p>
                <input type="text" name="name" placeholder="Name" id="name">
            </div>
            <div class="field">
                <p>Surname </p>
                <input type="text" name="surname" placeholder="Surname" id="surname">
            </div>
            <div class="field">
                <p>Username </p>
                <input type="text" name="uid" placeholder="Username" id="uid"> 
            </div>
            <div class="field">
                <p>Email </p>
                <input type="email" name="email" placeholder="Email" id="email">
            </div>
            <div class="field">
                <p>Password </p>
                <input type="password" name="pwd" placeholder="Password" id="pwd">
            </div>
            <div class="field">
                <p>Password Confirm</p>
                <input type="password" name="pwdrepeat" placeholder="Password Confirm" id="pwdrepeat">
            </div>
            <div class="field">
                <p>Role</p>
                <select class="select-field" name="role" id="role">
                    <option value="student">Student</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
            <button class="btn" type="submit" name="submit">Register</button>
        </form>
        <?php
            if(isset($_GET["error"])){
                if ($_GET["error"] == "emptyinput"){
                    echo "<p>Fill in all fields!</p>";
                }
                else if ($_GET["error"] == "invaliduid"){
                    echo "<p>Chose a proper username!</p>";
                }
                else if ($_GET["error"] == "passwordsdontmatch"){
                    echo "<p>Passwords don't match!</p>";
                }
                else if ($_GET["error"] == "usernametaken"){
                    echo "<p>Username is already taken!</p>";
                }
                else if ($_GET["error"] == "stmtfailed"){
                    echo "<p>Something went wrong try again!</p>";
                }
                else if ($_GET["error"] == "none"){
                    echo "<p>You registered successfully!</p>";
                }
            }
        ?>
        </div>
    </div>
<?php 
    include_once "footer.php";
?>