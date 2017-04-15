<?php

$conn = mysql_connect('localhost', 'root', '', 3306);

if (!$conn) {
	die("Cound not connect: " . mysql_error());
}

if (!mysql_select_db('my_db')) {
	die("Could not select database: " . mysql_error);
}

$query = "insert into likes values(" . $_GET['user_id'] . ',' . $_GET['post_id'] . ');';
 
$result = mysql_query($query);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die("Unable to like post!");
		    
}

$query = "update posts set num_likes = num_likes + 1 where post_id = " . $_GET['post_id'] . ';';

$result = mysql_query($query);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die("Unable to like post!");
		    
}

?>