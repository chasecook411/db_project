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
		if (isset($_GET["user"]) && isset($_GET["pass"])) {
			setCookie("12345", $_GET['user'] . ',' . $_GET['pass'], time() + (86400 * 30), '/');
			$email = $_GET["user"];
			$pass = $_GET["pass"];
		} else if (isset($_COOKIE["12345"])) {
			//$creds = array();
			$creds = explode(",",$_COOKIE["12345"]);
			$email = $creds[0];
			$pass = $creds[1];
		} 

		if (isset($_GET["is_following"]) && isset($_GET["uid"]) && isset($_GET["follows"])) {
			//echo $_GET;
			if ($_GET["is_following"] == "yes") {
				$query = "insert into follows values(" . $_GET["follows"] . ',' . $_GET["uid"] . ",now());";
				echo $query;
				$result = mysql_query($query);

				if (!$result) {
				    $message  = 'Invalid query: ' . mysql_error() . "\n";
				    $message .= 'Whole query: ' . $query;
				    die("Invalid User Name or Password!");
						    
				}
			}
		}

		if (isset($_GET['comment']) && isset($_GET['comment_id']) && isset($_GET['other_user_id'])) {
			$comment = $_GET['comment'];
			$query = sprintf("insert into posts values (" . $_GET["uc_id"] . ",NULL,NOW(),". "'$comment'". ", " . $_GET['other_user_id'] . ",0," . $_GET["comment_id"] . ");");

			echo $query;

			$result = mysql_query($query);

			if (!$result) {
				    $message  = 'Invalid query: ' . mysql_error() . "\n";
				    echo $message ?> <br> <?php
				    $message .= 'Whole query: ' . $query;
				    echo $message ?> <br> <?php
				    die("Invalid User Name or Password!");			    
			}

		}

		if (isset($_GET["is_like"]) && isset($_GET["p_uid"]) && isset($_GET["post_id"])) {
			//echo $_GET;
			if ($_GET["is_like"] == "yes") {
				$query = "insert into likes values(" . $_GET['post_id'] . ',' . $_GET['p_uid'] .');';
 
				$result = mysql_query($query);

				if (!$result) {
				    $message  = 'Invalid query: ' . mysql_error() . "\n";
				    echo $message;
				    $message .= 'Whole query: ' . $query;
				    echo $message;
				    die("Unable to like post!");
						    
				}

				$query = "update posts set num_likes = num_likes + 1 where post_id = " . $_GET['post_id'] . ';';

				$result = mysql_query($query);

				if (!$result) {
				    $message  = 'Invalid query: ' . mysql_error() . "\n";
				    $message .= 'Whole query: ' . $query;
				    die("Unable to like post!");
				}
			}
		}

			//		$email = $_GET["user"];
			//$pass = $_GET["pass"];
		$query = sprintf("SELECT user_id, f_name, l_name, email FROM users WHERE email = '$email' AND password = '$pass'");
		//echo $query;

		$result = mysql_query($query);
		if (!$result) {
		    $message  = 'Invalid query: ' . mysql_error() . "\n";
		    $message .= 'Whole query: ' . $query;
		    die("Invalid User Name or Password!");
		}

		if (isset($_GET['profile_page'])) {

			?> 


			<h1>Your <a href="mainpage.php">Twitta</a> Profile</h1>

			<?php
			if ($row = mysql_fetch_assoc($result)) {
				$user_id = $row['user_id'];

				if (isset($_GET["delete_post"])) {
					$post_id = $_GET["delete_post"];
					$query = sprintf("delete from likes where post_id = $post_id");

					$result = mysql_query($query);
					$query = sprintf("delete from posts where post_id = $post_id");
					$result = mysql_query($query);
				}

				?><h3>Your Account Details</h3><?php
				$query = sprintf("select f_name, l_name, email from users where user_id = $user_id");

				$result = mysql_query($query);

				while ($row = mysql_fetch_assoc($result)) {
					?><h5>Your first name:</h5><?php echo $row["f_name"];
					?><h5>Your last name: </h5><?php echo $row["l_name"];
					?><h5>Your email address: </h5><?php echo $row["email"];
				}

				?><h3>Who Your Currently Following</h3><?php

				$query = sprintf("select u.f_name, u.l_name from follows f, users u where follower = $user_id and f.following = u.user_id");
				$result = mysql_query($query);
				

				?><ul> <?php
				while ($row = mysql_fetch_assoc($result)) {
					?><li><?php echo $row['f_name'] . ' ' . $row['l_name'] ?></li><?php 
				}
				?></ul>

				<h3>See your tweets</h3>

				<?php

				$query = sprintf("select content,post_id from posts where user_id = $user_id");
				$result = mysql_query($query);
				

				?><ul> <?php
				while ($row = mysql_fetch_assoc($result)) {
					?><li><?php echo $row['content'];?></li><a href="mainpage.php?profile_page=yes&delete_post=<?php echo $row['post_id'];?>">Delete this post?</a> <?php  
				}
				?></ul><?php
			}
		} else if ($row = mysql_fetch_assoc($result)) {
			$user_id = $row['user_id'];
		?> 

		<div id="greetings">
			<h3> Welcome to Twitta, <a href="mainpage.php?profile_page=1"><?php echo $row['f_name'] . " " . $row['l_name']; ?></a>! </h3>
		</div>
		<div id="menu">
			<!-- here is where the menu will go -->
		</div>

		<div id="posts">
			<form action="mainpage.php" method="GET">
				Post something:<input id="post" type="text" name="post"></input></br>
				<input id="postit" type="submit" value="Post it!"></input>
			</form>
			<?php
				if (isset($_GET["post"])) {
					$query = "INSERT INTO posts VALUES($user_id,NULL, NOW(), '". $_GET["post"]."',$user_id, 0, NULL);";
					
					$result = mysql_query($query);
					if (!$result) {
			    		$message  = 'Invalid query: ' . mysql_error() . "\n";
			    		echo $message;
			    		$message .= 'Whole query: ' . $query;
			    		echo $message;
			    		die("Unable to insert post!");
			    	}
		    	}

				?><h2>What's new?</h2><?php
				//$query = sprintf("select f_name,email, content from users u inner join (select content, user_id from posts where user_id in (select following from follows where follower = $user_id)) p on u.user_id = p.user_id;");
				//echo $query;

				$query = sprintf("select u.user_id, u.f_name, p.content, p.post_id, p.num_likes from users u inner join (select * from posts where author_id = user_id and parent_id is null and user_id in (select following from follows where follower = $user_id)) p on u.user_id=p.user_id order by post_time desc");

				$result = mysql_query($query);
				if (!$result) {
		    		$message  = 'Invalid query: ' . mysql_error() . "\n";
		    		$message .= 'Whole query: ' . $query;
		    		die("Unable to collect posts!");
		    	}


		    	while ($row = mysql_fetch_assoc($result)) {
		    		echo '@' . $row['f_name'] . " " . $row['content'] . ' ';
		    		?><img src="images/like.svg" height=12 width=12><?php echo ' * ' .$row['num_likes'] . ' '; 
		    		?><a href="mainpage.php?is_like=yes&p_uid=<?php echo $user_id . '&post_id=' . $row['post_id']?>">Like this post!</a>


		    		</br>


		    		<?php
		    		$query = sprintf("select u.f_name, p.content from posts p, users u where parent_id=" . $row['post_id'] ." and u.user_id = p.user_id");
		    		//echo $query;
		    		$result2 = mysql_query($query);
		    		
		    		if (!$result2) {
		    			$message  = 'Invalid query: ' . mysql_error() . "\n";
		    			$message .= 'Whole query: ' . $query;
		    			die("Unable to collect comments!");
		    		}

		    		?><ul><?php
		    		while ($row2 = mysql_fetch_assoc($result2)) {
		    			?><li><?php echo '@' . $row2['f_name'] . ' ' .$row2['content'];?></li><?php
		    			?></br><?php
		    		}
		    		?></ul>
		    			<form method="GET">
							Any comments?:<input type="text" name="comment"></input>
							<input hidden name="comment_id" value="<?php echo $row['post_id']?>"></input>
							<input hidden name="other_user_id" value="<?php echo $row['user_id']?>"></input>
							<input hidden name="uc_id" value="<?php echo $user_id?>"></input>
						<input id="postit" type="submit" value="Post it!"></input>
					</form><?php
		    	}

	    		?><h2>Follow other users!</h2><?php
		    	//$query = sprintf("select f_name, l_name, user_id from users where user_id not in ($user_id)");
		    	$query = sprintf("select distinct u.f_name, u.l_name, u.user_id from users u, follows f where u.user_id not in ($user_id) and u.user_id not in (select following from follows where follower = $user_id)");
		    	$result = mysql_query($query);

		    	if (!$result) {
		    		$message = 'Invalid query: ' . mysql_error() . '\n';
		    		$message .= 'Whole query: ' . $query;
		    		die("Unable to collect other users");
		    	}



		    	while ($row = mysql_fetch_assoc($result)) {
		    		$link = "mainpage.php?&is_following=yes&uid=" . $user_id . '&follows=' . $row['user_id']; 
		    		?><a href=<?php echo $link;?>><?php echo $row['f_name'] . ' ' . $row['l_name'];
		    		?></a></br><?php
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
