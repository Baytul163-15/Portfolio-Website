<?php 
  include "header.php"; 
  include("class/adminBack.php");
  $obj_admin = new adminBack();

  #Authentication
  if ($_SESSION['users_role'] == 0) {
    header("Location: posts.php");
  }

  #Display_all_user.
  $user_data = $obj_admin->display_user();

  #Delete User
  if (isset($_GET['status'])) {
    $user_id = $_GET['id'];
    if ($_GET['status'] == 'delete') {
      $user_info = $obj_admin->delete_user($user_id);
    }
  }

  #pagination
  $number_of_page = $obj_admin->pagination_number();

?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Users</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-user.php">add user</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>SI NO.</th>
                        <th>DB ID</th>
                        <th>Full Name</th>
                        <th>User Name</th>
                        <th>Role</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>

                        <?php 
                          $serial = 0;
                          while ($row = mysqli_fetch_assoc($user_data)) {
                        ?>
                              <tr><td class='id'><?php echo $serial++; ?></td>
                              <td class='id'><?php echo $row['user_id'] ?></td>
                              <td><?php echo $row['user_first_name']." ".$row['user_last_name'] ?></td>
                              <td><?php echo $row['username'] ?></td>
                              <td>
                                <?php
                                  if ($row['user_role'] == 1) {
                                    echo "Moderator";
                                  }elseif($row['user_role'] == 2){
                                    echo "Admin";
                                  }else{
                                    echo "Normal user";
                                  }
                                ?>
                              </td>
                              <td class='edit'><a href='update-user.php?status=edit&&id=<?php echo $row['user_id'] ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a onclick="return confirm('Are You Sure to delete?')" href='?status=delete&&id=<?php echo $row['user_id'] ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                      <?php } ?>
                    </tbody>
                </table>
                <?php
                  #pagination 
                  $limit = 5;
                  if (isset($_GET['page'])) {
                      $page_number = $_GET['page'];
                  }else{
                      $page_number = 1;
                  }
                  $offset = ($page_number - 1) * $limit;


                  echo "<ul class='pagination admin-pagination'>";
                  if ($page_number > 1) {
                    echo '<li><a href="users.php?page='.($page_number-1).'">pre</a></li>';
                  }
                  for ($i = 1; $i <= $number_of_page; $i++) { 
                    if ($i == $page_number) {
                      $active = "active";
                    }else{
                      $active = "";
                    }
                    echo '<li class='.$active.'><a href="users.php?page='.$i.'">'.$i.'</a></li>';
                  }
                  if ($number_of_page > $page_number) {
                    echo '<li><a href="users.php?page='.($page_number+1).'">next</a></li>';
                  }
                  
                  echo "</ul>";
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>