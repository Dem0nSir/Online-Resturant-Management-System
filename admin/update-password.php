<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>
        <?php
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }
        ?>
        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Current Password:</td>
                    <td><input type="password" name="current_password" placeholder="Enter current password"></td>
                </tr>
                <tr>
                    <td>New Password:</td>
                    <td><input type="password" name="new_password" placeholder="Enter new password"></td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td><input type="password" name="confirm_password" placeholder="Enter Confirm password"></td>
                </tr>
                <tr colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                </tr>
            </table>

        </form>
    </div>
</div>
<?php
    if(isset($_POST['submit'])){
        //1. get the data from the server
        $id=$_POST['id'];
        $current_password =md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);
        //2. check whether the user with current id and current password exist or not
        $sql = "SELECT * FROM tbl_admin WHERE id = $id AND password = '$current_password'";
        $result = mysqli_query($conn,$sql);
        if($result == true){
            $count=mysqli_num_rows($result);
            if($count == 1){
                //user exist and change password
                //echo"user found";
                if($new_password == $confirm_password){
                    $sql2 = "UPDATE tbl_admin SET
                        password = '$new_password'
                        WHERE id = $id;
                        ";
                    $result2=mysqli_query($conn,$sql2);

                    if($result2 == true){
                        $_SESSION['change-pwd']= "<div class='success'>Password chnaged Successfully</div>";

                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                    else{
                        $_SESSION['change-pwd']= "<div class='error'>Failed to change Password</div>";

                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else{
                    $_SESSION['user-not-found']= "<div class='error'>Password Did Not Match.</div>";

                    header('location:'.SITEURL.'admin/manage-admin.php');
                } 
                }
            }
            else
            {
                //user doesnt exist and redirect
                $_SESSION['user-not-found']= "<div class='error'>User Not Found..</div>";

                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        //3. check whether the new password and confirm password match or not

        //4. change password if all above is true
    
?>




<?php include('partials/footer.php'); ?>