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
// $htmloutput .="Connected successfully<br>";




//make a year month array
$sql = "SELECT 
	max(
		DATE_FORMAT(timestamp, '%Y%m')
	) as max, 
	min(
		DATE_FORMAT(timestamp, '%Y%m')
	) as min 
from 
	account_values";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$min = $row['min'];
$max = $row['max'];
// echo $min . $max;
$yearmonth_array = [];
for ($y = $min; $y <= $max; $y++) {
    if (substr($y,-2) == 13){$y = $y + 88;}
    array_push($yearmonth_array, $y);
}
// print_r($yearmonth_array);

//make an account array
$sql = "SELECT * FROM accounts";
$result = mysqli_query($conn, $sql);
$account_array = [];
while($row = mysqli_fetch_assoc($result)) {
	$account_array[$row['ID']] = $row['Name'];
	}
// print_r($account_array);

//make a type array
$sql = "SELECT Type FROM accounts GROUP BY Type";
$result = mysqli_query($conn, $sql);
$type_array = [];
while($row = mysqli_fetch_assoc($result)) {
	array_push($type_array, $row['Type']);
	}
// print_r($type_array);

//loop and extract all values
$results_array = [];
$cols = '"cols": [{"id":"Month", "label":"Month", "type":"string"},';
foreach ($account_array as $account) {
			$cols .= '{"id":"'.$account.'", "label":"'.$account.'", "type":"number"},';
	}
$rows = '"rows": [';
foreach ($yearmonth_array as $yearmonth) {
	$rows .= '{"c":[{"v": "'.$yearmonth.'"},';
	foreach ($account_array as $id => $account) {
// 		echo $yearmonth;
		$timestamp = substr($yearmonth,0,4) . "-" . substr($yearmonth,-2) . "-01 00:00:00";
		$sql = "SELECT value FROM `account_values` 
				WHERE timestamp < ADDDATE( '$timestamp', INTERVAL 1 month)
				AND id = $id
				ORDER BY timestamp DESC LIMIT 1";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
//  		echo $sql;
// 		echo $row['value'];
		$rows .= '{"v":'.(int)$row['value'].'},';
	}

	$rows = substr($rows,0,-1) ."]},";
	}  
$rows = substr($rows,0, -1) . "]";
$cols = substr($cols,0,-1) . "]";
// echo $cols;
// echo $rows;
$data = "{".$cols.", ".$rows."}";
echo $data;
?>

