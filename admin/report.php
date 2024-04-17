<!-- ADMIN MAIN PAGE -->
<?php
require_once "connection.php";
// session_start();

// if (!$_SESSION['AdminID']) {
// 	header("location:index.php");
// }

$sql = "SELECT totalpay,datepay FROM payment";
$result = mysqli_query($conn,$sql);
$chart_data="";
while ($row = mysqli_fetch_array($result)) 
{ 
 	$totalpay[]  = $row['totalpay']  ;
    $datepay[] = $row['datepay'];
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Tourism Database Management System</title>

	<!-- <link rel="stylesheet" type="text/css" href="c3-0.7.20/c3.css"> -->
	<link href="c3-0.7.20/c3.css" rel="stylesheet">
	<script src="c3-0.7.20/c3.min.js"></script>
	<script src="https://d3js.org/d3.v5.min.js"></script>

	<!-- jquery libs -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/w3.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

<div class="w3-sidebar w3-black w3-bar-block w3-card w3-animate-left w3-large" style="display:none" id="mySidebar">
<button class="w3-bar-item w3-button w3-border-bottom w3-padding-16" onclick="w3_close()"><i class="fa fa-close"> Close</i></button>
<a href="admin_profile.php" class="w3-bar-item w3-button w3-border-bottom w3-padding-16"><i class="fa fa-user"> Profile</i></a>
<a href="admin_page.php" class="w3-bar-item w3-button w3-border-bottom w3-padding-16"><i class="fa fa-list"> Attraction</i></a>
<a href="promo_code.php" class="w3-bar-item w3-button w3-border-bottom w3-padding-16"><i class="fa fa-percent"> Promo Code</i></a>
<a href="report.php" class="w3-bar-item w3-button w3-border-bottom w3-padding-16"><i class="fa fa-bar-chart"> Report</i></a>
<a href="backup_recovery.php" class="w3-bar-item w3-button w3-border-bottom w3-padding-16"><i class="fa fa-database"> Backup & Recovery</i>
</a>
<a href="logout.php?user=admin" class="w3-bar-item w3-button w3-border-bottom w3-padding-16"><i class="fa fa-sign-out"> Logout</i>
</a>
</div>

<div id="wrapped">
<div class="w3-red">
<div class="w3-container">
	<button id="openNav" class="w3-button w3-red w3-xlarge" onclick="w3_open()">&#9776;</button>
  <a href="admin_page.php" id="logo">TOURISM DATABASE MANAGEMENT SYSTEM</a>
</div>
</div>  


	<div id="content">
		<div>
			<center>
				<h2>Report</h2>
					<td for="year">Year</td>
					<td>: <select name="year" id="year" style="width:20%; height: 35px">
						<option value="2018">2018</option>
						<option value="2019">2019</option>
						<option value="2020">2020</option>
						<option value="2021">2021</option>
						<option value="2022">2022</option>
					</select></td>
					<td for="month"> Month</td>
					<td>: <select name="month" id="month" style="width:20%; height: 35px">
						<option value="">--Select Month--</option>
						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select></td>
	  				<button class="w3-button w3-teal" onclick="myFunction()">Search</button>
	  			
  			</center>
		</div>
		<br>
		<div id="chart"></div>
	</div>  
		  
</div>

</body>

<script>
	function myFunction() 
	{
		var year = document.getElementById("year").value;
		var month = document.getElementById("month").value;

		
		if (month == '') {
			$.ajax({
			type: "POST",
			url: 'report_search.php',
			data: {year: year},
			dataType: "json",
				success: function(data){
				console.log(data);

					var chart = c3.generate({
					    data: {
					    	// x: 'x',

					        columns: [
					            ['Sales', data[0], data[1], data[2], data[3], data[4], data[5], data[6], data[7], data[8], data[9], data[10], data[11]]
					        ],
					        // columns: [
					        //     ['x', 30, 200, 100, 400, 150, 250],
					        //     ['data2', 130, 100, 140, 200, 150, 50]
					        // ],
					        type: 'bar'
					    },
					    bar: {
					        width: {
					            ratio: 0.5 // this makes bar width 50% of length between ticks
					        }
					        // or
					        //width: 100 // this makes bar width 100px
					    },
					    axis: {
					        x: {
					            type: 'category',
				            	categories: [
				            		'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
				            		]
					        }
					    }
					});	

					loadChart(chart);
				},
					error: function(xhr, status, error){
					console.error(xhr);
				}
			});
		} else {
			if (month == '02' && year != '2020') {
				$.ajax({
				type: "POST",
				url: 'report_search.php',
				data: {yr: year, month: month},
				dataType: "json",
					success: function(data){
					console.log(data[0]);

						var chart = c3.generate({
						    data: {
						    	columns: [

							        	['Sales', data[0], data[1], data[2], data[3], data[4], data[5], data[6], data[7], data[8], data[9], data[10], data[11], data[12], data[13], data[14], data[15], data[16], data[17], data[18], data[19], data[20], data[21], data[22], data[23], data[24], data[25], data[26], data[27]]
							            
							        ],
				        
						        type: 'bar'
						    },
						    bar: {
						        width: {
						            ratio: 0.2 // this makes bar width 50% of length between ticks
						        }
						        // or
						        //width: 100 // this makes bar width 100px
						    },
						    axis: {
						        x: {
						            type: 'category',
						            
					            	categories: [
						            		'01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28'
						            	]
						        }
						    }
						});	

						loadChart(chart);
					},
						error: function(xhr, status, error){
						console.error(xhr);
					}
				});
			} else if (month == '02' && year == '2020') {
				$.ajax({
				type: "POST",
				url: 'report_search.php',
				data: {yr: year, month: month},
				dataType: "json",
					success: function(data){
					console.log(data[0]);

						var chart = c3.generate({
						    data: {
						    	columns: [

							        	['Sales', data[0], data[1], data[2], data[3], data[4], data[5], data[6], data[7], data[8], data[9], data[10], data[11], data[12], data[13], data[14], data[15], data[16], data[17], data[18], data[19], data[20], data[21], data[22], data[23], data[24], data[25], data[26], data[27], data[28]]
							            
							        ],
				        
						        type: 'bar'
						    },
						    bar: {
						        width: {
						            ratio: 0.2 // this makes bar width 50% of length between ticks
						        }
						        // or
						        //width: 100 // this makes bar width 100px
						    },
						    axis: {
						        x: {
						            type: 'category',
						            
					            	categories: [
						            		'01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29'
						            	]
						        }
						    }
						});	

						loadChart(chart);
					},
						error: function(xhr, status, error){
						console.error(xhr);
					}
				});
			} else if (month == '04' || month == '06' || month == '09' || month == '11') {
				$.ajax({
				type: "POST",
				url: 'report_search.php',
				data: {yr: year, month: month},
				dataType: "json",
					success: function(data){
					console.log(data[0]);

						var chart = c3.generate({
						    data: {
						    	columns: [

							        	['Sales', data[0], data[1], data[2], data[3], data[4], data[5], data[6], data[7], data[8], data[9], data[10], data[11], data[12], data[13], data[14], data[15], data[16], data[17], data[18], data[19], data[20], data[21], data[22], data[23], data[24], data[25], data[26], data[27], data[28], data[29]]
							            
							        ],
				        
						        type: 'bar'
						    },
						    bar: {
						        width: {
						            ratio: 0.2 // this makes bar width 50% of length between ticks
						        }
						        // or
						        //width: 100 // this makes bar width 100px
						    },
						    axis: {
						        x: {
						            type: 'category',
						            
					            	categories: [
						            		'01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'
						            	]
						        }
						    }
						});	

						loadChart(chart);
					},
						error: function(xhr, status, error){
						console.error(xhr);
					}
				});
			} else {
				$.ajax({
				type: "POST",
				url: 'report_search.php',
				data: {yr: year, month: month},
				dataType: "json",
					success: function(data){
					console.log(data[0]);

						var chart = c3.generate({
						    data: {
						    	columns: [

							        	['Sales', data[0], data[1], data[2], data[3], data[4], data[5], data[6], data[7], data[8], data[9], data[10], data[11], data[12], data[13], data[14], data[15], data[16], data[17], data[18], data[19], data[20], data[21], data[22], data[23], data[24], data[25], data[26], data[27], data[28], data[29], data[30]]
							            
							        ],
				        
						        type: 'bar'
						    },
						    bar: {
						        width: {
						            ratio: 0.2 // this makes bar width 50% of length between ticks
						        }
						        // or
						        //width: 100 // this makes bar width 100px
						    },
						    axis: {
						        x: {
						            type: 'category',
						            
					            	categories: [
						            		'01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'
						            	]
						        }
						    }
						});	

						loadChart(chart);
					},
						error: function(xhr, status, error){
						console.error(xhr);
					}
				});
			}
			
		}

		
	}


	function loadChart(chart) 
	{
		setTimeout(function () {
	    chart.load({
	        columns: [
	            // ['data2', 130, 150, 200, 300, 200]
	        ]
	    });
	}, 1000);
	}

	
</script>


<?php

include "footer.php";

?>