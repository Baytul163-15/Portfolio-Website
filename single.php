<?php
    include 'header.php'; 
    include("admin/class/adminBack.php");
    $obj_client = new adminBack();

    #Get_single_post
    if (isset($_GET['status'])) {
        $post_ids = $_GET['id'];
        if ($_GET['status'] == 'single') {
            $post_data = $obj_client->get_single_data($post_ids);
        }
    }
?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                  <!-- post-container -->
                    <?php while ($data = mysqli_fetch_assoc($post_data)) { ?>
                        <div class="post-container">
                            <div class="post-content single-post">
                                <h3><?php echo $data['post_title']; ?></h3>
                                <div class="post-information">
                                    <span>
                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                        <a href="category.php?status=single&&cid=<?php echo $data['post_category']; ?>"><?php echo $data['category_name']; ?></a>
                                    </span>
                                    <span>
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <a href='author.php?author_id=<?php echo $data['post_author']; ?>'><?php echo $data['username']; ?></a>
                                    </span>
                                    <span>
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        <?php echo $data['post_date']; ?>
                                    </span>
                                </div>
                                <img class="single-feature-image" src="admin/upload/<?php echo $data['post_img']; ?>" alt=""/>
                                <p class="description">
                                    <?php echo $data['post_description']; ?> 
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
