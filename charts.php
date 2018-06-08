 <!--Load the AJAX API-->
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawChart2);
      google.charts.setOnLoadCallback(drawChart3);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
function drawChart() {
		
		
        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
<?php echo "data.addRows($pie);" ?>
        // Set chart options
        var options = {'title':'',
                       'width':400,
                       'height':300,
                       legend: 'none'};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        }
        
function drawChart2() {
		var jsonData = $.ajax({
          url: "monthlyjson.php",
          dataType: "json",
          async: false
          }).responseText;
          
		// Create the data table.
        var data = new google.visualization.DataTable(jsonData); 
        

        // Set chart options
        var options = {'title':'',
                       legend: 'bottom',
                      
                       'height':300,
                       vAxis: { format:'£#,###'},
                       isStacked: true};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('historychart_div'));
        chart.draw(data, options);    
        
        
        function resizeChart () {
					chart.draw(data, options);
				}
				if (document.addEventListener) {
					window.addEventListener('resize', resizeChart);
				}
				else if (document.attachEvent) {
					window.attachEvent('onresize', resizeChart);
				}
				else {
					window.resize = resizeChart;
				}
    
      }
      
      
function drawChart3() {

		var jsonData = $.ajax({
          url: "totalsjson.php",
          dataType: "json",
          async: false
          }).responseText;
          
        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Total');
		data.addRows([["201709",160227],["201710",163379],["201711",166723],["201712",168797],["201801",174246],["201802",171873],["201803",171755],["201804",177655]]);
        
        
        // Set chart options
        var options = {'title':'',
                       'height':300,
                       vAxis: { format:'£#,###'},
                       
                       legend: 'none'};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.AreaChart(document.getElementById('chart2_div'));
        chart.draw(data, options);    
        
    function resizeChart () {
    chart.draw(data, options);
}
if (document.addEventListener) {
    window.addEventListener('resize', resizeChart);
}
else if (document.attachEvent) {
    window.attachEvent('onresize', resizeChart);
}
else {
    window.resize = resizeChart;
}
      }

    </script>