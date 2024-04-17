<?php
require_once 'connection.php';
session_start();	

if (isset($_POST['year'])) 
{	
	$year = $_POST['year'];
	
	$sql = "SELECT SUM(totalPay) as TotalPay, DatePay, MONTHNAME(DatePay) AS month_date, MIN(DATE_FORMAT(DatePay, '%b')) AS month_name, FROM payment WHERE YEAR(DatePay) = '$year' GROUP BY MONTH(DatePay)";


	$sql = "
		SELECT 
		    SUM(IF(month = 'Jan', total, 0)) AS 'Jan',
		    SUM(IF(month = 'Feb', total, 0)) AS 'Feb',
		    SUM(IF(month = 'Mar', total, 0)) AS 'Mar',
		    SUM(IF(month = 'Apr', total, 0)) AS 'Apr',
		    SUM(IF(month = 'May', total, 0)) AS 'May',
		    SUM(IF(month = 'Jun', total, 0)) AS 'Jun',
		    SUM(IF(month = 'Jul', total, 0)) AS 'Jul',
		    SUM(IF(month = 'Aug', total, 0)) AS 'Aug',
		    SUM(IF(month = 'Sep', total, 0)) AS 'Sep',
		    SUM(IF(month = 'Oct', total, 0)) AS 'Oct',
		    SUM(IF(month = 'Nov', total, 0)) AS 'Nov',
		    SUM(IF(month = 'Dec', total, 0)) AS 'Dec'
		FROM
		    (
		    	SELECT MIN(DATE_FORMAT(DatePay, '%b')) AS month, SUM(totalPay) AS total
		    	FROM
		        	payment
			    WHERE
			        YEAR(DatePay) = '$year'
			    GROUP BY MONTH(DatePay)
			    ORDER BY MONTH(DatePay)
		    ) AS sale";

	$result = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($result);

	if ($count > 0) 
	{
		while ($row = $result->fetch_array(MYSQLI_NUM)) 
		{
		    $data = $row; 	
		    // $data['Januari'] = $row[0];
		    // $data['February'] = $row[1];
		}

		echo json_encode($data);
	}
	
	mysqli_free_result($result);
}

if (isset($_POST['month'])) {
	$year = $_POST['yr'];
	$month = $_POST['month'];

	$sql = "SELECT 
				SUM(IF(day = '01', total, 0)) AS '01',
				SUM(IF(day = '02', total, 0)) AS '02',
				SUM(IF(day = '03', total, 0)) AS '03',
				SUM(IF(day = '04', total, 0)) AS '04',
				SUM(IF(day = '05', total, 0)) AS '05',
				SUM(IF(day = '06', total, 0)) AS '06',
				SUM(IF(day = '07', total, 0)) AS '07',
				SUM(IF(day = '08', total, 0)) AS '08',
				SUM(IF(day = '09', total, 0)) AS '09',
				SUM(IF(day = '10', total, 0)) AS '10',
				SUM(IF(day = '11', total, 0)) AS '11',
				SUM(IF(day = '12', total, 0)) AS '12',
			    SUM(IF(day = '13', total, 0)) AS '13',
				SUM(IF(day = '14', total, 0)) AS '14',
				SUM(IF(day = '15', total, 0)) AS '15',
				SUM(IF(day = '16', total, 0)) AS '16',
				SUM(IF(day = '17', total, 0)) AS '17',
				SUM(IF(day = '18', total, 0)) AS '18',
				SUM(IF(day = '19', total, 0)) AS '19',
				SUM(IF(day = '20', total, 0)) AS '20',
				SUM(IF(day = '21', total, 0)) AS '21',
				SUM(IF(day = '22', total, 0)) AS '22',
				SUM(IF(day = '23', total, 0)) AS '23',
				SUM(IF(day = '24', total, 0)) AS '24',
			    SUM(IF(day = '25', total, 0)) AS '25',
				SUM(IF(day = '26', total, 0)) AS '26',
				SUM(IF(day = '27', total, 0)) AS '27',
				SUM(IF(day = '28', total, 0)) AS '28',
			    SUM(IF(day = '29', total, 0)) AS '29',
				SUM(IF(day = '30', total, 0)) AS '30',
				SUM(IF(day = '31', total, 0)) AS '31'
			    
			FROM
			(
				SELECT DATE_FORMAT(DatePay, '%d') AS day, SUM(totalPay) AS total
				FROM payment
				WHERE YEAR(DatePay) = '$year' AND MONTH(DatePay) = '$month'
				GROUP BY DAY(DatePay)
				ORDER BY DAY(DatePay)
			) AS sale";

	$result = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($result);

	if ($count > 0) 
	{
		while ($row = $result->fetch_array(MYSQLI_NUM)) 
		{
		    $data = $row; 	
		}

		echo json_encode($data);
	}
	
	mysqli_free_result($result);
}
?>