<?php
        include_once "./config/config.php";
// session_start();

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
                
                    <?php
                        include "./bar/adminHeader.php";
                        include "./bar/sidebar.php";
                        include_once "./config/config.php";
                    ?>

                            <title>Payment Page</title>
                        </head>
                        <body>
                        <div class="container">
                            <h2>Payment</h2>
                            <form action="cardPayment.php" method="post">
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <input type="text" name="card_number" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <label for="expiration">Expiration Date:</label>
                                    <select name="expiration_month" id="expiration_month" class="form-control">
                                        <?php
                                        for ($i = 1; $i <= 12; $i++) {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                        ?>
                                    </select>
                                    <select name="expiration_year" id="expiration_year" class="form-control">
                                        <?php
                                        $current_year = date("Y");
                                        for ($i = $current_year; $i <= $current_year + 10; $i++) {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>CVV</label>
                                    <input type="text" name="cvv" class="form-control ">
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="text" name="amount" class="form-control" >
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="paymentDate" class="form-control"  id="paymentDate" >
                                    <!-- <input type="hidden" name="transactionType" class="form-control"  id="transactionType"> -->
                                </div>
                                <input type="hidden" name="transactionType" id="transactionType" value="Debit/Credit Card">
                                <input type="submit" value="Submit Payment">
                                <!-- <input type="submit" class="btn btn-primary" > -->
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
    $amount = $_POST['amount'];
    $transactionType = $_POST['transactionType'];
    $paymentDate = $_POST['paymentDate'];
    // echo $transactionType;

    // Insert the address into the database
    $sql = "INSERT INTO payment (amount, paymentDate, transactionType) VALUES ('$amount', NOW(), '$transactionType')";
    mysqli_query($conn,$sql);
  

    // Redirect to the account page
}
?>

<script>
//     window.onload = function() {
                
//                 var today = new Date();
//                 var dd = String(today.getDate()).padStart(2, '0');
//                 var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
//                 var yyyy = today.getFullYear();

//                 today = yyyy + '-' + mm + '-' + dd;
//                 document.getElementById('paymentDate').value = today;
// }

window.onload = function() {
    document.getElementById("transactionType").value = "Debit/Credit Card";
}
</script>