<?php 
//Initierar sessionshantering
session_start();
//Raderar all information i sessionsvariabler
session_unset();
//Avslutar den aktuella sessionen
session_destroy();
//Skickar en användare till startsidan
header('Location: login_barn.php');
//Utloggning sker när en användare navigerar till denna fil via länken <a href="logout.php">Logga ut</a>
?> 