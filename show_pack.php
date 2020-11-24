<?php
session_start();
    $conn = mysqli_connect('localhost','admin','admin1234','tour');

    if(!$conn){
        echo "Connection Error".mysqli_connect_error();
    }

    $sql = "SELECT package FROM tblbooking WHERE UserEmail = '{$_SESSION['email']}'";

    $result = mysqli_query($conn, $sql);

    $packages = mysqli_fetch_all($result,MYSQLI_ASSOC);

    $tours = array();
    foreach($packages as $package=>$pack){
        foreach($pack as $p){
            array_push($tours,$p);

        }
    }
    $tours = array_unique($tours);

    if(isset($_POST["logout"])){
        session_unset();
        session_destroy();
        header('Location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include('./includes/header.php'); ?>
    <h1>Cart</h1>
    <link rel="stylesheet" href="CSS/show_pack.css" />
    <?php foreach($tours as $tour){ ?>
        <div class="package">
            <div class="card">
                <?php echo $tour; ?>
            </div>         
        </div>
    <?php } ?>
    <form action="" method="POST">
        <input type="submit" name="logout" id="" value="Logout" />
    </form>
</body>
</html>