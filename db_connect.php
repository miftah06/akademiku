<?php

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
