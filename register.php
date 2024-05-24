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
    $username = trim($_POST['username']); // Trim whitespace
    $password = $_POST['password'];
    $email = $_POST['email']; // Add email variable

    // Check if the username already exists
    $check_stmt = $databaseConnection->prepare("SELECT * FROM login WHERE username = ?");
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    if ($check_result->num_rows > 0) {
        echo "Error: Username already exists";
    } else {
        // Prepare and execute query to prevent SQL injection
        $stmt = $databaseConnection->prepare("INSERT INTO login (username, password, email) VALUES (?, ?, ?)");

        // Check for errors in prepare
        if ($stmt === false) {
            die("Error in preparing statement: " . $databaseConnection->error);
        }

        // Bind parameters and execute query
        $stmt->bind_param("sss", $username, $password, $email); // Add email binding
        if ($stmt->execute()) {
            echo "Registration successful"; // Display success message
        } else {
            echo "Error: " . $stmt->error; // Display SQL error if execution fails
        }

        $stmt->close(); // Close statement
    }
    $check_stmt->close(); // Close check statement
}

// Close database connection
$databaseConnection->close();
?>
