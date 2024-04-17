<?php
include('dbConnection.php');
include("../seller/bar/headerSeller.php");
session_start();
?>

<!DOCTYPE HTML>  
<html>
<head>

    <style>
    .error {color: #FF0000;}
    </style>
    <title>Courier</title>

    <script type="text/javascript">
        function cancelDelete() {
            fetch("../seller/deleteCourier.php")
            .then(response => {
                if (response.ok) {
                    window.location.href = "../seller/viewCourier.php"
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
    
    
    $courierID = $_POST['hiddenCourierID'];
    $deleteQuery = "DELETE FROM Courier WHERE courierID='".$courierID."';";
    $result = mysqli_query($conn, $deleteQuery);

    if($result){
    echo '<script type="text/javascript">alert("Courier deleted successfully !");window.location.href = "../seller/viewCourier.php";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($result);
    }
    mysqli_close($conn);

}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

<div class="container">
<p>Courier Form</p>
<form name="courierForm" id="courierForm" method="post" action="../seller/deleteCourier.php">  
  <?php 
    $courierID = $_GET['courierID'];
    $sql="SELECT * FROM courier WHERE courierID = '".$courierID."'";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_array($result);
    ?>
  
  Courier Name<br>
    <input type="text" name = "name" value="<?php echo $rows['name'];?>" oninput="this.className=''" readonly>
  
  <br>
  <br>
 
  Fee Charged<br>
    <input type="text" name="fee" value="<?php echo $rows['fee'];?>" oniput="this.className=''" readonly>
     
  <br>
  <br>

  Shipping<br>
    <input type="text" name="shippingType" value="<?php echo $rows['shippingType'];?>" oniput="this.className=''" readonly>
      
  <br>
  <br>

    <input type = "hidden" name="hiddenCourierID" value="<?php echo $rows['courierID']?>">
    <input type="submit" name="submit" value="Delete Courier" onclick="return confirm('Changes cannot be undo. Are you sure you want to delete this courier?');">
    <input type="button" name="btnCancelDel" id="btnCancelDel" onclick="cancelDelete()" value="Cancel">
  </form></div>

  
</body>

</html>
