<?php
// Include the necessary functions and data handling logic
include_once 'db_connect.php';

// Function to fetch all admins from the database
function getAllAdmins($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM admins");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database error
        die("Error fetching admins: " . $e->getMessage());
    }
}

// Function to fetch all instructors from the database
function getAllInstructors($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM instructors");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database error
        die("Error fetching instructors: " . $e->getMessage());
    }
}

// Function to fetch all users from the database
function getAllUsers($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database error
        die("Error fetching users: " . $e->getMessage());
    }
}

// Function to perform additional admin functionality
function additionalAdminFunction() {
    // Placeholder for additional admin functionality
    // Implementation goes here
}

// Function to perform additional data management functionality
function additionalDataManagementFunction() {
    // Placeholder for additional data management functionality
    // Implementation goes here
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Management - Akademiku </title>
    <!-- Include your stylesheets and scripts here -->
    <style>
        /* Add your custom styles for the Data Management page */
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

        .management-section {
            margin-top: 20px;
        }

        .logout-link {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Data Management</h1>
    </header>

    <main>
        <div class="admin-info">
            <?php if (!empty($admin)) : ?>
                <h2>Welcome, <?php echo $admin; ?> (Admin)!</h2>
                <?php if (!empty($adminDetails)) : ?>
                    <p>Email: <?php echo $adminDetails['email']; ?></p>
                    <!-- Add more admin details as needed -->
                <?php else : ?>
                    <p>Error retrieving admin information.</p>
                <?php endif; ?>
            <?php else : ?>
                <p>Error: Admin not logged in.</p>
            <?php endif; ?>
        </div>

        <div class="management-section">
            <!-- Add your data management features here -->
            <h2>Data Management Section</h2>
            <!-- Include links or buttons for managing payment methods, Admins, and instructors -->
            <p><a href="manage_payment.php">Manage Payment Methods</a></p>
            <p><a href="manage_users.php">Manage users</a></p>
            <p><a href="manage_instructors.php">Manage Instructors</a></p>
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