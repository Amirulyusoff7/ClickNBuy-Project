<?php
include('../connect.php');
include "./bar/adminHeader.php";
session_start();
?>

<!DOCTYPE HTML>  
<html>
<head>

    <style>
    .error {color: #FF0000;}
    </style>
    <title>Seller Courier</title>

    <script type="text/javascript">
        function cancelUpdate() {
            fetch("editCourier.php")
            .then(response => {
                if (response.ok) {
                    window.location.href = "viewCourier.php"
                }
            })
            .catch(error => console.log(error));
        }
    </script>
    
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>

<body>      
<?php


// define variables and set to empty values
$nameErr = $feeErr = $shippingTypeErr = "";
$name = $fee = $shippingType = "";

// if btn submit is post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errorCount = 0;
    if (empty($_POST["name"])) {
        $nameErr = "Courier name is required";
        $errorCount++;
    } else {
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        // if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        //     $nameErr = "Only letters and white space allowed";
        //     $errorCount++;
        // }
    }
  
    if (empty($_POST["fee"])) {
        $feeErr = "Fee is required";
        $errorCount++;
    } else {
        $fee = test_input($_POST["fee"]);
        if (!preg_match("/^[0-9-.' ]*$/",$fee)) {
                $feeErr = "Only numbers allowed";
                $errorCount++;
            }
    }

    if (empty($_POST["shippingType"])) {
        $shippingTypeErr = "Shipping type is required";
        $errorCount++;
    } else {
        $shippingType = test_input($_POST["shippingType"]);
    }

    if($errorCount == 0 ) {
        $courierID = $_POST['hiddenCourierID'];
        $updateQuery = "UPDATE Courier SET name = '".$name."', fee='".$fee."', shippingType='".$shippingType."' WHERE courierID='".$courierID."';";
        $result = mysqli_query($conn, $updateQuery);

        if($result){
        echo '<script type="text/javascript">alert("Courier updated successfully !");window.location.href = "viewCourier.php";</script>';
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($result);
        }
        mysqli_close($conn);
        // header("Location: " . $_SERVER['PHP_SELF']);
        // exit;
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

<!-- <p><span class="error">* required field</span></p> -->
<div class="container">
<p>Courier Form</p>
<form name="courierForm" id="courierForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <?php 
    $courierID = $_GET['courierID'];
    $sql="SELECT * FROM courier WHERE courierID = '".$courierID."'";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_array($result);
    ?>
  
  Courier Name<br>
    <input type="text" name = "name" value="<?php echo $rows['name'];?>" oninput="this.className=''" required>
  <span class="error"><?php echo $nameErr;?></span><br><br>

  
  Fee Charged<br>
    <input type="text" name="fee" value="<?php echo $rows['fee'];?>" oniput="this.className=''" required>
    
    <span class="error"><?php echo $feeErr;?></span><br><br>
  
  
  Shipping<br>
    <input type="radio" name="shippingType" <?php if ($rows['shippingType'] == "West") echo "Checked";?> value="West" oniput="this.className=''" required>West
    <input type="radio" name="shippingType" <?php if ($rows['shippingType'] == "East") echo "checked";?> value="East" oniput="this.className=''" required>East 
    <span class="error"><?php echo $shippingTypeErr;?></span><br><br>
  
  
  <input type = "hidden" name="hiddenCourierID" value="<?php echo $rows['courierID']?>">
  <input type="submit" name="submit" value="Update Courier" onclick="return confirm('Changes cannot be undo. Are you sure you want to update this courier?');">
  <input type="button" name="btnCancel" id="btnCancel" onclick="cancelUpdate()" value="Cancel">
  
  </form></div>

  
</body>

<?php
include "./bar/adminfooter.php";
?>
</html>
