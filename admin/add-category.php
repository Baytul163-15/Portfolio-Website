
<?php include "header.php"; ?>
<?php
    include("class/adminBack.php");
    $obj_admin = new adminBack();
    
    //Insert User
    if (isset($_POST['cat_submit'])) {
        $add_cat = $obj_admin->add_user_category($_POST);
    }
?>


  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add New Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                    <?php
                        if (isset($add_cat)) {
                            echo $add_cat;
                        }
                    ?>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" placeholder="Category Name" required>
                      </div>
                      <input type="submit" name="cat_submit" class="btn btn-block btn-primary" value="Add Category" required />
                  </form>
                  <!-- /Form End -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
