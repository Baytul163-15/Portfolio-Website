
<?php
    include "header.php";
    include("class/adminBack.php");
    $obj_admin = new adminBack();

    #Authentication
    if ($_SESSION['users_role'] == 0) {
        header("Location: posts.php");
      }

    #Edit_User.
    if (isset($_GET['status'])) {
        $user_id = $_GET['id']; 
        if ($_GET['status'] == 'edit') {
            $get_user_data = $obj_admin->user_edit($user_id);
        }
    }

    #User update
    if (isset($_POST['u_submit'])) {
        $update_data = $obj_admin->user_update($_POST);
    }

?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading text-center">Update User</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form Start -->
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                    <div class="form-group">
                        <input type="hidden" name="u_user_id"  class="form-control" value="<?php echo $get_user_data['user_id'] ?>">
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="u_fname" class="form-control" value="<?php echo $get_user_data['user_first_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="u_lname" class="form-control" value="<?php echo $get_user_data['user_last_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>User Name</label>
                        <input type="text" name="u_user" class="form-control" value="<?php echo $get_user_data['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>User Role</label>
                        <select class="form-control" name="u_role" value="<?php echo $get_user_data['user_role']; ?>">
                            <?php
                                if ($get_user_data['user_role'] == 1) {
                                    echo "<option value='0'>Normal User</option>";
                                    echo "<option value='1' selected >Moderator</option>";
                                    echo "<option value='2'>Admin</option>";
                                }elseif($get_user_data['user_role'] == 2){
                                    echo "<option value='0'>Normal User</option>";
                                    echo "<option value='1'>Moderator</option>";
                                    echo "<option value='2' selected >Admin</option>";
                                }else{
                                    echo "<option value='0' selected >Normal User</option>";
                                    echo "<option value='1'>Moderator</option>";
                                    echo "<option value='2'>Admin</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <input type="submit" name="u_submit" class="btn btn-primary btn-block" value="Update User" required />
                </form>
                <!-- Form End-->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
