<?php
require_once 'sessioncheck.php';
require_once 'assets/config/db.php';
require_once 'assets/functions.php';


error_reporting(E_ALL); // Report all PHP errors
ini_set('display_errors', 1); // Display errors in the browser 

if (!isset($_SESSION['username'])) {
    header("Location: login_vuxen.php"); // Redirect to login if not logged in
    exit;
}




$children = []; // Initialize an empty array for children
$selectedChild = null;
$valueInSEK = 1;
$stepCoins = 0;
$dailySteps = 0;
$weeklySteps = 0;
$monthlySteps = 0;

try {
    // Fetch all children for the dropdown
    $sql = "SELECT username, name, värde FROM user_barn WHERE parent_user = :parent_user";
    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':parent_user', $_SESSION['username'], PDO::PARAM_STR);
    $stmt->execute();
    $children = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all children

    // Handle form submission to fetch selected child's data
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['child'])) {
        $selectedChildUsername = $_POST['child'];

        $sql = "SELECT stepCoins, värde FROM user_barn WHERE username = :username";
        $stmt = $forum->prepare($sql);
        $stmt->bindValue(':username', $selectedChildUsername, PDO::PARAM_STR);
        $stmt->execute();
        $selectedChild = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($selectedChild) {
            $stepCoins = $selectedChild['stepCoins'];
            $valueInSEK = $selectedChild['värde'];
            $dailySteps = getDailySteps($forum, $selectedChildUsername);//Fetch daily steps
            $weeklySteps = getWeeklySteps($forum, $selectedChildUsername); // Fetch weekly steps
            $monthlySteps = getMonthlySteps($forum, $selectedChildUsername);//  Fetch monthly steps
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<HTML>
<HEAD>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Statistik</title>
    <link href="assets/css/stepquest.css" rel="stylesheet" type="text/css"><!--Länk till css-->
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet"> <!-- Font-->
    <link href="https://fonts.googleapis.com/css?family=Antonio" rel="stylesheet"><!--Title font-->
    
</HEAD>
<BODY>
<div class="wrapper">
<h1><i>STEPQUEST</i></h1>

    <?php echo $meny;
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
    <h2>V&auml;lkommen, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

<?php echo $navigering;?>
    <br>

    <div class="grid-container2">
        <div class="cell">
         

            <table>
                <tr>
                    <td>   <form action="statistik.php" method="POST">
                <label for="children"></label>
                <select name="child" id="child">
                    <option value="" disabled selected>Välj ett barn</option>
                    <?php foreach ($children as $child): ?>
                        <option value="<?php echo htmlspecialchars($child['username']); ?>">
                            <?php echo htmlspecialchars($child['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" name="submit" value="Visa statistik">
            </form></td>
                    <td>Steg</td>
                    <td>Inkomst</td>
                </tr>
                <tr>
                    <td>Idag:</td>
                    <td><?php echo number_format(htmlspecialchars($dailySteps), 0, ',', ' ');?></td>
                    <td><?php echo number_format(round(htmlspecialchars($dailySteps/$valueInSEK)), 0, ',', ' ');?> Kr</td>
                </tr>
                <tr>
                    <td>Denna vecka:</td>
                    <td><?php echo number_format(htmlspecialchars($weeklySteps), 0, ',', ' ');?></td>
                    <td><?php echo number_format(round(htmlspecialchars($weeklySteps/$valueInSEK)), 0, ',', ' ');?> kr</td>
                </tr>
                <tr>
                    <td>Denna M&aring;nad:</td>
                    <td><?php echo number_format(htmlspecialchars($monthlySteps), 0, ',', ' ');?></td>
                    <td><?php echo number_format(round(htmlspecialchars($monthlySteps/$valueInSEK)), 0, ',', ' ');?> Kr</td>
                </tr>
                <tr>
                    <td>N&aring;gonsin (temp):</td>
                    <td><?php echo number_format(htmlspecialchars($stepCoins), 0, ',', ' '); ?></td>
                    <td><?php echo number_format(round(htmlspecialchars($stepCoins/$valueInSEK)), 0, ',', ' '); ?> Kr</td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <?php echo $sidfot; ?>
</div>
<?php
?>
<script src="script.js"></script>

</BODY>
</HTML>