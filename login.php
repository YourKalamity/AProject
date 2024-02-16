<?php
session_start();

if (isset($_SESSION['username'])) {
    // user is already authenticated, redirect to logged_in.php
    header("Location: logged_in.php");
    exit();
}


if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success_msg = "Your account has been created successfully. Please log in with your new account details.";
} else {
    $success_msg = "";
}

if (isset($_GET['error']) && $_GET['error'] == 1) {
    $error_msg = "Invalid username or password. Please try again.";
} else {
    $error_msg = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css?rnd=@Function.SessionID">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="prompt-container">
            <h1 id="title">Login to your AProject account</h1>
            <?php if ($success_msg !== "") { ?>
                <div class="success-msg">
                    <?php echo $success_msg; ?>
                </div>
            <?php } ?>
            <?php if ($error_msg !== "") { ?>
                <div class="error-msg">
                    <?php echo $error_msg; ?>
                </div>
            <?php } ?>
            <form action="login_process.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="button">Log in</button>
            </form>
            <span>Don't have an account? <a href="register.php">Create one</a></span>
            <br>
            <span>Or return to the home page. <a href="index.php">Home</a></span>
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