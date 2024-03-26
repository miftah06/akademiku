<!-- pesanan.php -->

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

    // Fetch ordered courses for the current user
    $orderedCourses = getOrderedCourses($pdo, $user);

    // Add your additional features and logic here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php
        // Include the viewport meta tag using the "from" function
        echo from('<meta name="viewport" content="width=device-width, initial-scale=1.0">');
    ?>
    <title>Pesanan - Akademiku</title>
    <!-- Include your stylesheets and scripts here -->
    <style>
        /* Add your custom styles for the Pesanan page */
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

        .ordered-courses {
            background-color: #fff;
            margin-top: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <header>
        <h1>Pesanan</h1>
        <?php
            // Display the username and logout link
            echo "<p>Welcome, $user! <a href='logout.php'>Logout</a></p>";
        ?>
    </header>

    <main>
        <div class="user-info">
            <h2>User Information</h2>
            <?php
                // Display user information
                if ($userDetails) {
                    echo "<p>User: {$userDetails['username']}</p>";
                    echo "<p>Email: {$userDetails['email']}</p>";
                    // Add more user details as needed
                } else {
                    echo "<p>Error retrieving user information.</p>";
                }
            ?>
        </div>

        <div class="ordered-courses">
            <h2>Ordered Courses</h2>
            <?php
                // Display ordered courses
                if ($orderedCourses) {
                    foreach ($orderedCourses as $course) {
                        echo "<p>Course ID: {$course['course_id']}</p>";
                        echo "<p>Course Name: {$course['course_name']}</p>";
                        // Add more course details as needed
                        echo "<hr>";
                    }
                } else {
                    echo "<p>No courses ordered yet.</p>";
                }
            ?>
        </div>
		
		<!-- Payment form -->
		<div class="payment-form">
			<h2>Payment</h2>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
				<button type="submit" name="bayar">Bayar</button>
			</form>
		</div>
		</main>


        <!-- Add more features and content as needed -->
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Akademiku. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
    // Close the database connection (optional, as PHP will automatically close it)
    $pdo = null;
?>
