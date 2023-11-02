<?php  
   include('../config/constants.php');



    if(isset($_GET['id']) and isset($_GET['image_name']))
    {
        //process to delete
        //get id and image name
       $id = $_GET['id'];
        $image_name = $_GET['image name'];
       // echo "process to delete";
   


        //remove the imgae if availabe
        if($image_name!="")
        {
            //it has image and need to remobe the image
            //get the img path
            $path ="../images/food/".$image_name;

            $remove = unlink($path);
            if($remove == false)
            {
                $_SESSION['upload']="<div class='error'>Failes to remove image file.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                die();
            }
        }

        //dlt food from db
        //redirect to manage food with message
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        $result = mysqli_query($conn,$sql);
        if($result == true)
        {
            //food deleted
            $_SESSION['delete']="<div class='success'>Food Deleted Successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //failed to delete food
            $_SESSION['delete']="<div class='error'>Failed to delete food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }

        
        
    }
    else
    {
        //redirect to manage food page
        $_SESSION['unauthorize']="<div class='error'>Unauthorized access</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>