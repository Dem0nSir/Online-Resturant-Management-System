<?php 
    //include constants.php file here
    include('../config/constants.php');

    
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //mget value and delete
       // echo "get value";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove the physical image file is availabe
        if($image_name != "")
        {
            //image is avaialabe so remove it
            $path = "../images/category/".$image_name;
            //remove the image
            $remove = unlink($path);

            //if failed to remove the image the add an error message and stop the process
            if($remove == false){
                $_SESSION['remove'] = "<div class='error'>Failed to remove the category</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
                //stop the process
                die();
            }

        }
        $sql = "DELETE FROM tbl_category WHERE id = $id";
        $result = mysqli_query($conn,$sql);
        if($result == True)
        {
            $_SESSION['delete'] ="<div class='success'>Category Is Deleted</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else{
            $_SESSION['delete'] ="<div class='error'>Error deleteing the category.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }

        
    }
    else{
        //redirext to manaege category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }

?>