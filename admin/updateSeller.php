<?php
// Include config file
include('../connect.php');
 
// Define variables and initialize with empty values
$name = $phoneNo = $email = $username = $password = $pin = $shopName = $pickUpAddress ="";
$name_err = $phoneNo_err = $email_err = $username_err = $password_err = $pin_err = $shopName_err = $pickUpAddress_err = "";

// Processing form data when form is submitted
if(isset($_POST["sellerID"]) && !empty($_POST["sellerID"])){
    // Get hidden input value
    $sellerID = $_POST["sellerID"];

    // Validate  name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a username.";
    } else{
        $name = $input_name;
    }

    // Validate phoneNo
    $input_phoneNo = trim($_POST["phoneNo"]);
    if(empty($input_phoneNo)){
        $phoneNo_err = "Please enter phone number.";
    } else{
        $phoneNo = $input_phoneNo;
    }
    
    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter email.";
    } else{
        $email = $input_email;
    }

    // Validate Username
    $input_username = trim($_POST["username"]);
    if(empty($input_username)){
        $username_err = "Please enter username.";
    } else{
        $username = $input_username;
    }

    // Validate Password
    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "Please enter password.";
    } else{
        $password = $input_password;
    }

    // Validate Secret Pin
    $input_pin = trim($_POST["pin"]);
    if(empty($input_pin)){
        $pin_err = "Please enter pin.";
    } else{
        $pin = $input_pin;
    }

    // Validate ShopName
    $input_shopName = trim($_POST["shopName"]);
    if(empty($input_shopName)){
        $shopName_err = "Please enter shopName.";
    } else{
        $shopName = $input_shopName;
    }

    // Validate pickUpAddress
    $input_pickUpAddress = trim($_POST["pickUpAddress"]);
    if(empty($input_pickUpAddress)){
        $pickUpAddress_err = "Please enter pickUpAddress.";
    } else{
        $pickUpAddress = $input_pickUpAddress;
    }


    // Check input errors before inserting in database
    if(empty($name_err) && empty($phoneNo_err) && empty($email_err) && empty($username_err) && empty($password_err) && empty($pin_err) && empty($shopName_err) && empty($pickUpAddress_err)){
        // Prepare an update statement
        $sql = "UPDATE seller SET name=?, phoneNo=?, email=?, username=?, password=?, pin=?, shopName=?, pickUpAddress=? WHERE sellerID=?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
			//sssi = string,string,string,integer
			// might change datatype tu varchar in database
            mysqli_stmt_bind_param($stmt, "ssssssssi", $param_name, $param_phoneNo, $param_email, $param_username, $param_password, $param_pin, $param_shopName, $param_pickUpAddress, $param_sellerID);

            // Set parameters
            $param_name = $name;
            $param_phoneNo = $phoneNo;
            $param_email = $email;
            $param_username = $username;
            $param_password = $password;
            $param_pin = $pin;
            $param_shopName = $shopName;
            $param_pickUpAddress = $pickUpAddress;
            $param_sellerID = $sellerID;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: sellerUser.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);

} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["sellerID"]) && !empty(trim($_GET["sellerID"]))){
        // Get URL parameter
        $sellerID =  trim($_GET["sellerID"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM seller WHERE sellerID = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_sellerID);
            
            // Set parameters
            $param_sellerID = $sellerID;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["name"];
                    $phoneNo = $row["phoneNo"];
                    $email = $row["email"];
                    $username = $row["username"];
                    $password = $row["password"];
                    $pin = $row["pin"];
                    $shopName = $row["shopName"];
                    $pickUpAddress = $row["pickUpAddress"];

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: sellerUser.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($conn);
        
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       <link rel="stylesheet" href="./assets/css/style.css">

    <style>
        .wrapper{
            width: 900px;
            margin: 0 auto;
        }

        .container-fluid{
            height: 100%;
            margin: 0; 
            padding: 0; 
        }
    </style>

</head>
<body>
     <?php
            include "./bar/adminHeader.php";
            include "./bar/sidebar.php";

        ?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Details</h2>
                    <p>Please edit the input values and submit to update the admin details.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Seller Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Shop Number</label>
                            <textarea name="shopName" class="form-control <?php echo (!empty($shopName_err)) ? 'is-invalid' : ''; ?>"><?php echo $shopName; ?></textarea>
                            <span class="invalid-feedback"><?php echo $shopName_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phoneNo" class="form-control <?php echo (!empty($phoneNo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phoneNo; ?>">
                            <span class="invalid-feedback"><?php echo $phoneNo_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Pick Up Address</label>
                            <input type="text" name="pickUpAddress" class="form-control <?php echo (!empty($pickUpAddress_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pickUpAddress; ?>">
                            <span class="invalid-feedback"><?php echo $pickUpAddress_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Secret Pin</label>
                            <input type="text" name="pin" class="form-control <?php echo (!empty($pin_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pin; ?>">
                            <span class="invalid-feedback"><?php echo $pin_err;?></span>
                        </div>
                        <input type="hidden" name="sellerID" value="<?php echo $sellerID; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit" onclick="return confirm('Are you sure you want to update the details?');">
                        <a href="sellerUser.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>

    <!-- <?php
            include "./bar/adminfooter.php";

    ?> -->

    <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>
    <script type="text/javascript" src="./assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

</body>

</html>