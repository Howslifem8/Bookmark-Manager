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
    <form method="POST" action="login.php">
        <label for="username" class="">Username:</label><br>
        <input type="text" id="username" name="username" class=""><br>

        <label for="password" class="">Password:</label><br>
        <input type="text" id="password" name="password" class=""><br>

        <input type="submit" value="Sign In" class="w3-btn">
    </form>
    
</div>


<div class=" signin register">
    <h1 class="w3-center">Register</h1>
    <form method="POST" action="register.php">

                                       <!-- Username  -->
        <label for="username" class="">Username</label><br>
        <input type="text" name="username" required class=""><br>


                                       <!-- Email  -->
        <label for="Email" class="">Email</label><br>
        <input type="text" name="email" required class=""><br>   
                                        <!-- Duplicate email Error Handling -->
        <?php 
            if (isset($_SESSION['errors']['email_error'])) {
                echo "<p style='color:red'>" . $_SESSION['errors']['email_error'] . "</p>";
            }
        ?>

                                       <!-- Password  -->
        <label for="password" class="">Password</label><br>
        <input type="text" name="password" required class=""><br>


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
