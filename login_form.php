<?php
// Start the session
session_start();

// Check if the user is already logged in, redirect to the home page
if (isset($_SESSION['user'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin.php");
    } else {
        header("Location: lms.php");
    }
    exit();
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Placeholder function for user authentication
    if (authenticateAdmin($username, $password)) {
        // Set session variables
        $_SESSION['user'] = $username;
        $_SESSION['role'] = 'admin';
        
        // Redirect to the appropriate page
        header("Location: interface.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}

// Placeholder function for admin authentication using JSON file
function authenticateAdmin($username, $password) {
    $adminData = json_decode(file_get_contents('admin.json'), true);

    foreach ($adminData as $admin) {
        if ($admin['username'] === $username && $admin['password'] === $password) {
            return true;
        }
    }

    return false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Akademiku</title>
    <!-- Include your stylesheets and scripts here -->
    <style>
        /* Add your custom styles for the Login page */
        body {
            font-family: 'Arial', sans-serif;
            background-color: <?php echo isset($error) ? '#fff' : '#f4f4f4'; ?>;
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

        .login-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>

    <main>
        <div class="login-form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <br>

                <button type="submit">Login</button>
            </form>

            <?php
                // Display error message if authentication fails
                if (isset($error)) {
                    echo "<p class='error'>$error</p>";
                }
            ?>
        </div>
    </main>
</body>
</html>
