<?php include("dbConnection.php"); 
// /include("header.php");
session_start();
$qry = "SELECT * FROM `seller` WHERE username='" . $_SESSION['username'] . "'";
$result = mysqli_query($conn,$qry);
$rows=mysqli_fetch_array($result);
$sellerID = $rows['sellerID'];


     
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($conn->connect_error) {
        die ("Connection failed: " . $conn->connect_error);
    }

    // $allCatStatus = false;
    // $prodOptStatus = false;
    $prodID = $_POST["hiddenProdID"];
    $prodName = $_POST["productName"];
    $prodName = filter_var($prodName, FILTER_SANITIZE_STRING);
    $description = $_POST["description"];
    
    $oneCol = $_POST["oneCol"];
    $twoCol=false;
    // $twoCol = $_POST["twoCol"];
    if(!empty($_POST["twoCol"])){
        $twoCol = true;
    } else {
        $twoCol = false;
    }
    echo $oneCol ."-One<br>";
    echo $twoCol ."-twocol<br>";
    echo $prodID ."-prodID<br>";
    
    if($oneCol == false){
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        echo $price ."<br>";
        echo $stock ."<br>";
    }
    
    if($oneCol == true) {
        $vName1 = $_POST["vName1"];
        //$option1 = $_POST["option1"];
        $priceArr = $_POST["priceOption"];
        $stockArr = $_POST["stockOption"];
        $prodOptID = $_POST["prodOptID"];
        $pMax = count($priceArr);
        echo $vName1 ."<br>";
        echo $pMax ."<br>";
        if($twoCol == true) {
            $vName2 = $_POST["vName2"];
            //$option2 = $_POST["option2"];
            echo $vName2 ."<br>";
        }

        foreach ($priceArr as $value){
            echo $value . " ";
        }

        foreach ($stockArr as $value){
            echo $value . " ";
        }

        foreach ($prodOptID as $value){
            echo $value . " ";
        }
    }
    $p = -1;

    if(!empty($_POST["field1"])){
        
        $deleteQuery = "DELETE FROM prod_category WHERE productID='".$prodID."';";
        $result = mysqli_query($conn, $deleteQuery);

        if($result){
            echo "All category deleted successfully !";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($result);
        }
        
        $categories = $_POST["field1"];
        foreach($categories as $category)
        {
            $catQuery = "INSERT INTO prod_category (productID, categoryID) VALUES ('$prodID','$category')";
            $catQuery_result = mysqli_query($conn, $catQuery);
            if($catQuery_result){
                $allCatStatus = true;
            } else if (!$catQuery_result){
                $allCatStatus = false;
                exit;
            }
        }
    }else{
        echo "no update for categories";
    }
    
    $image = $_POST['image'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    //$image_size = filesize($image);
    $image_tmp_name = tempnam(sys_get_temp_dir(), 'image');
    $image_size = filesize($image_tmp_name);
    $image_folder = 'images/'.$image;
    $old_image = $_POST['old_image'];

    if(!empty($image)){
        if($image_size > 2000000){
            echo "<script type='text/javascript'>alert('Images size too large.');</script>";
            return;
        }else{
           $update_image = $conn->prepare("UPDATE `product` SET image = ? WHERE productID = ?");
           $update_image->bind_param("is", $image, $prodID);
           if($update_image->execute()){
              move_uploaded_file($image_tmp_name, $image_folder);
              //unlink('images/'.$old_image);
              $message[] = 'image updated successfully!';
           };
        };
     };

    $updatesql = 'UPDATE `product` SET name="'.$prodName.'", description="'.$description.'" WHERE productID ="'.$prodID.'";'; 
    $result = mysqli_query($conn, $updatesql);

    $updateProdOptStatus = false;
    if($result){
        echo "HI";
        echo $oneCol;
        echo $twoCol;
        if($oneCol == false){
            echo "update using normal one";
            
           
            $updatequery = 'UPDATE `productoption` SET unitPrice="'.$price.'", stockQuantity="'.$stock.'" WHERE productID ="'.$prodID.'";'; 
            $updateProdOptResult = mysqli_query($conn, $updatequery);
            if($updateProdOptResult){
                $updateProdOptStatus = true;
            } else if (!$updateProdOptResult) {
                $updateProdOptStatus = false;
                exit;
            }
            
        }
        
        if($oneCol == true || $twoCol == true) {
            echo "update using onecol / twocol";
            
            for ($i = 0; $i < $pMax; $i++){
                $updatequery = "UPDATE `productoption` SET unitPrice='".$priceArr[$i]."', stockQuantity='".$stockArr[$i]."' WHERE productOptionID ='".$prodOptID[$i]."';"; 
                $updateProdOptResult = mysqli_query($conn, $updatequery);
                if($updateProdOptResult){
                    $updateProdOptStatus = true;
                } else if (!$updateProdOptResult) {
                    $updateProdOptStatus = false;
                    exit;
                }
            }
        }
        if($updateProdOptStatus){
            echo '<script type="text/javascript">alert("Product updated successfully !");window.location.href = "../seller/myProduct.php";</script>';
        }
    
    } else {
        echo "Error: " . $updatesql . "<br>" . mysqli_error($result);
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<meta charset="utf-8">
    <head>
        <title>ClickNBuy Seller Centre</title>
        
        <script src="multiselect-dropdown.js"></script>
        <link rel="stylesheet" href="style.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- JS & CSS library of MultiSelect plugin -->
        <script src="multiselect/jquery.multiselect.js"></script>
        <link rel="stylesheet" href="multiselect/jquery.multiselect.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

        <style>
            #tooltip {
                display: none;
                position: absolute;
                background-color: #DBF3FA ;
                padding: 13px;
                font-size: 12px;
            }
        </style>
    </head>
    <body>
        
    <?php 
        $productID = $_GET['productID'];
        // echo "ProductID ".$productID;
        $sql3="SELECT * FROM productoption, product 
        WHERE productoption.productID = product.productID AND
        productoption.productID = '".$productID."'";
        $allProdResults = mysqli_query($conn, $sql3);
        $allProdRows = mysqli_fetch_array($allProdResults);
        
    ?>
        
        <div class="container">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <p id="demo">Edit Product</p>
            <img src="images/<?= $allProdRows['image']; ?>" alt="Product Image" width="400px" height="400px">
            
            Update new product image
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
            <input type="hidden" name="old_image" value="<?= $allProdRows['image']; ?>">

            <input type = "hidden" name="hiddenProdID" value="<?php echo $allProdRows['productID']?>">

            <div class="basic-information">
                
                    Product Name
                    <input type="text" name="productName" value ="<?php echo $allProdRows['name']; ?>" placeholder="Enter name of the product">
                

                <div class="row">
                Category
                    
                    
                    <?php
                    $sql2 = "SELECT * FROM prod_category, category WHERE 
                    prod_category.categoryID = category.categoryID AND
                    productID ='".$productID."';";
                    if($categoryProd = mysqli_query($conn, $sql2)){
                        if(mysqli_num_rows($categoryProd) > 0){
                            while($row = mysqli_fetch_array($categoryProd)) 
                            {
                                // Category name
                                echo $row['name']."<br>";
                            }
                            mysqli_free_result($categoryProd);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    ?>
                   
                   Edit Category
            
                    <select name="field1[]" multiple multiselect-max-items="3">
                    <?php
                        $sql = "SELECT * FROM `category`";
                        $all_categories = mysqli_query($conn,$sql);
                        while($category = mysqli_fetch_array($all_categories, MYSQLI_ASSOC)):;
                    ?>
                        <option value ="<?php echo $category["categoryID"];?>">
                        <?php echo $category["name"];?>
                        </option>
                    <?php endwhile; ?>
                    </select></td>
              
                </div>

               
                    Description
                    <div id="tooltip"></div>
                    <td><textarea name="description" rows ="8" cols="50" required
                    onmouseover="showTooltip('Help buyers to decide if the product meets their needs by creating an informative description with: <br> - Product specification <br> - Uses and benefits <br> - Warranties/expiry date and etc.')"
                    onmouseout="hideTooltip()" > <?php echo $allProdRows['description']; ?></textarea>
                    <input type="hidden" id="tbenableVariation1" name="tbenableVariation1" value=false>
                    <input type="hidden" id="tbenableVariation2" name="tbenableVariation2" value=false>
              
           
           

            <?php
            $oneCol=false;
            $twoCol=false;
            $loop=0;
            $sql="SELECT * FROM productoption, product 
            WHERE productoption.productID = product.productID AND
            productoption.productID = '".$productID."'";
                    if($allProdResults = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($allProdResults) > 0){
                            $loop = mysqli_num_rows($allProdResults);
                            $headerCount = 0;
                            while($row = mysqli_fetch_array($allProdResults)) 
                            {
                                if($row['variationName1']!= NULL || $row['variationName1']!= ""){
                                    $oneCol = true;
                                    echo"<input type='hidden' id='oneCol' name='oneCol' value=".$oneCol.">";
                                    echo"<input type='hidden' id='twoCol' name='twoCol' value=".$twoCol.">";
                                    if($row['variationName2']!= NULL || $row['variationName2']!= ""){
                                        $twoCol = true;
                                        echo"<input type='hidden' id='twoCol' name='twoCol' value=".$twoCol.">";
                                    }

                                } else { 
                                    ?>
                                    Price (RM) <input type="text" placeholder="Enter Price" id="price" name="price" value ='<?php echo $row['unitPrice'] ?>' required>
                                    Stock <input type="text" placeholder="Enter Amount" id="stock" name="stock" value ='<?php echo $row['stockQuantity'] ?>' required>
                                    <?php 
                                }
                            }
                            mysqli_free_result($allProdResults);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    if($oneCol){
                        if($twoCol){
                            echo "<table id='variationTable' border='1'>";
                            
                            echo "<th>".$allProdRows['variationName1']."</th>";
                            echo "<th>".$allProdRows['variationName2']."</th>";
                            echo"<input type='hidden' id='vName1' name='vName1' value=".$allProdRows['variationName1'].">";
                            echo"<input type='hidden' id='vName2' name='vName2' value=".$allProdRows['variationName2'].">";
                            echo "<th>Price (RM)</th>";
                            echo "<th>Stock Quantity</th>";
                        } else {
                            echo "<table id='variationTable' border='1'>";
                            echo "<th>".$allProdRows['variationName1']."</th>";
                            echo"<input type='hidden' id='vName1' name='vName1' value=".$allProdRows['variationName1'].">";
                            echo "<th>Price (RM)</th>";
                            echo "<th>Stock Quantity</th>";
                        }
                    }

                    if($allProdResults = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($allProdResults) > 0){
                            $loop = mysqli_num_rows($allProdResults);
                            while($row = mysqli_fetch_array($allProdResults)) 
                            {
                                if($oneCol){
                                    if($twoCol){
                                        echo "<tr>";
                                        echo "<td>".$row['variation1']."</td>";
                                        echo "<td>".$row['variation2']."</td>";
                                        echo "<td><input type='text' placeholder='Enter price' name='priceOption[]' value=".$row['unitPrice']." required></td>";
                                        echo "<td><input type='text' placeholder='Enter amount' name ='stockOption[]' value=".$row['stockQuantity']." required></td>";
                                        echo"<input type='hidden' id='prodOptID' name='prodOptID[]' value=".$row['productOptionID'].">";
                                        echo "</tr>";
                                    } else {
                                        echo "<tr>";
                                        echo "<td>".$row['variation1']."</td>";
                                        echo "<td><input type='text' placeholder='Enter price' name='priceOption[]' value=".$row['unitPrice']." required></td>";
                                        echo "<td><input type='text' placeholder='Enter amount' name ='stockOption[]' value=".$row['stockQuantity']." required></td>";
                                        echo"<input type='hidden' id='prodOptID' name='prodOptID[]' value=".$row['productOptionID'].">";
                                        echo "</tr>";
                                    }
                                }
                            }
                            echo "</table>";
                            mysqli_free_result($allProdResults);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }

    
                
            ?>
            <input type="submit" name="submit" value="Update Product" onclick="return confirm('Are you sure you want to update this product?');">
            </form>
        </div>
        
      

        <script>
            $(document).ready(function() {       
                $('#current_select').multiselect({		
                    nonSelectedText: 'Select Current'				
                });
            });

            $(function(){
                $('#current_select').multiselect({ 
                    buttonText: function(options, select) {
                        var labels = [];
                        console.log(options);
                        options.each(function() {
                            labels.push($(this).val());
                        });

                        $("#current_select_values").val(labels.join(',') + '');
                            return labels.join(', ') + '';
                    }
                
                });
            });
        </script>

        <script type="text/javascript">
            var iGlobal=1, jGlobal=1;
            var enableVariation2=false;
            var enableVariation=false;
            var countTBdiv1=0;
            var countTBdiv2=0;

            function showTooltip(text) {
                var tooltip = document.getElementById("tooltip");
                tooltip.innerHTML = text;
                tooltip.style.display = "block";
            }

            function hideTooltip() {
                var tooltip = document.getElementById("tooltip");
                tooltip.style.display = "none";
            }

            function addTextbox() {
                var form = document.getElementById('add-variation1');
                iGlobal++;

                // Create a new text box element
                var textBox = document.createElement("input");
                textBox.setAttribute("type", "text");
                textBox.setAttribute("name", "option1[]");
                var id = "variation" + iGlobal;
                
                textBox.setAttribute("id", id);
                textBox.setAttribute("placeholder", "eg:Red, etc.");

                var imgId = "imgId" + iGlobal;
                const imageDel = "<img src='images/delete.png' width='25px' height='25px' id='" + imgId + "' onclick='deleteTextBox()'>";
                
                
                // Add the text box to the form
                form.appendChild(textBox);
                countTBdiv1++;
                textBox.insertAdjacentHTML("afterend", imageDel);
            }

            function addTextbox2() {
                var form = document.getElementById('add-variation2');
                jGlobal++;

                // Create a new text box element
                var textBox = document.createElement("input");
                textBox.setAttribute("type", "text");
                textBox.setAttribute("name", "option2[]");
                var id = "size" + jGlobal;
                
                textBox.setAttribute("id", id);
                textBox.setAttribute("placeholder", "eg:S,M, etc.");

                var imgSizeId = "imgSizeId" + jGlobal;
                const imageDel2 = "<img src='images/delete.png' width='25px' height='25px' id='" + imgSizeId + "' onclick='deleteTextBox2()'>";
                
                
                // Add the text box to the form
                form.appendChild(textBox);
                countTBdiv2++;
                textBox.insertAdjacentHTML("afterend", imageDel2);
                
            }

            function getNumericValue(str) {
                let match = str.match(/\d+/);
                if (match) {
                    return match[0];
                }
                return null;
            }   

            function deleteTextBox() {
                document.querySelectorAll('img').forEach((img) => {
                    img.addEventListener('click', function() {
                        let imgId = this.id;
                        const lastChar = getNumericValue(imgId);
                        const textbox = document.getElementById('variation' + lastChar);
                        textbox.parentNode.removeChild(textbox);
                        let imgRemove = document.getElementById(imgId);
                        imgRemove.remove();
                        countTBdiv1--;
                    });
                });
            }

            function deleteTextBox2() {
                document.querySelectorAll('img').forEach((img) => {
                    img.addEventListener('click', function() {
                        let imgId2 = this.id;
                        const lastChar2 = getNumericValue(imgId2);
                        const textbox2 = document.getElementById('size' + lastChar2);
                        textbox2.parentNode.removeChild(textbox2);
                        let imgRemove2 = document.getElementById(imgId2);
                        imgRemove2.remove();
                        countTBdiv2--;
                    });
                });
            }

            function generateTable(){
                var iPrivate = 0;
                var jPrivate = 0;
                var dataTb1 = [];
                var dataTb2 = [];

                document.getElementById("tableCreated").innerHTML = "";

                var form = document.getElementById("tableCreated");
                if(enableVariation){
                    var rowCount = countTBdiv1;
                    if(enableVariation2){
                        var rowspanCount = countTBdiv2;
                    }
                }

                if(enableVariation == true){
                    for (var i = 0; i < iGlobal; i++){
                        var id = i+1;
                        var textbox = document.getElementById("variation"+id);
                        
                        if (textbox) {
                            dataTb1[iPrivate] = textbox.value;
                            iPrivate++;
                        }
                    }
                }
                
                if(enableVariation2 == true) {
                    for (var j = 0; j < jGlobal; j++){
                        var id = j+1;
                        var textbox2 = document.getElementById("size"+id);
                        if (textbox2 && textbox2.tagName.toLowerCase() === "input" && textbox2.type === "text") {
                            dataTb2[jPrivate] = textbox2.value;
                            jPrivate++;
                        }
                    }
                }

                if(rowCount>0){
                    var table = document.createElement("table");
                    table.setAttribute("id","variationTable");
                    table.setAttribute("border",1);
                    
                    // add header if variation is enabled
                    if(enableVariation){
                        var header = document.createElement("th");
                        header.innerHTML = document.getElementById("v1").value;
                        table.appendChild(header); 
                        // add header if variation2 is enable
                        if(enableVariation2){
                            var header = document.createElement("th");
                            header.innerHTML = document.getElementById("v2").value;
                            table.appendChild(header); 

                            // price header
                            var headerPrice = document.createElement("th");
                            headerPrice.innerHTML = "Price (RM)";
                            table.appendChild(headerPrice); 

                            // stockArr header
                            var headerStock = document.createElement("th");
                            headerStock.innerHTML = "Stock";
                            table.appendChild(headerStock); 
                        } else {
                            // price header
                            var headerPrice = document.createElement("th");
                            headerPrice.innerHTML = "Price (RM)";
                            table.appendChild(headerPrice); 

                            // stockArr header
                            var headerStock = document.createElement("th");
                            headerStock.innerHTML = "Stock";
                            table.appendChild(headerStock); 
                        }
                    }

                    
                
                    for (var i = 0; i < rowCount; i++){
                        var row = document.createElement("tr");
                        var cell = document. createElement("td");

                        cell.innerHTML = dataTb1[i];
                        if(enableVariation2){
                            cell.setAttribute("rowspan", rowspanCount+1);
                        }
                        
                        
                        row.appendChild(cell);
                        table.appendChild(row);
                        if(rowspanCount>0){
                            for (var j = 0; j < rowspanCount; j++) {
                                var row2 = document.createElement("tr");
                                var cell2 = document. createElement("td");
                                cell2.innerHTML = dataTb2[j];
                                row2.appendChild(cell2);
                                
                                var cell3 = document. createElement("td");
                                var textbox = document.createElement("input");
                                textbox.setAttribute("required", " ");
                                textbox.setAttribute("placeholder", "Enter price");
                                textbox.setAttribute("name","priceOption[]");
                                textbox.setAttribute("type","text");
                                
                                cell3.appendChild(textbox);
                                row2.appendChild(cell3);

                                var cell4 = document. createElement("td");
                                var textbox2 = document.createElement("input");
                                textbox2.setAttribute("required", " ");
                                textbox2.setAttribute("placeholder", "Enter amount");
                                textbox2.setAttribute("name","stockOption[]");
                                textbox2.setAttribute("type","text");
                                
                                cell4.appendChild(textbox2);
                                row2.appendChild(cell4);

                                table.appendChild(row2);
                            }
                        } else {
                            var cell2 = document. createElement("td");
                            
                            var textbox = document.createElement("input");
                            // textbox.setAttribute("required", " ");
                            textbox.setAttribute("name","priceOption[]");
                            textbox.setAttribute("type","text");
                            
                            cell2.appendChild(textbox);
                            row.appendChild(cell2);

                            var cell3 = document. createElement("td");
                            var textbox2 = document.createElement("input");
                            // textbox2.setAttribute("required", " ");
                            textbox2.setAttribute("name","stockOption[]");
                            textbox2.setAttribute("type","text");
                            
                            cell3.appendChild(textbox2);
                            row.appendChild(cell3);

                            table.appendChild(row);
                        }
                    
                    }
                    // generate cells in table with rowspan
                    
                form.appendChild(table);
                }
            }

            function addProduct() {
                var prodName = document.forms["addProd"]["productName"].value;
                var description = document.forms["addProd"]["description"].value;

                //var selectedOptions = $_POST['categoryOpt'];
                //document.getElementById("testing").innerHTML = $selectedOptions;
                if((prodName == ""  || prodName == null) ||
                (description == ""  || description == null)) {
                    alert("Please complete the details");
                    reset();
                    return false;
                }
            }

            document.getElementById("btn-enable-variation").addEventListener("click", () => {
                if(document.getElementById("enable-variation1").style.display == "none") {
                    document.getElementById("price-stock").style.display = "none";
                    document.getElementById("price").value = 0;
                    document.getElementById("stock").value = 0;
                    enableVariation = true;
                    document.getElementById("tbenableVariation1").value = true;
                    countTBdiv1++;
                    document.getElementById("tableCreated").style.display = "block";
                    document.getElementById("enable-variation1").style.display = "block";
                    document.getElementById("createTable").style.display = "block";
                    document.getElementById("btn-enable-variation").value = "Disable Variations";
                } 
                
                else if (document.getElementById("enable-variation1").style.display == "block") {
                    document.getElementById("tableCreated").style.display = "none";
                    document.getElementById("price-stock").style.display = "block";
                    document.getElementById("price").value = "";
                    document.getElementById("stock").value = "";
                    document.getElementById("btn-enable-variation").value = "Enable Variations";
                    enableVariation = false;
                    document.getElementById("tbenableVariation1").value = false;
                    enableVariation2 = false;
                    document.getElementById("tbenableVariation2").value = false;
                    countTBdiv1--;
                    document.getElementById("createTable").style.display = "none";
                    document.getElementById("enable-variation2").style.display = "none";
                    document.getElementById("enable-variation1").style.display = "none";
                }
            });

            document.getElementById("btn-enable-variation2").addEventListener("click", () => {
                if(document.getElementById("enable-variation2").style.display == "none") {
                    enableVariation2 = true;
                    document.getElementById("tbenableVariation2").value = true;
                    countTBdiv2++;
                    
                    document.getElementById("btn-enable-variation2").value = "Disable Variation 2";
                    document.getElementById("enable-variation2").style.display = "block";
                } 
                
                else if (document.getElementById("enable-variation2").style.display == "block") {
                    enableVariation2 = false;
                    document.getElementById("tbenableVariation2").value = false;
                    countTBdiv2--;
                    
                    document.getElementById("btn-enable-variation2").value = "Enable Variation 2";
                    document.getElementById("enable-variation2").style.display = "none";
                }
            });
        </script>
        
        
    </body>
</html>