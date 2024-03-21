<?php
include "user.php";
    if (isset($_POST['update'])) {
        $stu_id = $_POST['stu_id'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "UPDATE `cap` SET `name`='$name',`age`='$age',`email`='$email',`password`='$password' WHERE `id`='$stu_id'";
        $result = $conn->query($sql);
        if ($result == TRUE) {
            echo "Record updated successfully.";
            header('Location: view.php');
        }else{
            echo "Error:" . $sql . "<br>" . $conn->error;
        }

    }

if (isset($_GET['id'])) {
    $stu_id = $_GET['id'];
    $sql = "SELECT * FROM cap WHERE id='$stu_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $name = $row['name'];
            $age = $row['age'];
            $email = $row['email'];
            $password = $row['password'];
        }
    ?>

        <h2>Student details Update Form</h2>
        <form action="" method="post">
          <fieldset>
            <legend>Personal information:</legend>
            Name:<br>
            <input type="text" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="stu_id" value="<?php echo $id; ?>">
            <br>
            Age:<br>
            <input type="text" name="age" value="<?php echo $age; ?>">
            <br>
            Email:<br>
            <input type="email" name="email" value="<?php echo $email; ?>">
            <br><br>
            Password:<br>
            <input type="password" name="password" value="<?php echo $password; ?>">
            <br><br>
            <input type="submit" value="Update" name="update">
          </fieldset>
        </form>
        </body>
        </html>


    <?php
    } else{
        header('Location: view.php');
    }
}
?>