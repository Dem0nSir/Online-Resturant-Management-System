<?php include('../config/constants.php'); ?>
<?php
    
    session_destroy(); //usets $_sessiopn['user']
    
    header('location:'.SITEURL.'admin/login.php');
?>