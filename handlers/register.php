<?php
session_start();
require '../includes/db.php'; // make sure this connects to your DB

    //triming user inputs
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    




    //Sanatize username 
    $originalusername = trim($_POST['username']);
    $sanitizedusername = filter_var($originalusername, FILTER_SANITIZE_STRING);
    $sanitizedusername = preg_replace("/[^a-zA-Z0-9_]/", "", $sanitizedusername);

    //Validate username 
    if($originalusername !== $sanitizedusername) {
        $_SESSION['errors']['bad_username'] = 'Username not valid, must only contain letters, numbers, or underscores.';
    }
    
    if (empty($sanitizedusername)) {
        $_SESSION['errors']['empty_username'] = "Username is required and must only contain letters, numbers, and underscores.";
    } 
    
    if (strlen($sanitizedusername) <3 || strlen($sanitizedusername) > 20){
        $_SESSION['errors']['username_length'] = "Username must be atleast 3 characters long or shorter than 20 characters.";
    }

    $username= $sanitizedusername;

    //Sanatize email 

    $originalemail = trim($_POST['email']);
    $sanitizedemail= filter_var($originalemail, FILTER_SANITIZE_EMAIL);

    //Validate email 

    if($originalemail !== $sanitizedemail) {
        $_SESSION['errors']['invalid_email'] = "Email is not valid.";
    }

    if (empty($sanitizedemail)) {
        $_SESSION['errors']['empty_email'] = "Please Enter an Email. "; 
    } 

    if (strlen($sanitizedemail) <3 || strlen($sanitizedemail) > 100) {
        $_SESSION['errors']['email_length'] = "Email needs to be longer than 3 characters and shorter than 100. "; 
    }

    $email = $sanitizedemail; 


    // Validate password 

    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    if ($password !== $confirm) {
        $_SESSION ['errors']['confirm_password_error'] = "Passwords do not match.";
    }
    
    if (empty($password)){
        $_SESSION['errors']['empty_password'] = "Password can not be empty. ";
    }
    
    if (strlen($password) <8 ) {
        $_SESSION['errors']['short_password'] = "Password must be atleast 8 characters long. ";
    }
    
    if (strlen($password) >50 ) {
        $_SESSION['errors']['long_password'] = "Password must be less than 50 characters long. ";
    }

    // If any validation errors exist -- exit before injection. 

    if (!empty($_SESSION['errors'])){
        header("Location: ../index.php");
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

        $_SESSION['successful']['register_success'] = "Account Created Successfully!";

    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            $_SESSION['errors']['email_error'] = "Email is already registered.";
        } else {
            $_SESSION['errors']['db_error'] = "Database error: " . $e->getMessage();
        }

        header("Location: ../index.php");
        exit();

    }

    //Final success redirect. 
    if (empty($_SESSION['errors'])){
        $_SESSION['successful']['register_success'] = "Account Created Successfully.";
        header("Location: ../index.php");
        exit();
    }

}
?>
