<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Database connection parameters
require_once('user.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username, password, and age from the form
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $age = $_POST['age'];

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
            $valid_age = $user['age']; // Get the valid age from the database

            // Verify password and age
            if ($password === $user['password']) {
                echo "Login successful!\n";
                $_SESSION['username'] = $username;
            } else {
                echo "Invalid username or password. Please try again.\n";
            }
        } else {
            echo "User not found.";
        }
    }

    // Close statement
    $stmt->close();
} else {
    // Login attempt code
    $valid_username = "user";
    $valid_password = "password";
    $valid_age = "age";

    $max_attempts = 2;
    $attempts = 0;
    $age_attempts = 0;

    while ($attempts < $max_attempts) {
        $username = readline("Enter username: ");
        $password = readline("Enter password: ");

        if ($username === $valid_username && $password === $valid_password) {
            echo "Login successful! \n";
            break;
        } else {
            $attempts++;
            if ($attempts >= $max_attempts) {
                echo "Maximum attempts reached for username and password. Proceeding to age validation.\n";
                break;
            }
            echo "Invalid username or password. Please try again.\n";
        }
    }

    if ($attempts === $max_attempts) {
        while ($age_attempts < $max_attempts) {
            $age_input = readline("Enter age: ");
            if (intval($age_input) === intval($valid_age)) {
                echo "Login successful! \n";
                break;
            } else {
                $age_attempts++;
                echo "Invalid age. Please try again.\n";
            }
        }

        if ($age_attempts === $max_attempts) {
            echo "You've reached the maximum number of login attempts.\n";
            echo "Here's a valid entry of age: $valid_age\n";
        }
    }
}
?>
