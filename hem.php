<?php 
require_once 'sessioncheck.php';
require_once 'assets/functions.php';

if (!isset($_SESSION['username'])) {
    header("Location: login_vuxen.php");
    exit;
}

?>
<HTML>
<HEAD>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title> Hem </title>
<link href="assets/css/stepquest.css" rel ="stylesheet" type="text/css"> <!--Länk till min css-->
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Antonio" rel="stylesheet"> <!--title font-->

</HEAD>
<BODY>
<div class="wrapper">
<h1><i>STEPQUEST</i></h1>


<h2>V&auml;lkommen, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>


<!-- Side Navigation -->
<?php echo $meny?>
<br>



<?php 
/*
<!-- Menu button -->
<div class="menu" onclick="toggleMenu()">
    <div class="bar1"></div>
    <div class="bar2"></div>
    <div class="bar3"></div>
</div>

<!-- Dropdown Menu -->
<nav class="menu-items" id="menuItems">
    <a href="hem.php">FAQ</a>
    <a href="#about">About</a>
    <a href="#services">Services</a>
    <a href="#contact">Contact</a>
</nav>
<!-- ^Menu button^ -->
*/
?>
<!-- <a href="hem.php">
<div class ="grid-container">
    <div class="navigationCell">
        <p class="p hem"><b>Hem</b></p>
    </div>
    </a>

<a href="hantera_stepcoins.php">
    <div class="navigationCell">
        <p class="p hanteraStepCoins"><b>Hantera StepCoins</b></p>
    </div>
    </a>

<a href="statistik.php">
    <div class="navigationCell">
        <p class="p statistik"><b>Statistik</b></p>
</div>
</a>

<a href="forum.php">
    <div class="navigationCell">
        <p class="p socialt"><b>Socialt</b></p>
</div>
</a>
</div> -->
<?php echo $navigering;?>


<br>







<div class="grid-container">
    <div class="cell">
        <H2 class="H2 vuxen"> Om oss</H2>
        <p>
        Vi är ett passionerat team med en gemensam vision - att g&ouml;ra fysisk aktivitet till ett &auml;ventyr! P&aring; StepQuest tror vi att varje steg r&auml;knas och att &auml;ven sm&aring; r&ouml;relser kan leda till stora &auml;ventyr. Genom att kombinera spelmekanik med vardagsmotion vill vi inspirera barn och unga  att ta steget ut i en v&auml;rld d&auml;r tr&auml;ning associeras med positiva v&auml;rden som bel&ouml;ningar.<br>
        V&aring;r resa b&ouml;rjade med en enkel idé: att förena hälsan med vardagen. Idag str&auml;var vi efter att motivera barn och unga till att r&ouml;ra p&aring; sig, upt&auml;cka nya utmaningar och fira sina framsteg. Med innovativa funktioner och ett engagerande uppl&auml;gg &auml;r vi &ouml;vertygade om att varje steg inte bara st&auml;rker kroppen, utan ocks&aring; &ouml;ppnar upp en ny v&auml;rd av m&ouml;jligheter.<br>
        Tack för att du är en del av vår gemenskap - tillsammans tar vi steget mot en aktivare och roligare vardag!
        </p>
            <br><br>
            <h2 class="H2 vuxen" id="FAQ">FAQ</h2>
            <p> 
                <h3>Hur l&auml;gger jag till mitt barn?</h3> <a href="signup_barn.php" class="a">Tryck h&auml;r</a><br><br>
                <h3>Hur fungerar StepCoins?</h3>
                Varje steg ditt barn tar motsvarar en stepcoin, du kan sedan best&auml;mma hur m&aring;nga stepcoins en krona &auml;r v&auml;rt, altts&aring; hur m&aring;a steg en krona &auml;r v&auml;rd.
            </p>
        


        </div>

</div>


<br>




<?php
echo($sidfot);
?>



</div>

<script src="script.js"></script>
</BODY>
</HTML>