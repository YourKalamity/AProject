<!DOCTYPE html>
<html>

<head>
  <title>Register</title>
  <link rel="stylesheet" type="text/css" href="css/register.css?rnd=@Function.SessionID" />
  <link rel="stylesheet" href="css/login.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>
  <div class="container">
    <div class="prompt-container">
      <h1>Register for an AProject account!</h1>
      <form method="post">
        <input type="text" name="username" id="username" placeholder="Username" required />
        <input type="email" name="email" id="email" placeholder="Email" required />
        <input type="password" name="password" id="password" placeholder="Password" required />
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required />
        <input type="submit" name="register" value="Register" />
      </form>

      <?php
      require_once "config.php";
      if (isset($_POST["register"])) {
        // Check if the username already exists in the database
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        // Connect to the database
        $db = mysqli_connect($host, $username, $password, $dbname);
        if (!$db) {
          die("Connection failed: " . mysqli_connect_error());
        }

        // Check if username already exists
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) > 0) {
          echo "<p class='error-message'>Username already exists</p>";
          exit();
        }

        // Check if email already exists
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) > 0) {
          echo "<p class='error-message'>Email already exists</p>";
          exit();
        }

        // Check if password and confirm_password match
        if ($password !== $confirm_password) {
          echo "<p class='error-message'>Passwords do not match</p>";
          exit();
        }

        // If there are no errors, hash the password and add user to database
        if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);
          $stmt = mysqli_prepare($db, "INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
          mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
          mysqli_stmt_execute($stmt);
        
          // Redirect to login page with success message
          header("Location: login.php?success=1");
          exit;
        }
        

      }
      ?>
      <span>Already have an account? <a href="login.php">Log in</a></span>
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