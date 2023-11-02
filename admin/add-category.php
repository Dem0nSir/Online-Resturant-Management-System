<?php include('partials/menu.php')  ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>
        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>
       
        <br><br>


        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="category Title"></td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                    <input type="radio" name="active" value="Yes">Yes
                    <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        if(isset($_POST['submit']))
        {
            $title = $_POST['title'];

            //check is button is selected or not
            if(isset($_POST['featured'])){
                $featured = $_POST['featured'];
            }
            else{
                $featured = "No";
            }
            $active = (isset($_POST['active'])) ? $_POST['active'] : "No";
            
            //image is selected or not and set the value for image name accordingly
            //print_r($_FILES['image']);
            
           // die();
           if(isset($_FILES['image']['name']))
           {
              //upload the image
              //to  upload image we need image name, source path and destination path
              $image_name = $_FILES['image']['name'];

              //upload the image only if image is selected
              if($image_name != "")
              {

              
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
                header('loacton:'.SITEURL.'admin/add-category.php');
                die();
              }
            }

           } 
           else
           {
            $image_name = "";
           }




             $sql = "INSERT INTO tbl_category SET
             title='$title',
             image_name='$image_name',
             featured='$featured',
             active='$active'
        ";
        $result = mysqli_query($conn,$sql);
        if($result==true){
            //query executed and category added
          // echo "successfull";
          $_SESSION['add'] = "<div class='success'>Category added succesfully</div>";
          header('location:'.SITEURL.'admin/manage-category.php' );
        }
        else
        {
            //failed to execute
            $_SESSION['add'] = "<div class='error'>Failed too add category</div>";
            header('location:'.SITEURL.'admin/add-category.php' );
            
        
        }
    }

        ?>
    </div>
</div>


<?php include('partials/footer.php')  ?>