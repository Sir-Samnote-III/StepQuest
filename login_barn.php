<?php 
require_once 'login2.php';
?>

<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <title>Forum</title>
        <link href="assets/css/stepquest.css" rel="stylesheet" type="text/css">
    </head>

    <body class="body barn">

<p></p>
<br>

<div class="stepquest-container">
    <div class="indexcell">
        <p>        <h1>Login</h1>
        <?php
        if(count($errors) > 0){
        //Skriver ut felmeddelanden
        echo'
        <ul>
        <li>'.implode('</li><li>',$errors).'</li>
        </ul>';
    }
    ?>
    <form action="login_barn.php" method="post">
        <fieldset>
            <legend><p><div class="indexColor">Ange inloggningsuppgifter</div></p></legend>
            <ol>
                <li>
                    <label for="username"><div class="indexColor">Username:</label>
                    <input name="username" type="text" placeholder=" Username"></div>
                </li>
                <li>
                    <label for="password"><div class="indexColor" >Password:  </label>
                    <input name="password" type="password" placeholder=" Password"></div>
                </li>
            </ol>
        </fieldset>
<input type="submit" name="submit" value="Submit">
</form>

</div>


<br><br>







</div>
</BODY>
</HTML>









