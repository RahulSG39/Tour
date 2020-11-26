<?php
session_start();
$email = $_SESSION["email"];
$pid = intval($_GET['pkgid']);

$conn = mysqli_connect('localhost','admin','admin1234','tour');

if(!$conn){
    echo "Connection Error".mysqli_connect_error();
}


$sql1 = "SELECT * FROM tbltourpackages WHERE PackageId= $pid";

$result1 = mysqli_query($conn, $sql1);

$packages = mysqli_fetch_all($result1, MYSQLI_ASSOC);

$package_name = $packages[0]['PackageName'];
$package_price = $packages[0]['PackagePrice'];
$package_details = $packages[0]['PackageDetails'];
$package_image = $packages[0]['PackageImage'];

$set = 0;

if(isset($_POST['sub'])){
    $conn = mysqli_connect('localhost','admin','admin1234','tour');

    if(!$conn){
        echo "Connection Error".mysqli_connect_error();
    }

    $sql = "INSERT INTO tblbooking (UserEmail,package) VALUE ('{$_SESSION["email"]}','{$package_name}')";

    $set =1;

    $result = mysqli_query($conn, $sql);
}
if(isset($_POST['sub2'])){
    mysqli_close($conn);
    header('Location: show_pack.php');
}

?>

<!DOCTYPE html>
<html lang="en">
    <?php include('./includes/header.php'); ?>
    <link rel="stylesheet" href="CSS/package.css" />
    <?php if($set == 1){ ?>
        <p style="background-color: lightgreen; padding: 10px;"><i class="fa fa-check"></i>Added Successfully</p>  
    <?php }  ?>
    <div class="container1">
        <form method="POST">
            <h1><?php echo $package_name; ?></h1>
            <div class="card-img">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($package_image); ?>" width='475' height='400' />
            </div>
            <h4>About The Place</h4>
            <p><?php echo $package_details; ?></p>
            <h2><span class="price-font">Price:</span> INR <span class="price"><?php echo $package_price; ?></span></h2>
            <div class="btns">
                <input type="submit" name="sub" id="" value="Book Now" />
                <input type="submit" name="sub2" id="" value="Go To Cart" />
            </div>
        </form>
    </div>
    
</body>
</html>