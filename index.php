<?php
session_start();
include 'includes/header.php';
require_once 'includes/functions.php';
?>

<html>
<div class="w3-center intro">
    <h1>Welcome to Booksyde.</h1>
    <h2>Store your bookmarks as you please, for absolutely free. </h2>
    <h3>Please Sign in or Register to get started !</h3>
</div>

<div class="signin">
    <h1 class="w3-center">Sign in</h1>
    <form method="POST" action="handlers/login.php" class="w3-center">
        <label for="username" class="">Email:</label><br>
        <input type="text" id="email" name="email" class=""><br>
        <?php 
        display_error('no_email_found'); 
        if (isset($_SESSION['errors']['no_email_found'])){
            echo "<p style='color:red'>" . $_SESSION['errors']['no_email_found'] . "</p>";
        }
        ?>




        <label for="password" class="">Password:</label><br>
        <input type="text" id="password" name="password" class=""><br>
        <?php 
        if (isset($_SESSION['errors']['incorrect_password'])){
            echo "<p style='color:red'>" . $_SESSION['errors']['incorrect_password'] . "</p>";
        }
        ?>








        <button type="submit" name="login" class="add-btn">Login</button>
    </form>
    
</div>


<div class="w3-display-container register">

    <h1 class="w3-center">Register</h1>
    <form method="POST" action="handlers/register.php" class="w3-center">

                                       <!-- Username  -->
        <label for="username" class="">Username</label><br>
        <input type="text" name="username" required class=""><br>
        <?php 
        display_error('bad_username');
        display_error('empty_username');
        display_error('username_length');
        ?>       

                                       <!-- Email  -->
        <label for="Email" class="">Email</label><br>
        <input type="text" name="email" required class=""><br>   
                                        <!-- Duplicate email Error Handling -->
        <?php 
        display_error('invalid_email');
        display_error('empty_email');
        display_error('email_length');
        ?>

                                       <!-- Password  -->
        <label for="password" class="">Password</label><br>
        <input type="text" name="password" required class=""><br>

        <?php 
        display_error('empty_password');
        display_error('short_password');
        display_error('long_password');
        ?>

                                       <!-- Confirm Password  -->
        <label for="confirm_password" class="">Confirm Password</label><br>
        <input type="text" name="confirm_password" required class=""><br> 

                                        <!-- Passwords Do Not Match error Handling  -->
        <?php 
        display_error('confirm_password_error');

        ?>

                                        
                                       <!-- Submit Button  -->
        <input type="submit" value="Register" class="add-btn">    
        <?php 
        display_success();
        ?>
        



    </form>

</div>

<hr style="margin-top: 4rem;">

<section class="footer-features w3-container w3-center">
<h2> Learn More About Booksyde Manager</h2>

<ul>
    <li>Easily save and organize your links.</li>
    <li>Access your bookmarks across all devices.</li>
    <li>Free, secure, and completely private.</li>
</ul>


</section>






















<?php
// Clean up success & errors arrays. 
if (isset($_SESSION['successful']) || isset($_SESSION['errors'])) {
    unset($_SESSION['successful']);
    unset($_SESSION['errors']);
}
?>

</html>
