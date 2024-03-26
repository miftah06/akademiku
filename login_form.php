<?php
// Include the necessary functions and data handling logic
include 'db_connect.php';
include_once 'header.php';

// Start the session
session_start();

// Check if the user is already logged in, redirect to the home page
if (isset($_SESSION['instructors'])) {
    header("Location: course.php");
    exit();
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Placeholder function for user authentication (replace with your actual logic)
    $authenticatedUser = authenticateUser($_POST['username'], $_POST['password']);

    if ($authenticatedUser !== false) {
        // Set session variables
        $_SESSION['user'] = $authenticatedUser['username'];

        // Redirect based on user role
        if ($authenticatedUser['role'] == 'admin') {
            header("Location: course.php");
            exit();
        } else {
            header("Location: lms.php");
            exit();
        }
    } else {
        $error = "Invalid username or password";
    }
}

// Placeholder function for user authentication (replace with your actual logic)
function authenticateUser($username, $password)
{
    // Implement your user authentication logic here
    // Example: Check the database for the provided username and password
    // Replace this with your actual authentication logic
    $pdo = connectToDatabase();

    // Fetch user data using the username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password
    if ($userData && password_verify($password, $userData['password'])) {
        return $userData;
    } else {
        return false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login admin - Akademiku</title>
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
                <input type="username" id="username" name="username" required> <!-- Perhatikan atribut name="username" -->

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
