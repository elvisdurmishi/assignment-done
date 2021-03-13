
<div class="container grid">
        <div class="container-content">
        <div class="circle"><i class="fas center fa-users fa-3x"></i></div> 
        <h1 class="title">Create Class</h1>
        <form action="./includes/createClass.inc.php" method="post">
            <div class="field">
                <p>Name </p>
                <input type="text" name="name" placeholder="Name" id="name">
            </div>
            <div class="field">
                <p>Description </p>
                <input type="text" name="description" placeholder="Description" id="description">
            </div>
            <div class="field">
                <p>Icons</p>
                <div class="icons">
                <i class="fas fa-atom fa-2x"></i>
                Atom
                <i class="fas fa-laptop-code fa-2x"></i>
                Code
                <i class="fas fa-calculator fa-2x"></i>
                Calculator
                <i class="fas fa-leaf fa-2x"></i>
                Leaf
                </div>
            </div>
            <div class="field">
                <p>Select Icon</p>
                <select class="select-field" name="icon" id="icon">
                    <option value="atom">Atom</option>
                    <option value="laptop-code">Code</option>
                    <option value="calculator">Calculator</option>
                    <option value="leaf">Leaf</option>
                </select>
            </div>
            <div class="field">
                <p>Color</p>
                <select class="select-field" name="color" id="color">
                    <option value="red">Red</option>
                    <option value="blue">Blue</option>
                    <option value="pink">Pink</option>
                    <option value="purple">Purple</option>
                    <option value="green">Green</option>
                </select>
            </div>
            <div class="field">
                <p>Creator ID</p>
                <?php 
                    echo "<select class=\"select-field\" name=\"creator\" id=\"creator\">";
                    echo "<option value=".$_SESSION["staffuid"].">".$_SESSION["staffuid"]."</option>";
                    echo "</select>";
                ?>
            </div>
            <div class="field">
                <p>Creator Name</p>
                <?php 
                    echo "<select class=\"select-field\" name=\"teacherName\" id=\"teacherName\">";
                    echo "<option value=".$_SESSION["staffname"].">".$_SESSION["staffname"]."</option>";
                    echo "</select>";
                ?>
            </div>
            <button class="btn" type="submit" name="submit">Create Class</button>
        </form>
        <?php
            if(isset($_GET["error"])){
                if ($_GET["error"] == "emptyinput"){
                    echo "<p>Fill in all fields!</p>";
                }
                else if ($_GET["error"] == "invalidclassname"){
                    echo "<p>The class name should not contain white space!</p>";
                }
                else if ($_GET["error"] == "classtaken"){
                    echo "<p>Class name is already taken</p>";
                }
                else if ($_GET["error"] == "none"){
                    echo "<p>Class created successfully!</p>";
                }
            }
        ?>
        </div>
    </div>