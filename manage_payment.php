<?php
// Include the necessary functions and data handling logic
include_once 'db_connect.php';
include_once 'header.php';

// Placeholder function for fetching payment methods (replace with your actual logic)
function getPaymentMethods($pdo)
{
    try {
        $stmt = $pdo->prepare("SELECT * FROM payment_methods");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database error
        die("Error retrieving payment methods: " . $e->getMessage());
    }
}

// Start the session
session_start();

// Inisialisasi variabel user dan userDetails
$user = "";
$userDetails = array();

// Pastikan session user terdefinisi
if (isset($_SESSION['user'])) {
    // Jika ada, isi variabel user
    $user = $_SESSION['user'];
    // Connect to the database
    $pdo = connectToDatabase();
    // Fetch user information
    $userDetails = getUserDetails($pdo, $user);
} else {
    // Jika tidak ada sesi user, redirect ke halaman login
    header("Location: login_admin.php");
    exit();
}

// Placeholder function for fetching user details (replace with your actual logic)
function getUserDetails($pdo, $user)
{
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$user]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database error
        die("Error retrieving user information: " . $e->getMessage());
    }
}

// Handle form submissions or data management logic here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if it's a payment form submission
    if (isset($_POST['payment_submit'])) {
        // Process payment, update database, etc.
        // Assuming successful payment, you can update the database or handle accordingly

        // Retrieve payment information
        $bankInfo = $_POST['bank_info'];
        $creditInfo = $_POST['credit_info'];

        // Insert payment information into the database
        $insertPaymentMethod = $pdo->prepare("INSERT INTO payment_methods (method, bank_info, credit_info) VALUES (:method, :bank_info, :credit_info)");
        $method = 'Bank Transfer'; // You can change this to match your payment method
        $insertPaymentMethod->bindParam(':method', $method);
        $insertPaymentMethod->bindParam(':bank_info', $bankInfo);
        $insertPaymentMethod->bindParam(':credit_info', $creditInfo);
        $insertPaymentMethod->execute();

        // Redirect to prevent form resubmission on refresh
        header("Location: manage_payment.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payment Methods</title>
    <!-- Include your stylesheets and scripts here -->
    <style>
        /* Add your custom styles for the Manage Payment Methods page */
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

        .user-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .payment-form {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .payment-list {
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
        <h1>Manage Payment Methods</h1>
    </header>

    <main>
        <div class="user-info">
            <h2>Welcome, <?php echo $user; ?>!</h2>
            <?php
                // Display user information
                if ($userDetails) {
                    echo "<p>Email: {$userDetails['email']}</p>";
                    // Add more user details as needed
                } else {
                    echo "<p>Error retrieving user information.</p>";
                }
            ?>
        </div>

		<!-- Payment Form -->
		<div class="payment-form">
			<h2>Add New Payment Method</h2>
			<form method="post">
				<!-- Add input fields for bank information -->
				<label for="bank_info">Bank Information:</label><br>
				<textarea id="bank_info" name="bank_info" rows="4" cols="50"></textarea><br><br>
				
				<!-- Add input fields for credit card information -->
				<label for="credit_card_info">Credit Card Information:</label><br>
				<textarea id="credit_card_info" name="credit_card_info" rows="4" cols="50"></textarea><br><br>
				
				<!-- Add input field for payment instructions -->
				<label for="payment_instructions">Payment Instructions:</label><br>
				<textarea id="payment_instructions" name="payment_instructions" rows="4" cols="50"></textarea><br><br>
				
				<button type="submit">Add Payment Method</button>
			</form>
		</div>

               
			<!-- Payment List -->
			<div class="payment-list">
				<h2>Existing Payment Methods</h2>
				<!-- Include a list or table for displaying existing payment methods -->
				<!-- Fetch and display payment methods from the database -->
				<?php
				$paymentMethods = getPaymentMethods($pdo);
				foreach ($paymentMethods as $method) {
					echo "<div class='payment-method'>";
					echo "<h3>{$method['method']}</h3>";
					echo "<p><strong>Bank Information:</strong> {$method['bank_info']}</p>";
					echo "<p><strong>Credit Card Information:</strong> {$method['credit_card_info']}</p>";
					echo "<p><strong>Payment Instructions:</strong> {$method['payment_instructions']}</p>";
					echo "</div>";
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
