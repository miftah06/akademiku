<?php
session_start();

// Handle form submission to save course file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_file']) && isset($_POST['content'])) {
    $courseFile = $_POST['course_file'];
    $content = $_POST['content'];
    $filePath = "frontend/" . $courseFile;

    // Menyimpan perubahan ke dalam file
    if (file_put_contents($filePath, $content) !== false) {
        echo "Changes saved successfully!";
    } else {
        echo "Failed to save changes.";
    }
} else {
    echo "Invalid request.";
}
?>
