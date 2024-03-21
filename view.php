<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit(); // Ensure script stops execution after redirection
}

error_reporting(E_ALL);
ini_set('display_errors', '1');
include "user.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Database</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap.min.css">
</head>
<body>

    <div class="container">
        <h2>Student Details</h2>
        <a class="btn btn-warning" href="install.php">Add User</a>
        <a class="btn btn-warning" href="logout.php">logout</a>

        <table id="studentTable" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM cap";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['age']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['password']; ?></td>
                                <td>
                                    <a class="btn btn-info" href="update.php?id=<?php echo $row['id']; ?>">Edit</a>
                                    <a class="btn btn-danger" href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                                </td>
                            </tr>
                <?php       }
                    }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Include jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#studentTable').DataTable();
        });
    </script>
</body>
</html>
