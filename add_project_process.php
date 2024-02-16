<?php
session_start();

// Check if user is authenticated
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

// Include the config file
require_once "config.php";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare data for insertion
$title = $_POST['project_name'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$phase = $_POST['dev_phase'];
$description = $_POST['project_description'];
$username = $_SESSION['username'];

// Get the user ID for the given username
$user_query = "SELECT uid FROM users WHERE username='$username'";
$user_result = $conn->query($user_query);

if (!$user_result) {
  die("Error getting user ID: " . $conn->error);
}

if ($user_result->num_rows == 0) {
  die("No user found with username: $username");
}

$user_row = $user_result->fetch_assoc();
$uid = $user_row['uid'];

// Insert data into projects table
$insert_query = "INSERT INTO projects (title, start_date, end_date, phase, description, uid) VALUES ('$title', '$start_date', '$end_date', '$phase', '$description', '$uid')";

if ($conn->query($insert_query) === TRUE) {
  // Redirect to success page
  header('Location: logged_in.php?added=1');
  exit();
} else {
  die("Error inserting project data: " . $conn->error);
}

?>