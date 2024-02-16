<?php
session_start();

// Check if user is authenticated
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

// Check if project ID is set in the URL
if (!isset($_GET['pid'])) {
  header('Location: edit_project.php');
  exit();
}

// Include the config file
require_once "config.php";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare data for update
$title = $_POST['project_name'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$phase = $_POST['dev_phase'];
$description = $_POST['project_description'];
$pid = $_GET['pid'];
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

// Check if the user is the owner of the project
$project_query = "SELECT * FROM projects WHERE pid='$pid' AND uid='$uid'";
$project_result = $conn->query($project_query);

if (!$project_result) {
  die("Error checking ownership of project: " . $conn->error);
}

if ($project_result->num_rows == 0) {
  die("You do not have permission to edit this project");
}

// Check if there are changes in the data
$changes_query = "SELECT * FROM projects WHERE pid='$pid' AND title='$title' AND start_date='$start_date' AND end_date='$end_date' AND phase='$phase' AND description='$description'";
$changes_result = $conn->query($changes_query);

if (!$changes_result) {
  die("Error checking for changes: " . $conn->error);
}

if ($changes_result->num_rows == 1) {
  // No changes were made
  header('Location: logged_in.php?updated=0');
  exit();
}

// Update data in projects table
$update_query = "UPDATE projects SET title='$title', start_date='$start_date', end_date='$end_date', phase='$phase', description='$description' WHERE pid='$pid' AND uid='$uid'";

if ($conn->query($update_query) === TRUE) {
  // Redirect to success page
  header('Location: logged_in.php?updated=1');
  exit();
} else {
  die("Error updating project data: " . $conn->error);
}

?>