<?php
//Initierar sessionshantering
session_start();
//Kontrollerar om sessionsvariabel existerar
if(!isset($_SESSION['user_barn'])){
       //Raderar all information i sessionsvariabler
       session_unset();
       //Avslutar den aktuella sessionen
       session_destroy();
       //Skickar en användare till startsidan
    //Skicka användaren till startsidan
    header('Location: login_barn.php');
 
}
?>


