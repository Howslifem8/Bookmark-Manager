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
    $stmt = $pdo->prepare("SELECT title, url, bookmark_id FROM bookmarks WHERE user_id = ? AND favorite = 1");
    $stmt->execute([$user_id]);
    $result = $stmt->fetchAll();
    
    
    $favorites = $result;
    
    // Creating Groups Array 
    $stmt = $pdo->prepare("SELECT group_id, group_title FROM groups WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $result = $stmt->fetchAll();

    $groups = $result; 

    //Creating an array to group bookmarks with respective group_id 
    $stmt = $pdo->prepare("
    SELECT bookmark_id, title, url, group_id
    FROM bookmarks
    WHERE user_id = ? AND group_id IS NOT NULL
    ");
    $stmt->execute([$user_id]);

    $groupedBookmarks = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $groupedBookmarks[$row['group_id']][] = $row;
    }


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
    <hr>
    <section class="favorites w3-container">
        <div class="w3-card card-padding group-section" data-group-id="favorites">
            <div class="group-header w3-center">
                <h2 class="group-title ">Favorites</h2>
                <button class="add-btn" onclick="editSection(null, this)" data-editing="false">EDIT</button>
            </div>

            <ul id="FavoriteSection" class="w3-center">
                <?php foreach ($favorites as $fav): ?>
                    <li class="bookmark-item">
                        <button 
                            class="edit-pencil" 
                            style="display: none;" 
                            onclick="openEditModal('favorite', <?= $fav['bookmark_id'] ?>, this)" 
                            data-title="<?= htmlspecialchars($fav['title']) ?>" 
                            data-url="<?= htmlspecialchars($fav['url']) ?>"
                        >✏️</button>

                        <a href="<?= htmlspecialchars($fav['url']) ?>" target="_blank">
                            <?= htmlspecialchars($fav['title']) ?>
                        </a>
                        
                    </li>
                <?php endforeach; ?>

                <li>
                    <a href="javascript:void(0)" onclick="openAddFavoriteBookmarkForm()">+ Add Bookmark</a>
                </li>
            </ul>
        </div>

        <!-- Hidden Favorite Bookmark Form -->
        <div id="FavoriteBookmarkForm" style="display:none;" class="add-bookmark-form w3-auto">
            <form method="POST" action="handlers/add_bookmark.php">
                <button type="button" class="cancel-btn" onclick="closeFavoriteBookmarkForm()" aria-label="Close">&#10006;</button>
                <h3 class="w3-center" style="margin-top: 0px;">Add Bookmark</h3>

                <input type="hidden" name="group_id" id="modalGroupId">
                <input type="hidden" name="favorite" value="1">

                <label for="title">Title:</label>
                <input type="text" name="title" id="modalTitle" required><br>

                <label for="url">URL:</label>
                <input type="text" name="url" id="modalUrl" required placeholder="https://example.com"><br>

                <button type="submit" class="add-btn">Add Bookmark</button>
            </form>
        </div>

        <?php
            display_error('url_wrong'); 
            display_error('long_title');
            display_error('db');
            display_success();
        ?>
    </section>

    <hr style="margin-top: 1rem;">
    <section class="last-visited w3-container w3-center">
    
        <h2 class="w3-center">Last Visited</h2>
        <!-- <ul>
        <?php foreach ($favorites as $fav): ?>
            <li><a href="<?php echo htmlspecialchars($fav['url']); ?>" target="_blank"><?php echo htmlspecialchars($fav['title']); ?></a></li>
        <?php endforeach; ?>
        </ul> -->
    
    </section>

    <section class="Custom Groups w3-container w3-center">
    <hr>
        <h2 class="w3-center">Custom Groups</h2>
        
  

        
        <?php foreach ($groups as $grp): ?>
            <div class="w3-card card-padding group-section" data-group-id="<?= $grp['group_id'] ?>">

                <div class="group-header">
                    <h2 class="group-title"><?= htmlspecialchars($grp['group_title']) ?></h2>
                    <button 
                        class="edit-pencil" 
                        style="display: none;" 
                        onclick="openEditModal('group', <?= $grp['group_id'] ?>, this)" 
                        data-title="<?= htmlspecialchars($grp['group_title']) ?>"
                    >✏️</button>

                    <button class="add-btn" onclick="editSection(<?= $grp['group_id'] ?>, this)" data-editing="false">EDIT</button>
                </div>

                <ul id="group-list-<?= $grp['group_id'] ?>" class="w3-center">
                    <?php
                        $gid = $grp['group_id'];
                        if (isset($groupedBookmarks[$gid])):
                            foreach ($groupedBookmarks[$gid] as $bookmark):
                    ?>
                        <li class="bookmark-item">
                            <a href="<?= htmlspecialchars($bookmark['url']) ?>" target="_blank">
                                <?= htmlspecialchars($bookmark['title']) ?>
                            </a>
                            <button 
                                class="edit-pencil" 
                                style="display: none;" 
                                onclick="openEditModal('bookmark', <?= $bookmark['bookmark_id'] ?>, this)" 
                                data-title="<?= htmlspecialchars($bookmark['title']) ?>" 
                                data-url="<?= htmlspecialchars($bookmark['url']) ?>"
                            >✏️</button>

                        </li>
                    <?php
                            endforeach;
                        else:
                    ?>
                        <li><em>No bookmarks yet</em></li>
                    <?php endif; ?>

                    <li>
                        <a href="javascript:void(0)" onclick="openAddBookmarkModal(<?= $grp['group_id'] ?>)">+ Add Bookmark</a>
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
    <hr>
    </section>


        <!-- Dynamic Editing Modal  -->
        <div id="editModalContainer" class="w3-modal" style="display: none;">
    <div class="w3-modal-content w3-card-4 w3-animate-top" style="max-width: 400px; margin: auto;">
        <span onclick="closeEditModal()" class="w3-button w3-display-topright">&times;</span>
        <div id="editModalContent" class="w3-container" style="padding: 20px;">
        <!-- Dynamic content will be inserted here -->
        </div>
    </div>
    </div>

</body>










</html>
