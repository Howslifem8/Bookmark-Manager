<?php
include 'includes/header.php';
?>

<div class="w3-center intro">
    <h1>Welcome to your Bookmark Manager.</h1>
    <h2>Store your bookmarks as you please, for absolutely free. </h2>
    <h3>Please Sign in or Register to get started !</h3>
</div>

<div class="signin">
    <h1 class="w3-center">Sign in</h1>
    <form>
        <label for="firstname" class="">First Name:</label><br>
        <input type="text" id="fname" name="fname" class=""><br>

        <label for="lastname" class="">Last Name:</label><br>
        <input type="text" id="lname" name="lname" class=""><br>

        <input type="submit" value="Sign In" class="w3-btn">
    </form>
    
</div>


<div class=" signin register">
    <h1 class="w3-center">Register</h1>
    <form method="POST" action="register.php">
        <label for="username" class="">Username</label><br>
        <input type="text" name="uname" required class=""><br>

        <label for="Email" class="">Email</label><br>
        <input type="text" name="email" required class=""><br>   

        <label for="password" class="">Password</label><br>
        <input type="text" name="passwrd" required class=""><br>

        <label for="confirm_password" class="">Confirm Password</label><br>
        <input type="text" name="confirm_passwrd" required class=""><br>  

        <input type="submit" value="Register" class="w3-btn" style="background-color: beige;">        
    </form>



</div>

