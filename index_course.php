<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login_admin.php");
    exit();
}

include 'db_connect.php';
include 'header.php';

// Function to ensure directory exists with specific permissions
function ensureDirectory($directory) {
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true); // Change permission accordingly
        chmod($directory, 0755); // Change permission accordingly
    }
}

// Function to convert video link to iframe
function convertVideoLinkToIframe($videoLink) {
    // Pattern to match YouTube and Vimeo links
    $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/|vimeo\.com\/(?:\w*\/videos\/)?)([\w\-]{11}|\d+)/';

    // Check if video link matches pattern
    if (preg_match($pattern, $videoLink, $matches)) {
        // If YouTube link
        if (strpos($videoLink, 'youtube') !== false) {
            $videoId = $matches[1];
            return "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/$videoId\" frameborder=\"0\" allowfullscreen></iframe>";
        }
        // If Vimeo link
        elseif (strpos($videoLink, 'vimeo') !== false) {
            $videoId = $matches[1];
            return "<iframe src=\"https://player.vimeo.com/video/$videoId\" width=\"560\" height=\"315\" frameborder=\"0\" allowfullscreen></iframe>";
        }
    }

    // Return original link if not matched
    return "<a href=\"$videoLink\">$videoLink</a>";
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
    $thumbnailDirectory = '../thumbnails/';
    $courseMaterialDirectory = '../assets/pdf/';

    // Ensure directories exist with specific permissions
    ensureDirectory($thumbnailDirectory);
    ensureDirectory($courseMaterialDirectory);

    // Handle file uploads
    $thumbnailFileName = basename($_FILES['thumbnail']['name']);
    $thumbnailUploadPath = $thumbnailDirectory . $thumbnailFileName;
    if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnailUploadPath)) {
        // File uploaded successfully
    } else {
        // Failed to upload file
        $error_message = "Failed to upload thumbnail file.";
    }

    $courseMaterialFileName = basename($_FILES['course_material']['name']);
    $courseMaterialUploadPath = $courseMaterialDirectory . $courseMaterialFileName;
    if (move_uploaded_file($_FILES['course_material']['tmp_name'], $courseMaterialUploadPath)) {
        // File uploaded successfully
    } else {
        // Failed to upload file
        $error_message = "Failed to upload course material file.";
    }

    // Convert video link to iframe
    $courseVideo = convertVideoLinkToIframe($courseVideo);

    // Create file materi_$nama_course.php
    $fileName = "materi_$courseName.html";
    $filePath = "frontend/$fileName";
    $fileContent = <<<EOD
<?php
// File Materi: $courseName
// Deskripsi: $description
// Video: $courseVideo
// Text: $courseText
// Instruksi: $instructions
// Thumbnail: $thumbnailFileName
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

        .thumbnail-container {
            margin-top: 20px;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .thumbnail {
            display: block;
            width: 100%;
            height: auto;
            transition: transform 0.3s;
        }

        .thumbnail:hover {
            transform: scale(1.05);
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars("\$courseName"); ?></title>
    <link rel="stylesheet" href="materi.css"> <!-- Tautan ke file CSS -->
</head>
<body>
    <h1>$courseName</h1>
    <p><strong>Deskripsi:</strong> $description</p>
    <p><strong>Video:</strong><a href="$courseVideo</a>$courseVideo</p>
    <p><strong>Penjelasan:</strong> $courseText</p>
    <p><strong>Instruksi:</strong> $instructions</p>
    <p><strong>Thumbnail:</strong> <img src="$thumbnailUploadPath" alt="Thumbnail"></p>
    <p><strong>Materi PDF:</strong> <a href="$courseMaterialUploadPath">$courseMaterialFileName</a></p>
</body>
</html>


EOD;

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
    <title>Create Course</title>
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

        form {
            margin-top: 20px;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"], textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="file"] {
            margin-top: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create New Course</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <?php if(isset($error_message)) echo "<p class='error-message'>$error_message</p>"; ?>
            <label for="course_name">Course Name:</label>
            <input type="text" id="course_name" name="course_name" required>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="course_video">Course Video (Embed Link) contoh: https://www.youtube.com/embed/rIfrJt57sGg :</label>
            <input type="text" id="course_video" name="course_video" required>

            <label for="thumbnail">Thumbnail (Image):</label>
            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" required>

            <label for="course_material">Course Material (PDF):</label>
            <input type="file" id="course_material" name="course_material" accept=".pdf" required>

            <label for="course_text">Course Text:</label>
            <textarea id="course_text" name="course_text" rows="6" required></textarea>

            <label for="instructions">Instructions:</label>
            <textarea id="instructions" name="instructions" rows="6" required></textarea>

            <input type="submit" value="Create Course">
        </form>
    </div>
</body>
</html>
