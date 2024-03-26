<!-- e-learning.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Platform</title>
    <!-- Include your stylesheets and scripts here -->

    <style>
        /* Add your custom styles for the e-learning page */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #495057;
        }

        header {
            background-color: #343a40;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        main {
            padding: 20px;
        }

        .course-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .course-card {
            background-color: #fff;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .course-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-bottom: 1px solid #e1e1e1;
        }

        .course-info {
            padding: 10px;
        }

        .course-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .course-description {
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <header>
        <h1>E-Learning Platform</h1>
        <?php
            // Include login.php for login/logout functionality
            include 'login_form.php';
        ?>
    </header>

    <main>
        <h2>Explore Courses</h2>
        <div class="course-list">
            <?php
                // Assume $courses is an array of course data fetched from the database
                foreach ($courses as $course) {
                    echo '<div class="course-card">';
                    echo '<img src="' . $course['thumbnail'] . '" alt="' . $course['title'] . '">';
                    echo '<div class="course-info">';
                    echo '<h3 class="course-title">' . $course['title'] . '</h3>';
                    echo '<p class="course-description">' . $course['description'] . '</p>';
                    echo '<a href="course_detail.php?course_id=' . $course['id'] . '">View Details</a>';
                    echo '</div>';
                    echo '</div>';
                }
            ?>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> E-Learning Platform. All rights reserved.</p>
    </footer>
</body>
</html>
