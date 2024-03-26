<?php
// Include the necessary functions and data handling logic
include 'db_connect.php';

// Check if the user is logged in, otherwise redirect to the login page
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login_form.php");
    exit();
}

// Connect to the database
$pdo = connectToDatabase();

// Fetch user information
$user = $_SESSION['user'];
$userDetails = getUserDetails($pdo, $user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php
        // Include the viewport meta tag using the "from" function
        echo from('<meta name="viewport" content="width=device-width, initial-scale=1.0">');
    ?>
    <title>Login Portal</title>
    <!-- Include your stylesheets and scripts here -->
    <style>
        /* Add your custom styles for the Login Portal page */
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

        .user-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logout-link {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Login Portal</h1>
    </header>

    <main>
        <div class="user-info">
            <h2>Welcome, <?php echo $user; ?>!</h2>
            <?php
                // Display user information
                if ($userDetails) {
                    echo "<p>Email: {$userDetails['email']}</p>";
                    // Add more user details as needed
                } else {
                    echo "<p>Error retrieving user information.</p>";
                }
            ?>
        </div>

        <div class="logout-link">
            <p><a href="logout.php">Logout</a></p>
        </div>
    </main>
</body>
</html>

<?php
    // Close the database connection (optional, as PHP will automatically close it)
    $pdo = null;
?>
