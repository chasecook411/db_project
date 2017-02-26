

<?
if (isset($_POST["email"])) {
	if (isset($_POST["pass"])) {
		if (isset($_POST["fname"])) {
			if (isset($_POST["fname"])) { 
				$sql = "insert into users\nvalues (NULL, " . $_POST["fname"] . ", " . $_POST["lname"] . ", " . $_POST["email"] . ", " . $_POST["pass"] . ")";
				echo $sql;
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