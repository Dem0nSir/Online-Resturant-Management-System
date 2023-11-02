<?php include('partials/menu.php');?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <?php
            if(isset($_GET['id']))
            {
                //get all the details
                $id = $_GET['id'];

                $sql2 ="SELECT * FROM tbl_food WHERE id = $id";
                $result2 = mysqli_query($conn,$sql2);

                $row2 = mysqli_fetch_assoc($result2);

                //get the individual calues of selected food
                $title = $row2['title'];
                $description = $row2['description'];
                $price = $row2['price'];
                $current_image=$row2['image_name'];
                $current_category=$row2['category_id'];
                $featured=$row2['featured'];
                $active = $row2['active'];
            }
            else
            {
                //redirect to manage food
                header('location:'.SITEURL.'admin/manage-food.php');
            }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
            <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" ><?php echo $description;  ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image == "")
                            {
                                //image not availabe
                                echo "<div class='error'>Image Not Availabe.</div>";
                            }
                            else
                            {
                                //image availabe
                                ?>
                                <img src="<?php echo SITEURL;  ?>images/food/<?php echo $current_image; ?>" alt=""width="100px">
                                <?php
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input type="File" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category" id="">
                            <?php
                                //Create php code to display categories from datebase
                                //1. Create SQL to get all active acategories from database
                                $sql = "SELECT * FROM tbl_category WHERE active ='Yes'";
                                $result = mysqli_query($conn,$sql);
                                $count = mysqli_num_rows($result);
                                if($count > 0)
                                {
                                    //we have categories
                                    while($row=mysqli_fetch_assoc($result))
                                    {
                                        //get the deeatils of the categoies
                                        $category_id = $row['id'];
                                        $category_title =$row['title'];
                                        ?>
                                        <option <?php if($current_category == $category_id){ echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //we donit have categories
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }
                                //2. Display on dropdown


                            ?>
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=="Yes"){ echo "checked";} ?>  type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No"){ echo "checked";} ?>  type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=="Yes"){ echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){ echo "checked";} ?>  type="radio" name="active" value="No">No

                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image"value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
        <?php
            if(isset($_POST['submit']))
            {
                //echo"clicked";
                //1. Get all the deatils from the form
                    $id=$_POST['id'];
                    $title=$_POST['title'];
                    $description=$_POST['description'];
                    $price=$_POST['price'];
                    $current_image=$_POST['current_image'];
                    $category = $_POST['category'];
                    $featured=$_POST['featured'];
                    $active=$_POST['active'];
                //2 upload the imag if selected

                //check wheather upload button is clicked or not
                if(isset($_FILES['image']['name']))
                {
                    //upload button clicked
                    //a. uploading new image
                    $image_name=$_FILES['image']['name'];
                    //check weather the file is available or not
                    if($image_name!="")
                    {
                        //image is availabe
                        //rename the image
                        $ext = end(explode('.',$image_name));

                        $image_name="Food-name-".rand(0000,9999).'.'.$ext; // this will be renamed image

                        //get the source path and destination path
                        $src_path = $_FILES['image']['tmp_name'];
                        $dest_path = "../images/food/".$image_name;
                    
                        $upload = move_uploaded_file($src_path,$dest_path);

                        if($upload == false)
                        {
                            $_SESSION['upload']="<div class='error'>Failes to upload new Image.</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            die();
                        }
                        //3 Remove the image if new image is uploaded and current image exists
                        //b. remove current image IF availabe
                        if($current_image!="")
                        {
                            //current image is availabe
                            //remove the image
                            $remove_path="../images/food/".$current_image;
                            $remove=unlink($remove_path);
                            if($remove==false)
                            {
                                //failed to remove the curent image
                                $_SESSION['remove-failed']="<div class='error'>Failes to remove Image.</div>";
                                header('location:'.SITEURL.'admin/manage-food.php');
                                die();
                            }

                        }

                    }
                    else
                    {
                        $image_name=$current_image;
                    }
                }
                else
                {
                    $image_name=$current_image;
                }

                

                //4 Update the food in database
                $sql3 = "UPDATE tbl_food SET
                    title='$title',
                    description='$description',
                    price= $price,
                    image_name='$image_name',
                    category_id='$category',
                    featured='$featured',
                    active='$active'
                    WHERE id = $id
                    ";
                $result3 = mysqli_query($conn,$sql3);
                if($result3==true)
                {
                    //query executed and food updated
                    $_SESSION['update']="<div class='success'>Food Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to update
                    $_SESSION['update']="<div class='error'>Failes to update food.</div>";
                     header('location:'.SITEURL.'admin/manage-food.php');
                }
                
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php');?>