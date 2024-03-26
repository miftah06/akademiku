<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari formulir
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Alamat tujuan email
    $to = "izharuddinmiftah@gmail.com";

    // Subject email
    $subject = "New Contact Form Submission";

    // Isi pesan email
    $mailMessage = "Name: $name\n";
    $mailMessage .= "Email: $email\n";
    $mailMessage .= "Message:\n$message";

    // Header email
    $headers = "From: $email";

    // Kirim email
    $mailSuccess = mail($to, $subject, $mailMessage, $headers);

    // Cek apakah pengiriman email berhasil
    if ($mailSuccess) {
        // Jika berhasil, redirect ke halaman sukses
        header("Location: contact_success.php");
        exit;
    } else {
        // Jika gagal, tampilkan pesan error
        $errorMessage = "Sorry, there was an error sending your message.";
    }
} else {
    // Jika bukan metode POST, redirect ke halaman kontak
    header("Location: contact.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Akademiku</title>
    <link rel="stylesheet" href="styles/contact.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <section class="contact-section">
        <div class="contact-container">
            <h2>Contact Us</h2>
            <?php
            if (isset($errorMessage)) {
                echo "<p class='error-message'>$errorMessage</p>";
            } else {
                echo "<p>Your message has been sent successfully. We will get back to you soon!</p>";
            }
            ?>
            <p>Return to <a href="contact.php">Contact Page</a></p>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>
</html>
