<?php

// Include the config file
require_once "config.php";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get search query, if any
$search_query = isset($_GET['q']) ? $_GET['q'] : '';

// Prepare SQL statement with placeholders
$sql = "SELECT pid, title, start_date FROM projects WHERE title LIKE ? OR start_date LIKE ?";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the parameters to the statement
$search_param = "%$search_query%";
$stmt->bind_param("ss", $search_param, $search_param);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Close the statement and connection
$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Projects</title>
    <link rel="stylesheet" href="css/view_projects.css?rnd=@Function.SessionID">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Click a Project to view</h1>
    </div>
    <div class="search-container">
        <form action="view_projects.php" method="GET">
            <input type="text" name="q" placeholder="Search by title or start date"
                value="<?php echo $search_query; ?>">
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="table-container">
        <table>
            <tr>
                <th>Title</th>
                <th>Start Date</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr onclick=\"location.href='project_details.php?pid=" . $row["pid"] . "'\">";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "<td>" . $row["start_date"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No results found</td></tr>";
            }
            ?>
        </table>
    </div>
    <div class="button-container">
        <button class="button" onclick="window.location.href='index.php'">Back</button>
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