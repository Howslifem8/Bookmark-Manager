<?php
session_start();
require '../includes/db.php';

// if not logged in- redirect back to index 
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php"); 
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];

    //Sanatize and Validate Title 
    $raw_title = trim($_POST['title']);
    $title= htmlspecialchars($raw_title, ENT_QUOTES, 'UTF-8');

    //Sanatize URL

    $url= trim($_POST['url']);

    //ADD HTTP if none 
    if (!preg_match("~^https?://~i", $url)) {
        $url = "https://" . $url;
    }

    //Validate URL structure 
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        $_SESSION['errors']['url_wrong'] = "Invalid URL format.";
        header("Location: ../bookmark-manager.php");
        exit();
    }

    
    
    //Injecting data. 
    $stmt = $pdo->prepare("INSERT INTO bookmarks (user_id, group_id, title, url) VALUES (?, ?, ?, ?)");
    $group_id = isset($_POST['group_id']) ? (int)$_POST['group_id'] : null;

    try {
        $stmt->execute([$user_id, $group_id, $title, $url]);
        $_SESSION['success'] = "Bookmark added successfully.";
    } catch (PDOException $e) {
        $_SESSION['errors']['db'] = "Database error: " . $e->getMessage();
    }

    header("Location: ../bookmark-manager.php");
    exit();   



}

 

