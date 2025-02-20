<?php 
require_once 'login.php';
?>

<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>Forum</title>
        <link href="assets/css/stepquest.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Antonio" rel="stylesheet"><!--Title font-->

    </head>

    <body>

<p></p>
<br>

<div class="stepquest-container">
    <div class="indexcell">
        <p>        <h1><i>Logga in</i></h1>
        <?php
        if(count($errors) > 0){
        //Skriver ut felmeddelanden
        echo'
        <ul>
        <li>'.implode('</li><li>',$errors).'</li>
        </ul>';
    }
    ?>
    <form action="login_vuxen.php" method="post">
        <fieldset>
            <legend><p><div class="indexColor">Ange inloggningsuppgifter</div></p></legend>
            <ol>
                <li>
                    <label for="username"><div class="indexColor">Anv&auml;ndarnamn:</label>
                    <input name="username" type="text" placeholder=" Anv&auml;ndarnamn"></div>
                </li>
                <li>
                    <label for="password"><div class="indexColor" >L&ouml;senord:  </label>
                    <input name="password" type="password" placeholder=" L&ouml;senord"></div>
                </li>
            </ol>
            <input type="submit" name="submit" value="Skicka">
        </fieldset>

</form>
<div class="centertext">
<p><div class="indexColor">Har du inget konto? </div><a href="signup.php">Skapa konto</a></p> </p></div>

</div>
</div>


<br><br>







</div>
</BODY>
</HTML>









