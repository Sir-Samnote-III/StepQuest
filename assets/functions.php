<?php
require_once 'config/db.php';

$sidfot='<div class="sidfot">
<p>
    Du kan kontakta mig p&aring; min <a target="blank" href="https://mail.google.com/mail/u/0/#inbox?compose=jrjtXDzgsKwhmvtVDQsfRDDPZTDHRJmsfsQqBXHnGTpXzNPMBKXqWThFSFDdqnpjLwfNkljw" class="a ">E-mail</a> eller tel nr (076 555 21 17)<br>
    Senast uppdaterad 19/2-2025<br>
    Skapad av Antonios Danho
</p>
</div>';

$sidfot_barn='<div class="sidfot">
<p>
    Du kan kontakta mig p&aring; min <a target="blank" href="https://mail.google.com/mail/u/0/#inbox?compose=jrjtXDzgsKwhmvtVDQsfRDDPZTDHRJmsfsQqBXHnGTpXzNPMBKXqWThFSFDdqnpjLwfNkljw" class="a barn">E-mail</a> eller tel nr (076 555 21 17).<br>
    Senast uppdaterad 11/2-2025<br>
    Skapad av Antonios Danho
</p>
</div>';


$meny_gammal='<div class="menu" onclick="toggleMenu()">
    <div class="bar1"></div>
    <div class="bar2"></div>
    <div class="bar3"></div>
</div>

<nav class="menu-items" id="menuItems">
    <a href="hem.php">Hem</a>
    <a href="#about">Om StepQuest</a>
    <a href="updateUser.php">Uppdatera profil</a>
    <a href="logout.php">Logga ut</a>


    <div class="dropdown">
    <button class="dropbtn" id="faqButton">FAQ ↓</button>
    <div class="dropdown-content" id="faqContent">
        <a href="#">Hur anv&auml;nder man StepQuest?</a>
        <a href="#">Hur kan jag kontakta support?</a>
        <a href="hem.php">Hur l&auml;gger jag till ett barn?</a>
        <a href="#">More...</a>
    </div>
</div>
</nav>';

$meny='<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="toggleSideNav()">&times;</a>
  <a href="#">Services</a>
  <a href="hem.php#FAQ">FAQ</a>
  <a href="signup_barn.php">L&auml;gg till barn</a>
  <a href="updateUser.php">Uppdatera profil</a>
  <a href="logout.php">Log out</a>

</div>

<!-- Menu Button -->
<div class="menu" onclick="toggleSideNav()">
  <div class="bar1"></div>
  <div class="bar2"></div>
  <div class="bar3"></div>
</div>';

$navigering='<a href="hem.php">
<div class ="grid-container">
    <div class="navigationCell">
        <p class="p hem"><b>Hem</b></p>
    </div>
    </a>

<a href="hantera_stepcoins.php">
    <div class="navigationCell">
        <p class="p hanteraStepCoins"><b>Hantera StepCoins</b></p>
    </div>
    </a>

<a href="statistik.php">
    <div class="navigationCell">
        <p class="p statistik"><b>Statistik</b></p>
</div>
</a>

<a href="forum.php">
    <div class="navigationCell">
        <p class="p socialt"><b>Socialt</b></p>
</div>
</a>
</div>';





function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {

    switch ($theType) {
        case "text":
            $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            break;
        case "long":
        case "int":
            $theValue = ($theValue != "") ? intval($theValue) : "NULL";
            break;
        case "double":
            $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
            break;
        case "date":
            $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            break;
        case "defined":
            $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
            break;
    }
    return $theValue;
}

function insertStepCoinInfo($forum, $username, $stepCoins) {
    // Update the stepCoins in user_barn
    $sql = "UPDATE user_barn SET stepCoins = stepCoins + :stepCoins WHERE username = :username";
    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':stepCoins', $stepCoins);
    $stmt->execute();

    // Log the step entry
    $sql = "INSERT INTO step_logs (username, steps) VALUES (:username, :steps)";
    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':steps', $stepCoins);
    return $stmt->execute();
}

/* function getStepCoinInfo($forum){
    $sql = "SELECT stepCoins from user_barn";
    $stmt = $forum->prepare($sql);
    $stmt->execute();
    return $stmt;
}     */


function updateStepCoinValue($forum, $username, $value) {
    $sql = "UPDATE user_barn SET värde = :value WHERE username = :username";
    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':value', $value, PDO::PARAM_INT);
    return $stmt->execute();
}

function getDailySteps($forum, $username){
    // Calculate steps for the last day
    $sql = "SELECT SUM(steps) AS totalSteps 
            FROM step_logs 
            WHERE username = :username 
            AND DATE(logged_at) = CURDATE()"; 

    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['totalSteps'] ?? 0;

}
function getWeeklySteps($forum, $username) {
    $sql = "SELECT SUM(steps) AS totalSteps 
            FROM step_logs 
            WHERE username = :username 
            AND logged_at >= DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)"; //calculates the most recent Monday at 00:00

    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['totalSteps'] ?? 0;
}

