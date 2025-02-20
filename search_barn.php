<?php 
require_once 'assets/config/db.php'; 

$searchResults = [];
$searchTerm = '';
$resultsPerPage = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? max((int)$_GET['page'], 1) : 1; // Ensure page is at least 1
$start = ($page - 1) * $resultsPerPage;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = trim($_POST['searchTerm']); 
}

try {
    // Base SQL and total posts query
    $baseSql = "SELECT * FROM forum_barn";
    $countSql = "SELECT COUNT(*) FROM forum_barn";
    $params = [];

    if (!empty($searchTerm)) {
        $baseSql .= " WHERE username LIKE :searchTerm";
        $countSql .= " WHERE username LIKE :searchTerm";
        $params[':searchTerm'] = '%' . $searchTerm . '%';
    }

    // Add sorting and pagination
    $baseSql .= " ORDER BY tid DESC LIMIT :start, :limit";

    // Fetch paginated posts
    $stmt = $forum->prepare($baseSql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':start', $start, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $resultsPerPage, PDO::PARAM_INT);
    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch total post count
    $countStmt = $forum->prepare($countSql);
    foreach ($params as $key => $value) {
        $countStmt->bindValue($key, $value);
    }
    $countStmt->execute();
    $totalPosts = $countStmt->fetchColumn();

    $totalPages = ceil($totalPosts / $resultsPerPage);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Search Posts</title>
    <link href="assets/css/stepquest.css" rel="stylesheet" type="text/css">
</head>
<body class="body barn">
<?php 
require_once 'sessioncheck_barn.php';
?>

<div class="wrapper barn">

    <img src="bilder/stepquest-title.png" class="centerheaderimg">

    <div class="container">
        <a href="hem_barn.php"><img src="bilder/vuxen-stepquest-hem.png"></a>
        <a href="hantera_stepcoins_barn.php"><img src="bilder/vuxen-stepquest-hantera-stepcoins.png"></a>
        <a href="statistik_barn.php"><img src="bilder/vuxen-stepquest-statistik.png"></a>
        <a href="forum_barn.php"><img src="bilder/vuxen - stepquest-socialt.png"></a>
    </div>

    <br>

    <div class="grid-container">
        <div class="cell">

            <br>            <h2><p>S&ouml;k Resultat</p></h2>


            <!-- Search Form -->
            <form action="search_barn.php" method="post">
                <div class="centertext">
                <label for="search"><p>S&ouml;k inl&auml;gg efter anv&auml;ndarnamn:</label>
                
                <input type="text" id="search" name="searchTerm" placeholder="S&ouml;k efter andra anv&auml;ndare..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                <input type="submit" value="  S&ouml;k  "></p>
            </form>
            </div><br>
            <!-- End Search Form -->


            <?php if (!empty($searchResults)): ?>
                <table>
                    <tr>
                        <th>Anv&auml;ndarnamn</th>
                        <th>Meddelande</th>
                        <th>Datum</th>
                    </tr>
                    <?php foreach ($searchResults as $post): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($post['username']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($post['msg'])); ?></td>
                            <td><?php echo htmlspecialchars($post['tid']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <!-- Pagination Links -->
                <?php if ($totalPages > 1): ?>
                    <div class="pagination">
                        <!-- Previous Button -->
                        <?php if ($page > 1): ?>
                            <a href="search_barn.php?page=<?php echo $page - 1; ?>" class="prev">Previous</a>
                        <?php else: ?>
                            <span class="disabled">Previous</span>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="search_barn.php?page=<?php echo $i; ?>" 
                               class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                               <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <!-- Next Button -->
                        <?php if ($page < $totalPages): ?>
                            <a href="search_barn.php?page=<?php echo $page + 1; ?>" class="next">Next</a>
                        <?php else: ?>
                            <span class="disabled">Next</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p>No posts found for "<?php echo htmlspecialchars($searchTerm); ?>"</p>
            <?php endif; ?>

            <p><a href="forum_barn.php" class="a">Tillbaka till forumet</a></p>

              <!--  ⌄ Textfield ⌄  -->
  <form action="forum_barn.php" method="Post">
<table>
<tr>
                    <td>Message</td>
                    <td><label for="msg"></label>
                        <textarea class="textFiled" name="msg"  rows="8" id="msg"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="skicka" id="skicka" value="Skicka"></td>
                </tr>
            </table>
            <input type="hidden" name="MM_insert" value="nypost">
            <input type="hidden" name="username" value="<?php echo $_SESSION['user_barn']; ?>">
        </form>
    <!-- ^ Textfield ^ -->
        </div>
    </div>
    <br>
</div>
</body>
</html>
