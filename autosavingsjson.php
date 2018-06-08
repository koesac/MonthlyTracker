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




// automatically update accounts if required
$sql = "SELECT * FROM accounts WHERE autoupdatedate > 0 ";
$currentdate = time();
$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_assoc($result)) {
		print_r($row);
		$sql = "SELECT max(timestamp) as maxtimestamp FROM `account_values` WHERE id = ". $row['ID'];
		$result2 = mysqli_query($conn, $sql);
		while($row2 = mysqli_fetch_assoc($result2)) {

			$lastupdate = strtotime($row2['maxtimestamp']);
			//$currentdate = time(); //---set above to only set once
			$autoupdate = strtotime(date("Y-m-",time()).$row['autoupdatedate']);
			if (($currentdate > $autoupdate) && ($lastupdate < $autoupdate)){
				$sql = "SELECT * FROM account_values WHERE id = " . $row["ID"]. " order by timestamp DESC LIMIT 1";
				$result3 = mysqli_query($conn, $sql);
				$row3 = mysqli_fetch_assoc($result3);
				
				$newvalue = (int)$row3["value"] + (int)$row['autoupdateamount'];
				$sql = "INSERT INTO account_values (`id`, `value`, `timestamp`) VALUES (" . $row["ID"]. ", " . $newvalue. ", CURRENT_TIMESTAMP);";
				if (mysqli_query($conn, $sql)) {
    				echo  (int)$row["value"] . " automatically added to " . $row["Name"] ;
				} else {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
				
				
			}
			
			
	}
}



//  print_r(get_defined_vars());







mysqli_close($conn);


?>