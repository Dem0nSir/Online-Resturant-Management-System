<?php include('../config/constants.php'); ?>
<html>
    <head>
        <title>Login Food order system</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <div class="login">
            <h1 class="text-center">login</h1>
            <br><br>
            <?php
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                if(isset($_SESSION['no-login-message'])){
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>
            <br><br>
            <form action="" method="post" class="text-center">
                Username:<br>
                <input type="text" name="username" placeholder="Enter username"><br><br>
                Passwood:<br>
                <input type="password" name="password" placeholder="Enter password"><br><br>
                <input type="submit" name="submit" value="submit" class="btn-primary">

            </form>
            <bR><br>
            <p class="text-center">Created by <a href="#">Shopiee Team</a></p>
        </div>
    </body>
</html>
<?php
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password =md5( $_POST['password']);

        $sql = "SELECT * FROM tbl_admin  WHERE username = '$username' AND password = '$password'";
        $result =mysqli_query($conn,$sql);

        $count = mysqli_num_rows($result);
        if($count==1){
            $_SESSION['login'] = "<div class='success'>Login successful.</div>";
            $_SESSION['user'] = $username; //to check user is login out or not and logot willl unset it
            header('location:'.SITEURL.'admin/');
        }
        else{
            $_SESSION['login'] = "<div class='error text-center'>Login failed.</div>";
            header('location:'.SITEURL.'admin/login.php');
        }

       
    }



?>