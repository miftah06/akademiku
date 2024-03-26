<?php
// Include header or any necessary files
include 'header.php';
session_start();

// Function to get all course files
function getAllCourseFiles() {
    $courseFiles = glob("frontend/materi_*.php");
    return $courseFiles;
}
// Function to verify login credentials
function verifyLogin($username, $password) {
    // Read the contents of akademiku.json
    $file_contents = file_get_contents('akademiku.json');
    // Decode JSON to an associative array
    $data = json_decode($file_contents, true);

    // Check if username exists in the data
    if (isset($data[$username])) {
        // Verify the password
        if ($data[$username]['password'] === $password) {
            return true; // Password match
        }
    }
    return false; // Username or password incorrect
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars($_POST['password']);

    // Verify login credentials
    if (verifyLogin($username, $password)) {
        // Authentication successful, set session variables
        $_SESSION['username'] = $username;
        $_SESSION['expire'] = time() + (3 * 24 * 60 * 60); // Set expiration time to 3 days
        // Redirect to user profile
        header("Location: profile.php");
        exit();
    } else {
        // Authentication failed, display error message
        $error = "Invalid username or password.";
    }
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Display course information
// You can fetch and display course data from your database or file
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
