<?php
session_start();    
$conn = mysqli_connect('localhost','admin','admin1234','tour');

    if(!$conn){
        echo "Connection Error".mysqli_connect_error();
    }

    $sql = "SELECT package FROM tblbooking WHERE UserEmail = '{$_SESSION['email']}'";

    $sql2 = "SELECT PackageId, PackageName, PackagePrice FROM tbltourpackages";

    $result = mysqli_query($conn, $sql);

    $result2 = mysqli_query($conn, $sql2);

    $packages = mysqli_fetch_all($result,MYSQLI_ASSOC);

    $pkgs = mysqli_fetch_all($result2,MYSQLI_ASSOC);


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
            echo "<pre style='color: white; background-color: gray ;padding: 40px; width: 60%; margin: auto; text-align: center; font-size: 1.5rem;'>Cart Empty</pre>";
        }
    ?>
    <link rel="stylesheet" href="CSS/show_pack.css" />
    <?php 
    $total = 0;
    foreach($tours as $tour){
        foreach($pkgs as $pkg=>$p){ 
           if($p["PackageName"] == $tour){
                $total += $p["PackagePrice"]; 
                ?>
                <div class="package">
                    <div class="card">
                    <form action="" method="POST">
                            <a class="tour_name" href="package.php?pkgid=<?php echo $p["PackageId"];?>"><?php echo $tour;?></a>
                            <span class="price"><i class="fas fa-rupee-sign"></i><?php echo number_format($p["PackagePrice"]); ?></span>
                            <a href="delete.php?id_name=<?php echo $tour;?>"><i class="fa fa-times"></i></a>
                    </form>
                    </div>         
                </div>
    <?php 
        } } }
        $_SESSION["total"] = $total;    
    ?>

<span class="total"><h1 class="spanh1">Total: <i class="fas fa-rupee-sign"></i><?php echo number_format($total);?></h1></span>

    <form action="" method="POST">
        <input type="submit" name="logout" id="" value="Logout" />
    </form>
</body>
</html>