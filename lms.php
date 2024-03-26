<!-- lms.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Management System (LMS)</title>
    <!-- Include your stylesheets and scripts here -->

    <style>
        /* Add your custom styles for the LMS page */
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

        .thumbnail-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .thumbnail-item {
            margin: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: calc(33.33% - 20px); /* Adjust width based on your design */
        }

        .thumbnail img {
            width: 100%;
            height: auto;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            overflow: hidden;
            margin-top: 10px;
        }

        .video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Learning Management System (LMS)</h1>
    </header>

    <main>
        <h2>Available Courses</h2>
        <ul class="thumbnail-list">
            <?php
                // Function to generate thumbnails and promotional videos
                function generateCourseContent() {
                    $courseFiles = glob("frontend/materi_*.php");

                    // Generate HTML for each course
                    foreach ($courseFiles as $courseFile) {
                        $courseName = basename($courseFile, ".php");
                        $thumbnailPath = "assets/thumbnails/thumbnail_$courseName.jpg";
                        $videoPath = "assets/materi_video/course_$courseName.mp4";
                        ?>
                        <li class="thumbnail-item">
                            <a href="<?php echo $courseFile; ?>">
                                <img src="<?php echo $thumbnailPath; ?>" alt="<?php echo $courseName; ?>" class="thumbnail">
                            </a>
                        </li>
                        <?php
                    }
                }

                // Call the course content generation function
                generateCourseContent();
            ?>
        </ul>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Akademiku. All rights reserved.</p>
    </footer>
</body>
</html>
