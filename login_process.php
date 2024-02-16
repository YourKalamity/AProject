<?php

session_start();

// Include the config file
require_once "config.php";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the entered username and password
$username = $_POST['username'];
$password = $_POST['password'];

// Get the hashed password from the database
$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $hashed_password = $row['password'];

    // Verify the entered password against the stored hashed password
    if (password_verify($password, $hashed_password)) {
        // User is authenticated, start a new session and redirect to add_project.php
        $_SESSION['username'] = $username;
        header("Location: logged_in.php");
    } else {
        // User is not authenticated, redirect to login.php with an error message
        header("Location: login.php?error=1");
    }
} else {
    // User is not authenticated, redirect to login.php with an error message
    header("Location: login.php?error=1");
}

mysqli_close($conn);
?>