<?php
require_once 'assets/config/db.php';
require_once 'assets/functions.php';

$error=false;

if(isset($_POST['submit'])){
        // Check if username or email is already taken
    if(checkUsernameAndMail($forum, $_POST)){
        $error=true;
        echo'The username or E-mail you\'ve entered is taken';
    } else{
    // Kontrollera om användarnamnet innehåller otillåtna karaktärer
    if (!isValidInput($_POST['username'])) {
        $error = true;
        echo 'The username contains invalid characters or is to long. Please use only letters, numbers, dashes, underscores and keep the username less than 15 characters.';
        
    } elseif (!isValidInput($_POST['name'])) {
        $error = true;
        echo 'The name contains invalid characters. Please use only letters';

    } else {
        //Hasha lösenordet och skapa användare
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);


    if(insertNewUser($forum,$_POST)){
        echo 'User created succesfully';
        session_start();        
        $_SESSION['username']=$_POST['username'];
        $_SESSION['password']=$_POST['password'];
        header("location:hem.php");
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>Signup</title>
        <link href="assets/css/stepquest.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Antonio" rel="stylesheet"> <!--title font-->

        
    </head>

    <body>
    <div class="stepquest-container">
    <div class="indexcell">

        <h1><i>Registrera dig</i></h1>
        <?php
        if($error){
            echo"The username and/or email is taken!";
        }
        ?>
        <form action="signup.php" method="post">
  <fieldset>
    <legend><p><div class="indexColor">Sign up:</div></p></legend>
    <ol>
        <li>
        <label for="username"><div class="indexColor">Anv&auml;ndarnamn:</label>
        <input type="text" id="username" name="username" placeholder="John_Doe"><br><br>
        </li>
        <li>
        <label for="lname"><div class="indexColor">Namn:</label>
        <input type="text" id="name" name="name" placeholder="John"><br><br>
        </li>
        <li>
        <label for="email"><div class="indexColor">E-mail:</label>
        <input type="text" id="email" name="email" placeholder="Ex. john.doe@gmail.com"><br><br>
        </li>
        <li>
        <label for="password"><div class="indexColor">L&ouml;senord:</label>
        <input type="password" id="password" name="password" placeholder="L&ouml;senord"><br><br>
        </li>
    </ol>


    <input type="submit" value="Skicka" name="submit">
  </fieldset>
</form> 
<div class="centertext">
<p class="indexColor">Har du redan ett konto?  <br>
    <a href="login_vuxen.php">Logga in</a> </p>    
    </div>
</div>
    </div>
    </div>
    </div>
</div>
</div>
    </body>
    </html>