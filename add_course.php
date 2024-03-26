<?php
session_start();

// Include database connection and header file
include 'db_connect.php';
include 'header.php';

// Directory to upload files
$thumbnailUploadDir = 'thumbnails/';
$courseMaterialUploadDir = 'assets/pdf/';

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

// Handle form submission to add course to the list
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $courseName = $_POST['course_name'] ?? '';
    $description = $_POST['description'] ?? '';
    $courseVideo = $_POST['course_video'] ?? '';
    $courseText = $_POST['course_text'] ?? '';
    $instructions = $_POST['instructions'] ?? '';

    // Check if all required fields are filled
    if (empty($courseName) || empty($description) || empty($courseText) || empty($instructions)) {
        echo "All fields are required.";
        exit();
    }

    // Upload thumbnail file
    if (!empty($_FILES['thumbnail']['name'])) {
        $thumbnailFileName = basename($_FILES['thumbnail']['name']);
        $thumbnailUploadPath = $thumbnailUploadDir . $thumbnailFileName;
        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnailUploadPath)) {
            echo "Thumbnail uploaded successfully!<br>";
        } else {
            echo "Failed to upload thumbnail file.<br>";
            exit();
        }
    } else {
        echo "Thumbnail file is required.<br>";
        exit();
    }

    // Upload course material file
    if (!empty($_FILES['course_material']['name'])) {
        $courseMaterialFileName = basename($_FILES['course_material']['name']);
        $courseMaterialUploadPath = $courseMaterialUploadDir . $courseMaterialFileName;
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
    <h2>Add New Course</h2>
    <form action="add_course.php" method="post" enctype="multipart/form-data">
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
        <label for="thumbnail">Thumbnail (Image):</label>
        <input type="file" id="thumbnail" name="thumbnail" accept="image/*" required><br>
        <label for="course_material">Course Material (PDF):</label>
        <input type="file" id="course_material" name="course_material" accept=".pdf" required><br>
        <button type="submit">Add New Course</button>
    </form>
</body>
</html>
