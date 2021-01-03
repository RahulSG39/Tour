<?php
    session_start();
    
    $conn = mysqli_connect('localhost','admin','admin1234','Tour');

    if(!$conn){
        echo "Connection Error".mysqli_connect_error();
    }

    $sql = "SELECT * FROM tbltourpackages";

    $result = mysqli_query($conn, $sql);

    $packages = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    if(isset($_POST['search_sub'])){
        $packages2 = [];
        $search_text = $_POST['search_box'];
        foreach($packages as $package){
            if($search_text != ""){
                if($package['PackageName'] === $search_text){
                    array_push($packages2, $package);
                }
            }
        }
        if($search_text != ""){
            $packages = $packages2;
        }
    }


    mysqli_free_result($result);

    mysqli_close($conn);

?>


<!DOCTYPE html>
<html lang="en">
<?php include('./includes/header.php'); ?>
    <link rel="stylesheet" href="CSS/packages.css" />
    <div class="search">
        <form method="POST">
            <input type="text" name="search_box" placeholder="Search Package..." class="btnn">
            <input type="submit" name="search_sub" value="Search" class="btnn">
            <input type="reset" value="Clear">
        </form>
    </div>
    <?php foreach($packages as $package){ ?>
        <div class="package">
            <div class="card">
                <div class="card-img">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode( $package['PackageImage']); ?>" width='475' height='400' />
                </div>
                <div class="right-div">
                    <h1><?php print_r($package['PackageName']); ?></h1>
                    <a href="package.php?pkgid=<?php echo $package['PackageId']; ?>">Click for more info!</a>
                </div>
            </div>         
        </div>
    <?php } ?>
</body>
</html> 
