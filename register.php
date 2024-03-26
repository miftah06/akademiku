<?php
include_once 'db_guests_connect.php';
session_start();

// Inisialisasi variabel error
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password']; // Password hashing will be done later for security

    // Check if username or email already exists
    $checkUser = $pdo_guests->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
    $checkUser->bindParam(':username', $username);
    $checkUser->bindParam(':email', $email);
    $checkUser->execute();
    $userExists = $checkUser->fetchColumn();

    if ($userExists) {
        $error = "Username or email already exists.";
    } else {
        // Hash the password before storing it in the database (for security)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the 'users' table
        $addUser = $pdo_guests->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $addUser->bindParam(':username', $username);
        $addUser->bindParam(':email', $email);
        $addUser->bindParam(':password', $hashedPassword);
        $addUser->execute();

        // Redirect to the login page after successful registration
        header("Location: login_guests.php");
        exit();
    }
}

// Close the database connection
$pdo_guests = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Akademiku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .registration-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #555;
        }

        .error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <h2>Registration</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Register</button>
        </form>
        <?php echo $error; ?>
    </div>
</body>
</html>
