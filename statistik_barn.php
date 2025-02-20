<?php 
require_once 'sessioncheck_barn.php';
require_once 'assets/functions.php';
require_once 'assets/config/db.php';

if (!isset($_SESSION['user_barn'])) {
    header("Location: login_barn.php");
    exit;
}


$valueInSEK = 1;
$stepCoins = 0;
$dailySteps = 0;
$weeklySteps = 0;
$monthlySteps = 0;

$childUsername = $_SESSION['user_barn'];

$dailySteps   = getDailySteps($forum, $childUsername);
$weeklySteps  = getWeeklySteps($forum, $childUsername);
$monthlySteps = getMonthlySteps($forum, $childUsername);

$sql = "SELECT stepCoins, värde FROM user_barn WHERE username = :username";
$stmt = $forum->prepare($sql);
$stmt->bindValue(':username', $childUsername, PDO::PARAM_STR);
$stmt->execute();
$childData = $stmt->fetch(PDO::FETCH_ASSOC);

$stepCoins = $childData['stepCoins'];
$valueInSEK = $childData['värde'];

?>
<HTML>
<HEAD>
<meta charset="utf 8">
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
        <p>
            Idag har du g&aring;tt <?php echo number_format( htmlspecialchars($dailySteps), 0, ',', ' ');?> steg och tj&auml;nat <?php echo number_format(round(htmlspecialchars($dailySteps/$valueInSEK)), 0, ',', ' ');?> <img src="bilder/stepCoin.png" width="40px"><br>

            Denna vecka har du g&aring;tt <?php echo number_format(htmlspecialchars($weeklySteps),0, ',', ' ');?> steg och tj&auml;nat <?php echo number_format(round(htmlspecialchars($weeklySteps/$valueInSEK)), 0, ',', ' ');?> <img src="bilder/stepCoin.png" width="40px"><br>

            Denna m&aring;nad har du g&aring;tt <?php echo number_format(htmlspecialchars($monthlySteps), 0, ',', ' ');?> steg och tj&auml;nat <?php echo number_format(round(htmlspecialchars($monthlySteps/$valueInSEK)), 0, ',', ' ');?> <img src="bilder/stepCoin.png" width="40px">

        </p>
</div>
</div><br>
<br> <br>
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