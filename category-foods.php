
<?php include('partials-front/menu.php'); ?>

<?php

    //check wehather id is passed or not
    if(isset($_GET['category_id']))
    {
        //category id is set and get the id
        $category_id = $_GET['category_id'];

        $sql = "SELECT * FROM tbl_category WHERE id=$category_id";
        $result = mysqli_query($conn,$sql);
        
        $row = mysqli_fetch_assoc($result);

        $category_title=$row['title'];
    }
    
    else
    {
        //category not passed and refirect to home page
        header('location:'.SITEURL);
    }
    
?>
    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            <?php
                //create sql t get food based on selected db
                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";
                $result2 = mysqli_query($conn,$sql2);
                $count2 = mysqli_num_rows($result2);
                if($count2 > 0)
                {
                    //food is availabe
                    while($row2=mysqli_fetch_assoc($result2))
                    {
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];
                        ?>
                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php
                                      if($image_name =="")
                                      {
                                          //image not availabae
                                          echo"<div class='error'>Image NOt Availabe</div>";
                                      }
                                      else
                                      {
                                          ?>
                                           <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
  
                                          <?php
                                      }

                                    ?>
                                    
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo $title; ?></h4>
                                    <p class="food-price"><?php echo $price; ?></p>
                                    <p class="food-detail">
                                    <?php echo $description; ?>
                                    </p>
                                    <br>

                                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>

                        <?php
                    }
                }
                else
                {
                    //food not availabe
                    echo "<div class='error'>Food not Availabe.</div>";
                }

            ?>



          

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php');  ?>