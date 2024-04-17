<?php
 include('../connect.php');
 session_start();

// $qry = "SELECT * FROM `customer` WHERE customerID= '" . $_SESSION['username'] . "'";
// $result = mysqli_query($conn,$qry);
// $rows=mysqli_fetch_array($result);
// $customerID = $rows['customerID'];


?>

</script>
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
                            <link rel="stylesheet" href="./assets/css/payment.css"></link>
                        </head>
                </head>
            <body >
                
                    <!-- <?php
                        include "./bar/adminHeader.php";
                        include "./bar/sidebar.php";
                        include_once "./config/config.php";
                    ?> -->

                            <title>Payment Page</title>
                        </head>
                        <body>
                        <div class="container">
                            <h2>Payment</h2>
                            <form action="onlinePayment.php" method="post">
                                <input type="hidden" name="transactionType" value="Online Banking">
                                <label>Account Number:</label>
                                <input type="text" name="accountNumber"><br>
                                <label>Bank Name:</label>
                                <input type="text" name="bankName"><br>
                                <label>Amount:</label>
                                <input type="text" name="amount" value="<?php echo $_SESSION['gtotal']; ?>"readonly><br>
                                <div class="form-group">
                                    <input type="hidden" name="paymentDate" class="form-control"  id="paymentDate">
                                </div>
                                <input type="submit" value="Submit" >
                                
                            </form>

                        </div>
<br>


                <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>    
                <script type="text/javascript" src="./assets/js/script.js"></script>
                <script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
            
            
            </body>
</html>


<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){

    $amount = $paymentDate = $transactionType = "";

    // Get the address information from the form
    $amount =  $_SESSION['gtotal'];
    $transactionType = $_POST['transactionType'];
    $paymentDate = $_POST['paymentDate'];
    // echo $transactionType;

    // Insert the address into the database
    $sql = "INSERT INTO payment ( paymentDate, transactionType,amount, paymentStatus) VALUES ( NOW(), '$transactionType','$_SESSION[gtotal]', 'Paid')";
    $result=mysqli_query($conn,$sql);
    if($result){
        echo "<script>document.location='order.php'</script>";
    }
    // echo $result;
}
?>

<script>


window.onload = function() {
    // Get the hidden input field to store the date
    var input = document.getElementById("paymentDate");
  
    // Generate a random date
    var date = new Date();
    var year = date.getFullYear();
    var month = (date.getMonth() + 1).toString().padStart(2, "0");
    var day = date.getDate().toString().padStart(2, "0");
  
    // Set the value of the hidden input field to the random date
    input.value = year + "-" + month + "-" + day;
  }

window.onload = function() {
    document.getElementById("transactionType").value = "Online Banking";
}
</script>