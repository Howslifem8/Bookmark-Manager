<?php 
session_start();
require '../includes/db.php'; 

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

   
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "user found.<br>";
    if ($user) {
        if (password_verify($password, $user['password_hash'])) {
            echo "password matched.<br>";
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            
            header("Location: ../bookmark-manager.php");
            exit();

        } else {
            //passwords not matching handling
            echo "Password doesn't match.<br>";
            $_SESSION['errors']['incorrect_password'] = "Incorrect password.";
            header("Location: ../index.php");
            exit();
        }
    } else {
        //user not found handling
        echo "user NOT found.<br>";
        $_SESSION['errors']['no_email_found'] = "No user found with that email.";
        header("Location: ../index.php");
        exit();
    }
}
?>
