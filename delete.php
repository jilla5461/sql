​<?php
include "user.php";
if (isset($_GET['id'])) {
    $stu_id = $_GET['id'];
    $sql = "DELETE FROM cap WHERE id ='$stu_id'";
     $result = $conn->query($sql);
     if ($result == TRUE) {
        echo "Record deleted successfully.";
        header('Location: view.php');
    }else{
        echo "Error:" . $sql . "<br>" . $conn->error;
    }
}
