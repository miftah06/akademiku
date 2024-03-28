<?php
session_start();

// Include header file
include 'header.php';

// Function to list all available courses
function listCourses($directory) {
    $files = scandir($directory);
    $courses = [];
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) == "html") {
            $courses[] = $file;
        }
    }
    return $courses;
}

// Function to delete a course file
function deleteCourse($filePath) {
    if (file_exists($filePath)) {
        unlink($filePath);
        return true;
    }
    return false;
}

// Function to merge course files
function mergeCourses($courseFiles, $outputFileName) {
    $outputFilePath = "frontend/materi_$outputFileName";
    $outputContent = '';
    foreach ($courseFiles as $file) {
        $content = file_get_contents("frontend/$file");
        $outputContent .= $content;
    }
    if (file_put_contents($outputFilePath, $outputContent) !== false) {
        return $outputFileName;
    } else {
        return false;
    }
}

// Handle form submission for deleting a course
if (isset($_POST['delete_course'])) {
    $courseToDelete = $_POST['course_to_delete'];
    $filePathToDelete = "frontend/$courseToDelete";
    if (deleteCourse($filePathToDelete)) {
        echo "Course $courseToDelete has been deleted successfully.";
    } else {
        echo "Failed to delete course $courseToDelete.";
    }
}

// Handle form submission for merging course files
if (isset($_POST['merge_courses'])) {
    $coursesToMerge = $_POST['courses_to_merge'];
    $outputFileName = $_POST['output_file_name'];
    if (!empty($coursesToMerge) && !empty($outputFileName)) {
        if (mergeCourses($coursesToMerge, $outputFileName)) {
            echo "Courses merged successfully. <a href='frontend/$outputFileName'>Download merged file</a>";
        } else {
            echo "Failed to merge courses.";
        }
    } else {
        echo "Please select courses to merge and provide an output file name.";
    }
}

// List available courses
$courseDirectory = "frontend";
$courses = listCourses($courseDirectory);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
</head>
<body>
    <h2>Manage Courses</h2>
    <h3>Delete Course</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="course_to_delete">Select Course to Delete:</label>
        <select name="course_to_delete" id="course_to_delete">
            <?php foreach ($courses as $course) { ?>
                <option value="<?php echo $course; ?>"><?php echo $course; ?></option>
            <?php } ?>
        </select>
        <button type="submit" name="delete_course">Delete Course</button>
    </form>

    <h3>Merge Courses</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="courses_to_merge">Select Courses to Merge:</label><br>
        <select name="courses_to_merge[]" id="courses_to_merge" multiple>
            <?php foreach ($courses as $course) { ?>
                <option value="<?php echo $course; ?>"><?php echo $course; ?></option>
            <?php } ?>
        </select><br>
        <label for="output_file_name">Output File Name:</label>
        <input type="text" id="output_file_name" name="output_file_name" required><br>
        <button type="submit" name="merge_courses">Merge Courses</button>
    </form>
</body>
</html>
