<?php
// Include the necessary functions and data handling logic
include 'db_connect.php';
include_once 'db_guests_connect.php';

// Check if the user is logged in, otherwise redirect to the login page
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login_form.php");
    exit();
}

// Connect to the database
$pdo = connectToDatabase();

// Handle PayPal payment process
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle PayPal payment logic here
    // This is just a placeholder

    // For example, you can generate a PayPal payment link and redirect the user to it
    $paymentLink = generatePayPalPaymentLink();
    if ($paymentLink !== false) {
        // Redirect the user to the PayPal payment page
        header("Location: $paymentLink");
        exit();
    } else {
        // Handle payment failure
        // You can display an error message or redirect to a failure page
        header("Location: payment_failure.php");
        exit();
    }
}
// Include PayPal SDK
require 'paypal/autoload.php';

// Replace these variables with your PayPal sandbox credentials
$client_id = 'YOUR_PAYPAL_CLIENT_ID';
$client_secret = 'YOUR_PAYPAL_CLIENT_SECRET';

// Set up PayPal API context
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential($client_id, $client_secret)
);

// Create PayPal payment
$payment = new \PayPal\Api\Payment();
$payment->setIntent('sale')
    ->setPayer(new \PayPal\Api\Payer(['payment_method' => 'paypal']))
    ->setTransactions([
        (new \PayPal\Api\Transaction())
            ->setAmount(new \PayPal\Api\Amount(['total' => '10.00', 'currency' => 'USD']))
            ->setDescription('Description of the payment')
    ])
    ->setRedirectUrls((new \PayPal\Api\RedirectUrls())
        ->setReturnUrl('http://yourwebsite.com/execute_payment.php?success=true')
        ->setCancelUrl('http://yourwebsite.com/execute_payment.php?success=false'));

try {
    $payment->create($apiContext);
    // Get PayPal approval link
    $approvalUrl = $payment->getApprovalLink();
    // Redirect user to PayPal for payment approval
    header("Location: $approvalUrl");
    exit();
} catch (\PayPal\Exception\PayPalConnectionException $ex) {
    echo "PayPal Error: " . $ex->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Payment Process</title>
    <!-- Add your stylesheets and scripts here -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>PayPal Payment Process</h1>
        <?php
            // Display the username and logout link
            echo "<p>Welcome! <a href='logout.php'>Logout</a></p>";
        ?>
    </header>

    <main>
        <div class="payment-form">
            <h2>Payment Information</h2>

            <!-- Add your PayPal payment form here -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!-- Add your PayPal payment form fields here -->
                <button type="submit">Proceed to PayPal</button>
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
