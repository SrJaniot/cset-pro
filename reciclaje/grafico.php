<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1.1", {packages:["bar"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
		  
        var data = google.visualization.arrayToDataTable([
          ['area', 'correctas', 'Erradas', 'sin contestar'],
          ['mate', '75%', '20%', '5%'],
          ['ingles', '20%', '50%', '30%'],
          ['ciudadana', '50%', '50%', '0%'],
          ['lectura', '78%', '2%', '20%'],
        ]);
		
		/*
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Month'); // Implicit domain label col.
		data.addColumn('number', 'Sales'); // Implicit series 1 data col.
		data.addColumn({type:'number', role:'interval'});  // interval role col.
		data.addColumn({type:'number', role:'interval'});  // interval role col.
		data.addColumn({type:'string', role:'annotation'}); // annotation role col.
		data.addColumn({type:'string', role:'annotationText'}); // annotationText col.
		data.addColumn({type:'boolean',role:'certainty'}); // certainty col.
		data.addRows([
			['April',1000,  900, 1100,  'A','Stolen data', true],
			['May',  1170, 1000, 1200,  'B','Coffee spill', true],
			['June',  660,  550,  800,  'C','Wumpus attack', true],
			['July', 1030, null, null, null, null, false]
		]);
		*/

        var options = {
          chart: {
            title: 'Company Performance',
            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          },
		  colors: ['#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6']
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="columnchart_material" style="width: 500px; height: 500px;"></div>
  </body>
</html>
