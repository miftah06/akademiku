<?php
// Include header or any necessary files
include 'header.php';

// Function to get all course files
function getAllCourseFiles() {
    $courseFiles = glob("frontend/materi_*.php");
    return $courseFiles;
}
// Start the session
session_start();

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// Redirect to login page if user is not logged in
function redirectToLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

// Example usage:
// Panggil fungsi redirectToLogin() di halaman course.php untuk memastikan hanya pengguna terdaftar yang dapat mengaksesnya
// Contoh:
//<?php
require_once('authentication_functions.php');
redirectToLogin();
//
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

        .course-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .course-item {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
            cursor: pointer;
        }

        .thumbnail img {
            width: 100%;
            height: auto;
        }

        .course-content {
            display: none;
            padding: 20px;
        }

        .course-title {
            font-size: 18px;
            margin: 10px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>All Courses</h1>
        <ul class="course-list">
            <?php
            $courseFiles = getAllCourseFiles();
            if (!empty($courseFiles)) {
                foreach ($courseFiles as $courseFile) {
                    #include $courseFile; // Include course content
                    $courseName = basename($courseFile, ".php");
                    $thumbnailPath = "thumbnails/thumbnail_$courseName.jpg";
                    ?>
                    <li class="course-item" onclick="redirectToCourse('<?php echo $courseName; ?>')">
                        <div class="thumbnail">
                            <img src="<?php echo $thumbnailPath; ?>" alt="<?php echo $courseName; ?>">
                        </div>
                        <h2 class="course-title"><?php echo $courseName; ?></h2>
                    </li>
                    <?php
                }
            } else {
                echo "<p>No courses available.</p>";
            }
            ?>
        </ul>
    </div>

    <script>
        function redirectToCourse(courseName) {
            window.location.href = 'frontend/'+ courseName + '.php';
        }
    </script>
</body>
</html>
