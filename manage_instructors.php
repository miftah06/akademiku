<?php
// Include the necessary functions and data handling logic
include 'db_connect.php';
include_once 'header.php';

// Check if the user is logged in, otherwise redirect to the login page
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login_admin.php");
    exit();
}

// Connect to the database
$pdo = connectToDatabase();

// Placeholder function for fetching user details (replace with your actual logic)
function getUserDetails($pdo, $user)
{
    // Implement your logic to fetch user details from the database
    // Example query: SELECT * FROM users WHERE username = ?
    // Replace this with your actual query
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$user]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Placeholder function for fetching instructors (replace with your actual logic)
function getInstructors($pdo)
{
    try {
        $stmt = $pdo->prepare("SELECT * FROM instructors");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database error
        die("Error retrieving instructors: " . $e->getMessage());
    }
}

// Fetch admin information
$admin = $_SESSION['user'];
$adminDetails = getUserDetails($pdo, $admin); // Change to getUserDetails()

// Handle instructor-related actions or data management logic here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for instructor-related actions, e.g., delete instructor, update instructor information, etc.
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Instructors - Akademiku</title>
    <!-- Include your stylesheets and scripts here -->
    <style>
        /* Add your custom styles for the Manage Instructors page */
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

        .admin-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .instructor-actions {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .instructor-list {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .logout-link {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Manage Instructors</h1>
    </header>

    <main>
        <div class="admin-info">
            <h2>Welcome, <?php echo $admin; ?> (Admin)!</h2>
            <?php
                // Display admin information
                if ($adminDetails) {
                    echo "<p>Email: {$adminDetails['email']}</p>";
                    // Add more admin details as needed
                } else {
                    echo "<p>Error retrieving admin information.</p>";
                }
            ?>
        </div>

        <!-- Instructor Actions -->
        <div class="instructor-actions">
            <h2>Instructor Actions</h2>
            <!-- Add your instructor-related actions, e.g., buttons for deleting instructors, updating instructor information, etc. -->
            <form method="post">
                <!-- Example: Delete Instructor -->
                <label for="instructor_id">Instructor ID to Delete:</label>
                <input type="text" name="instructor_id" id="instructor_id">
                <button type="submit" name="delete_instructor">Delete Instructor</button>
            </form>
            <!-- Add more instructor-related actions as needed -->
        </div>

        <!-- Instructor List -->
        <div class="instructor-list">
            <h2>Existing Instructors</h2>
            <!-- Display a list or table of existing instructors -->
            <!-- Fetch and display instructors from the database -->
            <?php
                $instructors = getInstructors($pdo);
                foreach ($instructors as $instructor) {
                    echo "<p>Instructor ID: {$instructor['id']}, Name: {$instructor['name']}, Email: {$instructor['email']}</p>";
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
