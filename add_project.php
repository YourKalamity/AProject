<?php
session_start();

// Redirect to login page if user is not authenticated
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <link rel="stylesheet" href="css/add_project.css?rnd=@Function.SessionID">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <div class="container">
            <div class="prompt-container">
                <h1>Add a project</h1>
                <form action="add_project_process.php" method="POST">
                    <input type="text" name="project_name" id="project_name" placeholder="Project Name..." required>
                    <textarea name="project_description" id="project_description" placeholder="Project Description..."
                        required></textarea>
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" id="start_date" required>
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" id="end_date" required>
                    <label for="dev_phase">Current Development Phase:</label>
                    <select name="dev_phase" id="dev_phase" required>
                        <option value="" disabled selected>Select a phase</option>
                        <option value="design">Design</option>
                        <option value="development">Development</option>
                        <option value="testing">Testing</option>
                        <option value="deployment">Deployment</option>
                        <option value="complete">Complete</option>
                    </select>
                    <?php
                    echo "<button type=\"submit\">Add Project to database as " . $_SESSION['username'] . ".</button>";
                    ?>

                </form>
            </div>
        </div>
    </main>
    <footer>
        <div class="logo-container">
            <a href="index.php">
                <img src="img/ap.svg" alt="logo">
            </a>
        </div>
        <div class="footer-text">
            <span>©2023 M Kalam | 220064521@aston.ac.uk</span>
        </div>
    </footer>
    <script>
        // Validate start and end dates
        var startDate = document.getElementById('start_date');
        var endDate = document.getElementById('end_date');
        var startChangedOnce = false;

        startDate.addEventListener('change', function () {
            if (!startChangedOnce) {
                endDate.value = startDate.value + 1;
                startChangedOnce = true;
                return;
            }
            if (startDate.value > endDate.value) {
                alert('Start date must be before end date.');
                startDate.value = '';
            }
        });
        endDate.addEventListener('change', function () {
            if (startDate.value > endDate.value) {
                alert('End date must be after start date.');
                endDate.value = '';
            }
        });
    </script>
</body>

</html>