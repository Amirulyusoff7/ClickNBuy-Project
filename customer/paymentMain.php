<?php include('../connect.php');
session_start();

$qry = "SELECT * FROM customer WHERE username='" . $_SESSION['ses'] . "'";
$result = mysqli_query($conn,$qry);
$rows=mysqli_fetch_array($result);
$cusID = $rows['customerID'];

?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin</title>
  <link rel="icon" href = "./assets/img/logo1.png"> 
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css/style.css"></link>
  </head>
<body>


            <div style="text-align: center;">
                <label>Please Select Your Payment Method</label>
                <br>
                <!-- <input type="submit" class="btn btn-primary" value="Debit/Credit Card" > &nbsp; <input type="submit" class="btn btn-primary" value="Online Banking"> -->
                <a onclick="return confirm('Are you sure you want to choose Debit/Credit Card?')" href="cardPayment.php?customerid=<?php echo $cusID?>">Debit/Credit Card</a>&nbsp;<a onclick="return confirm('Are you sure you want to choose Online Banking?')"href="onlinePayment.php ?customerid=<?php echo $cusID?>">Online Banking</a>
            </div>


</body>
</html>