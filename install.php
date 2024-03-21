<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit(); // Always add exit() after header() to prevent further execution
}

require_once('user.php');

// Create table if not exists
$car = "CREATE TABLE IF NOT EXISTS cap (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    age INT,
    email VARCHAR(50),
    password VARCHAR(32), -- MD5 hash has 32 characters
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
    
if ($conn->query($car) === TRUE) {
    // echo "Table cap created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    
    // Check if 'password' key exists in $_POST array before accessing it
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate inputs (you may add more validations)
    if (empty($name) || empty($age) || empty($email) || empty($password)) {
        echo "All fields are required.";
    } elseif (!is_numeric($age)) {
        echo "Age must be a valid number.";
    } else {
        // Hash the password using md5()
        $hashed_password = md5($password);

        // Prepare and execute SQL statement
        $stmt = $conn->prepare("INSERT INTO cap(name, age, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $name, $age, $email, $hashed_password);
        if ($stmt->execute()) {
            echo "New record created successfully.";
            // Redirect to a success page or perform further actions
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<title>Student Database</title>
<body>
<h2>Student Form</h2>

  <form method="post">
    <legend>Student information:</legend><br>
    Name:<br>
    <input type="text" name="name"> <br>
    Age:<br>
    <input type="text" name="age"> <br>
    Email:<br>
    <input type="email" name="email"><br>
    Password<br>
    <input type="password" name="password"><br>
    <br><br>
    <input type="submit" name="submit" value="submit">
  </fieldset>
</form>
</body>
</html>

