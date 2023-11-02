<?php
    //check user is login or not
    if(!isset($_SESSION['user'])) //if user session is not set
    {
        $_SESSION['no-login-message'] = "<div class='error text-center'> Please login to access Admin panel.</div>";
        header('location:'.SITEURL.'admin/login.php');
    }
?>