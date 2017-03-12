<html>

	<head>
		<title>Sign Up</title>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>


	</head>

	<body>
		<form action="thanks.php" method="POST">
			Enter your first name:<input id="user" type="text" name="fname"></input></br>
			Enter your last name:<input id="user" type="text" name="lname"></input></br>
			Enter your username in the form of an email address:<input id="user" type="text" name="email"></input></br>
			Enter your password:<input ng-model="pass" type="password" name="pass"></input></br>
			Confirm your password:<input ng-model="conf" type="password" name="pass"></input></br>
			<input id="submit" type="submit" ></input>
		</form>
	</body>

</html>