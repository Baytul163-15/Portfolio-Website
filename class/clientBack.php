<?php
    class clientBack
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

        function header_category(){
            $cat_head = "SELECT * FROM category WHERE post > 0";
            if (mysqli_query($this->conn, $cat_head)){
                $result = mysqli_query($this->conn, $cat_head);
                return $result;
            }
        }

        








    }
    
