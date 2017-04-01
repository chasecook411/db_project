<?php

$user_id = $_GET['user'];
$follows = $_GET['follows'];

$conn = mysql_connect('localhost', 'root', '', 3306);

if (!$conn) {
	die("Cound not connect: " . mysql_error());
}

if (!mysql_select_db('my_db')) {
	die("Could not select database: " . mysql_error);
}

$query = "insert into follows values(".$user_id.",". $follows.",now());";

$result = mysql_query($query);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die("Invalid User Name or Password!");
		    
}


?>