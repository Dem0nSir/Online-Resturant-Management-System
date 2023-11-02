<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
    <h1>Manage Food</h1>
    <br /><br />
    <!--button to add admin-->
    <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
    <br /><br /><br />
    <?php
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if(isset($_SESSION['delete']))
        {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if(isset($_SESSION['unauthorize']))
        {
            echo $_SESSION['unauthorize'];
            unset($_SESSION['unauthorize']);
        }
        if(isset($_SESSION['update']))
        {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
    ?>
    <table class="tbl-full">
        <tr>
            <th>S.N.</th>
            <th>TItle</th>
            <th>Price</th>
            <th>Image</th>
            <th>Featured</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
        <?php
            //create a swl wuery to get all the food
            $sql = "SELECT * FROM tbl_food";
            $result = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($result);
            $sn=1;
            if($count > 0)
            {
                //we have food in database
                while($row = mysqli_fetch_assoc($result))
                {
                    $id = $row['id'];
                    $title=$row['title'];
                    $price = $row['price'];
                    $image_name=$row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $price; ?></td>
                        <td>
                        <?php 
                            if($image_name=="")
                            {
                                //we do not have imgae display the message
                                echo "<div class='error'>Image Not Added.</div>";
                            }
                            else{
                                //we have image display it
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php  echo $image_name;?>" width="100px">
                                <?php

                            }
                        ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                        <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id;?>" class="btn-secondary">Update Food</a>
                        <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id;?>& image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
                        </td>
                    </tr>
                    <?php
                }
            }
            else
            {
                //we dont have food in databse
                echo"<tr><td colspan='7' class='error'> Food not Added Yet.</td></tr>";
            }
        ?>
        
    </table>
    </div>

</div>

<?php include('partials/footer.php');?>