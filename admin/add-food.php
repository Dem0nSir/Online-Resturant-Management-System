<?php include('partials/menu.php')?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>
        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>


        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" >
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
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
                                        $id = $row['id'];
                                        $title =$row['title'];
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
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
                                //2. Display ondropdown


                            ?>
                            
                        </select>
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
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            if(isset($_POST['submit']))
            {
              //  1. get the data from the form
                $title = $_POST['title'];
                $description =$_POST['description'];
                $price=$_POST['price'];
                $category=$_POST['category'];

                if(isset($_POST['featured']))
                {
                    $featured=$_POST['featured'];
                }
                else
                {
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active=$_POST['active'];
                }
                else
                {
                    $active= "No";
                }
            
              //2. upload the image if selected
                //check wheather the select image is clicked or not and upload the image only if the image is selected
                if(isset($_FILES['image']['name']))
                {
                    //get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    //check wheather the image is selected or not and upload image only if selected
                    if($image_name!="")
                    {
                        //image is sleected
                        //a. rename the image
                        //get the extension of slected image(.jpg,png,gif,etc.)
                        $ext = end(explode('.',$image_name));

                        //create new image name for image
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext;

                        //b.upload the imagge
                        //get the souce path and destination path
                        $src = $_FILES['image']['tmp_name'];

                        $dst = "../images/food/".$image_name;
                        //finally upload the food image
                        $upload = move_uploaded_file($src,$dst);

                        //check wheather it is uploaded or not
                        if($upload == false)
                        {
                            //failes to upload the image
                            //rediect to add food page with error message and stop the process
                            $_SESSION['upload']="<div class='error'>Failes to upload the image.</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            die();
                        }


                    }

                }
                else
                {
                    $image_name = "";
                }

              //3. insert into database
                $sql2 = "INSERT INTO tbl_food SET 
                    title = '$title',
                    description ='$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured ='$featured',
                    active = '$active'
                    ";

                $result2 = mysqli_query($conn,$sql2);
                if($result2 == true)
                {
                    $_SESSION['add']="<div class='success'>Food added successfully</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    $_SESSION['add']="<div class='error'>Failed to Add Food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
              //4. redirect the message to manage food page
            }
        ?>
    </div>
</div>


<?php include('partials/footer.php')?>