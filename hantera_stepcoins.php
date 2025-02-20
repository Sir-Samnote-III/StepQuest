<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'sessioncheck.php';
require_once 'assets/config/db.php';
require_once 'assets/functions.php';

if (!isset($_SESSION['username'])) {
    header("Location: login_vuxen.php"); // Redirect to login if not logged in
    exit;
}

$children = []; // Initialize an empty array for children

try {
    $sql = "SELECT username, name, värde FROM user_barn WHERE parent_user = :parent_user";
    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':parent_user', $_SESSION['username'], PDO::PARAM_STR);
    $stmt->execute();
    $children = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all children
} catch (PDOException $e) {
    echo "Error fetching children: " . $e->getMessage();
}

// If the form is submitted, process the data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['child'])) && !empty(trim($_POST['steg'])) && !empty(trim($_POST['stepCoinValue']))) {
    // Retrieve form data
    $child = trim($_POST['child']);
    $stepCoins = intval($_POST['steg']);
    $stepCoinValue = intval(trim($_POST['stepCoinValue']));

    // Update StepCoin value (värde) in the database
    $valueUpdated = updateStepCoinValue($forum, $child, $stepCoinValue);
    
    // Add StepCoins (existing functionality)
    $coinsAdded = insertStepCoinInfo($forum, $child, $stepCoins);

    if ($valueUpdated && $coinsAdded) {
        echo "";//"StepCoins and StepCoin value (SEK) have been updated for {$child}.";
    } else {
        echo "";//"Failed to update. Please try again.";
    }
} else {
    echo "";//"Please fill in all fields correctly.";
}
?>

<HTML>
<HEAD>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title> Hantera StepCoins </title>
<link href="assets/css/stepquest.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Antonio" rel="stylesheet"><!--Title font-->

</HEAD>
<BODY>
<div class="wrapper">
<h1><i>STEPQUEST</i></h1>
<?php  echo $meny;
/*  <!-- Menu button -->
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
    */
?>
    <h2>V&auml;lkommen, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

<?php echo $navigering;?>

    <br>
    <div class="grid-container">
        <div class="cell">
            <form action="hantera_stepcoins.php" method="POST">
                <label for="children"></label>
                <select name="child" id="child">
                    <option value="" disabled selected>Välj ett barn</option>
                    <?php foreach ($children as $child): ?>
                        <option value="<?php echo htmlspecialchars($child['username']); ?>" data-value="<?php echo htmlspecialchars($child['värde']); ?>">
                            <?php echo htmlspecialchars($child['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br><br>

                <label for="stepCoin">Bestäm StepCoins värde:</label>
                <div class="stepcoin-input-wrapper">
                    <span class="stepcoin-prefix">StepCoins/kr</span>
                    <input type="text" id="stepCoin" name="stepCoinValue" placeholder=" Ex. 1000"  pattern="\d+" title="Please enter a valid number">
                </div>
                <br><br>

                <div class="form-row">
                    <label for="steg" id="stegLabel">Ange antalet steg X har tagit:</label>
                    <input type="text" id="steg" name="steg" placeholder=" Ex. 10 000" pattern="\d+" title="Please enter a valid number">
                </div>
                <br>

                <input type="submit" value="Skicka">
            </form>
        </div>
    </div>
    <br>

    <?php echo $sidfot; ?>
</div>
<script src="script.js"></script>
</BODY>
</HTML>

<script>
document.getElementById('child').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const stepCoinValue = selectedOption.getAttribute('data-value');
    const childName = selectedOption.text;

    document.getElementById('stepCoin').value = stepCoinValue || '';
    document.getElementById('stegLabel').innerHTML = `Ange antalet steg ${childName} har tagit:`;
}); 
src="script.js"

</script>