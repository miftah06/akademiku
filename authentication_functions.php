<?php
// Start the session
session_start();

// Redirect to dashboard page if user is already logged in
function redirectToDashboard() {
    if (isLoggedIn()) {
        header("Location: course.php");
        exit();
    }
}
?>
