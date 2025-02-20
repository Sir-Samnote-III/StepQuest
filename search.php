<?php 
require_once 'assets/config/db.php'; 
require_once 'assets/functions.php';
require_once 'sessioncheck.php';


$searchResults = [];
$searchTerm = '';
$resultsPerPage = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $resultsPerPage;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = trim($_POST['searchTerm']); 
}

try {
    if (!empty($searchTerm)) {
        // Search by username if a term is provided
        $sql = "SELECT * FROM forum WHERE username LIKE :searchTerm ORDER BY tid DESC LIMIT :start, :limit";
        $stmt = $forum->prepare($sql);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
    } else {
        // Fetch all posts if no search term is provided
        $sql = "SELECT * FROM forum ORDER BY tid DESC LIMIT :start, :limit";
        $stmt = $forum->prepare($sql);
    }

// Bind pagination values
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $resultsPerPage, PDO::PARAM_INT);
$stmt->execute();
$searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Pagination variables
$postsPerPage = 5; // Number of posts per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
if ($page < 1) $page = 1;
$offset = ($page - 1) * $postsPerPage;

// Fetch total number of posts
$totalPosts = $forum->query("SELECT COUNT(*) FROM forum")->fetchColumn();
$totalPages = ceil($totalPosts / $postsPerPage); // Total pages

// Fetch paginated posts
$sql = "SELECT * FROM forum ORDER BY tid DESC LIMIT :limit OFFSET :offset";
$stmt = $forum->prepare($sql);
$stmt->bindValue(':limit', $postsPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$forumPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count total posts for pagination
    if (!empty($searchTerm)) {
        $totalPostsQuery = $forum->prepare("SELECT COUNT(*) FROM forum WHERE username LIKE :searchTerm");
        $totalPostsQuery->bindValue(':searchTerm', '%' . $searchTerm . '%');
    } else {
        $totalPostsQuery = $forum->prepare("SELECT COUNT(*) FROM forum");
    }
    $totalPostsQuery->execute();
    $totalPosts = $totalPostsQuery->fetchColumn();
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
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet"> <!--Font-->
    <link href="https://fonts.googleapis.com/css?family=Antonio" rel="stylesheet"> <!--Title font-->
</head>
<body>


<div class="wrapper">

<h1><i>STEPQUEST</i></h1>
<!-- <img src="bilder/stepquest-title.png" class="centerheaderimg">
 -->

<?php echo $meny;
      echo $navigering;?>

<br>


<div class="grid-container">
    <div class="cell">
        
<br>
<h2><p>S&ouml;kresultat</p></h2>
<div class="center">

<!-- Sökruta -->
<form action="search.php" method="post">
    <label for="search"><p>S&ouml;k inl&auml;gg efter anv&auml;ndarnamn:</label>
    <input type="text" id="search" name="searchTerm" placeholder="S&ouml;k efter andra anv&auml;ndare..." value="<?php echo htmlspecialchars($searchTerm); ?>">
    <input type="submit" value="   S&ouml;k   "></p>
</form>
</div>
<!-- ^Sökruta^ -->



<?php if (!empty($searchResults)): ?>
    <table>
        <tr>
            <th>Username</th>
            <th>Message</th>
            <th>Date</th>
        </tr>
        <?php foreach ($searchResults as $post): ?>
            <tr>
                <td><?php echo htmlspecialchars($post['username']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($post['msg'])); ?></td>
                <td><?php echo htmlspecialchars($post['tid']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <!-- Previous Button -->
            <?php if ($page > 1): ?>
                <a href="search.php?page=<?php echo $page - 1; ?>" class="prev">Previous</a>
            <?php else: ?>
                <span class="disabled">F&ouml;reg&aring;ende</span>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="search.php?page=<?php echo $i; ?>" 
                   class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                   <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <!-- Next Button -->
            <?php if ($page < $totalPages): ?>
                <a href="search.php?page=<?php echo $page + 1; ?>" class="next">N&auml;sta</a>
            <?php else: ?>
                <span class="disabled">Next</span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <p>No posts to display.</p>
<?php endif; ?>




<p><a href="forum.php" class="a">Tillbaka till forumet</a></p>

  <!--  ⌄ Textfield ⌄  -->
  <form action="forum.php" method="Post">
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
            <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
        </form>
    <!-- ^ Textfield ^ -->

        </p></div>

        
</div>
<br>
</div>
</div>
<br>
</div>
<script src="script.js"></script>
</body>
</html>
