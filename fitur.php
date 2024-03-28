<?php
// Include the necessary functions and data handling logic
include_once 'db_connect.php';
include_once 'header.php';

// Start the session
session_start();

// Check if the user is already logged in, redirect to the home page
if (!isset($_SESSION['user'])) {
    header("Location: login_form.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitur</title>
    <!-- Include your stylesheets and scripts here -->
    <style>
        /* Add your custom styles for the Fitur page */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        main {
            padding: 20px;
            text-align: center;
        }

        .button-container {
            margin-top: 20px;
        }

        .button-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        .logout-link {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Fitur</h1>
        <?php
            // Display the username and logout link
            echo "<p>Welcome, {$_SESSION['user']}! <a href='logout.php'>Logout</a></p>";
        ?>
    </header>

    <main>
        <div class="button-container">
			<button onclick="location.href='course_manage.php'">Atur Kursus</button>
            <button onclick="location.href='index_course.php'">Buat Kursus</button>
            <button onclick="location.href='index_materi.php'">Tambah Materi</button>
            <button onclick="location.href='nano_course.php'">Edit Materi</button>
        </div>

        <div class="logout-link">
            <p><a href="logout.php">Logout</a></p>
        </div>
    </main>
</body>
</html>
