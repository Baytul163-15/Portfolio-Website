<?php include "header.php"; ?>
<?php
    include("class/adminBack.php");
    $obj_admin = new adminBack();
    
    //Insert User
    if (isset($_POST['submit'])) {
        $add_user = $obj_admin->add_user_data($_POST);
    }
?>

  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading text-center">Add User</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form  action="<?php $_SERVER['PHP_SELF'] ?>" method ="POST" autocomplete="off">
                      <?php
                        if (isset($add_user)) {
                            echo $add_user;
                        }
                      ?>  
                      <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                      </div>
                          <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="user" class="form-control" placeholder="Username" required>
                      </div>

                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control" placeholder="Password" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role">
                              <option value="0">Normal User</option>
                              <option value="1">Moderator</option>
                              <option value="2">Admin</option>
                          </select>
                      </div>
                      <input type="submit"  name="submit" class="btn btn-primary btn-block" value="Add User" required />
                  </form>
                   <!-- Form End-->
               </div>
           </div>
       </div>
   </div>
<?php include "footer.php"; ?>
