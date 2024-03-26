<?php
// Mulai sesi
session_start();

// Periksa apakah pengguna sudah login sebagai instruktur
if (!isset($_SESSION['instructor'])) {
    // Jika tidak, redirect ke halaman login
    header("Location: login_form.php");
    exit();
}

// Ambil informasi pengguna dari sesi
$instructor = $_SESSION['instructor'];

// Tampilkan halaman dashboard
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard - Akademiku</title>
    <!-- Tambahkan stylesheet dan script Anda di sini -->
    <style>
        /* Tambahkan gaya kustom untuk halaman dashboard */
        body {
            font-family: Arial, sans-serif;
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

        h2 {
            margin-bottom: 20px;
        }

        .welcome-message {
            margin-bottom: 20px;
        }

        .logout-link {
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Instructor Dashboard</h1>
    </header>

    <main>
        <div class="welcome-message">
            <h2>Welcome, <?php echo $instructor; ?>!</h2>
            <!-- Tambahkan pesan selamat datang atau informasi lainnya di sini -->
        </div>

        <!-- Tambahkan konten dashboard lainnya di sini -->

        <div class="logout-link">
            <p><a href="logout.php">Logout</a></p>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Akademiku. All rights reserved.</p>
    </footer>
</body>
</html>
