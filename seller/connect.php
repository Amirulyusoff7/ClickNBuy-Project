<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'clicknbuy';
$conn = mysqli_connect($host,$user,$pass,$db);
//echo "Database Connected";


if (!$conn) {

	echo "Fail";
}
?>