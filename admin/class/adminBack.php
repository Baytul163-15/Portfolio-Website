
<?php
    class adminBack
	{
		private $conn;
		
		public function __construct()
		{
			$dbhost = "localhost";
			$dbuser = "root";
			$dbpass = "";
			$dbname = "portfolionews";

			$this->conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

			if (!$this->conn) {
				die("Database connection error !");
			}
		}

        #Login_User.
        function user_login($data){
            $user_name = mysqli_real_escape_string($this->conn, $data['username']);
            $user_password = mysqli_real_escape_string($this->conn, md5($data['password']));

            if (empty($user_name) || empty($user_password)) {
                $msg = "<span style='color:red'>Username and password must not be empty</span>";
                return $msg;
            }else{
                $query = "SELECT user_id,username,user_role,user_first_name,user_last_name FROM user WHERE username = '$user_name' AND user_password = '$user_password' ";
                if (mysqli_query($this->conn, $query)) {
                    $result = mysqli_query($this->conn, $query);
                    $count = mysqli_num_rows($result);

                    if ($count > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            session_start();
                            $_SESSION['users_id'] = $row['user_id'];
                            $_SESSION['users_name'] = $row['username'];
                            $_SESSION['users_role'] = $row['user_role'];

                            header("Location: posts.php");
                        }
                    }
                }else{
                    $msg = "Username and password not match !!";
                    return $msg;
                }
            }
        }

		#textShorten code.
		public function textShorten($text, $limit = 400){
			$text = $text. " ";
			$text = substr($text, 0, $limit);
			$text = substr($text, 0, strrpos($text, ' '));
			$text = $text.".....";
			return $text;
		}

        #insert_user
        function add_user_data($data){
            $fname = mysqli_real_escape_string($this->conn, $data['fname']);
            $lname = mysqli_real_escape_string($this->conn, $data['lname']);
            $user_name = mysqli_real_escape_string($this->conn, $data['user']);
            $password = mysqli_real_escape_string($this->conn, md5($data['password']));
            $user_role = mysqli_real_escape_string($this->conn, $data['role']);

            $query = "SELECT username FROM user WHERE username = '$user_name'";
            if (mysqli_query($this->conn, $query)) {
                $result = mysqli_query($this->conn, $query);
                $count = mysqli_num_rows($result);

                if ($count > 0) {
                    $msg = "<span style='color:red'>Username Already Exists !!</span>";
                    return $msg;
                }else{
                    $insert_query = "INSERT INTO user(user_first_name, user_last_name, username, user_password, user_role)
                    VALUES('$fname','$lname','$user_name','$password','$user_role')";

                    if (mysqli_query($this->conn, $insert_query)) {
                        header("Location: users.php"); 
                    }else{
                        $rtn_msg = "<span style='color:red'>Not inserted !</span>";
                        return $rtn_msg;
                    }
                }
            }
        }

        #Show all user.
        function display_user(){
            #pagination start
            $limit = 5;
            if (isset($_GET['page'])) {
                $page_number = $_GET['page'];
            }else{
                $page_number = 1;
            }
            $offset = ($page_number - 1) * $limit;
            #pagination end

            $query = "SELECT * FROM user ORDER BY user_id DESC LIMIT {$offset},{$limit}";
            if (mysqli_query($this->conn, $query)) {
                $result = mysqli_query($this->conn, $query);
                return $result;
            }
        }

        #User Edit.
        function user_edit($id){
            $query = "SELECT * FROM user WHERE user_id = '$id' ";
            if (mysqli_query($this->conn, $query)) {
                $result = mysqli_query($this->conn, $query);
                $final_data = mysqli_fetch_assoc($result);
                return $final_data;
            }
        }

        #Delete User.
        function delete_user($id){
            $delete_query = "DELETE FROM user WHERE user_id = '$id'";
            if (mysqli_query($this->conn, $delete_query)) {
				$result = mysqli_query($this->conn, $delete_query);
                if ($result) {
                    header("Location: users.php");
                }
			}else{
				$delete_info = "<span style='color:red'>User Not deleted !</span>";
				return $delete_info;
			}
        }

        #Update User
        function user_update($data){
            $u_user_id = mysqli_real_escape_string($this->conn, $data['u_user_id']);
            $u_fname = mysqli_real_escape_string($this->conn, $data['u_fname']);  
            $u_lname = mysqli_real_escape_string($this->conn, $data['u_lname']);
            $u_user = mysqli_real_escape_string($this->conn, $data['u_user']);
            $u_role = mysqli_real_escape_string($this->conn, $data['u_role']);

            $update_query = "UPDATE user SET 
            user_first_name = '$u_fname',
            user_last_name = '$u_lname',
            username = '$u_user',
            user_role = '$u_role' WHERE user_id = '$u_user_id' ";

            if (mysqli_query($this->conn, $update_query)) {
                $result = mysqli_query($this->conn, $update_query);
                header("Location: users.php"); 
            }else{
                $rtn_msg = "<span style='color:red'>Not inserted !</span>";
                return $rtn_msg;
            }
        }

        #Pagination
        function pagination_number(){
            $limit = 5;
            $query = "SELECT * FROM user";
            if (mysqli_query($this->conn, $query)){
                $records = mysqli_query($this->conn, $query);
                $total_records = mysqli_num_rows($records);
                $total_page = ceil($total_records/$limit);
                return $total_page;
            }
        }

        #Insert_Category
        function add_user_category($data){
            $cat_name = mysqli_real_escape_string($this->conn, $data['cat_name']);

            $query = "SELECT category_name FROM category WHERE category_name = '$cat_name'";
            if (mysqli_query($this->conn, $query)) {
                $result = mysqli_query($this->conn, $query);
                $count = mysqli_num_rows($result);

                if ($count > 0) {
                    $msg = "<span style='color:red'>Username Already Exists !!</span>";
                    return $msg;
                }else{
                    $insert_query = "INSERT INTO category(category_name) VALUES('$cat_name')";

                    if (mysqli_query($this->conn, $insert_query)) {
                        header("Location: category.php"); 
                    }else{
                        $rtn_msg = "<span style='color:red'>Not inserted !</span>";
                        return $rtn_msg;
                    }
                }
            }
        }

        #Show all user.
        function display_category(){
            #pagination start
            $limit = 5;
            if (isset($_GET['page'])) {
                $page_number = $_GET['page'];
            }else{
                $page_number = 1;
            }
            $offset = ($page_number - 1) * $limit;
            #pagination end

            $query = "SELECT * FROM category ORDER BY category_id DESC LIMIT {$offset},{$limit}";        
            if (mysqli_query($this->conn, $query)) {
                $result = mysqli_query($this->conn, $query);
                return $result;
            }
        }

        #Delete_category.
        function category_deleted($id){
            $delete_query = "DELETE FROM category WHERE category_id = '$id'";
            if (mysqli_query($this->conn, $delete_query)) {
				$result = mysqli_query($this->conn, $delete_query);
                if ($result) {
                    header("Location: category.php");
                }
			}else{
				$delete_info = "<span style='color:red'>Category Not deleted !</span>";
				return $delete_info;
			}
        }

        #Edit_category
        function category_edit($id){
            $query = "SELECT * FROM category WHERE category_id = '$id' ";
            if (mysqli_query($this->conn, $query)) {
                $result = mysqli_query($this->conn, $query);
                $final_data = mysqli_fetch_assoc($result);
                return $final_data;
            }
        }

        #Update_category.
        function category_update($data){
            $u_category_id = mysqli_real_escape_string($this->conn, $data['u_category_id']); 
            $u_category_name = mysqli_real_escape_string($this->conn, $data['u_category_name']);
            $cat_post = mysqli_real_escape_string($this->conn, $data['cat_post']); 

            $update_query = "UPDATE category SET 
            category_name = '$u_category_name',
            post = '$cat_post' WHERE category_id = '$u_category_id' ";

            if (mysqli_query($this->conn, $update_query)) {
                $result = mysqli_query($this->conn, $update_query);
                header("Location: category.php"); 
            }else{
                $rtn_msg = "<span style='color:red'>Not inserted !</span>";
                return $rtn_msg;
            }
        }

        #Pagination
        function cat_pagination_number(){
            $limit = 5;
            $query = "SELECT * FROM user";
            if (mysqli_query($this->conn, $query)){
                $records = mysqli_query($this->conn, $query);
                $total_records = mysqli_num_rows($records);
                $total_page = ceil($total_records/$limit);
                return $total_page;
            }
        }

        #Insert_post
        function post_added($data){
            $post_title = mysqli_real_escape_string($this->conn, $data['post_title']);
            $postdesc = mysqli_real_escape_string($this->conn, $data['postdesc']);
            $category = mysqli_real_escape_string($this->conn, $data['category']); 
            $post_date = date("d M, Y");  
            $post_author = $_SESSION['users_id'];
            $post_img_name = $_FILES['fileToUpload']['name'];
			$post_img_size = $_FILES['fileToUpload']['size'];
			$post_tmp_name = $_FILES['fileToUpload']['tmp_name'];
			$pro_ext = pathinfo($post_img_name, PATHINFO_EXTENSION);

            if ($pro_ext == 'jpeg' || $pro_ext == 'jpg' || $pro_ext == 'png') {
				if ($post_img_size <= 2097152) {
					$query = "INSERT INTO post(post_title, post_description, post_category, post_date, post_author, post_img) 
					VALUES('$post_title','$postdesc','$category','$post_date','$post_author','$post_img_name');";
                    $query .= "UPDATE category SET post = post + 1 WHERE category_id = '$category' ";
					if (mysqli_multi_query($this->conn, $query)) {
						move_uploaded_file($post_tmp_name, 'upload/'.$post_img_name);   
                        header("Location: posts.php");
					}
				}else{
					echo "<span style='color:red'>Your image should be less or equal 2MB</span>";
				}
			}else{
				echo "<span style='color:red'>Please upload image ! jpg or jpeg or png file.</span>";
			}
        }


        

        #Display_all_post
        function display_all_post(){
            #pagination start
            $limit = 5;
            if (isset($_GET['page'])) {
                $page_number = $_GET['page'];
            }else{
                $page_number = 1;
            }
            $offset = ($page_number - 1) * $limit;
            #pagination end
            
            $query = "SELECT post.post_id, post.post_title, post.post_description, post.post_category, post.post_date, post.post_img, post.post_date,
             category.category_name,user.username FROM post
                LEFT JOIN category ON post.post_category = category.category_id 
                LEFT JOIN user ON post.post_author = user.user_id
                ORDER BY post.post_id DESC LIMIT {$offset },{$limit}";

            /*$query = "SELECT post.post_id, post.post_title, post.post_description, post.post_date,
             category.category_name,user.username FROM post
                LEFT JOIN category ON post.post_category = category.category_id 
                LEFT JOIN user ON post.post_author = user.user_id
                WHERE post.post_author = {$_SESSION['users_id']}
                ORDER BY post.post_id DESC LIMIT {$offset },{$limit}"; */ 

            if (mysqli_query($this->conn, $query)){
                $result = mysqli_query($this->conn, $query);
                return $result;
            }     
        }

        #Display_all_post
        function display_all_post_gen(){
            #pagination start
            $limit = 5;
            if (isset($_GET['page'])) {
                $page_number = $_GET['page'];
            }else{
                $page_number = 1;
            }
            $offset = ($page_number - 1) * $limit;
            #pagination end
            
            $query = "SELECT post.post_id, post.post_title, post.post_description, post.post_category, post.post_date, post.post_img, post.post_date,
             category.category_name,user.username FROM post
                LEFT JOIN category ON post.post_category = category.category_id 
                LEFT JOIN user ON post.post_author = user.user_id
                WHERE post.post_author = {$_SESSION['users_id']}
                ORDER BY post.post_id DESC LIMIT {$offset },{$limit}";
                
            /*$query = "SELECT post.post_id, post.post_title, post.post_description, post.post_date,
             category.category_name,user.username FROM post
                LEFT JOIN category ON post.post_category = category.category_id 
                LEFT JOIN user ON post.post_author = user.user_id
                WHERE post.post_author = {$_SESSION['users_id']}
                ORDER BY post.post_id DESC LIMIT {$offset },{$limit}"; */ 

            if (mysqli_query($this->conn, $query)){
                $result = mysqli_query($this->conn, $query);
                return $result;
            }     
        }

        #Pagination
        function post_pagination_number(){
            $limit = 5;
            $query = "SELECT * FROM post";
            if (mysqli_query($this->conn, $query)){
                $records = mysqli_query($this->conn, $query);
                $total_records = mysqli_num_rows($records);
                $total_page = ceil($total_records/$limit);
                return $total_page;
            }
        }

        #Edit_post.
        function edit_post($id){
            $query = "SELECT post.post_id, post.post_title, post.post_description, post.post_img, post.post_category, category.category_name FROM post
                LEFT JOIN category ON post.post_category = category.category_id 
                LEFT JOIN user ON post.post_author = user.user_id
                WHERE post.post_id = {$id} ";

            if (mysqli_query($this->conn, $query)){
                $result = mysqli_query($this->conn, $query);
                $post_id_data = mysqli_fetch_assoc($result);
                return $post_id_data;
            }
        }

        #Show all user.
        function display_post_category(){
            $query = "SELECT * FROM category ";        
            if (mysqli_query($this->conn, $query)) {
                $result = mysqli_query($this->conn, $query);
                return $result;
            }
        }

        #Update_post
        function update_post($data){
            $u_post_id = mysqli_real_escape_string($this->conn, $data['u_post_id']);
            $u_post_title = mysqli_real_escape_string($this->conn, $data['u_post_title']);
            $u_postdesc = mysqli_real_escape_string($this->conn, $data['u_postdesc']);
            $u_category = mysqli_real_escape_string($this->conn, $data['u_category']); 
                       
            if (empty($_FILES['new_image']['name'])) {
                $new_name = $data['old_image'];
            }else{
                $errors = array();
                
                $file_name = $_FILES['new_image']['name'];
                $file_size = $_FILES['new_image']['size'];
                $file_tmp = $_FILES['new_image']['tmp_name'];
                $file_type = $_FILES['new_image']['type'];
                $tmp = explode('.', $file_name);

                $file_extension = end($tmp);
                $extension = array("jpeg","jpg","png");

                if (in_array($file_extension, $extension) === false) {
                    $errors[] = "This extension file not allowed, Please choose a JPG or PNG file.";
                }

                if($file_size > 2097152){
                    $errors[] = "File size must be 2mb or lower.";
                }

                $new_name = time(). "-".basename($file_name);
                $target = "upload/".$new_name;
                $image_name = $new_name;
                if (empty($errors) == true) {
                    move_uploaded_file($file_tmp,$target);
                }else{
                    print_r($errors);
                    die();
                }
            }
           
            $query = "UPDATE post SET 
            post_title = '$u_post_title',
            post_description = '$u_postdesc',
            post_category = '{$u_category}',
            post_img = '$image_name' WHERE post_id = '$u_post_id';";
            
            if ($data['old_category'] != $data['u_category']) {
                $query .= "UPDATE category SET post = post - 1 WHERE category_id = {$data['old_category']};";
                $query .= "UPDATE category SET post = post + 1 WHERE category_id = {$data['u_category']};";
            }
            if (mysqli_multi_query($this->conn, $query)) {
                $result = mysqli_multi_query($this->conn, $query);
                if ($result) {
                    header("Location: posts.php");
                }   
            }   
        }

       /* #Update_post
        function update_post($data){
            $u_post_id = mysqli_real_escape_string($this->conn, $data['u_post_id']);
            $u_post_title = mysqli_real_escape_string($this->conn, $data['u_post_title']);
            $u_postdesc = mysqli_real_escape_string($this->conn, $data['u_postdesc']);
            $u_category = mysqli_real_escape_string($this->conn, $data['u_category']);   
            $post_img_name = $_FILES['new_image']['name'];
			$post_img_size = $_FILES['new_image']['size'];
			$post_tmp_name = $_FILES['new_image']['tmp_name'];
			$pro_ext = pathinfo($post_img_name, PATHINFO_EXTENSION);


            if ($pro_ext == 'jpeg' || $pro_ext == 'jpg' || $pro_ext == 'png') {
                if ($post_img_size <= 2097152) {
                    $query = "UPDATE post SET 
                    post_title = '$u_post_title',
                    post_description = '$u_postdesc',
                    post_category = '{$u_category}',
                    post_img = '$post_img_name' WHERE post_id = '$u_post_id';";
                    
                    if ($data['old_category'] != $data['u_category']) {
                        $query .= "UPDATE category SET post = post - 1 WHERE category_id = {$data['old_category']};";
                        $query .= "UPDATE category SET post = post + 1 WHERE category_id = {$data['u_category']};";
                    }
                    if (mysqli_multi_query($this->conn, $query)) {
                        move_uploaded_file($post_tmp_name, 'upload/'.$post_img_name);   
                        header("Location: posts.php");
                    }
                }else{
                    echo "<span style='color:red'>Your image should be less or equal 2MB</span>";
                }
            }else{
                echo "<span style='color:red'>Please upload image ! jpg or jpeg or png file.</span>";
            }   
        }*/

        #Delete_post_and_update_cat
        function delete_post($id, $catid){
            $query = "DELETE FROM post WHERE post_id = $id;";
            $query .= "UPDATE category SET post = post - 1 WHERE category_id = $catid";
            if (mysqli_multi_query($this->conn, $query)) {
                header("Location: posts.php");
            }else{
                $delete_info = "<span style='color:red'>Post Not deleted !</span>";
                return $delete_info;
            }
        }

        #################################################################################
        #################################### Fornt-in ###################################
        #################################################################################

        function get_single_data($id){
            $query = "SELECT post.post_id, post.post_title, post.post_description, post.post_category, post.post_date, post.post_img, post.post_author,
             category.category_name,user.username FROM post
                LEFT JOIN category ON post.post_category = category.category_id 
                LEFT JOIN user ON post.post_author = user.user_id
                WHERE post.post_id = {$id} ";

            if (mysqli_query($this->conn, $query)){
                $result = mysqli_query($this->conn, $query);
                return $result;
            }     
        }

        #Display_all_post
        function display_all_post_index(){
            #pagination start
            $limit = 5;
            if (isset($_GET['page'])) {
                $page_number = $_GET['page'];
            }else{
                $page_number = 1;
            }
            $offset = ($page_number - 1) * $limit;
            #pagination end
            
            $query = "SELECT post.post_id, post.post_title, post.post_description, post.post_category, post.post_date, post.post_img, post.post_author,
             category.category_name,user.username FROM post
                LEFT JOIN category ON post.post_category = category.category_id 
                LEFT JOIN user ON post.post_author = user.user_id
                ORDER BY post.post_id DESC LIMIT {$offset },{$limit}";

            if (mysqli_query($this->conn, $query)){
                $result = mysqli_query($this->conn, $query);
                return $result;
            }    
        }

        #Pagination
        function post_pagination_number_index(){
            $limit = 5;
            $query = "SELECT * FROM post";
            if (mysqli_query($this->conn, $query)){
                $records = mysqli_query($this->conn, $query);
                $total_records = mysqli_num_rows($records);
                $total_page = ceil($total_records/$limit);
                return $total_page;
            }
        }

        #Header_category
        function header_category_data($id){
            #pagination start
            $limit = 5;
            if (isset($_GET['page'])) {
                $page_number = $_GET['page'];
            }else{
                $page_number = 1;
            }
            $offset = ($page_number - 1) * $limit;
            #pagination end
            
            $query = "SELECT post.post_id, post.post_title, post.post_description, post.post_category, post.post_date, post.post_img, post.post_date, post.post_author,
             category.category_name,user.username FROM post
                LEFT JOIN category ON post.post_category = category.category_id 
                LEFT JOIN user ON post.post_author = user.user_id WHERE post.post_category = '$id'
                ORDER BY post.post_id DESC LIMIT {$offset },{$limit}";

            if (mysqli_query($this->conn, $query)){
                $result = mysqli_query($this->conn, $query);
                return $result;
            }  
        }

        #Pagination
        function category_pagination_number($id){
            $limit = 5;
            $query = "SELECT * FROM post WHERE post.post_category = '$id'";
            if (mysqli_query($this->conn, $query)){
                $records = mysqli_query($this->conn, $query);
                $total_records = mysqli_num_rows($records);
                $total_page = ceil($total_records/$limit);
                return $total_page;
            }
        }

        #Category_name
        function category_name($id){
            $query = "SELECT * FROM category WHERE category_id = '$id'";
            if (mysqli_query($this->conn, $query)) {
                $result = mysqli_query($this->conn, $query);
                $data = mysqli_fetch_assoc($result);
                return $data;
            }
        }

        #author_name_show
        function authentication_name($auth_id){
            $query = "SELECT * FROM user WHERE user_id = '$auth_id'";
            if (mysqli_query($this->conn, $query)) {
                $result = mysqli_query($this->conn, $query);
                $data = mysqli_fetch_assoc($result);
                return $data;
            }
        }

        #Header_category
        function header_auth_data($id){
            #pagination start
            $limit = 5;
            if (isset($_GET['page'])) {
                $page_number = $_GET['page'];
            }else{
                $page_number = 1;
            }
            $offset = ($page_number - 1) * $limit;
            #pagination end
            
            $query = "SELECT post.post_id, post.post_title, post.post_description, post.post_category, post.post_date, post.post_img, post.post_date, post.post_author,
             category.category_name,user.username FROM post
                LEFT JOIN category ON post.post_category = category.category_id 
                LEFT JOIN user ON post.post_author = user.user_id WHERE post.post_author = '$id'
                ORDER BY post.post_id DESC LIMIT {$offset },{$limit}";

            if (mysqli_query($this->conn, $query)){
                $result = mysqli_query($this->conn, $query);
                return $result;
            }  
        }

        #Pagination
        function auth_pagination_number($id){
            $limit = 5;
            $query = "SELECT * FROM post WHERE post.post_author = '$id'";
            if (mysqli_query($this->conn, $query)){
                $records = mysqli_query($this->conn, $query);
                $total_records = mysqli_num_rows($records);
                $total_page = ceil($total_records/$limit);
                return $total_page;
            }
        }

        function search_result_name($id){

        }

        #search_result_data
        function search_result_data($search_ids){
            #pagination start
            $limit = 5;
            if (isset($_GET['page'])) {
                $page_number = $_GET['page'];
            }else{
                $page_number = 1;
            }
            $offset = ($page_number - 1) * $limit;
            #pagination end
            
            $query = "SELECT post.post_id, post.post_title, post.post_description, post.post_category, post.post_date, post.post_img, post.post_date, post.post_author,
             category.category_name,user.username FROM post
                LEFT JOIN category ON post.post_category = category.category_id 
                LEFT JOIN user ON post.post_author = user.user_id WHERE post.post_title LIKE '%{$search_ids}%' OR post.post_description LIKE '%{$search_ids}%'
                ORDER BY post.post_id DESC LIMIT {$offset },{$limit}";

            if (mysqli_query($this->conn, $query)){
                $result = mysqli_query($this->conn, $query);
                return $result;
            }  
        }

        #endregion
        function suarch_pagination_number($id){
            $limit = 5;
            $query = "SELECT * FROM post WHERE post.post_title LIKE '%{$id}%'";
            if (mysqli_query($this->conn, $query)){
                $records = mysqli_query($this->conn, $query);
                $total_records = mysqli_num_rows($records);
                $total_page = ceil($total_records/$limit);
                return $total_page;
            }
        }
    }
?> 