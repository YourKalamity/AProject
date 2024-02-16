<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/logged_in.css?rnd=@Function.SessionID">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="prompt-container">
            <?php
            if (isset($_GET['added']) && $_GET['added'] == 1) {
                echo "<h1>Project successfully added!</h1>";
            } elseif (isset($_GET['updated']) && $_GET['updated'] == 1) {
                echo "<h1>Project successfully updated!</h1>";
            } elseif (isset($_GET['updated']) && $_GET['updated'] == 0) {
                echo "<h1>No changes were made to project.</h1>";
            } else {
                echo "<h1>Welcome back, " . $_SESSION['username'] . "</h1>";
            }
            ?>
            <div class="button-container">
                <a href="add_project.php" class="button">Add a new project</a>
                <a href="edit_project.php" class="button">Edit your existing project</a>
                <a href="logout.php" class="button">Log out</a>
            </div>
        </div>
    </div>

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

</body>

</html>