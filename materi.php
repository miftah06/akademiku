<?php
// Include header or any necessary files
include 'header.php';

// Function to get all course files
function getAllCourseFiles() {
    $courseFiles = glob("frontend/materi_*.php");
    return $courseFiles;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Courses</title>
    <style>
        /* Add your custom styles for the Course page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }

        .course {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .course-content {
            padding: 20px;
        }

        .course-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .course-description {
            margin-bottom: 10px;
        }

        .thumbnail img {
            width: 100%;
            height: auto;
        }

        .pdf-link {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: blue;
            text-decoration: none;
        }

        .pdf-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>All Courses</h1>
        <?php
        $courseFiles = getAllCourseFiles();
        if (!empty($courseFiles)) {
            foreach ($courseFiles as $courseFile) {
                include $courseFile; // Include course content
                $courseName = basename($courseFile, ".php");
                $thumbnailPath = "thumbnails/thumbnail_$courseName.jpg";
                $pdfPath = "assets/pdf/course_$courseName.pdf";
                ?>
                <div class="course">
                    <div class="thumbnail">
                        <img src="<?php echo $thumbnailPath; ?>" alt="<?php echo $courseName; ?>">
                    </div>
                    <div class="course-content">
                        <h2 class="course-title"><?php echo $courseName; ?></h2>
                        <?php if (isset($description)): ?>
                            <p class="course-description"><?php echo $description; ?></p>
                        <?php else: ?>
                            <p class="course-description">No description available.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No courses available.</p>";
        }
        ?>
    </div>
</body>
</html>
