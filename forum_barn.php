<?php
require_once 'assets/config/db.php'; 
require_once 'assets/functions.php';
require_once 'sessioncheck_barn.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_barn'])) {
    header("Location: login_barn.php");
}

// If a post is submitted, insert it into the database
if (isset($_POST['skicka']) && !empty(trim($_POST['msg']))) {
    $username = $_SESSION['user_barn'];
    $message = trim($_POST['msg']); // Sanitize the input

    if (insertForumpostBarn($forum, $username, $message)) {
        echo "";
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
$totalPosts = $forum->query("SELECT COUNT(*) FROM forum_barn")->fetchColumn();
$totalPages = ceil($totalPosts / $postsPerPage); // Total pages

// Fetch paginated posts
$sql = "SELECT * FROM forum_barn ORDER BY tid DESC LIMIT :limit OFFSET :offset";
$stmt = $forum->prepare($sql);
$stmt->bindValue(':limit', $postsPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$forumPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Forum</title>
    <link href="assets/css/stepquest.css" rel="stylesheet" type="text/css">
</head>
<body class="body barn">

<!-- Search form link -->


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
<br>
Have new information? Update user <a href="updateUser.php" class="a">here</a>.
<br>
<a href="logout_barn.php" class="a">Log out</a>?<br>
</p>

   

<h2><p>Forum Inl&auml;gg</p></h2>
<!-- Sökruta -->
<div class="center">

<form action="search_barn.php" method="post">
    <label for="search"><p>S&ouml;k inl&auml;gg efter anv&auml;ndarnamn:</label>
    <input type="text" id="search" name="searchTerm" placeholder="Sök efter andra användare..." value="<?php echo htmlspecialchars($searchTerm); ?>">
    <input type="submit" value="  S&ouml;k  ">
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
                <a href="forum_barn.php?page=<?php echo $page - 1; ?>" class="prev">Previous</a>
            <?php else: ?>
                <span class="disabled">Previous</span>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="forum_barn.php?page=<?php echo $i; ?>" 
                   class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                   <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <!-- Next Button -->
            <?php if ($page < $totalPages): ?>
                <a href="forum_barn.php?page=<?php echo $page + 1; ?>" class="next">Next</a>
            <?php else: ?>
                <span class="disabled">Next</span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    */?>

<?php else: ?>
    <p>No posts to display.</p>
<?php endif; ?><p>Vill du se fler inl&auml;gg? <a href="search_barn.php" class="a">Tryck h&auml;r</a>.

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

        </p></div>
        
       
</div><br>

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

