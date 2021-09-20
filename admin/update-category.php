<?php include "header.php"; 
  include("class/adminBack.php");
  $obj_admin = new adminBack();

  #Edit_category
  if (isset($_GET['status'])) {
     $cat_userid = $_GET['id'];
     if ($_GET['status'] == 'edit') {
        $cat_edit = $obj_admin->category_edit($cat_userid);
     }
  }

  #Update_category.
  if (isset($_POST['u_submit'])) {
    $cat_up = $obj_admin->category_update($_POST);
  }

  #Authentication
  if ($_SESSION['users_role'] == 0) {
    header("Location: posts.php");
  } 

?>

  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading text-center"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <form action="<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="u_category_id"  class="form-control" value="<?php echo $cat_edit['category_id'] ?>" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="u_category_name" class="form-control" value="<?php echo $cat_edit['category_name'] ?>"  placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Post Number</label>
                          <input type="text" name="cat_post" class="form-control" value="<?php echo $cat_edit['post'] ?>" placeholder="" required>
                      </div>
                      <input type="submit" name="u_submit" class="btn btn-block btn-primary" value="Update" required />
                  </form>
                </div>
            </div>
        </div>
  </div>
<?php include "footer.php"; ?>
