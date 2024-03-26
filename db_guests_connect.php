<?php
// Database configuration
$dbname = 'guests.db'; // Database name // Database password

// Database connection
$dsn = "sqlite:$dbname";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo_guests = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Failed to connect to the database: " . $e->getMessage());
}
?>
