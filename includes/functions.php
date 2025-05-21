<?php

//Function Displays Errors if specific key is filled, then removes message after 8 seconds. 
function display_error($key) {
    if (isset($_SESSION['errors'][$key])) {
        echo '<p id="generic-error" class="w3-center error-message">Error</p>';
        echo '
            <p id="error-message-' . $key . '" class="w3-center error-message">'
                . htmlspecialchars($_SESSION['errors'][$key]) .
            '</p>
            <script>
                setTimeout(function() {
                    const generic = document.getElementById("generic-error");
                    const specific = document.getElementById("error-message-' . $key . '");

                    if (generic) generic.style.display = "none";
                    if (specific) specific.style.display = "none";
                }, 8000); // 8 seconds
            </script>
        ';

        unset($_SESSION['errors'][$key]);
    }
}


//Function Displays Succsess Messages if $_SESSION['success'] is filled, then removes message after 8 seconds. 
function display_success() {
    if (isset($_SESSION['success'])) {
        echo '
            <p id="success-message" class=" w3-center success-message">' . htmlspecialchars($_SESSION['success']) . '</p>
            <script>
                setTimeout(function() {
                    const msg = document.getElementById("success-message");
                    if (msg) msg.style.display = "none";
                }, 8000); // 8 seconds
            </script>
        ';
        unset($_SESSION['success']);
    }
}