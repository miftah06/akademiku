<!-- user.php -->

<?php
    // Include the necessary functions and data handling logic
    include_once 'db_connect.php';
    include_once 'fitur.php'; // Sesuaikan dengan nama file yang sesuai

    // Connect to the database
    $pdo = connectToDatabase();

    // Add your additional features and logic here

    // Handle payment logic
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bayar'])) {
        // Implement your payment logic here
        // (e.g., generate QRIS, process payment, update database)

        // For demonstration purposes, assume payment is successful
        $paymentSuccessful = true;

        if ($paymentSuccessful) {
            // Redirect to pesanan.php with a success message
            header("Location: pesanan.php?success=true");
            exit();
        } else {
            // Redirect to gagal_bayar.php with an error message
            header("Location: gagal_bayar.php?error=true");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademiku</title>
    <!-- Include your stylesheets and scripts here -->
    <style>
        /* Add your custom styles for the Materi page */
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

        .payment-form {
            margin-top: 20px;
            text-align: center;
        }

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
	<main>

	<!-- Add your course thumbnails and details here -->
	<?php
		// Directory where thumbnails are stored
		$thumbnailFolder = 'thumbnails/';

		// Get all files matching the thumbnail format in the folder
		$thumbnails = glob($thumbnailFolder . 'thumbnail_*.jpg');

		// Display thumbnails
		foreach ($thumbnails as $thumbnail) {
			$courseNumber = preg_replace('/thumbnail_(\d+)\.jpg/', '$1', basename($thumbnail));
			echo "<img src=\"$thumbnail\" alt=\"Course $courseNumber\" class=\"thumbnail\">";
			// Add more course details as needed
		}
	?>
	
</body>
</html>

<?php
    // Close the database connection (optional, as PHP will automatically close it)
    $pdo = null;
?>
