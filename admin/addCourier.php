<?php
include('../connect.php');
session_start();
include("../admin/bar/adminheader.php");
?>

<!DOCTYPE HTML>  
<html>
<head>
<!-- <style>
.form-text {color: #FF0000;}
</style> -->
<title>Seller Courier</title>

<!-- BOOTSTRAP -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" 
rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

<script type="text/javascript">
  function cancelAdd() {
    fetch("addCourier.php")
    .then(response => {
        if (response.ok) {
            window.location.href = "viewCourier.php"
        }
    })
    .catch(error => console.log(error));
  }
</script>

</head>

<body>  
    
<?php
// define variables and set to empty values
$nameErr = $feeErr = $shippingTypeErr = "";
$name = $fee = $shippingType = "";

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
    $insertQuery = "INSERT INTO Courier (name, fee, shippingType) VALUES ('$name', '$fee', '$shippingType')";
    $result = mysqli_query($conn, $insertQuery);

    if($result){
      echo '<script type="text/javascript">alert("Courier added successfully !");window.location.href = "viewCourier.php";</script>';
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
<br><br><br>
<div class="container"; >
<form name="courierForm" id="courierForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
<div class="container">
  
  <div class="form-group">
    <label for="courierNameInput">Courier Name</label>
      <input class="form-control" id="courierNameInput" type="text" name = "name" aria-describedby="nameError" required>
      <small id="nameError" class="form-text" style="color: #FF0000;"><?php echo $nameErr;?></small>
  </div>
  <br>
  <div class="form-group">
    <label for="feeChargedInput">Fee Charged</label>
    <input class="form-control" type="text" name="fee" id="feeChargedInput" aria-describedby="feeError" required>
    <small id="feeError" class="form-text" style="color: #FF0000;"><?php echo $feeErr;?></small>
  </div>
  <br>
  <div class="form-group">
    <label for="shippingTypeInput">Shipping Location</label>
    <br>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="shippingType" id="shippingType1" value="West">
      <label class="form-check-label" for="shippingType1">West</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="shippingType" id="shippingType2" value="East">
      <label class="form-check-label" for="shippingType2">East</label>
    </div> 
  </div>
  <div class="form-group">
    <small id="shippingError" class="form-text" style="color: #FF0000;"><?php echo $shippingTypeErr;?></small>
  </div>
  <br>
  
  <input class="btn btn-primary" type="submit" name="submit" value="Add Courier" onclick="return confirm('Are you sure you want to add this courier?');">  
  <input class="btn" type="button" name="btnCancel" value="Cancel" onclick="cancelAdd();" value="Cancel">  
  </div>
  </form>
  </div>

  
</body>

</html>
