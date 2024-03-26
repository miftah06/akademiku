<?php
include 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate and sanitize input (you may need to enhance this based on your requirements)
    $username = htmlspecialchars(trim($username));
    $password = htmlspecialchars(trim($password));

    // Connect to the database
    $pdo = connectToDatabase();

    // Add your additional validation logic here

    // Create the account
    $result = createAccount($pdo, $username, $password);

    if ($result) {
        // Redirect to a success page or another appropriate location
        header("Location: account_created.php");
        exit();
    } else {
        // Handle account creation failure (e.g., display an error message)
        $error_message = "Account creation failed. Please try again.";
    }
}

function createAccount($pdo, $username, $password)
{
    // Implement your account creation logic here
    // Example: Insert user data into the database
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Execute the prepared statement
    return $stmt->execute([$username, $hashedPassword]);
}
?>
