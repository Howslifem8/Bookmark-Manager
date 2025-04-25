<?php
session_start();
require 'includes/db.php'; // make sure this connects to your DB

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Validate password match & error handling
    if ($password !== $confirm) {
        $_SESSION ['errors']['confirm_password_error'] = "Passwords do not match.";
        header("Location: index.php");
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    try {
        $stmt = $pdo->prepare("
            INSERT INTO users (username, email, password_hash)
            VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);

        $_SESSION['successful']['register_success'] = "User Registered Successfully!";

    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            $_SESSION['errors']['email_error'] = "Email is already registered.";
        } else {
            $_SESSION['errors']['db_error'] = "Database error: " . $e->getMessage();
        }
    }

    header("Location: index.php");
    exit();
}
?>
