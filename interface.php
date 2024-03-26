<!-- interface.php -->

<?php

    // Include the necessary functions and data handling logic
    include 'user.php';
	include_once 'header.php';

    // Check if the user is logged in, otherwise redirect to the login page
    if (!isset($_SESSION['user'])) {
        header("Location: login_form.php");
        exit();
    }

    // Logout functionality
    if (isset($_GET['logout'])) {
        // Clear all session variables
        session_unset();

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header("Location: login_form.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademiku</title>
    <!-- Include your stylesheets and scripts here -->

    <style>
        /* Add your custom styles for the Interface page */
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
        }

        .user-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .interface-content {
            margin-top: 20px;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logout {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
	<div class="logout">
		<p>Need to logout? <a href="logout.php">Click here</a></p>
	</div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Akademiku. All rights reserved.</p>
    </footer>
</body>
</html>
