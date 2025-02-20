<?php 
require_once 'sessioncheck_barn.php';
require_once 'assets/functions.php';

if (!isset($_SESSION['user_barn'])) {
    header("Location: login_barn.php");
    exit;
}

?>
<HTML>
<HEAD>
<meta charset="utf-8">
<title> Stepquest </title>
<link href="assets/css/stepquest.css" rel ="stylesheet" type="text/css"> <!--Länk till min css-->
</HEAD>
<BODY class="body barn">
<div class="wrapper barn">

<img src="bilder/stepquest-title.png" class="centerheaderimg">
<h2>V&auml;lkommen, <?php echo htmlspecialchars($_SESSION['user_barn']); ?>!</h2>

<div class="container"></a>
<a href="hem_barn.php"><img src="bilder/vuxen-stepquest-hem.png"></a>
<a href="hantera_stepcoins_barn.php"><img src="bilder/vuxen-stepquest-hantera-stepcoins.png"></a>
<a href="statistik_barn.php"><img src="bilder/vuxen-stepquest-statistik.png"></a>
<a href="forum_barn.php"><img src="bilder/vuxen - stepquest-socialt.png"></a>
</div>





<br>





<div class="grid-container">
    <div class="cell">
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p></div>

</div>


<br><br>




<!-- <div class="sidfot">
<p>
    Du kan kontakta mig p&aring; min <a target="blank" href="https://mail.google.com/mail" class="a barn">E-mail</a> eller tel nr (076 555 21 17).<br>
    Senast uppdaterad 11/11-2024<br>
    Skapad av Antonios Danho
</p>
</div> -->

<?php echo $sidfot_barn; ?>

</div>
</BODY>
</HTML>