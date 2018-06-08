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




// total only for now
$sql = "SELECT DATE_FORMAT(fulltable.timestamp,'%Y%m') as yearmonth
, sum(fulltable.value) as total

FROM

(SELECT 
id
,DATE_FORMAT(timestamp,'%Y%m') as yearmonth
, max(`timestamp`) as timestamp
FROM `account_values` 

GROUP BY yearmonth, id
ORDER BY `timestamp` ASC)

as querytable

INNER JOIN account_values as fulltable on fulltable.id = querytable.id and fulltable.timestamp = querytable.timestamp
INNER JOIN accounts on accounts.id = querytable.id
group by yearmonth";

$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_assoc($result)) {
	$total[$row['yearmonth']] = $row['total'];
	}



$json = '[';
foreach($total as $x => $x_value) {
//     echo "Key=" . $x . ", Value=" . $x_value;
    $json .= '["'.$x.'",'.$total[$x].'],';
}



$json = substr($json,0,-1) . "]";
echo '{'.$json.'}';
// print_r(get_defined_vars());







mysqli_close($conn);


?>