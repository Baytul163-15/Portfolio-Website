<?php
    include "header.php"; 
    include("class/adminBack.php");
    $obj_admin = new adminBack();

    #category_display
    $show_cat = $obj_admin->display_category();

    #insert_post
    if (isset($_POST['post_submit'])) {
        $post_add = $obj_admin->post_added($_POST);
    }
?>

  <div id="admin-content">
      <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <h1 class="admin-heading">Add New Post</h1>
             </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form -->
                  <form  action="" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="post_title">Title</label>
                          <input type="text" name="post_title" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="postdesc" class="form-control" rows="5"  required></textarea>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Category</label>
                          <select name="category" class="form-control">
                                <option disabled selected> Select Category</option>
                              <?php
                                while ($cat_show = mysqli_fetch_assoc($show_cat)) {
                              ?>
                                <option value="<?php echo $cat_show['category_id'] ?>"><?php echo $cat_show['category_name'] ?></option>
                              <?php } ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Post image</label>
                          <input type="file" name="fileToUpload" class="form-control" required>
                      </div>
                      <input type="submit" name="post_submit" class="btn btn-block btn-primary" value="Add Post" required />
                  </form>
                  <!--/Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
