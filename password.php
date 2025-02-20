<?php
//Infogar funktionalitet för inloggning
require_once 'login.php';
?>
<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <title>Formulär för inloggning</title>
        <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    //Kontrollerar om det finns felmeddelanden
    if(count($errors) > 0){
        //Skriver ut felmeddelanden
        echo'
        <ul>
        <li>'.implode('</li><li>',$errors).'</li>
        </ul>
        ';
    }
    ?>
    <form action="index.php" method="post">
        <fieldset>
            <legend>Ange inloggningsuppgifter</legend>
            <ol>
                <li>
                    <label for="username">Användarnamn</label>
                    <input name="username" type="text">
</li>
<li>
    <label for="password">Lösenord</label>
    <input name="password" type="password">
</li>
</ol>
</fieldset>
<input type="submit" name="submit" value="Log in">
</form>
<br>
<a href="signup.php">
    <button>Sign up</button>
</a>
</body>
</html>