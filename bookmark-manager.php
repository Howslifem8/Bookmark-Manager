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
    //User Identity 
    $user_id = $_SESSION['user_id'];

    // Creating favorites Array
    $stmt = $pdo->prepare("SELECT title, url FROM bookmarks WHERE user_id = ? AND favorite = 1");
    $stmt->execute([$user_id]);
    $result = $stmt->fetchAll();
    
    
    $favorites = $result;
    
    // Creating Groups Array 
    $stmt = $pdo->prepare("SELECT group_id, group_title FROM groups WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $result = $stmt->fetchAll();

    $groups = $result; 

    //Creating an array to group bookmarks with respective group_id 
    $stmt = $pdo->prepare("SELECT bookmark_id, title, url, group_id FROM bookmarks WHERE user_id = ? AND group_id IS NOT NULL");
    $stmt->execute([$user_id]);
    $groupedBookmarks = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

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
            <!-- Form (hidden by default) -->
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
        <h2 class="w3-center">Custom Groups</h2>
        
  



        <?php foreach ($groups as $grp): ?>
            <div class="w3-card card-padding">
            <h2 class="grp_title"><?php echo htmlspecialchars($grp['group_title']); ?> </h2>

            <!-- Copy of favorite bookmarks -->
            <ul class="w3-center">
            <?php foreach ($favorites as $fav): ?>
                <li><a href="<?php echo htmlspecialchars($fav['url']); ?>" target="_blank"><?php echo htmlspecialchars($fav['title']); ?></a></li>
            <?php endforeach; ?>

            <li onclick="openAddBookmarkModal(<?php echo $grp['group_id']; ?>)">
                <a href="javascript:void(0)">+ Add Bookmark</a>
            </li>
            </ul>

            
            </div>
        <?php endforeach; ?>
        

        <div class="w3-card w3-btn">
                <h2 onclick="openAddGroupForm()">Add Group</h2>
        </div>
        <div id="addGroupForm" style="display:none;" class="add-bookmark-form  w3-auto">
            <form class="w3-card w3-auto" method="POST"  action="handlers/add_group.php">
                <button type="button" class="cancel-btn" onclick="closeGroupForm" aria-label="Close">&#10006;</button>
                <h3 class="w3-center" style="margin-top: 0px;">Add Custom Group</h3>

                <input type="hidden" name="group_id" id="modalGroupId"> <!-- dynamic group_id -->

                <label for="title">Title:</label>
                <input type="text" name="group_title" id="modalTitle" required><br>

                <button type="submit" class="add-btn" style="margin-top: 1rem;">Add Group</button>
                <?php
                display_success();
                ?>

            </form>
        </div>
    </section>


</body>










</html>
