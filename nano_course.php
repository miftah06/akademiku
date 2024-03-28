<?php
session_start();

// Include database connection and header file
include 'db_connect.php';
include 'header.php';

// Function to list all available courses
function listCourses($conn) {
    $sql = "SELECT * FROM courses";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['course_name'] . "</option>";
        }
    } else {
        echo "<option value=''>No courses available</option>";
    }
}

// Function to ensure directory exists with specific permissions
function ensureDirectory($directory) {
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true); // Change permission accordingly
        chmod($directory, 0755); // Change permission accordingly
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $courseName = $_POST['course_name'];
    $description = $_POST['description'];
    $courseVideo = $_POST['course_video'];
    $courseText = $_POST['course_text'];
    $instructions = $_POST['instructions'];
    
    // Define upload directories
    $courseMaterialUploadDir = '../assets/pdf/';
    $courseMaterialDirectory = $_SERVER['DOCUMENT_ROOT'] . $courseMaterialUploadDir;

    // Ensure directory exists with specific permissions
    ensureDirectory($courseMaterialDirectory);
    
    // Upload course material file
    if (!empty($_FILES['course_material']['name'])) {
        $courseMaterialFileName = basename($_FILES['course_material']['name']);
        $courseMaterialUploadPath = $courseMaterialDirectory . $courseMaterialFileName;
        if (move_uploaded_file($_FILES['course_material']['tmp_name'], $courseMaterialUploadPath)) {
            echo "Course material uploaded successfully!<br>";
        } else {
            echo "Failed to upload course material file.<br>";
            exit();
        }
    } else {
        echo "Course material file is required.<br>";
        exit();
    }

    // Convert video link to iframe
    $courseVideo = convertVideoLinkToIframe($courseVideo);

    // Create file materi_$nama_course.php
    $fileName = "materi_$courseName.html";
    $filePath = "frontend/$fileName";

    // Check if file exists
    if (file_exists($filePath)) {
        // File exists, append content
        $fileContent = file_get_contents($filePath);
    } else {
        // File doesn't exist, create new content
        $fileContent = '';
    }

    // Append new content
    $newContent = <<<EOD
<?php
// File Materi: $courseName
// Deskripsi: $description
// Video: $courseVideo
// Text: $courseText
// Instruksi: $instructions
// Materi PDF: $courseMaterialFileName
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars("$courseName"); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        p {
            margin-bottom: 10px;
            font-size: 16px;
            line-height: 1.6;
        }

        strong {
            font-weight: bold;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .material-link {
            display: block;
            margin-top: 10px;
            font-size: 16px;
        }

        .material-link i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <h1>$courseName</h1>
    <p><strong>Deskripsi:</strong> $description</p>
    <p><strong>Video:</strong> $courseVideo</p>
    <p><strong>Text:</strong> $courseText</p>
    <p><strong>Instruksi:</strong> $instructions</p>
    <p><strong>Materi PDF:</strong> <a href="$courseMaterialUploadPath">$courseMaterialFileName</a></p>
</body>
</html>
EOD;

    // Append new content to the existing file
    $fileContent .= $newContent;

    // Write content to file
    if (file_put_contents($filePath, $fileContent) !== false) {
        // Redirect to index or any other page
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Failed to create course file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Course</title>
</head>
<body>
    <h2>Edit Course Material</h2>
    <form action="edit_course.php" method="post">
        <label for="course_file">Select Course:</label>
        <select name="course_file" id="course_file">
            <?php
            $files = scandir("frontend");
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) == "html") {
                    echo "<option value='$file'>$file</option>";
                }
            }
            ?>
        </select>
        <button type="submit">Edit Course Material</button>
    </form>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="course_name">Course Name:</label>
        <input type="text" id="course_name" name="course_name" required><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea><br>
        <label for="course_video">Video Link:</label>
        <input type="text" id="course_video" name="course_video"><br>
        <label for="course_text">Course Text:</label>
        <textarea id="course_text" name="course_text" rows="4" required></textarea><br>
        <label for="instructions">Instructions:</label>
        <textarea id="instructions" name="instructions" rows="4" required></textarea><br>
        <label for="course_material">Course Material (PDF):</label>
        <input type="file" id="course_material" name="course_material" accept=".pdf" ><br>
        <button type="submit">Add New Course</button>
    </form>
</body>
</html>
