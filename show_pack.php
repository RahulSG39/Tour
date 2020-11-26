<?php
session_start();    
$conn = mysqli_connect('localhost','admin','admin1234','tour');

    if(!$conn){
        echo "Connection Error".mysqli_connect_error();
    }

    $sql = "SELECT package FROM tblbooking WHERE UserEmail = '{$_SESSION['email']}'";

    $result = mysqli_query($conn, $sql);

    $packages = mysqli_fetch_all($result,MYSQLI_ASSOC);

    $set=0;

    if(mysqli_num_rows(mysqli_query($conn, $sql))==0){
        $set =1;
    }

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
<?php include('INCLUDES/header.php'); ?>
   <h1 class="first-head">Cart</h1>
    <?php if($set==1)
        {
            echo "<p style='color: white; background-color: gray ;padding: 40px; width: 60%; margin: auto; text-align: center; font-size: 1.5rem;'>Cart Empty</p>";
        }
    ?>
    <link rel="stylesheet" href="CSS/show_pack.css" />
    <?php 
    foreach($tours as $tour){ ?>
        <div class="package">
            <div class="card">
            <form action="" method="POST">
                    <?php echo $tour; ?>
                    <a href="delete.php?id_name=<?php echo $tour;?>"><i class="fa fa-times"></i></a>
            </form>
            </div>         
        </div>
    <?php } ?>


    <form action="" method="POST">
        <input type="submit" name="logout" id="" value="Logout" />
    </form>
</body>
</html>