<?php
// Include the necessary functions and data handling logic
include 'db_connect.php';
include_once 'header.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login_form.php");
    exit();
}

// Placeholder function to get user details (replace with your actual logic)
function getUserDetails($email)
{
    // Implement your logic to fetch user details from the database
    // Replace this with your actual database query
    $pdo = connectToDatabase();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get user details
$userDetails = getUserDetails($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Portal - Akademiku</title>
    <!-- Include your stylesheets and scripts here -->
    <style>
        /* Add your custom styles for the User Portal page */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        main {
            padding: 20px;
            text-align: center;
        }

        .user-details {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }

        .logout-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to User Portal</h1>
    </header>

    <main>
        <div class="user-details">
            <h2>Hello, <?php echo $userDetails['email']; ?>!</h2>
            <!-- Display other user details as needed -->
            <p>User ID: <?php echo $userDetails['id']; ?></p>
            <p>Profile Picture: <?php echo $userDetails['profile_picture']; ?></p>

            <!-- Add more user details as needed -->

            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </main>
</body>
</html>
