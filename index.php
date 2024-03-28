<!DOCTYPE html>
<html lang="en">
<head>
	 <?php include 'header.php'; ?> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademiku</title>
    <link rel="stylesheet" href="styles.css"> <!-- Menggunakan file eksternal CSS untuk gaya -->
</head>
<body>
    <main>
        <div class="container">
            <h2>Welcome to Akademiku</h2>
	    <p> Silahkan hubungi admin di t.me/izmiftah untuk mendapatkan token/akun login untuk akses materi akademiku</p>
            <div class="thumbnails">
                <?php
                    // Include login.php for login/logout functionality
                    include 'login.php';
                    // Function to generate thumbnails and promotional videos
                    function generateCourseContent() {
                        $thumbnailFolder = 'assets/thumbnails/';
                        $videoFolder = 'assets/materi_video/';
                        $thumbnailFormat = 'thumbnail_$1.jpg';

                        // Get all files matching the thumbnail format in the folder
                        $thumbnails = glob($thumbnailFolder . $thumbnailFormat);

                        // Generate HTML for each thumbnail and promotional video
                        foreach ($thumbnails as $thumbnail) {
                            $thumbnailName = basename($thumbnail);
                            $courseNumber = preg_replace('/thumbnail_(\d+)\.jpg/', '$1', $thumbnailName);
                            $frontendLink = "frontend/materi.php?course=$courseNumber";
                            $videoSource = $videoFolder . preg_replace('/thumbnail_(\d+)\.jpg/', 'course_$1.mp4', $thumbnailName);

                            echo "<div class='thumbnail'>";
                            echo "<a href=\"$frontendLink\"><img src=\"$thumbnail\" alt=\"Course $courseNumber\"></a>";
                            echo "<video controls>";
                            echo "<source src=\"$videoSource\" type='video/mp4'>";
                            echo "Your browser does not support the video tag.";
                            echo "</video>";
                            echo "</div>";
                        }
                    }

                    // Call the course content generation function
                    generateCourseContent();
                ?>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Akademiku. All rights reserved.</p>
            <?php include 'footer.php'; ?> <!-- Menampilkan komponen footer -->
        </div>
    </footer>
</body>
</html>
