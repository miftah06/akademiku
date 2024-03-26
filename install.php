<?php
// Include the necessary functions and data handling logic
function connectToDatabase()
{
    $dbname = 'lms.db';  // Nama file database SQLite
    try {
        $pdo = new PDO("sqlite:$dbname");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// Function to add an admin user during installation
function addAdminUser($pdo, $email, $username, $password, $profilePicture)
{
    // Hash the password before storing it in the database (for security)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Add the admin user to the 'admins' table
    $addAdminUser = $pdo->prepare("INSERT INTO admins (email, username, password, profile_picture, is_admin) VALUES (:email, :username, :password, :profilePicture, 1)");
    $addAdminUser->bindParam(':email', $email);
    $addAdminUser->bindParam(':username', $username);
    $addAdminUser->bindParam(':password', $hashedPassword);
    $addAdminUser->bindParam(':profilePicture', $profilePicture);
    $addAdminUser->execute();
}

// Connect to the database
$pdo = connectToDatabase();

// Install script logic
try {
    // Create necessary tables, perform other installation tasks

    // Create the 'admins' table
    $createadminsTable = $pdo->prepare("
        CREATE TABLE IF NOT EXISTS admins (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR(191) NOT NULL UNIQUE,
            email VARCHAR(191) NOT NULL UNIQUE,
            password VARCHAR(191) NOT NULL,
            profile_picture TEXT,
			role VARCHAR(50) DEFAULT admin,
            is_admin INT DEFAULT 1
        );
    ");
    $createadminsTable->execute();

	// Create the 'users' table
	$createUsersTable = $pdo->prepare("
		CREATE TABLE IF NOT EXISTS users (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			username VARCHAR(191) NOT NULL UNIQUE,
			email VARCHAR(191) NOT NULL UNIQUE,
			password VARCHAR(191) NOT NULL,
			profile_picture TEXT
		);
	");
	$createUsersTable->execute();

	// Create the 'instructors' table
	$createInstructorsTable = $pdo->prepare("
		CREATE TABLE IF NOT EXISTS instructors (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			username VARCHAR(191) NOT NULL UNIQUE,
			email VARCHAR(191) NOT NULL UNIQUE,
			password VARCHAR(191) NOT NULL,
			profile_picture TEXT,
			is_admin INT DEFAULT 0
		);
	");
	$createInstructorsTable->execute();


    // Create the 'courses' table
    $createCoursesTable = $pdo->prepare("
        CREATE TABLE IF NOT EXISTS courses (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(191) NOT NULL,
            description TEXT,
            thumbnail TEXT,
            video_url TEXT,
            instructor_id INT,
            FOREIGN KEY (instructor_id) REFERENCES admins(id)
        );
    ");
    $createCoursesTable->execute();

    // Create the 'payments' table
    $createPaymentsTable = $pdo->prepare("
        CREATE TABLE IF NOT EXISTS payments (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INT,
            course_id INT,
            transaction_id VARCHAR(191) NOT NULL UNIQUE,
            payment_status INT DEFAULT 0, -- 0: Pending, 1: Completed, 2: Failed
            payment_date DATETIME,
            FOREIGN KEY (user_id) REFERENCES admins(id),
            FOREIGN KEY (course_id) REFERENCES courses(id)
        );
    ");
    $createPaymentsTable->execute();

    // Add admin user
    $adminEmail = 'admin@admin.com';
    $adminUsername = 'admin';  // Tambahkan username yang diinginkan
    $adminPassword = 'admin123';
    $adminProfilePicture = 'profile.png'; // Placeholder for profile picture

    // Check if the admin user already exists
    $checkAdminExists = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
    $checkAdminExists->bindParam(':username', $adminUsername);
    $checkAdminExists->execute();

    if ($checkAdminExists->rowCount() === 0) {
        // Admin user doesn't exist, add the admin user
        addAdminUser($pdo, $adminEmail, $adminUsername, $adminPassword, $adminProfilePicture);
        echo "Admin user added successfully!";
    } else {
        echo "Admin user already exists.";
    }
} catch (PDOException $e) {
    // Handle exceptions if needed
    echo "Installation failed: " . $e->getMessage();
}

// SQL query to create the payment_methods table with additional columns
$sql = "CREATE TABLE IF NOT EXISTS payment_methods (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    method VARCHAR(255) NOT NULL,
    bank_info TEXT,
    credit_card_info TEXT,
    payment_instructions TEXT
)";
// Execute the query
$createPaymentMethodsTable = $pdo->prepare($sql);
$createPaymentMethodsTable->execute();

// Close the database connection
$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation</title>
    <!-- Include your stylesheets and scripts here -->
    <style>
        /* Add your custom styles, including .thumbnail class */
        .thumbnail {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin: 10px;
            border: 2px solid #ddd;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <h1>Installation Complete</h1>
    <!-- Add content or redirect to another page as needed -->
</body>
</html>
