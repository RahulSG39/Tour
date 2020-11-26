<?php
    session_start();
    $id_name = $_GET['id_name'];
    $conn1 = mysqli_connect('localhost','admin','admin1234','tour');
    if(!$conn1){
        echo "Connection Error".mysqli_connect_error();
    }
    echo $id_name;
    $sql2 = "DELETE FROM tblbooking WHERE package = '{$id_name}' AND UserEmail = '{$_SESSION['email']}'";
    $result2 = mysqli_query($conn1, $sql2);
    header('Location: show_pack.php');
?>