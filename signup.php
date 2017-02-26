<html>

	<head>
		<title>Sign Up</title>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>


	</head>

	<body>
		<form action="thanks.php" method="POST">
			Enter your username in the form of an email address:<input id="user" type="text" name="user"></input></br>
			Enter your password:<input ng-model="pass" id="pass" type="password" name="pass"></input></br>
			Confirm your password:<input ng-model="conf" id="pass" type="password" name="pass"></input></br>
			<input id="submit" type="submit" ></input>
		</form>
	</body>

</html>