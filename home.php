<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/home.css">
    <!-- Link to your stylesheets, if any -->
    <title>Home | Akademiku</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="home-container">
        <section class="featured-courses">
            <h2>Featured Courses</h2>
            <div class="course-container">
			<?php
				// Directory path to the thumbnails folder
				$thumbnailFolder = 'thumbnails/';

				// Get all files in the directory and sort by modification time (newest first)
				$thumbnails = scandir($thumbnailFolder, SCANDIR_SORT_DESCENDING);

				// Loop through the first 5 thumbnails
				for ($i = 0; $i < 5 && $i < count($thumbnails); $i++) {
					$thumbnail = $thumbnails[$i];
					$thumbnailPath = $thumbnailFolder . $thumbnail;

					// Display each thumbnail
					echo "<img src=\"$thumbnailPath\" alt=\"Course $i\" class=\"thumbnail\">";
				}
			?>
			</div>

        </section>

        <section class="latest-videos">
            <h2>Sambutan</h2>
            <div class="video-container">
                <!-- Add your video content here -->
                <div class="video">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/rIfrJt57sGg" frameborder="0" allowfullscreen></iframe>
                </div>
                <!-- Add more video content as needed -->
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
