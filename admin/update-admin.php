<?php include('partials/menu.php') ?>

<div class="main_content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php
            //1. Get the id of selected admin
            $id = $_GET['id'];

            //2.create sql querey to get the deatils
            $sql = "SELECT * from tbl_admin where id=$id";
            $result = mysqli_query($conn,$sql);

            if($result == true)
            {
                $count = mysqli_num_rows($result);
                if($count == true){
                    //echo"Admin available";
                    $row = mysqli_fetch_assoc($result);
                    $full_name = $row['full_name'];
                    $username = $row['username'];
                }
                else{
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
        ?>


        <form action="" method="post">
        <table class="tbl-30">
                <tr >
                    <td>Full Name:</td>
                    <td><input type="text" Name="full_name" value="<?php echo $full_name; ?>"></td>
                </tr>
                <tr >
                    <td>Username:</td>
                    <td><input type="text" Name="username" value="<?php echo $username; ?>"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
    if(isset($_POST['submit'])){
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        $sql = "UPDATE tbl_admin SET
        full_name ='$full_name',
        username = '$username'
        where id ='$id';
        ";
        $result = mysqli_query($conn,$sql);
        if($result){
            $_SESSION['update'] = "<div class='success'>Admin Updated Succesfully</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else{
            $_SESSION['update'] = "<div class='error'>Failed to delete admin</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }
?>





<?php include('partials/footer.php') ?>