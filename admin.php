<?php
// Include the necessary functions and data handling logic
include_once 'db_connect.php';
include_once 'header.php';

// Start the session
session_start();

// Inisialisasi variabel admin dan adminDetails
$admin = "";
$adminDetails = array();

// Pastikan session admin terdefinisi
if (isset($_SESSION['admin'])) {
    // Jika ada, isi variabel admin
    $admin = $_SESSION['admin'];
    // Connect to the database
    $pdo = connectToDatabase();
    // Fetch admin information
    $adminDetails = getadminDetails($pdo, $admin);
} elseif (!isset($_SESSION['user'])) {
    // Jika tidak ada sesi admin atau sesi user, redirect ke halaman login
    header("Location: admin_portal.php");
    exit();
}

// Placeholder function for fetching admin details (replace with your actual logic)
function getadminDetails($pdo, $admin)
{
    try {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$admin]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database error
        die("Error retrieving admin information: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Akademiku</title>
    <!-- Include your stylesheets and scripts here -->
    <style>
        /* Add your custom styles for the Admin page */
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

        .admin-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .notification {
            margin-top: 20px;
            background-color: #ffe066;
            padding: 10px;
            border-radius: 8px;
        }

        .logout-link {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
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

        <div class="notification">
            <p><strong>Notification:</strong> There are new admin registrations and payment issues. Please check the management panel.</p>
        </div>

        <div class="logout-link">
            <p><a href="logout.php">Logout</a></p>
        </div>
    </main>

    <?php
        // Include data.php for additional admin functionality
        include_once 'data.php';
    ?>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Akademiku. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
    // Close the database connection (optional, as PHP will automatically close it)
    $pdo = null;
?>