function getMonthlySteps($forum, $username) {
    // Calculate steps for the last 30 days
    $sql = "SELECT SUM(steps) AS totalSteps 
            FROM step_logs 
            WHERE username = :username 
            AND logged_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')"; //Givesthe furst day of the current month at 00:00, thus only entries from this month are summed 

    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['totalSteps'] ?? 0;
}

/* function insertStepCoinInfo($forum, $username, $message) {
    $sql = "insert into user_barn (username, stepCoins) values (:username, :stepCoins)";


    $stmt = $forum->prepare($sql);

    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':stepCoins', $message);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
} */
function insertForumpost($forum, $username, $message) {
    $sql = "insert into forum (username, msg) values (:username, :msg)";

   // global $forum;

    $stmt = $forum->prepare($sql);

    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':msg', $message);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


function insertForumpostBarn($forum, $username, $message) {
    $sql = "insert into forum_barn (username, msg) values (:username, :msg)";

   // global $forum;

    $stmt = $forum->prepare($sql);

    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':msg', $message);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function getForumPosts($forum) {
    $sql = "select * from forum order by tid desc";

    //global $forum;
    $stmt = $forum->prepare($sql);
    $stmt->execute();
    return $stmt;
}

function getForumPostsBarn($forum) {
    $sql = "select * from forum_barn order by tid desc";

    //global $forum;
    $stmt = $forum->prepare($sql);
    $stmt->execute();
    return $stmt;
}

function checkUsernameAndMail($forum, $info){
    $sql="SELECT * FROM user where username = :username or email = :mail";
    $stmt=$forum->prepare($sql);
    $stmt->bindValue(':username', $info['username']);
    $stmt->bindvalue(':mail', $info['email']);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        return true;
    } else{
        return false;
    }
}

function checkUsernameAndMailBarn($forum, $info){
    $sql="SELECT * FROM user_barn where username = :username";
    $stmt=$forum->prepare($sql);
    $stmt->bindValue(':username', $info['username']);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        return true;
    } else{
        return false;
    }
}


function insertNewUser($forum, $info){
    $sql= "INSERT into user (username, name, email, password)values(:username, :name, :mail, :password)";
    $stmt= $forum->prepare($sql);
    $stmt->bindValue(':username', $info['username']);
    $stmt->bindValue(':name', ucfirst($info['name']));
    $stmt->bindValue(':mail', $info['email']);
    $stmt->bindValue(':password', $info['password']);

    if($stmt->execute()){
        return true;
    } else{
        return false;
    }
}
function insertNewUserBarn($forum, $info){
    $sql= "INSERT into user_barn (username, name, email, password, parent_user)values(:username, :name, :mail, :password, :parent_user)";
    $stmt= $forum->prepare($sql);
    $stmt->bindValue(":username", $info["username"]);
    $stmt->bindValue(':name', ucfirst($info['name']));
    $stmt->bindValue(':mail', $info['email']);
    $stmt->bindValue(':password', $info['password']);
    $stmt->bindvalue(':parent_user', $info['parent_user']);

    if($stmt->execute()){
        return true;
    } else{
        return false;
    }
}

function validateUser($forum, $info){
    $sql="SELECT password FROM user where username = :username";
    $stmt=$forum->prepare($sql);
    $stmt->bindValue(':username', $info['username']);
    $stmt->execute();
    if($stmt->rowCount() == 1){
        $pass = $stmt->fetch(PDO::FETCH_ASSOC);
        if($pass['password'] == $info['password']){
        return true;
    }
    else{
        return false;
    }
    } else{
        return false;
    }
}
function validateUserBarn($forum, $info){
    $sql="SELECT password FROM user_barn where username = :username";
    $stmt=$forum->prepare($sql);
    $stmt->bindValue(':username', $info['username']);
    $stmt->execute();
    if($stmt->rowCount() == 1){
        $pass = $stmt->fetch(PDO::FETCH_ASSOC);
        if($pass['password'] == $info['password']){
        return true;
    }
    else{
        return false;
    }
    } else{
        return false;
    }
}


function updateUser($forum, $info){
    // print_r(value: $info);
    $sql= "UPDATE user SET name=:name,email=:email,password=:password WHERE username=:username";
    $stmt= $forum->prepare($sql);
    $stmt->bindValue(':username', $info['username']);
    $stmt->bindValue(':name', ucfirst($info['name']));
    $stmt->bindValue(':email', $info['email']);
    $stmt->bindValue(':password', password_hash($info['password'], PASSWORD_BCRYPT));
    if($stmt->execute()){
        return true;
    } else{
        return false;
    }
}
function getUserByUsername($forum, $username) {
    $sql = "SELECT * FROM user WHERE username = :username";
    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    
    // Hämta användaren om det finns en träff
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserByUsernameBarn($forum, $username) {
    $sql = "SELECT * FROM user_barn WHERE username = :username";
    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    
    // Hämta användaren om det finns en träff
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Funktion för att validera otillåtna karaktärer
function isValidInput($input) {
    // Tillåt endast bokstäver, siffror, bindestreck, och understreck
    return preg_match("/^[a-öA-Ö0-9-_]+$/", $input);
}

/* function checkKindOfUser($_SESSION){
    if $_SESSION["kindOfUser"] == "barn"{
        header("hem_barn.php");
} else{
    header("hem.php");
}
} */










