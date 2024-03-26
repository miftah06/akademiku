<!-- footer.php -->

<style>

/* footer.css */

.site-footer {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
}

.footer-container {
    max-width: 800px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
}

.footer-section {
    flex: 1;
}

h3 {
    color: #fff;
}

.social-icons {
    display: flex;
    gap: 10px;
}

.social-icon {
    width: 20px;
    height: 20px;
    border-radius: 50%;
}

.copyright {
    text-align: center;
    margin-top: 20px;
    color: #ddd;
}


</style>


<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3>Contact Us</h3>
            <p>Email: info@akademiku.com</p>
            <p>Phone: +1 (123) 456-7890</p>
        </div>

        <div class="footer-section">
            <h3>Follow Us</h3>
            <div class="social-icons">
                <a href="#" target="_blank"><img src="facebook.png" alt="Facebook" class="social-icon"></a>
                <a href="#" target="_blank"><img src="twitter.png" alt="Twitter" class="social-icon"></a>
                <a href="#" target="_blank"><img src="instagram.png" alt="Instagram" class="social-icon"></a>
            </div>
        </div>
    </div>

    <div class="copyright">
        <p>&copy; <?php echo date('Y'); ?> Akademiku. All rights reserved.</p>
    </div>
</footer>
