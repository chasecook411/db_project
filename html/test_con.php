<?php

$conn = mysql_connect('localhost', 'root', '', 3306);

if (!$conn) {
	die("Cound no connect: " . mysql_error());
}

if (!mysql_select_db('my_db')) {
	die("Could not select database: " . mysql_error);
}

$firstname = "Chase";
$query = sprintf("SELECT user_id, f_name, l_name, email FROM users ");

$result = mysql_query($query);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}
//print_r(mysql_fetch_assoc($result));

while ($row = mysql_fetch_assoc($result)) {
	?>User ID: <?php echo $row['user_id']; ?></br><?php
	?>First Name: <?php echo $row['f_name']; ?></br><?php
	?>Last Name: <?php echo $row['l_name']; ?></br><?php 
	?>Email Address: <?php echo $row["email"]; ?> </br><?php
}


$query = sprintf("select * from follows");

?><h1>Follows table</h1><?php

$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {
	?>Follower: <?php echo $row['follower']; ?></br><?php
	?>Following: <?php echo $row['following']; ?></br><?php
	?>Last Name: <?php echo $row['l_name']; ?></br><?php 
}

mysql_close($conn);


?>