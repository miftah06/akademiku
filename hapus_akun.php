<?php
include 'db_connect.php';

// Check if the user is logged in, otherwise redirect to the login page
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login_form.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $confirm_username = $_POST['confirm_username'];
    $confirm_password = $_POST['confirm_password'];

    // Validate and sanitize input (you may need to enhance this based on your requirements)
    $confirm_username = htmlspecialchars(trim($confirm_username));
    $confirm_password = htmlspecialchars(trim($confirm_password));

    // Connect to the database
    $pdo = connectToDatabase();

    // Add your additional validation logic here

    // Check if the provided username and password match the current user
    $user = $_SESSION['user'];
    $authentication_result = authenticateUser($pdo, $user, $confirm_password);

    if ($authentication_result) {
        // Delete the account
        $result = deleteAccount($pdo, $user);

        if ($result) {
            // Redirect to a success page or another appropriate location
            header("Location: account_deleted.php");
            exit();
        } else {
            // Handle account deletion failure (e.g., display an error message)
            $error_message = "Account deletion failed. Please try again.";
        }
    } else {
        // Handle authentication failure (e.g., display an error message)
        $error_message = "Authentication failed. Please check your username and password.";
    }
}

function authenticateUser($pdo, $username, $password)
{
    // Implement your user authentication logic here
    // Example: Retrieve hashed password from the database and verify it
    $stmt = $pdo->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $hash = $stmt->fetchColumn();

    return $hash !== false && password_verify($password, $hash);
}

function deleteAccount($pdo, $username)
{
    // Implement your account deletion logic here
    // Example: Delete user data from the database
    $stmt = $pdo->prepare("DELETE FROM users WHERE username = ?");

    // Execute the prepared statement
    return $stmt->execute([$username]);
}
?>
