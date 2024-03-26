<?php
session_start();

// Function to generate a random token
function generateToken() {
    return bin2hex(random_bytes(16)); // Generate a 32-character hexadecimal token
}

// Check if user is logged in
if (isset($_SESSION['username']) && isset($_SESSION['expire'])) {
    // Check if the session has expired
    if ($_SESSION['expire'] < time()) {
        // Session expired, redirect to login page
        header("Location: login.php");
        exit();
    }

    // Generate a token for accessing course.php
    $token = generateToken();
    $_SESSION['token'] = $token;

    // Display user profile
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Profile - Akademiku</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <?php include 'header.php'; ?>
        <h2>User Profile</h2>
        <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
        <p>Your session will expire in <?php echo date("H:i:s", $_SESSION['expire'] - time()); ?></p>
        <p>Here is your token for accessing course.php: <?php echo $token; ?></p>
        <a href="course.php?token=<?php echo $token; ?>">Access Course</a>
        <br><br>
        <a href="logout.php">Logout</a>
    </body>
    </html>

    <?php
    // Create akademiku.json if it doesn't exist and add the first course
    $filename = 'akademiku.json';
    if (!file_exists($filename)) {
        $courses = array(
            array(
                'title' => 'Introduction to Programming',
                'description' => 'Learn the basics of programming with this introductory course.',
                'author' => 'John Doe',
                'date' => date('Y-m-d')
            )
        );
        file_put_contents($filename, json_encode($courses));
    }
} else {
    // User not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
?>
