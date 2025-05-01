<?php
function display_error($key) {
    if (isset($_SESSION['errors'][$key])) {
        echo '<p class="error-message">' . htmlspecialchars($_SESSION['errors'][$key]) . '</p>';
    }
}
