
<?php

function convert_amount($amount, $direction){
if ($direction == "tonum"){
	return str_replace(array(',', '£', ' '), '', $amount);
}
else {
	return "£" . number_format($amount);
}
}
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

if (isset($_POST['save'])) {
$id = $_POST['ID'];
$amount = convert_amount($_POST['amount'], "tonum");
$sql = "INSERT INTO account_values (`id`, `value`, `timestamp`) VALUES ('$id', '$amount', CURRENT_TIMESTAMP);";

if (mysqli_query($conn, $sql)) {
    $htmloutput .="New record created successfully";
} else {
    $htmloutput .="Error: " . $sql . "<br>" . mysqli_error($conn);
}


unset($_POST['value']);
}
// automatically update accounts if required
$sql = "SELECT * FROM accounts WHERE autoupdatedate > 0 ";
$currentdate = time();
$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_assoc($result)) {

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
    				echo  (int)$row['autoupdateamount'] . " automatically added to " . $row["Name"] ;
				} else {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}


			}


	}
}



$sql = "SELECT Type FROM `accounts` WHERE hidden is null GROUP BY Type ORDER BY Type";
$type_result = mysqli_query($conn, $sql);
while($type = mysqli_fetch_assoc($type_result)) {

	$htmloutput .= "<div class='float'><h3>" .$type["Type"] . " - PLACEHOLDER</h3>";
	$sql = "SELECT * FROM `accounts` WHERE Type ='" .$type["Type"] . "'  AND hidden is null  order by name";
	$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_assoc($result)) {

		$sql2 = "SELECT *, DATEDIFF(CURRENT_TIMESTAMP, `timestamp`) as updatedays FROM account_values WHERE id = " . $row["ID"]. " order by timestamp DESC LIMIT 1";
		$result2 = mysqli_query($conn, $sql2);
		$row2 = mysqli_fetch_assoc($result2);

		if($row2["updatedays"] > 1 ){$update = " " . $row2["updatedays"] . " days ago";}
		elseif ($row2["updatedays"] == 1 ){$update = " " . $row2["updatedays"] . " day ago";}
		else { $update = "";}

			$htmloutput .=	"<form method='post'>


						<input type='hidden' name='ID' value='" . $row["ID"]. "'>
						<input type='text' name='amount' value='" . convert_amount($row2["value"]). "' onkeypress='showSave(". $row["ID"]. ")''>
						<input name='save' type='submit' value='+' id='". $row["ID"]. "' style='display:none'>";
			if ($row["url"] != "") {$htmloutput .=	"<a target='". $row["ID"]. "' href='". $row["url"]. "'><strong>" . $row["Name"]. "</strong></a>";}
			else {$htmloutput .=	"<strong>" . $row["Name"]. "</strong>";}

			$htmloutput .=	"<span class='update'>$update</span>
					</form>";

	$$row["Type"] += $row2["value"];

	}

	$htmloutput .="</div>";
}

//now get expenses
	$htmloutput .= "<div class='float'><h3>Expenses - PLACEHOLDER</h3>";
	$sql = "SELECT * FROM `expenses` WHERE hidden is null  order by amount DESC";
	$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_assoc($result)) {

			$htmloutput .=	"


						<input type='hidden' name='ID' value='" . $row["ID"]. "'>
						<input type='text' name='amount' value='" . convert_amount($row["amount"]). "' onkeypress='showSave(". $row["ID"]. ")''>
						<input name='save' type='submit' value='+' id='". $row["ID"]. "' style='display:none'>";
			if ($row["url"] != "") {$htmloutput .=	"<a target='". $row["ID"]. "' href='". $row["url"]. "'><strong>" . $row["Name"]. "</strong></a>";}
			else {$htmloutput .=	"<strong>" . $row["Name"]. "</strong>";}


			$htmloutput .= "</br>"



					;

	$expenses += $row["amount"];

	}

	$htmloutput .="</div>";

