<?php
require_once 'assets/config/db.php'; 
require_once 'assets/functions.php';
require_once 'sessioncheck.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_vuxen.php");
    exit;
}

// If a post is submitted, insert it into the database 
if (isset($_POST['skicka']) && !empty(trim($_POST['msg']))) {
    $username = $_SESSION['username'];
    $message = trim($_POST['msg']); // Sanitize the input

    if (insertForumpost($forum, $username, $message)) {
        echo "Post submitted successfully!";
    } else {
        echo "Failed to submit the post.";
    }
}

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


$searchTerm = ""; // Initialize the variable with an empty string
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Socialt</title>
    <link href="assets/css/stepquest.css" rel="stylesheet" type="text/css"><!--Länk till css-->
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet"> <!--Font-->
    <link href="https://fonts.googleapis.com/css?family=Antonio" rel="stylesheet"> <!--Title font-->

</head>
<body>



<div class="wrapper">

<!-- Search form link -->


<h1><i>STEPQUEST</i></h1>
<!-- <img src="bilder/stepquest-title.png" class="centerheaderimg">
 -->

<?php echo $meny;?>
<!-- Menu button -->
<!-- <div class="menu" onclick="toggleMenu()">
    <div class="bar1"></div>
    <div class="bar2"></div>
    <div class="bar3"></div>
</div>

<nav class="menu-items" id="menuItems">
    <a href="hem.php">Home</a>
    <a href="#about">About</a>
    <a href="#services">Services</a>
    <a href="#sidfot">Contact</a>

    <div class="dropdown">
    <button class="dropbtn" id="faqButton">FAQ ↓</button>
    <div class="dropdown-content" id="faqContent">
        <a href="#">How to use?</a>
        <a href="#">Where to find support?</a>
        <a href="hem.php">How do I add a child?</a>
        <a href="#">More...</a>
    </div>
</div>
</nav> -->
<!-- ^Menu button^ -->

<h2>V&auml;lkommen, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

<?php echo $navigering;?>


<br>
<!-- Länkar -->
<div class="grid-container">
    <div class="cell">

   

<h2><p>Forum Posts</p></h2>
<!-- Sökruta -->
<div class="center">

<form action="search.php" method="post">
    <label for="search"><p>S&ouml;k inl&auml;gg efter anv&auml;ndarnamn:</label>
    <input type="text" id="search" name="searchTerm" placeholder="Sök efter andra användare..." value="<?php echo htmlspecialchars($searchTerm); ?>">
</p>
</form> </div>
<!-- ^Sökruta^ -->


<?php if ($forumPosts): ?>
    <table>
        <tr>
            <th>Username</th>
            <th>Message</th>
            <th>Date</th>
        </tr>
        <?php foreach ($forumPosts as $post): ?>
            <tr>
                <td><?php echo htmlspecialchars($post['username']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($post['msg'])); ?></td>
                <td><?php echo htmlspecialchars($post['tid']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php
/*
    <!-- Pagination Links -->
    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <!-- Previous Button -->
            <?php if ($page > 1): ?>
                <a href="forum.php?page=<?php echo $page - 1; ?>" class="prev">Previous</a>
            <?php else: ?>
                <span class="disabled">Previous</span>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="forum.php?page=<?php echo $i; ?>" 
                   class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                   <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <!-- Next Button -->
            <?php if ($page < $totalPages): ?>
                <a href="forum.php?page=<?php echo $page + 1; ?>" class="next">Next</a>
            <?php else: ?>
                <span class="disabled">Next</span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    */
    ?>
<?php else: ?>
    <p>No posts to display.</p>
<?php endif; ?>






 
<p>Vill du se fler inl&auml;gg? <a href="search.php" class="a">Tryck H&auml;r</a>

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
        
       
</div><br  id="sidfot">
<?php
echo($sidfot);
?>

</div>
<script src="script.js"></script>

</BODY>
</HTML>
