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
$sql = "SELECT * FROM `accounts` order by Type";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)) {

	$ID = $row['ID'];
	$namearray[$ID] = $row['Name'];
	$sql2 = "SELECT 
	DATE_FORMAT(fulltable.timestamp,'%Y%m') as yearmonth
	, sum(fulltable.value) as total
	FROM

	(SELECT 
	id
	,DATE_FORMAT(timestamp,'%Y%m') as yearmonth
	, max(`timestamp`) as timestamp
	FROM `account_values` 
	WHERE account_values.id = $ID
	GROUP BY yearmonth, id
	ORDER BY `timestamp` ASC)

	as querytable

	INNER JOIN account_values as fulltable on fulltable.id = querytable.id and fulltable.timestamp = querytable.timestamp
	INNER JOIN accounts on accounts.id = querytable.id
	
	GROUP BY yearmonth
	";
	$result2 = mysqli_query($conn, $sql2);
	while($row2 = mysqli_fetch_assoc($result2)) {
// 	echo $row['Name'] .$row2['yearmonth'] . "<br>";
		$yearmonth = $row2['yearmonth'];
		
		$allarray[$yearmonth][$ID] = $row2['total'];
		
		}

}

// print_r($namearray);







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
//     $json .= '["'.$x.'",'.$total[$x].','.$total[$x].'],';
}


foreach($allarray as $yearmonth => $accountarray) {
	$n = 0;
    $json .=   '["' . $yearmonth . '",' ;
    foreach($namearray as $ID => $x_value) {
     	$json .= (int)$allarray[$yearmonth][$ID] . ",";
     	$n ++;
    }
	$json = substr($json,0,-1) . "],";
// 	echo $n ."<br>";
}


$json = substr($json,0,-1) . "]";
// echo $json;
// print_r(get_defined_vars());

echo"
// Create the data table.
        var data = new google.visualization.DataTable(); \n
        data.addColumn('string', 'YearMonth'); \n";
        
foreach($namearray as $ID => $x_value) {
	echo "data.addColumn('number', '". $x_value ."'); \n";
}     

echo "
      

var chartdata = $json; \n

data.addRows(chartdata); \n";



mysqli_close($conn);
?>








































