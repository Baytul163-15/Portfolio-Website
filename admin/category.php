<?php
    include "header.php";
    include("class/adminBack.php");
    $obj_admin = new adminBack();

    #Authentication
    if ($_SESSION['users_role'] == 0) {
        header("Location: posts.php");
    }
    
    #category_display
    $show_cat = $obj_admin->display_category();

    #Delete_category.
    if (isset($_GET['status'])) {
        $cat_id = $_GET['id'];
        if ($_GET['status'] == 'delete') {
            $del_cat = $obj_admin->category_deleted($cat_id);
        }
    }

    #pagination
    $page_no = $obj_admin->cat_pagination_number();
?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <?php
                if (isset($del_cat)) {
                    echo $del_cat;
                }
            ?>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php while ($cat_data = mysqli_fetch_assoc($show_cat)) { ?>
                            <tr>
                                <td class='id'><?php echo $cat_data['category_id']; ?></td>
                                <td><?php echo $cat_data['category_name']; ?></td>
                                <td><?php echo $cat_data['post']; ?></td>
                                <td class='edit'><a href='update-category.php?status=edit&&id=<?php echo $cat_data['category_id']; ?>'><i class='fa fa-edit'></i></a></td>
                                <td class='delete'><a onclick="return confirm('Are you sure to delete?')" href='?status=delete&&id=<?php echo $cat_data['category_id']; ?>'><i class='fa fa-trash-o'></i></a></td>
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
                    echo '<li><a href="category.php?page='.($page_number-1).'">pre</a></li>';
                  }
                  for ($i = 1; $i <= $page_no; $i++) { 
                    if ($i == $page_number) {
                      $active = "active";
                    }else{
                      $active = "";
                    }
                    echo '<li class='.$active.'><a href="category.php?page='.$i.'">'.$i.'</a></li>';
                  }
                  if ($page_no > $page_number) {
                    echo '<li><a href="category.php?page='.($page_number+1).'">next</a></li>';
                  }
                  
                  echo "</ul>";
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
