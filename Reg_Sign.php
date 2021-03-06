<?php
    session_start();
    $email=$name=$uname=$password='';
    $errors = array('email' => '', 'name' => '', 'password' => '', 'confirm_password' => '');
    $set=0;

    if(isset($_POST['log'])){
        header('Location: login.php');
    }

    if(isset($_POST['reg'])){

        $conn = mysqli_connect('localhost','admin','admin1234','tour');

        if(!$conn){
            echo "Connection Error".mysqli_connect_error();
        }
    
        $password = $_POST['password'];
        $email = $_POST['email'];

        $duplicate=mysqli_query($conn,"SELECT * FROM tblusers WHERE EmailId='$email'");
        if (mysqli_num_rows($duplicate)>0)
        {
            $errors['email'] = "Email id already exists.";
        }
        else{
                if(empty($_POST['email'])){
                $errors['email'] = 'An email is required';
            } else{
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $errors['email'] = 'Email must be a valid email address';
                }
            }
        }

        if(empty($_POST['name'])){
            $errors['name'] = 'A name is required';
        } else{
            $name = $_POST['name'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $name)){
                $errors['name'] = 'Name must be letters and spaces only';
            }
        }

 


        if(empty($_POST['password'] || $_POST['password'] )){
            $errors['password'] = 'A password is required';
        } else{
            $password = $_POST['password'];
            if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{6,12}$/', $password)) {
                $errors['password'] = 'the password does not meet the requirements!';
            }
        }

        if(empty($_POST['confirm_password'])){
            $errors['confirm_password'] = 'A password is required';
        } else{
            $confirm_password = $_POST['confirm_password'];
            if($confirm_password != $password){
                $errors['confirm_password'] = 'Passwords do not match';
            }
        }


        if(array_filter($errors)){
            echo 'errors in form';
        } else {
            $conn = mysqli_connect('localhost','admin','admin1234','tour');

            if(!$conn){
                echo "Connection Error".mysqli_connect_error();
            }

            $to_email = $email;
            $subject = "Welcome to TMS";
            $body = "Hi, Welcome $name ! This is a simple project to showcase the functionalities of MySQL and PHP. :) Enjoy!";
            $headers = "From: rahulgirish39@gmail.com";
    
            if (mail($to_email, $subject, $body, $headers)) {
            ?>
                <script>
                    alert("A mail has been sent to <?php echo $to_email; ?>...");
                </script>
    
            <?php
    
            } else {
                echo "Email sending failed...";
            }


            $sql = "INSERT INTO tblusers(FullName, EmailId, Password) VALUES('$name','$email','$password')";

            if (mysqli_query($conn, $sql)) {
                echo "<p id='success_para'>Success! Please login</p>";
            ?>
            <script>
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        alert("Working");
                        document.getElementById('success_para').style.backgroundColor = "lightgreen";
                        document.getElementById('success_para').style.padding = "5px";
                    }
                };
                xhttp.open("GET", "Reg_Sign.php", true);
                xhttp.send(null);
            
            </script>


            <?php    
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            
            mysqli_close($conn);
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
            <div class="btns">
                <div class="btns-style">
                    <button class="reg-page-btn" onclick="signup()">Sign Up</button>
                </div>
            </div>
      <form method="POST">
        <div id="reg" class="reg">
          <h1>Register</h1>
          <input type="text" placeholder="Name" name="name"/><?php echo $errors['name']?>
          <input type="email" placeholder="Email" name="email" /><?php echo $errors['email']?>
          <input type="password" placeholder="Password" name="password" /><?php echo $errors['password']?>
          <input type="password" placeholder="Confirm Password" name="confirm_password"/><?php echo $errors['confirm_password']?>
          <input type="submit" class="reg-btn" value="Sign Up" name="reg"/>
          <input type="submit" class="log" name="log" value="Log In">
        </div>
      </form>

    </div>

    <script>
        var x = document.getElementById("reg");
        var y = document.getElementById("login");

        function signup(event){
            this.event.preventDefault();
            y.style.display = "none";
            x.style.display = "block";
        }
    </script>


  </body>
</html>
