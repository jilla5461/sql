<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Database connection parameters
require_once('user.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // Prepare SQL statement to fetch user from the database
    $sql = "SELECT * FROM cap WHERE name = ?";
    $stmt = $conn->prepare($sql);

    // Check if prepare() succeeded
    if ($stmt === false) {
        die("Error in SQL: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if user exists
    if (empty($username) || empty($password)) {
        echo "Please enter the username and password.";
    } else {
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $valid_password = $user['password']; // Get the valid password from the database
            $valid_age = $user['age']; // Get the valid age from the database

            // Verify password
            if ($password === $valid_password) {
                echo "Login successful!\n";
                $_SESSION['username'] = $username;
            } else {
                // Check if two wrong password attempts have been made
                if (isset($_SESSION['password_attempts']) && $_SESSION['password_attempts'] >= 2) {
                    // Age validation after two wrong password attempts
                    $age_input = $_POST['age'];
                    if (intval($age_input) === intval($valid_age)) {
                        echo "Login successful! \n";
                        $_SESSION['username'] = $username;
                    } else {
                        echo "Invalid age. Please try again.\n";
                    }
                } else {
                    // Increment password attempts
                    $_SESSION['password_attempts'] = isset($_SESSION['password_attempts']) ? $_SESSION['password_attempts'] + 1 : 1;
                    echo "Invalid username or password. Please try again.\n";
                }
            }
        } else {
            echo "User not found.";
        }
    }

    // Close statement
    $stmt->close();
} else {
    // Display login form
    // Note: HTML form code to be inserted here
}
?>
