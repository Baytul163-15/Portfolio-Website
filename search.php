<?php
    include 'header.php';
    include("admin/class/adminBack.php");
    $obj_client = new adminBack(); 

    #Pagignation_search
    if (isset($_GET['search'])) {
        $auth_id = $_GET['search'];
        $page = $obj_client->suarch_pagination_number($auth_id);
    }

    #search_result_data
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $post = $obj_client->search_result_data($auth_id);
    }

    #author_name_show
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $search_data = $obj_client->search_result_name($search);
    } 
?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <h2 class="page-heading">Search:<?php echo $search ?></h2>
                    <?php while ($post_data = mysqli_fetch_assoc($post)) { ?>
                        <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php?status=single&&id=<?php echo $post_data['post_id']; ?>"><img src="admin/upload/<?php echo $post_data['post_img']; ?>" alt=""/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?status=single&&id=<?php echo $post_data['post_id']; ?>'><?php echo $post_data['post_title']; ?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php?status=single&&cid=<?php echo $post_data['post_category']; ?>'><?php echo $post_data['category_name']; ?></a> 
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php?author_id=<?php echo $post_data['post_author']; ?>'><?php echo $post_data['username']; ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $post_data['post_date']; ?>
                                            </span>
                                        </div>
                                        <p class="description">
                                            <?php echo substr($post_data['post_description'], 0,150)."....." ?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?status=single&&id=<?php echo $post_data['post_id']; ?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
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
                            echo '<li><a href="search.php?search='.$search.'&page='.($page_number-1).'">pre</a></li>';
                        }
                        for ($i = 1; $i <= $page; $i++) { 
                            if ($i == $page_number) {
                            $active = "active";
                            }else{
                            $active = "";
                            }
                            echo '<li class='.$active.'><a href="search.php?search='.$search.'&page='.$i.'">'.$i.'</a></li>';
                        }
                        if ($page > $page_number) {
                            echo '<li><a href="search.php?search='.$search.'&page='.($page_number+1).'">next</a></li>';
                        }               
                        echo "</ul>";
                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
