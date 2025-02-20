<?php
require_once 'assets/config/db.php';
require_once 'assets/functions.php';

$error=false;

if(isset($_POST['submit'])){
    if(checkUsernameAndMail($forum, $_POST)){
        $error=true;
        echo'The username or E-mail you\'ve entered is taken';
    }
else{
    // Kontrollera om användarnamnet innehåller otillåtna karaktärer
    if (!isValidInput($_POST['username'])) {
        $error = true;
        echo 'The username contains invalid characters. Please use only letters, numbers, dashes, and underscores.';
    } elseif (!isValidInput($_POST['name'])) {
        $error = true;
        echo 'The name contains invalid characters. Please use only letters, numbers, dashes, and underscores.';
    } else {
        //Hasha lösenordet och skapa användare
    $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
    if(insertNewUser($forum,$_POST)){
        echo 'User created succesfully';
        session_start();
        
        $_SESSION['username']=$_POST['username'];
        $_SESSION['password']=$_POST['password'];
        Echo 'Signed in succesfully';
        // header("location:forum.php");
        exit;
    }
}
}
}


?>
<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <title>Forum test</title>
        <link href="css/forum.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <?php
        if($error){
            echo"<h1>The username and/or email is taken";
        }
        ?>
        <h1>Sign up</h1>
        <form action="signup.php" method="post">
  <fieldset>
    <legend>Sign up:</legend>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username"><br><br>
    <label for="lname">Name:</label>
    <input type="text" id="name" name="name"><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email"><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>
    <input type="submit" value="Submit" name="submit">
  </fieldset>
</form> 
<p>Already have an account? <a href="index.php">Log in</a>. </p>    

    </body>
    </html>