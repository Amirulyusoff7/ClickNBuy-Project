


<?php
        include_once "./config/config.php";
// session_start();

// $query ="SELECT * FROM admin ORDER BY adminID DESC limit 1";
// $result = mysqli_query($conn,$query);
// $row = mysqli_fetch_array($result);

$qry = "SELECT * FROM `customer` WHERE customerID= '" . $_SESSION['username'] . "'";
$result = mysqli_query($conn,$qry);
$rows=mysqli_fetch_array($result);
$customerID = $rows['customerID'];
$customerID = '2';

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
                </head>
            <body >
                
                    <?php
                        include "./bar/adminHeader.php";
                        include "./bar/sidebar.php";
                        include_once "./config/config.php";
                    ?>


                            <div class="container" style="width: 50%;">
                                <form action="#" method="post">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="text" name="phoneNo" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>House Number</label>
                                        <input type="text" name="houseNo" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Street Name</label>
                                        <input type="text" name="streetName" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="city" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Postal Code</label>
                                        <input type="text" name="postcode" class="form-control">
                                    </div>
                                    <input type="submit" class="btn btn-primary" value="Add Address">
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
    // session_start();

    // Get customer ID from the session
    // $customerID = $_SESSION['customerID'];

    $name = $phoneNo = $houseNo = $streetName = $city = $postcode = "";

    // Get the address information from the form
    $name = $_POST['name'];
    $phoneNo = $_POST['phoneNo'];
    $houseNo = $_POST['houseNo'];
    $streetName = $_POST['streetName'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];

    // Insert the address into the database
    $sql = "INSERT INTO address (name, phoneNo, houseNo, streetName, city, postcode, customerID) VALUES ('$name', '$phoneNo', '$houseNo', '$streetName', '$city', '$postcode', '$customerID')";
   mysqli_query($conn,$sql);
    // $stmt->bind_param("sssssss", '$name', '$phoneNo',' $houseNo', '$streetName', '$city', '$postcode', '$customerID');
    // $stmt->execute();

    // Redirect to the account page
  
?>

