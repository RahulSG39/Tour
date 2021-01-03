<?php   
        $set=0;
        if(isset($_POST['sign_in'])){

            $conn = mysqli_connect('localhost','admin','admin1234','tour');
    
            if(!$conn){
                echo "Connection Error".mysqli_connect_error();
            }
            $login_email = $_POST['login_email'];
            $login_password = $_POST['login_password'];
    
            $sql1 = "SELECT * FROM tblusers WHERE EmailId = '$login_email' AND Password = '$login_password'";
    
            if (mysqli_num_rows(mysqli_query($conn, $sql1)) > 0) {
                $_SESSION["email"] = $_POST["login_email"];
                header('Location: packages.php');
            } else {
                $set = 1;           
            }
    
        }
?>


<!DOCTYPE html>
<html>
    <?php include('./INCLUDES/header.php'); ?>
    <?php if($set ==1 ){
        echo "<p style='background-color: #CD5C5C; padding: 10px;'>Invalid Credentials, Try again!</p>"; 
    }?>
    <link rel="stylesheet" href="./CSS/Reg_Sign.css" />
    <div class="form-wrap">
        <form method="POST">
            <div id="login" class="login">
                <h1>Login</h1>
                <input type="email" placeholder="Email" name="login_email" />
                <input type="password" placeholder="Password" name="login_password"/>
                <input type="submit" class="signin-btn" name="sign_in" value="Sign in"/>
            </div>
        </form>
    </div>
    
    </body>
</html>