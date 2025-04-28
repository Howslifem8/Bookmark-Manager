<?php
session_start();
include 'includes/header.php'; // Includes Header for CSS 
require 'includes/db.php'; // Incdlues Database 
// Check if user logged in -- If not, redirect to index.php 
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

?> 

<!-- GRABBING REQUIRED DATA (Favorites Section)  -->
<?php 
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT title, url FROM bookmarks WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $result = $stmt->fetchAll(); // PDO fetches all at once
    
    // Creating array for favorites
    $favorites = $result; // No need for a while loop with fetch_assoc
    
?> 



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dynamic Bookmarks</title>
</head>
<body>

    <header> 
        <h1 class="w3-container w3-center">Dynamic Bookmarks</h1>
    </header>

    <section class="favorites w3-container w3-center">
        <h2 class="w3-center">Favorites</h2>
        <ul>
        <?php foreach ($favorites as $fav): ?>
            <li><a href="<?php echo htmlspecialchars($fav['url']); ?>" target="_blank"><?php echo htmlspecialchars($fav['title']); ?></a></li>
        <?php endforeach; ?>
        </ul>

    </section>



</body>
</html>
