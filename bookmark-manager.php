<?php
session_start();
require 'includes/header.php'; // Includes Header for CSS 
require 'includes/db.php'; // Incdlues Database 
require_once 'includes/functions.php';

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

    <section class="favorites w3-container">
        <h2 class="w3-center">Favorites</h2>
        <!--            Listing Saved Favorite Bookmarks   -->

        <ul class="w3-center">
        <?php foreach ($favorites as $fav): ?>
            <li><a href="<?php echo htmlspecialchars($fav['url']); ?>" target="_blank"><?php echo htmlspecialchars($fav['title']); ?></a></li>
        <?php endforeach; ?>
        <li onclick="openAddBookmarkModal()">
            <a href="javascript:void(0)">+ Add Bookmark</a>
        </li>

        </ul>
            <!-- Modal (hidden by default) -->
        <div id="addBookmarkModal" style="display:none;" class="add-bookmark-form  w3-auto">
            <form method="POST"  action="handlers/add_bookmark.php">

                <button type="button" class="cancel-btn" onclick="closeBookmarkForm()" aria-label="Close">&#10006;</button>
                <h3 class="w3-center" style="margin-top: 0px;">Add Bookmark</h3>

                <input type="hidden" name="group_id" id="modalGroupId"> <!-- dynamic group_id -->

                <label for="title">Title:</label>
                <input type="text" name="title" id="modalTitle" required><br>
        
                
                <label for="url">URL:</label>
                <input type="text" name="url" id="modalUrl" required placeholder="https://example.com"><br>
                
                <label>
                    <input type="checkbox" name="favorite" value="1"> Add to Favorites
                </label>

                <button type="submit" class="add-btn">Add Bookmark</button>
            
            </form>
        </div>
        <?php 
        //URL Error Handling to User
        display_error('url_wrong'); 
        display_error('long_title');
        display_error('url_wrong');
        display_error('db');
        display_success();
        ?>
    </section>

    <section class="last-visited w3-container w3-center">
        <h2 class="w3-center">Last Visited</h2>
        <!-- <ul>
        <?php foreach ($favorites as $fav): ?>
            <li><a href="<?php echo htmlspecialchars($fav['url']); ?>" target="_blank"><?php echo htmlspecialchars($fav['title']); ?></a></li>
        <?php endforeach; ?>
        </ul> -->

    </section>

    <section class="Custom Groups w3-container w3-center">
        <h2 class="w3-center">Last Visited</h2>
        <!-- <ul>
        <?php foreach ($favorites as $fav): ?>
            <li><a href="<?php echo htmlspecialchars($fav['url']); ?>" target="_blank"><?php echo htmlspecialchars($fav['title']); ?></a></li>
        <?php endforeach; ?>
        </ul> -->

    </section>

</body>










</html>
