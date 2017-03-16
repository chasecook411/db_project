<html>

	<head>
		<title>Main Page!!</title>
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
			<h3> Hello <a href="profile.php"><?php echo $row['f_name'] . " " . $row['l_name']; ?></a>! </h3>
		</div>
		<div id="menu">
			<!-- here is where the menu will go -->
		</div>

		<div id="posts">
			<form action="mainpage.php" method="POST">
				Post something:<input id="post" type="text" name="post"></input></br>
				<input id="postit" type="submit" value="Post it!"></input>
			</form>
			<?php
				if (isset($_POST["post"])) {
					$query = "INSERT INTO posts VALUES($user_id,NULL, NOW(), '". $_POST["post"]."',$user_id, 0, $user_id);";
					
					$result = mysql_query($query);
					if (!$result) {
			    		$message  = 'Invalid query: ' . mysql_error() . "\n";
			    		$message .= 'Whole query: ' . $query;
			    		die("Unable to insert post!");
			    	}
		    	}

				$query = sprintf("select email, content from users u inner join (select content, user_id from posts where user_id in (select following from follows where follower = $user_id)) p on u.user_id = p.user_id;");
				//echo $query;

				$result = mysql_query($query);
				if (!$result) {
		    		$message  = 'Invalid query: ' . mysql_error() . "\n";
		    		$message .= 'Whole query: ' . $query;
		    		die("Unable to collect posts!");
		    	}


		    	while ($row = mysql_fetch_assoc($result)) {
		    		echo $row['email'] . " " . $row['content']; 
		    		?></br><?php
		    	}
			?>
		</div>
		<?php  
		} else {
			?><a href="login.php">Try Again?</a></br><a href="signup.php">Sign Up Now</a></br><?php
		}
		 

		?>
	</body>

</html>
