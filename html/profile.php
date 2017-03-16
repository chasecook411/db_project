<html>

	<head>
		<title>Profile</title>
		<link rel="stylesheet" type="text/css" href="CSS/main.css">
	</head>

	<body>

		<?php
		$conn = mysql_connect('localhost', 'root', '', 3306);

		if (!$conn) {
			die("Cound not connect: " . mysql_error());
		}

		if (!mysql_select_db('my_db')) {
			die("Could not select database: " . mysql_error);
		}

		$email = "";
		$pass = "";
		if (isset($_POST["user"]) && isset($_POST["pass"])) {
			setCookie("12345", $_POST['user'] . ',' . $_POST['pass'], time() + (86400 * 30), '/');
			$email = $_POST["user"];
			$pass = $_POST["pass"];
		} else if (isset($_COOKIE["12345"])) {
			//$creds = array();
			$creds = explode(",",$_COOKIE["12345"]);
			$email = $creds[0];
			$pass = $creds[1];
		} 

			//		$email = $_POST["user"];
			//$pass = $_POST["pass"];
		$query = sprintf("SELECT user_id, f_name, l_name, email FROM users WHERE email = '$email' AND password = '$pass'");
		//echo $query;

		$result = mysql_query($query);
		if (!$result) {
		    $message  = 'Invalid query: ' . mysql_error() . "\n";
		    $message .= 'Whole query: ' . $query;
		    die("Invalid User Name or Password!");
		    
		}

		if ($row = mysql_fetch_assoc($result)) {
			$user_id = $row['user_id'];
		?>
		<div id="greetings">
			<h3> Hello <?php echo $row['f_name'] . " " . $row['l_name']; ?>! </h3>
		</div>
		<div id="menu">
			<!-- here is where the menu will go -->
		</div>

		<div id="posts">
			<?php
				$query = sprintf("SELECT f_name, l_name, content, post_time, num_likes FROM users, posts WHERE posts.author_id = users.user_id AND posts.user_id = " . $user_id . " AND parent_id IS NULL ORDER BY post_time DESC;");
				//echo $query;

				$result = mysql_query($query);
				if (!$result) {
		    		$message  = 'Invalid query: ' . mysql_error() . "\n";
		    		$message .= 'Whole query: ' . $query;
		    		die("Unable to collect posts!");
		    	}


		    	while ($row = mysql_fetch_assoc($result)) {
		    		echo $row['f_name'] . " " . $row['l_name'] . "<br>" . $row['content'] . "<br>" . $row['post_time'] . " " . $row['num_likes'] . " likes<br>"; 
		    		?></br><?php
		    	}
				
			?>
			
		</div>
		<div id="links">
			<a href="mainpage.php">Back to Main Page</a></br><a href="login.php">Log out</a></br>
		</div>
		
		<?php  
		} else {
			?><a href="login.php">Try Again?</a></br><a href="signup.php">Sign Up Now</a></br><?php
		}
		 

		?>
	</body>

</html>