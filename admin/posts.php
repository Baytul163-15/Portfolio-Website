<?php
    include "header.php";
    include("class/adminBack.php");
    $obj_admin = new adminBack();

    #Display_All_Post_Admin
    $post_data = $obj_admin->display_all_post();

    #Display_All_Post_For_Nomal_user
    $gen_data = $obj_admin->display_all_post_gen();

    #Pagination
    $post_num = $obj_admin->post_pagination_number();

    #Delete_post_and_update_cat
    if (isset($_GET['status'])) {
        $post_data_id = $_GET['id']; 
        $post_cat_id = $_GET['catid'];
        if ($_GET['status'] == 'delete') {
            $del_post = $obj_admin->delete_post($post_data_id,$post_cat_id); 
        }
    }
    
?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Posts</h1>
            </div>
            <div class="col-md-2">
                <a href="add-post.php" class="add-new">Add Post</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>DB ID.</th>
                        <th>IMAGE</th>
                        <th>TITLE</th>
                        <th>CATEGORY</th>
                        <th>DATE</th>
                        <th>AUTHOR</th>
                        <th>EDIT</th>
                        <th>DELETE</th>
                    </thead>
                    <tbody>
                        <?php

                            if ($_SESSION['users_role'] == '2') {
                                while($posts = mysqli_fetch_assoc($post_data)) { 
                        ?>
                           <tr>
                                <td class="id"><?php echo $posts['post_id'] ?></td>
                                <td><img height="40px" width="70px;" src="upload/<?php echo $posts['post_img'] ?>"></td>
                                <td><?php echo $obj_admin->textShorten($posts['post_title'], 30) ?></td>
                                <td><?php echo $posts['category_name'] ?></td>
                                <td><?php echo $posts['post_date'] ?></td>
                                <td><?php echo $posts['username'] ?></td>
                                <td class='edit'><a href='update-post.php?prostatus=edit&&id=<?php echo $posts['post_id'] ?>'><i class="fa fa-edit"></i></a></td>
                                <td class='delete'><a onclick="return confirm('Are you sure to delete?')" href="?status=delete&&id=<?php echo $posts['post_id'] ?>&catid=<?php echo $posts['post_category'] ?>"><i class="fa fa-trash-o"></i></a></td>
                            </tr>
                        <?php } }elseif ($_SESSION['users_role'] == '0') { 
                                    while($posts_gen = mysqli_fetch_assoc($gen_data)) { 
                        ?>
                           <tr>
                                <td class="id"><?php echo $posts_gen['post_id'] ?></td>
                                <td><img height="40px" width="70px;" src="upload/<?php echo $posts_gen['post_img'] ?>"></td>
                                <td><?php echo $obj_admin->textShorten($posts_gen['post_title'], 30) ?></td>
                                <td><?php echo $posts_gen['category_name'] ?></td>
                                <td><?php echo $posts_gen['post_date'] ?></td>
                                <td><?php echo $posts_gen['username'] ?></td>
                                <td class='edit'><a href='update-post.php?prostatus=edit&&id=<?php echo $posts_gen['post_id'] ?>'><i class="fa fa-edit"></i></a></td>
                                <td class='delete'><a onclick="return confirm('Are you sure to delete?')" href="?status=delete&&id=<?php echo $posts_gen['post_id'] ?>&catid=<?php echo $posts_gen['post_category'] ?>"><i class="fa fa-trash-o"></i></a></td>
                            </tr>
                        <?php } } ?>  
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
                    echo '<li><a href="posts.php?page='.($page_number-1).'">pre</a></li>';
                  }
                  for ($i = 1; $i <= $post_num; $i++) { 
                    if ($i == $page_number) {
                      $active = "active";
                    }else{
                      $active = "";
                    }
                    echo '<li class='.$active.'><a href="posts.php?page='.$i.'">'.$i.'</a></li>';
                  }
                  if ($post_num > $page_number) {
                    echo '<li><a href="posts.php?page='.($page_number+1).'">next</a></li>';
                  }               
                  echo "</ul>";
                ?>
            </div>
        </div>   
    </div>
</div>


<?php include "footer.php"; ?>  
