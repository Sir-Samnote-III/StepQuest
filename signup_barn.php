<?php
require_once 'assets/config/db.php';
require_once 'assets/functions.php';
require_once 'sessioncheck.php';

$error=false;

if(isset($_POST['submit'])){
    if(checkUsernameAndMailBarn($forum, $_POST)){
        $error=true;
        echo'The username or E-mail you\'ve entered is taken';
    }
else{
    // Kontrollera om användarnamnet innehåller otillåtna karaktärer
    if (!isValidInput($_POST['username'])) {
        $error = true;
        echo 'The username contains invalid characters or is to long. Please use only letters, numbers, dashes, underscores and keep the username less than 15 characters.';
    } elseif (!isValidInput($_POST['name'])) {
        $error = true;
        echo 'The name contains invalid characters. Please use only letters, numbers, dashes, and underscores.';
    } else {
        //Hasha lösenordet och skapa användare
    $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
    if(insertNewUserBarn($forum,$_POST)){
        echo 'User created succesfully';
     /*    session_start(); */
        
/*         $_SESSION['username']=$_POST['username'];
        $_SESSION['password']=$_POST['password']; */
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

        <title>Forum test</title>
        <link href="assets/css/stepquest.css" rel="stylesheet" type="text/css">
    </head>

    <body class="body barn">
    <div class="stepquest-container">
    <div class="indexcell">

        <h1>Sign up</h1>
        <?php
        if($error){
            echo"The username and/or email is taken!";
        }
        ?>
        <form action="signup_barn.php" method="post">
  <fieldset>
    <legend><p><div class="indexColor">Registrera ditt barn:</div></p></legend>
    <ol>
        <li>
        <label for="username"><div class="indexColor">Anv&auml;ndarnamn:</label>
        <input type="text" id="username" name="username"><br>
        </li>
        <li>
        <label for="lname"><div class="indexColor" >Namn:</label>
        <input type="text" id="name" name="name" ><br>
        </li>

        <li>
        <label for="password"><div class="indexColor">L&ouml;senord:</label>
        <input type="password" id="password" name="password">

        <li>
        <input type="hidden" name="email" id="mail" value="<?php echo $_SESSION['email'] ?>">
        </li>

        <input type="hidden" name="parent_user" value="<?php echo $_SESSION['username'];?>">
        </li>
    </ol>


    <input type="submit" value="Skicka" name="submit">
  </fieldset>
</form> 
    Tillbaka till <a href="hem.php" class=>hemsidan</a>.  
  

</div>
    </div>
    </div>
    </div>
</div>
</div>
    </body>
    </html>