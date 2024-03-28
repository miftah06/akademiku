<?php
session_start();

// Include database connection and header file
include 'db_connect.php';
include 'header.php';

// Function to list all available courses
function listCourses($conn) {
    $files = scandir("frontend");
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) == "html") {
            echo "<option value='$file'>$file</option>";
        }
    }
}

// Initialize $fileContent
$fileContent = "";

// Handle form submission to edit course file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_file'])) {
    $selectedCourse = $_POST['course_file'];
    $filePath = "frontend/" . $selectedCourse;

    // Read content of the selected course file
    $fileContent = file_get_contents($filePath);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course Material</title>
    <link rel="stylesheet" href="styles.css"> <!-- Tautan ke file CSS -->
    <style>
        /* Styling untuk textarea */
        #code-editor {
            width: 100%;
            height: 400px;
            border: 1px solid #ccc;
            padding: 10px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <header>
        <h1>Edit Course Material</h1>
    </header>
    <main>
        <form action="edit_course.php" method="post">
            <label for="course_file">Select Course:</label>
            <select name="course_file" id="course_file" onchange="previewCourse()">
                <?php listCourses($conn); ?>
            </select>
            <button type="submit">Preview Course Material</button>
        </form>
        <hr>
        <section>
            <h2>File Content:</h2>
            <textarea id="code-editor" name="code-editor"><?php echo htmlspecialchars($fileContent); ?></textarea>
        </section>
        <section class="actions">
            <button onclick="saveChanges()">Save Changes</button>
        </section>
    </main>

    <script>
        // Function to preview the selected course
        function previewCourse() {
            var selectedCourse = document.getElementById("course_file").value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("code-editor").value = this.responseText;
                }
            };
            xhttp.open("POST", "edit_course.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("course_file=" + selectedCourse);
        }

        // Function to save changes made to the course
        function saveChanges() {
            var selectedCourse = document.getElementById("course_file").value;
            var content = document.getElementById("code-editor").value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert("Changes saved successfully!");
                }
            };
            xhttp.open("POST", "save_course.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("course_file=" + selectedCourse + "&content=" + encodeURIComponent(content));
        }
    </script>
</body>
</html>
