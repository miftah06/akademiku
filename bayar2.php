<?php
// Include the necessary functions and data handling logic
include 'db_connect.php';

// Check if the user is logged in, otherwise redirect to the login page
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login_form.php");
    exit();
}

// Connect to the database
$pdo = connectToDatabase();

// Fetch user information
$user = $_SESSION['user'];
$userDetails = getUserDetails($pdo, $user);

// Handle payment form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle payment logic here (replace with your actual payment processing code)

    // Placeholder function for generating a payment token
    $paymentToken = generateToken();

    // Check if the payment was successful
    if ($paymentToken !== false) {
        // Redirect to successful payment page with the generated token
        header("Location: successful_payment.php?token=$paymentToken");
        exit();
    } else {
        // Redirect to failed payment page
        header("Location: failed_payment.php");
        exit();
    }
}

// Placeholder function for generating a payment token (replace with your actual logic)
function generateToken()
{
    // Implement your token generation logic here
    // Example: Generate a random token for the payment
    return bin2hex(random_bytes(16));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php
        // Include the viewport meta tag using the "from" function
        echo from('<meta name="viewport" content="width=device-width, initial-scale=1.0">');
    ?>
    <title>Bayar</title>
    <!-- Include your stylesheets and scripts here -->
    <style>
        /* Add your custom styles for the Bayar page */
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

        .payment-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Bayar</h1>
        <?php
            // Display the username and logout link
            echo "<p>Welcome, $user! <a href='interface.php?logout'>Logout</a></p>";
        ?>
    </header>

    <main>
        <div class="payment-form">
            <h2>Payment Information</h2>
            <?php
                // Display user information
                if ($userDetails) {
                    echo "<p>User: {$userDetails['username']}</p>";
                    echo "<p>Email: {$userDetails['email']}</p>";
                    // Add more user details as needed
                } else {
                    echo "<p>Error retrieving user information.</p>";
                }
            ?>

            <!-- Add your payment form here -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!-- Add your payment form fields here (e.g., card details, amount, etc.) -->
                <button type="submit">Pay Now</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Akademiku. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
    // Close the database connection (optional, as PHP will automatically close it)
    $pdo = null;
?>
