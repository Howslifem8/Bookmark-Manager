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
    $raw_title = trim($_POST['group_title']);
    $title= htmlspecialchars($raw_title, ENT_QUOTES, 'UTF-8');

    if (strlen($raw_title) > 80) {
        $_SESSION['errors']['long_title'] = "Please modify title to be less than 80 characters.";
    }

    //Injecting data. 
    $stmt = $pdo->prepare("INSERT INTO groups (user_id, group_title) VALUES (?, ?)");
    
    
    
    try {
        $stmt->execute([$user_id, $title,]);
        $_SESSION['success'] = "Group added successfully.";
    } catch (PDOException $e) {
        $_SESSION['errors']['db'] = "Database error: " . $e->getMessage();
    }

    header("Location: ../bookmark-manager.php");
    exit();   



}