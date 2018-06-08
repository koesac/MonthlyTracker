<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "alex";
 
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname); 

// Check connection 
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());  
}
// echo "Connected successfully<br>";

$sql = "SELECT  accounts.Type, sum(fulltable.value)
FROM

(SELECT 
id

, max(`timestamp`) as timestamp
FROM `account_values` 

GROUP BY  id
ORDER BY `timestamp` DESC)

as querytable

INNER JOIN account_values as fulltable on fulltable.id = querytable.id and fulltable.timestamp = querytable.timestamp
INNER JOIN accounts on accounts.id = querytable.id
group by accounts.Type

";
$result = mysqli_query($conn, $sql);
 $allrow = mysqli_fetch_all($result) ;
	$myJSON = json_encode($allrow);
	
	
	
	echo $myJSON;



mysqli_close($conn);
?>