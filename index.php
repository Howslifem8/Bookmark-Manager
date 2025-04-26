<?php
session_start();
include 'includes/header.php';
?>

<html>
<div class="w3-center intro">
    <h1>Welcome to your Bookmark Manager.</h1>
    <h2>Store your bookmarks as you please, for absolutely free. </h2>
    <h3>Please Sign in or Register to get started !</h3>
</div>

<div class="signin">
    <h1 class="w3-center">Sign in</h1>
    <form method="POST" action="handlers/login.php" class="w3-center">
        <label for="username" class="">Email:</label><br>
        <input type="text" id="email" name="email" class=""><br>

        <label for="password" class="">Password:</label><br>
        <input type="text" id="password" name="password" class=""><br>

        <button type="submit" name="login" class="w3-btn">Login</button>
    </form>
    
</div>


<div class="w3-display-container register">

    <h1 class="w3-center">Register</h1>
    <form method="POST" action="handlers/register.php" class="w3-center">

                                       <!-- Username  -->
        <label for="username" class="">Username</label><br>
        <input type="text" name="username" required class=""><br>
        <?php 
            if (isset($_SESSION['errors']['bad_username'])) {
                echo "<p style='color:red'>" . $_SESSION['errors']['bad_username'] . "</p>";
            } 
            if (isset($_SESSION['errors']['empty_username'])) {
                echo "<p style='color:red'>" . $_SESSION['errors']['empty_username'] . "</p>"; 
            } 
            if (isset($_SESSION['errors']['username_length'])) {
                echo "<p style='color:red'>" . $_SESSION['errors']['username_length'] . "</p>"; 
            }
        ?>       

                                       <!-- Email  -->
        <label for="Email" class="">Email</label><br>
        <input type="text" name="email" required class=""><br>   
                                        <!-- Duplicate email Error Handling -->
        <?php 
            if (isset($_SESSION['errors']['invalid_email'])) {
                echo "<p style='color:red'>" . $_SESSION['errors']['invalid_email'] . "</p>";
            }
            if (isset($_SESSION['errors']['empty_email'])) {
                echo "<p style='color:red'>" . $_SESSION['errors']['empty_email'] . "</p>";
            }
            if (isset($_SESSION['errors']['email_length'])) {
                echo "<p style='color:red'>" . $_SESSION['errors']['email_length'] . "</p>";
            }
        ?>

                                       <!-- Password  -->
        <label for="password" class="">Password</label><br>
        <input type="text" name="password" required class=""><br>

        <?php 
            if (isset($_SESSION['errors']['empty_password'])) {
                echo "<p style='color:red'>" . $_SESSION['errors']['empty_password'] . "</p>";
            }
            if (isset($_SESSION['errors']['short_password'])) {
                echo "<p style='color:red'>" . $_SESSION['errors']['short_password'] . "</p>";
            }
            if (isset($_SESSION['errors']['long_password'])) {
                echo "<p style='color:red'>" . $_SESSION['errors']['long_password'] . "</p>";
            }
        ?>

                                       <!-- Confirm Password  -->
        <label for="confirm_password" class="">Confirm Password</label><br>
        <input type="text" name="confirm_password" required class=""><br> 

                                        <!-- Passwords Do Not Match error Handling  -->
        <?php 
            if (isset($_SESSION['errors']['confirm_password_error'])) {
                echo "<p style='color:red'>" . $_SESSION['errors']['confirm_password_error'] . "</p>";
            }
        ?>

                                        
                                       <!-- Submit Button  -->
        <input type="submit" value="Register" class="w3-btn" style="background-color: beige;">    
        <?php 
            if (isset($_SESSION['successful']['register_success'])) {
                echo "<p style='color:green'>" . $_SESSION['successful']['register_success'] . "</p>";
            }
        ?>
        



    </form>



</div>

<?php
// Clean up success & errors arrays. 
if (isset($_SESSION['successful']) || isset($_SESSION['errors'])) {
    unset($_SESSION['successful']);
    unset($_SESSION['errors']);
}
?>

</html>
