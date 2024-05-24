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
    $username = htmlspecialchars($_POST['username']);
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute query to prevent SQL injection
    $stmt = $databaseConnection->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $message = "";  // Initialize an empty message variable

    if ($result->num_rows > 0) {
        // Username exists, check password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Login successful, set session variables
            $_SESSION["username"] = $username;
            $_SESSION['loggedin'] = true;
            header("Location: home.html?username=" . urlencode($username));  // Redirect with username param
            exit();// Stop script execution after redirection
        } else {

            echo "<script>alert('Invalid credentials. Please try again.');</script>";

        }
    } else {
        // Username does not exist
        $message = "Username not found. Please register.";
    }

    // Close statement
    $stmt->close();

    // Handle message and redirection (combined logic)
    if ($message) {
        echo "<script>
      alert('$message');
      window.location.href='login.php';
    </script>";
    } else {
        // Successful login, no message needed, redirect directly
        header("Location: home.html");
        exit(); // Ensure script stops execution after redirection
    }
}

// Close database connection
$databaseConnection->close();
?>