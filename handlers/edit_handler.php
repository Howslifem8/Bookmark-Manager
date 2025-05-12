<?php 
//Dependencies 
session_start();
require '../includes/db.php';
require_once '../includes/functions.php';

//Check IF user is signed in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];

    //Sanatize and Validate Type, Favorite, bookmark, group, titile, url, group_title, checkmarks -- delete, delete_group 
    //Sanatizing Bookamrk Title
    $title = '';
    if (isset($_POST['title'])) {
        $raw_bk_title = trim($_POST['title']);
        $title = htmlspecialchars($raw_bk_title, ENT_QUOTES, 'UTF-8');
        if (strlen($raw_bk_title) > 80) {
            $_SESSION['errors']['long_title'] = "Please modify title to be less than 80 characters.";
        }
    }

    //Sanatize Bookmark URL
    $url = '';
    if (isset($_POST['url'])) {
        $url = trim($_POST['url']);
        if (!preg_match("~^https?://~i", $url)) {
            $url = "https://" . $url;
        }
        if (!filter_var($url, FILTER_VALIDATE_URL) || !preg_match('/\.[a-z]{2,}$/i', parse_url($url, PHP_URL_HOST))) {
            $_SESSION['errors']['url_wrong'] = "Please enter a valid URL with a domain like .com or .org.";
            header("Location: ../bookmark-manager.php");
            exit();
        }
    }

    //Sanatizing Group Title
    $grp_title = '';

    if (isset($_POST['group_title'])) {
        $raw_grp_title = trim($_POST['group_title']);
        $grp_title = htmlspecialchars($raw_grp_title, ENT_QUOTES, 'UTF-8');

        if (strlen($raw_grp_title) > 80) {
            $_SESSION['errors']['long_title'] = "Please modify title to be less than 80 characters.";
        }
    }



    //Grab POST Data Values 
    $type = $_POST['type'];

    $id = (int) $_POST['id'];

    $delete = isset($_POST['remove']);

    $delete_group = isset($_POST['delete_group']);




    //Logic Handling POST modifications 
    if($type === 'favorite') {
        //Check if remove checkmark is set
        $remove = isset($_POST['remove']);

        if ($remove) {
            $stmt = $pdo->prepare("UPDATE bookmarks SET favorite = 0 WHERE bookmark_id = ? AND user_id = ?");
            $stmt->execute([$id, $user_id]);
            $_SESSION['success'] = "Bookmark removed from Favorites.";    
        }else {
            // Update bookmark's title and URL
            $stmt = $pdo->prepare("UPDATE bookmarks SET title = ?, url = ? WHERE bookmark_id = ? AND user_id = ?");
            $stmt->execute([$title, $url, $id, $user_id]);
            $_SESSION['success'] = "Bookmark updated successfully.";
        }


        // Smart cleanup of orphaned bookmarks
        $stmt = $pdo->prepare("DELETE FROM bookmarks WHERE favorite = 0 AND group_id IS NULL AND user_id = ?");
        $stmt->execute([$user_id]);

        header("Location: ../bookmark-manager.php");
        exit(); 
    } 

    if ($type === 'group') {
        $delete = isset($_POST['delete_group']);
        $group_id = isset($_POST['group_id']) ? (int) $_POST['group_id'] : null;
        $group_id = $id; // Since type === 'group'

        if ($delete) {
            // 1. Delete the group
            $stmt = $pdo->prepare("DELETE FROM groups WHERE group_id = ? AND user_id = ?");
            $stmt->execute([$group_id, $user_id]);

            // 2. Ungroup the bookmarks (preserve favorites)
            $stmt = $pdo->prepare("UPDATE bookmarks SET group_id = NULL WHERE group_id = ? AND user_id = ?");
            $stmt->execute([$group_id, $user_id]);

            // 3. Delete orphaned bookmarks (not favorited and not grouped)
            $stmt = $pdo->prepare("DELETE FROM bookmarks WHERE favorite = 0 AND group_id IS NULL AND user_id = ?");
            $stmt->execute([$user_id]);

            $_SESSION['deletion_success'] = "Group deleted. Associated bookmarks were removed if not favorited.";
        } else {
            // Update group title
            $stmt = $pdo->prepare("UPDATE groups SET group_title = ? WHERE group_id = ? AND user_id = ?");
            $stmt->execute([$grp_title, $group_id, $user_id]);

            $_SESSION['success'] = "Group title updated successfully.";
        }

        
        header("Location: ../bookmark-manager.php");
        echo "Redirecting...";
        exit();
    }

    if ($type === 'bookmark') {
    $remove = isset($_POST['remove']);

    if ($remove) {
        $stmt = $pdo->prepare("UPDATE bookmarks SET group_id = NULL WHERE bookmark_id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);

        // Smart cleanup
        $stmt = $pdo->prepare("DELETE FROM bookmarks WHERE favorite = 0 AND group_id IS NULL AND user_id = ?");
        $stmt->execute([$user_id]);

        $_SESSION['success'] = "Bookmark removed from group.";
    } else {
        $stmt = $pdo->prepare("UPDATE bookmarks SET title = ?, url = ? WHERE bookmark_id = ? AND user_id = ?");
        $stmt->execute([$title, $url, $id, $user_id]);

        $_SESSION['success'] = "Bookmark updated successfully.";
    }

    header("Location: ../bookmark-manager.php");
    exit();
    }



}