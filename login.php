<?php
require_once 'assets/config/db.php';
require_once 'assets/functions.php';
//Initierar sessionhantering
session_start();
$errors = array();

//Kontrollerar om logga in-knappen har tryckts
if (isset($_POST['submit'])){

    //Deklarerar en vektor för att spara felmeddelanden
    $errors = array();

    //Kontrollerar om fälten användarnamn och lösenord är tomma
    if (empty($_POST['username'])||
    empty($_POST['password']))
    {
        //Skapar ett felmeddelande
        $errors[] = 'Fyll i fälten för användarnamn och lösenord';
    } else{
        // Hämta data från databasen
        $user = getUserByUsername($forum, $_POST['username']);

        if ($user && password_verify($_POST['password'], $user['password'])){
            //Starta session och spara user i sessionen
            $_SESSION['username'] = $user['username'];

            // Skickar användaren till forumet
            header('Location:hem.php');
            exit;
        } else{
            //Om användarnamn eller lösenord är inkorrekt, visa felmeddelande
            $errors[] = 'Check username and password';;
        }
    }
}
?>
