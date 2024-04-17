<?php
include("../connect.php");


if (isset($_POST['btn-confirm'])) {
    // Get the selected value from the combobox
    $orderID = $_POST['hiddenOrderID'];
    //echo "<script type='text/javascript'>alert(".$orderID.");</script>";
    $dateShip = $_POST['shippingDate'];
    $selected = $_POST['categoryCombobox'];
    $trackNo = $_POST['trackingNum'];
  
    // Insert the selected value into the database
    $insertQuery = "INSERT INTO `delivery` (trackingNumber,shippingDate, receiveDate, deliveryStatus, courierID) VALUES ('$trackNo', '$dateShip', '', 'To receive','$selected')";
    $result = mysqli_query($conn, $insertQuery);

    if($result){
        $sql = "SELECT LAST_INSERT_ID();";
        $result2 = $conn->query($sql);

        if (mysqli_num_rows($result2) > 0) {
        // output data of each row
            while($row = $result2->fetch_assoc()) {
                $deliveryID = $row["LAST_INSERT_ID()"];
            }
            $orderStatus = "Shipping";
            //echo "<script type='text/javascript'>alert(".$deliveryID.");</script>";
            //echo "<script type='text/javascript'>alert('".$orderStatus."');</script>";
            $updateOrderStatus = "UPDATE `order` SET `orderStatus` = '" . $orderStatus . "'  WHERE  orderID = ".$orderID.";";
            if($conn->query($updateOrderStatus) === TRUE) {
                //echo "<script type='text/javascript'>alert('Updated orderstatus!');</script>";
                // echo "<script type='text/javascript'>alert(".$deliveryID.");</script>";
                $updateOrderList = "UPDATE `orderlist` SET deliveryID = " . $deliveryID . " WHERE  orderID = ".$orderID.";";
                if($conn->query($updateOrderList) === TRUE) {
                    //echo "<script type='text/javascript'>alert('updated deliveryID!');</script>";
                    mysqli_close($conn);
                    // header("Location: manageOrder.php");
                    echo "<script type='text/javascript'>alert('Delivery details completed !'); window.location.href = 'manageOrder.php';</script>";
                } else {
                    echo "Error: ". $sql . "<br>" . $conn->error;
                }$conn->close();
            } else {
                echo "Error: ". $sql . "<br>" . $conn->error;
            }
        }   
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($result);
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <script type="text/javascript">
            window.onload = function() {
                var orderID1 =<?= $_GET['orderID1'];?>;
                document.getElementById("hiddenOrderID").value = orderID1;

                // Generate a random number between 100000 and 999999
                const trackingNumber = Math.floor(Math.random() * 900000) + 100000;
                
                // Return the tracking number as a string
                // return trackingNumber.toString();
                var textbox = document.getElementById('trackingNum');
                trackingNumberFinal = "CNB" + trackingNumber + "MY";
                textbox.value = trackingNumberFinal.toString();
            

                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
                var yyyy = today.getFullYear();

                today = yyyy + '-' + mm + '-' + dd;
                document.getElementById('shippingDate').value = today;                                                                    
            }
            
            function cancelShipping() {
                fetch("../seller/deliveryForm.php")
                .then(response => {
                    if (response.ok) {
                        window.location.href = "../seller/manageOrder.php"
                    }
                })
                .catch(error => console.log(error));
            }
        </script>

    </head>
    <body>
        <div class="container">
        <p>Delivery Details Form</p>
        
            <form id="delivery-form" method="POST" action="../seller/deliveryForm.php">
            <input type="hidden" id="hiddenOrderID" name="hiddenOrderID" >
                <table border="1">
                    <tr><td>Shipping Date</td>
                        <td><input type="date" value="<?php echo date('Y-m-d'); ?>" id="shippingDate" name="shippingDate"></td>
                    </tr>
                    <tr><td>Tracking Number</td>
                        <td><input type="text" name="trackingNum" id="trackingNum" readonly></td>
                    </tr>

                    <tr><td>Courier</td>
                        <td><?php
                        $sql = "SELECT * FROM `courier` ORDER BY shippingType DESC, name ASC";
                        $result = mysqli_query($conn, $sql);
                        
                        // Create the combobox
                        echo '<select name="categoryCombobox" id="categoryCombobox">';
                        if($result){
                            // Loop through the results and add each row to the combobox
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<option value="' . $row['courierID'] . '">' . $row['name'].' (RM '. $row['fee'].', '. $row['shippingType'] .')'.'</option>';
                            }
                            echo '</select>';
                            
                        }
                        ?></td></tr>
                        <tr><td>Shipping Details</td><td><?php

                        $orderID2 = $_GET['orderID1'];
                        $addressQuery = "SELECT * FROM `productOption`,`orderlist`,`order`,`address` WHERE 
                        `productOption`.productOptionID = `orderlist`.productOptionID AND
                        `orderList`.orderID = `order`.orderID AND
                        `order`.addressID = `address`.addressID AND 
                        `orderlist`.orderID = ".$orderID2.";";
                        $addressResult = mysqli_query($conn, $addressQuery);

                        $productQuery = "SELECT * FROM `productOption`,`orderlist`,`product` WHERE 
                        `productOption`.productOptionID = `orderlist`.productOptionID AND
                        `productOption`.productID = `product`.productID AND
                        `orderlist`.orderID = ".$orderID2.";";
                        $productResult = mysqli_query($conn, $productQuery);

                        

                        if($addressResult){
                            $count = 0;
                            while($address = mysqli_fetch_array($addressResult)){
                                if($count < 1)
                                {
                                    echo $address['name']."<br>".$address['phoneNo']."<br>".$address['houseNo'].",".$address['streetName']."<br>".$address['city'].",".$address['postcode'];
                                    $count++;
                                }
                            }
                        }
                        ?></td></tr>

                        </table><table border="1">

                        <tr><td colspan="2">Product(s)</td></tr>
                        <?php
                        if($productResult){
                            while($product = mysqli_fetch_array($productResult)){
                                echo "<tr><td colspan='2'>".$product['name']."&nbsp RM".$product['unitPrice']."<br>".$product['variationName1'].": ".$product['variation1']."<br>".$product['variationName2'].": ".$product['variation2']."</td></tr>";
                              
                            }
                        }

                        // Close the connection

                        mysqli_close($conn);
                        ?>
                    
                    <tr><td colspan="2"><input type="submit" name="btn-confirm" id="btn-confirm" value="Confirm" onclick="return confirm('Are you sure you want to ship this parcel?');">
                    <button name="btn-cancel-delivery" id="btn-cancel-delivery" onclick="cancelShipping()">Cancel</button></td></tr>

                </table>
            </form>
        </div>
    </body>
</html>