//now get regular savings
	$htmloutput .= "<div class='float'><h3>Savings - PLACEHOLDER</h3>";
	$sql = "SELECT * FROM `accounts` WHERE hidden is null AND autoupdateamount > 0 order by autoupdateamount DESC";
	$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_assoc($result)) {

			$htmloutput .=	"


						<input type='hidden' name='ID' value='" . $row["ID"]. "'>
						<input type='text' name='amount' value='" . convert_amount($row["autoupdateamount"]). "' onkeypress='showSave(". $row["ID"]. ")''>
						<input name='save' type='submit' value='+' id='". $row["ID"]. "' style='display:none'>";
			if ($row["url"] != "") {$htmloutput .=	"<a target='". $row["ID"]. "' href='". $row["url"]. "'><strong>" . $row["Name"]. "</strong></a>";}
			else {$htmloutput .=	"<strong>" . $row["Name"]. "</strong>";}


			$htmloutput .= "</br>"



					;

	$saving_rate += $row["autoupdateamount"];

	}

	$htmloutput .="</div>";

// $htmloutput .="</table>";
$sum = $Cash + $Shares + $Pension;
$htmloutput  = str_replace('Cash - PLACEHOLDER', convert_amount($Cash) .' - Cash', $htmloutput);
$htmloutput  = str_replace('Pension - PLACEHOLDER',convert_amount($Pension) . ' - Pension', $htmloutput);
$htmloutput  = str_replace('Shares - PLACEHOLDER', convert_amount($Shares). ' - Shares', $htmloutput);
$htmloutput  = str_replace('Expenses - PLACEHOLDER', convert_amount($expenses). ' - Expenses', $htmloutput);
$htmloutput  = str_replace('Savings - PLACEHOLDER', convert_amount($saving_rate). ' - Savings', $htmloutput);
global $pie;
$pie = "	[
			['Cash', $Cash]
			,['Shares', $Shares]
			,['Pension', $Pension]
			]";


$htmloutput .="</div>";


$sql = "SELECT sum(autoupdateamount) as savingrate FROM `accounts`";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);


$saving_target = $expenses * 12 * 25;

$monthstilfi = ($saving_target - $sum) / $saving_rate ;
$yearstilfi = floor($monthstilfi/12);
$monthstilfi = $monthstilfi - $yearstilfi *12;

$strheader =   "<h3>" .convert_amount($sum) . " saved of " . convert_amount($saving_target). "</h3>";
$strheader .=  "<h3>" .$yearstilfi . " years & ". floor($monthstilfi) . " months until financial independence</h3>";








mysqli_close($conn);



?>
<!DOCTYPE html>
<html>
<head>
<title>Saving Tracker</title>
<script>
function showSave(id) {
    var x = document.getElementById(id);
    x.style.display = "inline";
	}
</script>

<?php
include 'charts.php';
echo file_get_contents('css.php'); ?>
<!-- <meta http-equiv="refresh" content="1" > -->
</head>
<body>
<div class='container'>
<?php
echo $strheader ;
echo $htmloutput;
?>
<div class='float' id="chart_div"></div>
<div class='summary' id="historychart_div"></div>
<div class='summary' id="chart2_div"></div>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Effort', 'Amount given'],
          ['My all',     100],
          ['65%',     65],
          ['Spending',   35],

        ]);

        var options = {
          pieHole: 0.5,
          pieSliceTextStyle: {
            color: 'black',

          },
          legend: 'none'
          ,pieStartAngle: 90
          ,enableInteractivity:false

          ,pieSliceText:'label'
          ,slices: {
            0: { color: 'transparent', textStyle: {color: 'none',}}
            ,1: { color: 'green'}
            ,2: { color: 'red', textStyle: {color: 'none',}}
          }
        };

        var chart = new google.visualization.PieChart(document.getElementById('donut_single'));
        chart.draw(data, options);
      }

</script>
       <div id="donut_single" style="width: 900px; height: 500px; clear:both;"></div>
</body>
</html>
