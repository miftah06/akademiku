<?php
// Include the necessary functions and data handling logic
function connectToDatabase()
{
    $dbname = 'guests.db';  // Nama file database SQLite
    try {
        $pdo = new PDO("sqlite:$dbname");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// Connect to the database
$pdo = connectToDatabase();

// Create users table
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL
    )");
    echo "Table 'users' created successfully.";
} catch (PDOException $e) {
    die("Error creating table: " . $e->getMessage());
}

// Create users table
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS guests (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL
    )");
    echo "Table 'users' created successfully.";
} catch (PDOException $e) {
    die("Error creating table: " . $e->getMessage());
}

// Close the database connection
$pdo = null;
?>
