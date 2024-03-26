<?php
session_start();

// Function to verify login credentials
function verifyLogin($username, $password) {
    // Read the contents of akademiku.json
    $file_contents = file_get_contents('akademiku.json');
    // Decode JSON to an associative array
    $data = json_decode($file_contents, true);

    // Check if username exists in the data
    if (isset($data[$username])) {
        // Verify the password
        if ($data[$username]['password'] === $password) {
            return true; // Password match
        }
    }
    return false; // Username or password incorrect
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars($_POST['password']);

    // Verify login credentials
    if (verifyLogin($username, $password)) {
        // Authentication successful, set session variables
        $_SESSION['username'] = $username;
        $_SESSION['expire'] = time() + (3 * 24 * 60 * 60); // Set expiration time to 3 days
        // Redirect to user profile
        header("Location: profile.php");
        exit();
    } else {
        // Authentication failed, display error message
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Akademiku</title>
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
