<?php
// Include config file
include('../connect.php');
 
// Define variables and initialize with empty values
$name = $phoneNo = $email = "";
$name_err = $phoneNo_err = $email_err = "";

 
// Processing form data when form is submitted
if(isset($_POST["adminID"]) && !empty($_POST["adminID"])){
    // Get hidden input value
    $adminID = $_POST["adminID"];

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

    // Check input errors before inserting in database
    if(empty($name_err) && empty($phoneNo_err) && empty($email_err)){
        // Prepare an update statement
        $sql = "UPDATE admin SET name=?, phoneNo=?, email=? WHERE adminID=?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
			//sssi = string,string,string,integer
			// might change datatype tu varchar in database
            mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_phoneNo, $param_email, $param_adminID);

            // Set parameters
            $param_name = $name;
            $param_phoneNo = $phoneNo;
            $param_email = $email;
            $param_adminID = $adminID;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: adminUser.php");
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
    if(isset($_GET["adminID"]) && !empty(trim($_GET["adminID"]))){
        // Get URL parameter
        $adminID =  trim($_GET["adminID"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM admin WHERE adminID = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_adminID);
            
            // Set parameters
            $param_adminID = $adminID;
            
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
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: adminUser.php");
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
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <textarea name="phoneNo" class="form-control <?php echo (!empty($phoneNo_err)) ? 'is-invalid' : ''; ?>"><?php echo $phoneNo; ?></textarea>
                            <span class="invalid-feedback"><?php echo $phoneNo_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <input type="hidden" name="adminID" value="<?php echo $adminID; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit" onclick="return confirm('Are you sure you want to update the details?');">
                        <a href="adminUser.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>
    <script type="text/javascript" src="./assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>