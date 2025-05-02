<?php
session_start();
require '../includes/db.php';
require_once '../includes/functions.php';

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

    if (strlen($raw_title) > 80) {
        $_SESSION['errors']['long_title'] = "Please modify title to be less than 80 characters.";
    }


    
    //Sanatize URL

    $url= trim($_POST['url']);

    //ADD HTTP if none 
    if (!preg_match("~^https?://~i", $url)) {
        $url = "https://" . $url;
    }

    //Validate URL structure 
// Validate URL structure
    if (
        !filter_var($url, FILTER_VALIDATE_URL) ||
        !preg_match('/\.[a-z]{2,}$/i', parse_url($url, PHP_URL_HOST))
    ) {
        $_SESSION['errors']['url_wrong'] = "Please enter a valid URL with a domain like .com or .org.";
        header("Location: ../bookmark-manager.php");
        exit();
    }

    
    
    //Injecting data. 
    $group_id = isset($_POST['group_id']) ? (int)$_POST['group_id'] : null;
    $favorite = isset($_POST['favorite']) ? 1 : 0;
    
    $stmt = $pdo->prepare("INSERT INTO bookmarks (user_id, group_id, title, url, favorite) VALUES (?, ?, ?, ?, ?)");
    
    try {
        $stmt->execute([$user_id, $group_id, $title, $url, $favorite]);
        $_SESSION['success'] = "Bookmark added successfully.";
    } catch (PDOException $e) {
        $_SESSION['errors']['db'] = "Database error: " . $e->getMessage();
    }

    header("Location: ../bookmark-manager.php");
    exit();   



}