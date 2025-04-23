<?php
require 'db.php'; // make sure this connects to your DB

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Validate password match
    if ($password !== $confirm) {
        die("Passwords do not match.");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    try {
        $stmt = $pdo->prepare("
            INSERT INTO users (firstname, lastname, email, password_hash)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$firstname, $lastname, $email, $hashedPassword]);
        echo "User registered successfully!";
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            echo "Email is already registered.";
        } else {
            echo "Database error: " . $e->getMessage();
        }
    }
}
?>
