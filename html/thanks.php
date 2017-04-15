<?php

// need to remove these conditions, logic better with jquery
if (isset($_POST["email"])) {
	if (isset($_POST["pass"])) {
		if (isset($_POST["fname"])) {
			if (isset($_POST["fname"])) { 


				$conn = mysql_connect('localhost', 'root', 'root', 3306);

				if (!$conn) {
					die("Cound no connect: " . mysql_error());
				}

				if (!mysql_select_db('my_db')) {
					die("Could not select database: " . mysql_error);
				}

				// $sql = sprintf("insert into users values (".$_POST["fname"] . ", " . $_POST["lname"] . ", " . mysql_real_escape_string($_POST["email"]) . ", " . $_POST["pass"] . ")");

				$fname = mysql_real_escape_string($_POST["fname"]);
				$lname = mysql_real_escape_string($_POST["lname"]);
				$pass = mysql_real_escape_string($_POST["pass"]);
				$email = mysql_real_escape_string($_POST["email"]);

				//echo $email;
				$query = sprintf("insert into users values(NULL, '$fname', '$lname', '$email', '$pass')");

				echo "SQL: " . $query;

				$result = mysql_query($query);

				if (!$result) {
    				$message  = 'Invalid query: ' . mysql_error() . "\n";
    				$message .= 'Whole query: ' . $query;
    				die($message);
				}

				mysql_close($conn);
			} else {
				echo "You didn't enter a last name";
			}
		} else {
			echo "You didn't enter a first name";
		}
	} else {
		echo "You didn't ented a password";
	}	
} else {
	echo "You didn't enter a user name!";
}


?>

<p><a href="login.php">Click here</a> to login </p>