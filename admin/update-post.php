<?php include "header.php"; 
    include("class/adminBack.php");
    $obj_admin = new adminBack();

    if($_SESSION['users_role'] == '0'){
      header("location: posts.php");
    }

    #Edit_Post
    if (isset($_GET['prostatus'])) {
        $post_id = $_GET['id'];
        if ($_GET['prostatus'] == 'edit') {
            $post_info = $obj_admin->edit_post($post_id);
        }
    }

    #category_display
    $show_post_cat = $obj_admin->display_post_category();

    #update_post
    if (isset($_POST['u_post_submit'])) {
        $post_upd = $show_cat = $obj_admin->update_post($_POST);
    }
    
?>


<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
        <form  action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="hidden" name="u_post_id"  class="form-control" value="<?php echo $post_info['post_id']; ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="post_title">Title</label>
                <input type="text" name="u_post_title" class="form-control" value="<?php echo $post_info['post_title'] ?>" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="u_postdesc" class="form-control"  required rows="5">
                    <?php echo $post_info['post_description']; ?>
                </textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Category</label>
                <select name="u_category" class="form-control">
                      <option disabled selected> Select Category</option>
                    <?php
                      while ($cat_post = mysqli_fetch_assoc($show_post_cat)) {
                          if ($post_info['post_category'] == $cat_post['category_id']) {
                              $selected = "selected";
                          }else{
                            $selected = "";
                          }
                    ?>
                      <option <?php echo $selected ?> value="<?php echo $cat_post['category_id']; ?>"><?php echo $cat_post['category_name'] ?></option>
                    <?php } ?>
                </select>
                <input type="hidden" name="old_category" value="<?php echo $post_info['post_category'] ?>">
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new_image">
                <img  src="upload/<?php echo $post_info['post_img']; ?>" height="150px" width="250">
                <input type="hidden" name="old_image" value="<?php echo $post_info['post_img']; ?>">
            </div>
            <input type="submit" name="u_post_submit" class="btn btn-block btn-primary" value="Update Post"/>
        </form>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
