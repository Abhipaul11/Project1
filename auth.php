<?php
session_start();

// Database connection details
$host = "localhost";
$user = "root";
$password = "Rudra@06102001";
$db = "php_tourism";

// Create database connection
$databaseConnection = new mysqli($host, $user, $password, $db);

// Check connection
if ($databaseConnection->connect_error) {
  die("Connection failed: " . $databaseConnection->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Prepare and execute query to prevent SQL injection
  $stmt = $databaseConnection->prepare("SELECT * FROM login WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Username exists, check password
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      // Password matches, set session and redirect to home page
      $_SESSION["username"] = $username;
      header("Location: home.html");  // Use header for redirection
      exit(); // Ensure script stops execution after redirection
    } else {
      // Incorrect password
      echo "<script>alert('Invalid credentials. Please try again.');</script>";
    }
  } else {
    // Username does not exist
    echo "<script>alert('Username not found. Please register.');</script>";
  }

  // Close statement
  $stmt->close();
}

// Close database connection
$databaseConnection->close();
?>