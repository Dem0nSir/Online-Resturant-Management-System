<?php include('partials/menu.php')  ?>

<?php
//check id is set or not
    if(isset($_GET['id']))
    {
        //get the id and all other details
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_category WHERE id = $id";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);

        if($count == 1){
            //get the data
            $row = mysqli_fetch_assoc($result);
            $title = $row['title'];
            $current_image = $row['image_name'];
            $featured = $row['featured'];
            $active = $row['active'];
        }
        else{
            //rediect it to manage category 
            $_SESSION['no-category-found'] ="<div class='error'>Category not Found</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
    }
    else
    {
        //redirect to manage category
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title;  ?>"></td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image != "")
                            {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                echo "<div class='error'>Image not added.</div>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured == "Yes"){ echo "Checked"; } ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No"){ echo "Checked"; } ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                    <input <?php if($active=="Yes"){ echo "Checked"; } ?>   type="radio" name="active" value="Yes">Yes
                    <input <?php if($active=="No"){ echo "Checked"; } ?>   type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" >
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <?php

            if(isset($_POST['submit']))
            {
                //echo "clicked";
                //get all the value from our form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //updating new image if selected
                
                if(isset($_FILES['image']['name']))
                {
                    //get image detail
                    $image_name = $_FILES['image']['name'];

                    //check image is availabe or not
                    if($image_name != "")
                    {
                        //image availabe
                        //upload the new image
                        //auto rename our image
                        //get the extension of image
                        $ext = end(explode('.', $image_name)); 
                        $image_name = "Food_category_".rand(000,999).'.'.$ext;

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        $upload = move_uploaded_file($source_path,$destination_path);

                        //check image is uploadded or not
                        if($upload == false)
                        {
                            $_SESSION['upload'] = "<div class='error'>Failed to upload the image.</div>";
                            header('loacton:'.SITEURL.'admin/manage-category.php');
                            die();
                        }
                        //remove the current image if available
                        if($current_image != "")
                        {
                            $remove_path = "../images/category/".$current_image;
                            $remove =unlink($remove_path);
                            //check wheather the image is removed or not
                            //of failed to remove then display messahe and stop the process
                            if($remove==false){
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            die();
                             } 
                        }
                    }
                    else
                        {
                            $image_name = $current_image;
                        }
               
                }
                else
                {
                    $image_name = $current_image;
                }
               
                //update the database
                $sql2 = "UPDATE tbl_category SET
                    title='$title',
                    image_name = '$image_name',
                    featured ='$featured',
                    active = '$active'
                    WHERE id = $id
                
                ";
                $result2 = mysqli_query($conn,$sql2);
                if($result2 == true)
                {
                    //category updated
                    $_SESSION['update'] = "<div class='success'>Category updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //Failed to update category
                    $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                
                //redirect to manage category with message
            }
        ?>




    </div>
</div>



<?php include('partials/footer.php')  ?>
