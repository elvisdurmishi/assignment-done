<?php


function emptyInputRegister($name, $surname, $username, $email, $pwd, $pwdrepeat, $role){
    $result;

    if(empty($name) || empty($surname) || empty($username) || empty($email) || empty($pwd) || empty($pwdrepeat) || empty($role)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}


function invalidUid($username){
    $result;

    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdrepeat){
    $result;

    if($pwd !== $pwdrepeat){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}


function uidExists($conn, $username, $email, $role){
    $sql = "SELECT * FROM ". $role ." WHERE " . $role ."Uid = ? OR " . $role . "Email = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);


    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }else {
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $surname, $username, $email, $pwd, $role){

    if($role === "student"){
        $sql = "INSERT INTO student (studentName, studentSurname, studentEmail, studentUid, studentPwd) VALUES (?, ?, ?, ?, ?);";
    }
    else if($role === "staff"){
        $sql = "INSERT INTO staff (staffName, staffSurname, staffEmail, staffUid, staffPwd) VALUES (?, ?, ?, ?, ?);";
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    
   
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $name, $surname, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../register.php?error=none");
    exit();
}

function emptyInputLogin($username,$pwd){
    $result;

    if(empty($username) || empty($pwd)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function loginStudent($conn, $username, $pwd){
    $uidExist = uidExists($conn, $username, $username, "student");

    if($uidExist === false){
        header("location: ../loginStudent.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExist["studentPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if($checkPwd === false){
        header("location: ../loginStudent.php?error=wronglogin");
        exit();
    }else if ($checkPwd === true){
        session_start();
        $_SESSION["studentname"] = $uidExist["studentName"];
        $_SESSION["studentid"] = $uidExist["studentId"];
        $_SESSION["studentuid"] = $uidExist["studentUid"];
        $_SESSION["studentsurname"] = $uidExist["studentSurname"];
        $_SESSION["role"] = "student";
        header("location: ../studentIndex.php");
        exit();
    }
}

function loginStaff($conn, $username, $pwd){
    $uidExist = uidExists($conn, $username, $username, "staff");

    if($uidExist === false){
        header("location: ../loginStaff.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExist["staffPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if($checkPwd === false){
        header("location: ../loginStaff.php?error=wronglogin");
        exit();
    }else if ($checkPwd === true){
        session_start();
        $_SESSION["staffid"] = $uidExist["staffId"];
        $_SESSION["staffuid"] = $uidExist["staffUid"];
        $_SESSION["staffname"] = $uidExist["staffName"];
        $_SESSION["staffsurname"] = $uidExist["staffSurname"];
        $_SESSION["role"] = "staff";
        header("location: ../staffIndex.php");
        exit();
    }
}

// End of Staff Functions


// Class Creation Functions
function emptyInputClass($name, $description, $icon, $color){
    $result;

    if(empty($name) || empty($description) || empty($icon) || empty($color)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function invalidClassName($name){
    $result;
    $name = strtolower($name);

    if(preg_match("/\s/",$name)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function classExists($conn, $name){
    $sql = "SELECT * FROM classes WHERE classesName = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../createClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);


    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }else {
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

function createClass($conn, $name, $description, $icon, $color, $creator){
    $sql = "INSERT INTO classes (classesName, classesDescription, classesIcon, classesColor, classesCreator) VALUES (?, ?, ?, ?, ?);";
       
    $stmt = mysqli_stmt_init($conn);
    $name = lcfirst($name);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../createClass.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssss", $name, $description, $icon, $color, $creator);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../createClass.php?error=none");
    exit();
}

// Class Sessions

function openClass($className){
    $className = lcfirst($className);
    session_start();
    $_SESSION["classname"] = $className;
    $_SESSION["role"] = "staff";
    header("location: ../staffClass.php?class=".$className);
    exit();
}

function deleteStudentsFromClass($classname, $creator, $conn){
    $sql = "DELETE FROM stuclass WHERE stuclassName = ? AND stuclassCreator = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffIndex.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $classname, $creator);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteClass($classname, $conn){
    $classname = lcfirst($classname);
    $sql = "DELETE FROM classes WHERE classesName = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffIndex.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $classname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ./classclose.inc.php");
    exit();
}

function deleteQuizClass($classname, $conn){
    $sql = "DELETE FROM quiz WHERE quizClass = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffIndex.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $classname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteQuizQuestionTable($classname, $conn){
    $sql = "DELETE FROM quizquestions WHERE className = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffIndex.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $classname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteQuizAnswersTable($classname, $conn){
    $sql = "DELETE FROM studentquiz WHERE className = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffIndex.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $classname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteUser($studentuid, $classname, $creator, $conn){
    $sql = "DELETE FROM stuclass WHERE stuclassStudentUid = ? AND stuclassName = ? AND stuclassCreator = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../pjestaret.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $studentuid, $classname, $creator);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../pjestaret.php?error=none");
    exit();
}

function deleteStudentQuizWork($conn, $studentuid, $classname){
    $sql = "DELETE FROM studentquiz WHERE studentUid = ? AND className = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../pjestaret.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $studentuid, $classname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteStudentAssignments($conn, $studentuid, $classname){
    $sql = "DELETE FROM studentwork WHERE workStudentUid = ? AND assignmentClass = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../pjestaret.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $studentuid, $classname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// End of Class Section


// Class Code Section
function cipher($ch, $key)
{
	if (!ctype_alpha($ch))
		return $ch;

	$offset = ord(ctype_upper($ch) ? 'A' : 'a');
	return chr(fmod(((ord($ch) + $key) - $offset), 26) + $offset);
}

function encipher($input, $key)
{
	$output = "";
	$inputArr = str_split($input);
	foreach ($inputArr as $ch)
        $output .= Cipher($ch, $key);
        
	return $output;
}

function decipher($input, $key)
{
	return encipher($input, 26 - $key);
}
// End of Class Code Seciton

// Assignment Section

function emptyInputAsgmt($title, $description, $creator, $timestamp, $duedate, $atch){
    $result;

    if(empty($title) || empty($description) || empty($creator) || empty($timestamp) || empty($duedate) || empty($atch)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function createAssignment($conn, $classname, $title, $description, $creator, $timestamp, $duedate, $atch){
    $sql = "INSERT INTO assignment (assignmentClass, assignmentCreator, assignmentTitle, assignmentDescription,
    assignmentTimestamp, assignmentDue, assignmentAtch) VALUES (?, ?, ?, ?, ?, ?, ?);";
       
    $stmt = mysqli_stmt_init($conn);
    $name = lcfirst($name);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../createClass.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssssss", $classname, $creator, $title, $description, $timestamp, $duedate, $atch);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../createAssignment.php?error=none");
    exit();
}

function getAsgmt($conn, $className, $creator){
    $sql = "SELECT * FROM assignment WHERE assignmentClass = ? AND assignmentCreator = ?;";
    $stmt = mysqli_stmt_init($conn);

 
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $className, $creator);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}

function getAsgmtData ($conn, $asgmtId, $className, $creator){
    $sql = "SELECT * FROM assignment WHERE assignmentId = ? AND assignmentClass = ? AND assignmentCreator = ?;";
    $stmt = mysqli_stmt_init($conn);

 
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $asgmtId, $className, $creator);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}

function deleteAssignmentClass($classname, $conn){
    $classname = lcfirst($classname);
    $sql = "DELETE FROM assignment WHERE assignmentClass = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $classname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteStudentSubmitions($conn, $asgmtid, $classname, $creator){
    $sql = "DELETE FROM studentwork WHERE studentwork.assignmentId = ? AND studentwork.assignmentClass = ? AND studentwork.assignmentCreator = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $asgmtid, $classname, $creator);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteAssignment($asgmtId, $classname, $conn){
    $classname = lcfirst($classname);
    $sql = "DELETE FROM assignment WHERE assignmentId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $asgmtId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ./assignmentclose.inc.php");
    exit();
}

function deleteFileClass($classname, $conn){
    $classname = lcfirst($classname);
    $tablename = strtolower($classname);
    $sql = "SELECT * FROM assignment WHERE assignmentClass = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $classname);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($resultData)){
        unlink("../files/".$row["assignmentAtch"]);
    }
}

function deleteFile($asgmtId, $conn){
    $sql = "SELECT * FROM assignment WHERE assignmentId = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $asgmtId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($resultData)){
        unlink("../files/".$row["assignmentAtch"]);
    }
}

function deleteStudentsWorkFiles($conn, $classname){
    $sql = "SELECT * FROM studentwork WHERE assignmentClass = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $classname);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($resultData)){
        unlink("../studentwork/".$row["workAtch"]);
    }
}

function deleteStudentWork($conn, $classname){
    $sql = "DELETE FROM studentwork WHERE assignmentClass = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffIndex.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $classname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteStudentWorkFile($conn, $asgmtid, $classname, $creator){
    $sql = "SELECT * FROM studentwork WHERE assignmentId = ? AND assignmentClass = ? AND assignmentCreator = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $asgmtid, $classname, $creator);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($resultData)){
        unlink("../studentwork/".$row["workAtch"]);
    }
}

function updateAssisgnmentWithAtch($conn, $asgmtid, $title, $due, $description, $atch){
    $sql = "UPDATE assignment SET assignmentTitle = ?, assignmentDue = ?, assignmentDescription = ?, assignmentAtch = ?
    WHERE assignment.assignmentId = ?;";
    $stmt = mysqli_stmt_init($conn);

 
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $title, $due, $description, $atch, $asgmtid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../staffClass.php");
    exit();
}

function updateAssignment($conn, $asgmtid, $title, $due, $description){
    $sql = "UPDATE assignment SET assignmentTitle = ?, assignmentDue = ?, assignmentDescription = ?
    WHERE assignment.assignmentId = ?;";
    $stmt = mysqli_stmt_init($conn);

 
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $title, $due, $description, $asgmtid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../staffClass.php");
    exit();
}

function openAssignment($asgmtId, $classname){
    session_start();
    $_SESSION["asgmtid"] = $asgmtId;
    header("location: ../viewAssignment.php?class=".$classname);
    exit();
}

// End of Assignment Section

// Quiz Section

function getQuiz($conn, $className, $creator){
    $sql = "SELECT * FROM quiz WHERE quizClass = ? AND quizCreator = ?;";
    $stmt = mysqli_stmt_init($conn);

 
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $className, $creator);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}

function openQuiz($quizId, $quizTitle, $classname){
    session_start();
    $_SESSION["quizid"] = $quizId;
    $_SESSION["quiztitle"] = $quizTitle;
    header("location: ../viewQuiz.php?class=".$classname);
    exit();
}

function emptyQuiz($title, $description, $creator, $timestamp, $duedate, $questionNr){
    $result;

    if(empty($title) || empty($description) || empty($creator) || empty($timestamp) || empty($duedate) || empty($questionNr)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function insertQuizData($conn, $classname, $creator, $title, $description, $timestamp, $duedate, $questionnr){
    $sql = "INSERT INTO quiz (quizClass, quizCreator, quizTitle, quizDescription,
    quizTimestamp, quizDue, quizQuestionNr) VALUES (?, ?, ?, ?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);
    $classname = lcfirst($classname);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../createQuiz.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssssss", $classname, $creator, $title, $description, $timestamp, $duedate, $questionnr);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getQuizData($conn, $creator, $title){
    $sql = "SELECT * FROM quiz WHERE quizCreator = ? AND quizTitle = ?;";
    $stmt = mysqli_stmt_init($conn);

 
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $creator, $title);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}

function insertQuestion($conn, $quizId, $questionNumber, $question, $alt1, $alt2, $alt3, $alt4, $rightAnswer, $classname){
    $sql = "INSERT INTO quizquestions (quizId, quizQuestionsQuestionNr, quizQuestionsQuestion,
    quizQuestionsAlt1, quizQuestionsAlt2, quizQuestionsAlt3, quizQuestionsAlt4, quizQuestionsQAnswer, className) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
       
    $stmt = mysqli_stmt_init($conn);
    $name = lcfirst($name);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../createQuiz.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssssssss", $quizId, $questionNumber, $question, $alt1, $alt2, $alt3, $alt4, $rightAnswer, $classname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteQuiz($quizId, $conn){
    $sql = "DELETE FROM quiz WHERE quizId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $quizId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ./quizclose.inc.php");
    exit();
}

function deleteQuizQuestions($conn, $quizId){
    $classname = lcfirst($classname);
    $sql = "DELETE FROM quizquestions WHERE quizId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $quizId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteQuizStudentAnswers($conn, $quizId){
    $classname = lcfirst($classname);
    $sql = "DELETE FROM studentquiz WHERE quizId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $quizId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getQuizInfo($conn, $quizId){
    $sql = "SELECT * FROM quiz WHERE quizId = ?;";
    $stmt = mysqli_stmt_init($conn);

 
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $quizId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}

function getQuestionData($conn, $quizId){
    $sql = "SELECT * FROM quizquestions WHERE quizId = ?;";
    $stmt = mysqli_stmt_init($conn);

 
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $quizId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}

function updateQuizInfo($conn, $quizId, $title, $due, $description){
    $sql = "UPDATE quiz SET quizTitle = ?, quizDue = ?, quizDescription = ? WHERE quizId = ?;";
    $stmt = mysqli_stmt_init($conn);

 
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $title, $due, $description, $quizId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../staffClass.php");
    exit();
}

function updateQuestion($conn, $question, $alt1, $alt2, $alt3, $alt4, $rightAnswer, $questionNumber, $quizId){
    $sql = "UPDATE quizquestions SET quizQuestionsQuestion = ?, quizQuestionsAlt1 = ?, quizQuestionsAlt2 = ?
    , quizQuestionsAlt3 = ?, quizQuestionsAlt4 = ?, quizQuestionsQAnswer = ?  WHERE quizquestions.quizQuestionsQuestionNr = ? AND 
    quizquestions.quizId = ?;";
    $stmt = mysqli_stmt_init($conn);

 
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffClass.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssssss", $question, $alt1, $alt2, $alt3, $alt4, $rightAnswer, $questionNumber, $quizId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// End of Quiz Section


////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////              STUDENT FUNCTIONS               /////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getStudentClasses($conn, $studentuid){
    $sql = "SELECT * FROM classes, stuclass WHERE classes.classesName = stuclass.stuclassName AND classes.classesCreator = stuclass.stuclassCreator
    AND stuclass.stuclassStudentUid = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./studentIndex.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $studentuid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}

function getClassData($conn, $classname, $creator){
    $sql = "SELECT * FROM classes WHERE classesName = ? AND classesCreator = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./studentIndex.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $classname, $creator);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
    mysqli_stmt_close($stmt);
}

function userAlreadyRegistered($conn, $classname, $creator, $studentuid){
    $sql = "SELECT * FROM stuclass WHERE stuclassName = ? AND stuclassCreator = ? AND stuclassStudentUid = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../studentIndex.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $classname, $creator, $studentuid);
    mysqli_stmt_execute($stmt);


    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }else {
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

function emptyClassCode($conn, $classname, $creator, $studentuid){
    $result;

    if(empty($classname) || empty($creator) || empty($studentuid)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function joinclass($conn, $classname, $creator, $studentname, $studentuid, $studentsurname){
    $sql = "INSERT INTO stuclass (stuclassName, stuclassCreator, stuclassStudent, stuclassStudentUid, stuclassSurname) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../studentIndex.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssss", $classname, $creator, $studentname, $studentuid, $studentsurname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../studentIndex.php?error=none");
    exit();
}

function getstudentInfo($conn, $classname, $creator){
    $sql = "SELECT * FROM stuclass WHERE stuclassName = ? AND stuclassCreator = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./includes/classclose.inc.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $classname, $creator);
    mysqli_stmt_execute($stmt);


    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}

function openClassStudent($className, $creator){
    $className = lcfirst($className);
    session_start();
    $_SESSION["classname"] = $className;
    $_SESSION["creator"] = $creator;
    $_SESSION["role"] = "student";
    header("location: ../studentClass.php?class=".$className);
    exit();
}

function emptyWork($description, $atch, $deliveredtime){
    $result;

    if(empty($description) || empty($atch) || empty($deliveredtime)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function deliverWork($conn, $asgmtid, $classname, $creator, $description, $deliveredtime, $atch, $studentname, $studentsurname, $studentuid){
    $sql = "INSERT INTO studentwork (assignmentId, assignmentClass, assignmentCreator, workDescription,
    workDeliveredTime, workAtch, workName, workSurname, workStudentUid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
       
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../viewAssignment.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssssssss", $asgmtid, $classname, $creator, $description, $deliveredtime, $atch, $studentname, $studentsurname, $studentuid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../viewAssignment.php?error=none");
    exit();
}

function getWork($conn, $asgmtid, $classname, $creator){
    $sql = "SELECT * FROM studentwork WHERE assignmentId = ? AND assignmentClass = ? AND assignmentCreator = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./includes/classclose.inc.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $asgmtid, $classname, $creator);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}

function getWorkStudent($conn, $asgmtid, $classname, $creator, $studentuid){
    $sql = "SELECT * FROM studentwork WHERE assignmentId = ? AND assignmentClass = ? AND assignmentCreator = ? AND workStudentUid = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./includes/classclose.inc.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $asgmtid, $classname, $creator, $studentuid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}

function unsubmitWork($conn, $asgmtid, $classname, $creator, $studentuid, $atch){

    unlink("../studentwork/".$atch);

    $sql = "DELETE FROM studentwork WHERE assignmentId = ? AND assignmentClass = ? AND assignmentCreator = ? AND workStudentUid = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../staffIndex.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $asgmtid, $classname, $creator, $studentuid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../viewAssignment.php");
    exit();
}

function emptyGradeInput($comment, $grade, $studentuid){
    $result;

    if(empty($comment) || empty($grade) || empty($studentuid)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function gradeStudent($conn, $comment, $grade, $studentuid){
    $sql = "UPDATE studentwork SET workComment = ?, workGrade = ? WHERE studentwork.workStudentUid = ?;";
       
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../viewAssignment.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $comment, $grade, $studentuid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../viewAssignment.php?error=graded");
    exit();
}

function emptyQuestion($question){
    $result;

    if(empty($question)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function submitQuiz($conn, $studentuid, $studentname, $studentsurname, $quizId, $currentQuestion, $answer, $timestamp, $classname){
    $sql = "INSERT INTO studentquiz (studentUid, studentName, studentSurname, quizId, questionNr, studentAnswer, submitTimestamp, className) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
       
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../viewAssignment.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssssssss", $studentuid, $studentname, $studentsurname, $quizId, $currentQuestion, $answer, $timestamp, $classname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getStudentQuiz($conn, $quizId, $studentuid){
    $sql = "SELECT * FROM studentquiz WHERE quizId = ? AND studentUid = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./includes/classclose.inc.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $quizId, $studentuid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}

function quizPoints($conn, $studentuid, $quizId){
    $sql = "SELECT * FROM studentquiz, quizquestions WHERE studentquiz.quizId = quizquestions.quizId 
    AND studentquiz.questionNr = quizquestions.quizQuestionsQuestionNr AND studentquiz.studentUid = ? AND studentquiz.quizId = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./studentIndex.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $studentuid, $quizId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}

function getStudentAnswer($conn, $quizId, $studentuid){
    $sql = "SELECT * FROM studentquiz WHERE quizId = ? AND studentUid = ? AND questionNr = 1;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./studentIndex.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $quizId,$studentuid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}

function getStudentAnswers($conn, $quizId, $studentuid, $questionnr){
    $sql = "SELECT * FROM studentquiz WHERE quizId = ? AND studentUid = ? AND questionNr = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ./studentIndex.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $quizId,$studentuid, $questionnr);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;
}

function openStudentSubmition($conn, $quizId, $studentUid, $studentname, $studentsurname){
    session_start();
    $_SESSION["quizid"] = $quizId;
    $_SESSION["studentuid"] = $studentUid;
    $_SESSION["studentname"] = $studentname;
    $_SESSION["studentsurname"] = $studentsurname;
    header("location: ../viewStudentAnswers.php?quizid=".$quizId."&studentuid=".$studentUid);
    exit();
}
