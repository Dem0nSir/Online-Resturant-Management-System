<?php 
    //include constants.php file here
    include('../config/constants.php');


    //1. get the id of admin to be deleted
    echo $id = $_GET['id'];

    //2. Create SQL Query to delete Admin
    $sql = "DELETE FROM tbl_admin where id = $id";

    $result = mysqli_query($conn,$sql);
    if($result == true){
       // echo"Admin Deleted";
        //create session variable to display message
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";

        header('location:'.SITEURL.'admin/manage-admin.php');

    }
    else{
       // echo"Failed to Delete Admin";
       $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin.</div>";
       header('location:'.SITEURL.'admin/manage-admin.php');
    }

    //3.Redirect to manage Admin page with message(success/error)

?>