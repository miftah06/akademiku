<!-- contact.php -->

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
            <p>If you have any questions, feel free to reach out to us!</p>
            <form action="submit_contact.php" method="post">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Your Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>
</html>
