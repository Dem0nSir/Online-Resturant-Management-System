<?php include('partials/menu.php'); ?>


<div class="main_content">
    <div class="wrapper">
        <br /><br />
        <h1>Add admin</h1>
        <br /><br />
        <?php
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>
        
        <form action="" method="POST">
            <table class="tbl-30">
                <tr >
                    <td>Full Name:</td>
                    <td><input type="text" Name="full_name" placeholder="Enter Your Name"></td>
                </tr>
                <tr >
                    <td>Username:</td>
                    <td><input type="text" Name="username" placeholder="Enter Your Username"></td>
                </tr>
                <tr >
                    <td>Password:</td>
                    <td><input type="password" Name="password" placeholder="Enter Your Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <br /><br /><br />
    </div>
</div>

<?php include('partials/footer.php');?>

<?php
 //process the form and save in db
    if(isset($_POST['submit'])){
        $fullname = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5( $_POST['password']); //password encryption with md5
        
        $sql = "INSERT INTO tbl_admin SET 
            full_name = '$fullname',
            username = '$username',
            password = '$password'
        ";

        $result =mysqli_query($conn,$sql) or die(mysqli_connect_error());

        if($result==true){
                //create a session variable to display message 
                $_SESSION['add']= "Admin Added Successfully";
                //redirect the page to manage admin
                header("location:".SITEURL.'admin/manage-admin.php');

        }
        else{
            //create a session variable to display message 
            $_SESSION['add']= "Failed to Add Admin";
            //redirect the page to manage admin
            header("location:".SITEURL.'admin/add-admin.php');
        }
    }
?>