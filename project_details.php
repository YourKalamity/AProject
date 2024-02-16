<?php

// Include the config file
require_once "config.php";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$pid = $_GET['pid'];
$sql = "SELECT * FROM projects WHERE pid=$pid";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$sql2 = "SELECT * FROM users WHERE uid=$row[uid]";
$result2 = mysqli_query($conn, $sql2);
$userRow = mysqli_fetch_assoc($result2);

// close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <link rel="stylesheet" href="css/project-details.css?rnd=@Function.SessionID">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container" style="text-align: left;">
        <div class="prompt-container">
            <h1 style="text-align: center;">
                <?php echo $row["title"]; ?>
            </h1>
            <h2>
                <?php echo $row["description"]; ?>
                </h3>
                <br>
                <h3><strong>Submitted by :</strong>
                    <?php echo $userRow["username"]; ?>
            </h2>
            <h3><strong>E-Mail :</strong>
                <?php echo $userRow["email"]; ?>
            </h3>
            <h3><strong>Phase :</strong>
                <?php echo $row["phase"]; ?>
            </h3>
            <br>
            <p>
                <?php echo $row["start_date"] . " to " . $row["end_date"]; ?>
            </p>
            <button class="button" onclick="window.location.href='view_projects.php'">Back</button>
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