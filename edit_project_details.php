<?php
session_start();

// Redirect to login page if user is not authenticated
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// check pid in url
if (!isset($_GET['pid'])) {
    header('Location: edit_project.php');
    exit;
}

// Include the config file
require_once "config.php";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from username
$sql = "SELECT uid FROM users WHERE username = '" . $_SESSION['username'] . "'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$uid = $row['uid'];

// Get project ID from URL
$pid = $_GET['pid'];

// Prepare SQL statement
$sql = "SELECT * FROM projects WHERE pid = " . $pid;
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// check current user is owner of project
if ($row['uid'] != $uid) {
    header('Location: edit_project.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    echo "<title>Edit Project: " . $row["title"] . "</title>";
    ?>
    <link rel="stylesheet" href="css/add_project.css?rnd=@Function.SessionID">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <div class="container">
            <div class="prompt-container">
                <?php
                echo "<h1>Edit Project: " . $row["title"] . "</h1>";
                ?>
                <?php
                echo "<form action=\"edit_project_process.php?pid=" . $pid . "\" method=\"POST\">"
                    ?>
                <?php
                echo "<input type=\"text\" name=\"project_name\" id=\"project_name\" placeholder=\"Project Name...\" value=\"" . $row["title"] . "\" required>";
                echo "<textarea name=\"project_description\" id=\"project_description\" placeholder=\"Project Description...\" value=\"" . $row["description"] . "\"  required></textarea>";
                echo "<label for=\"start_date\">Start Date:</label>";
                echo "<input type=\"date\" name=\"start_date\" id=\"start_date\" value=\"" . $row["start_date"] . "\" required>";
                echo "<label for=\"end_date\">End Date:</label>";
                echo "<input type=\"date\" name=\"end_date\" id=\"end_date\" value=\"" . $row["end_date"] . "\" required>";
                echo "<label for=\"dev_phase\">Current Development Phase:</label>";
                ?>
                <select name="dev_phase" id="dev_phase" required>
                    <option value="" disabled>Select a phase</option>
                    <option value="Design" <?php if ($row["phase"] == "design")
                        echo " selected"; ?>>Design</option>
                    <option value="Development" <?php if ($row["phase"] == "development")
                        echo " selected"; ?>>Development
                    </option>
                    <option value="Testing" <?php if ($row["phase"] == "testing")
                        echo " selected"; ?>>Testing</option>
                    <option value="Deployment" <?php if ($row["phase"] == "deployment")
                        echo " selected"; ?>>Deployment
                    </option>
                    <option value="Complete" <?php if ($row["phase"] == "complete")
                        echo " selected"; ?>>Maintenance
                    </option>
                </select>
                <?php
                echo "<button type=\"submit\">Update \"" . $row["title"] . "\" in database as " . $_SESSION['username'] . ".</button>";
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
        <?php
        echo "document.getElementById('project_description').value = '" . $row["description"] . "';";
        ?>
    </script>
</body>

</html>