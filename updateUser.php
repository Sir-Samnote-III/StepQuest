<?php
require_once 'assets/config/db.php';
require_once 'assets/functions.php';
require_once 'sessioncheck.php';


if (isset($_POST['submit'])) {
    // print_r($_POST);
if(updateUser($forum,$_POST)){
    print_r($_POST);
    session_start();
    $_SESSION['password']=$_POST['password'];
    header("location:hem.php");
  }
}
if (!isset($_SESSION['username'])) {
    header("Location: login_vuxen.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>Update User</title>
        <link href="assets/css/stepquest.css" rel="stylesheet" type="text/css"> <!--Länk till CSS-->
    </head>
    <body>

  <!-- Fixed container for the menu -->

    <div>
    <div class="wrapper">
    <div class="stepquest-container">
    <div class="indexcell">

            <h1>Uppdatera profil</h1>
 

<?php   

            if($error){
            echo"The username and/or email is taken!";
        }
        ?>
        <form action="updateUser.php" method="post">
            <fieldset>
                <legend><p><div class="indexColor">Uppdatera information</div></p></legend>
                <ol>
                    <li>
                        <label for="username"><div class="indexColor">Anv&auml;ndarnamn: </label>
                        <input type="text" id="username" name="username"><br><br>
                    </li>
                    <li>
                        <label for="lname"><div class="indexColor">Namn: </label>
                        <input type="text" id="name" name="name"> <br><br>
                    </li>
                    <li>
                        <label for="email"><div class="indexColor">E-mail: </label>
                        <input type="email" id="email" name="name"><br><br>
                    </li>
                    <li>
                        <label for="password"><div class="indexColor">L&ouml;senord: </label>
                        <input type="password" id="password" name="password"><br><br>
                    </li>
                </ol>
                <input type="submit" value="Skicka" name="submit">
            </fieldset>
            Tillbaka till <a href="hem.php">hemsidan</a>.

        </form>

        </div>
        </div>
        <br>    <?php echo $sidfot;?>
        </div>
        </div>

 


    

  
    <script src="script.js"></script>

    </body>
</html>