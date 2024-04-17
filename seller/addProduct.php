<?php include('../connect.php');
include "../seller/bar/headerSeller.php";
session_start();
$qry = "SELECT * FROM `seller` WHERE username='" . $_SESSION['username'] . "'";
$result = mysqli_query($conn,$qry);
$rows=mysqli_fetch_array($result);
$sellerID = $rows['sellerID'];


     
if(isset($_POST["btn-submit"])){
    if($conn->connect_error) {
        die ("Connection failed: " . $conn->connect_error);
    }

    $allCatStatus = false;
    $prodOptStatus = false;
    $prodName = $_POST["productName"];
    $description = $_POST["description"];
    $categories = $_POST["field1"];
    $enableVariation = $_POST["tbenableVariation1"];
    $enableVariation2 = $_POST["tbenableVariation2"];
    echo $enableVariation ."<br>";
    echo $enableVariation2 ."<br>";
    
    
    if($enableVariation === true) {
        $vName1 = $_POST["v1"];
        $option1 = $_POST["option1"];
        $priceArr = $_POST["priceOption"];
        $stockArr = $_POST["stockOption"];
        $pMax = count($priceArr);
        echo $vName1 ."<br>";
        echo $pMax ."<br>";
        if($enableVariation2 === true) {
            $vName2 = $_POST["v2"];
            $option2 = $_POST["option2"];
            echo $vName2 ."<br>";
        }
    } else {
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        echo $price ."Price inserted<br>";
        echo $stock ."<br>";
    }
    $p = -1;
    
    $image = $_POST['image'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_tmp_name = tempnam(sys_get_temp_dir(), 'image');
    $image_size = filesize($image_tmp_name);
    $image_folder = 'images/'.$image;

    $insertsql = "INSERT INTO `product` (productID, name, description, sellerID, image) VALUES ('','$prodName','$description','$sellerID','$image')";

    if($image_size > 2000000){
        echo "<script type='text/javascript'>alert('Images size too large.');</script>";
        return;
    }
    
    if($conn->query($insertsql)==TRUE) {
        move_uploaded_file($image_tmp_name, $image_folder);
        $message[] = 'new product added!';
        $prodID = mysqli_insert_id($conn);
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

        if($allCatStatus){
            if($enableVariation == false) {
                $insertProdOption = "INSERT INTO `productoption`(`productOptionID`, `stockQuantity`, `unitPrice`, `productID`) 
                VALUES ('','$stock','$price','$prodID')";
                $prodOptResult = mysqli_query($conn, $insertProdOption);
                if($prodOptResult){
                    $prodOptStatus = true;
                } else if (!$prodOptResult) {
                    $prodOptStatus = true;
                    exit;
                }
            } else if ($enableVariation2 == true){
                $insertProdOption = "INSERT INTO `productoption`(`productOptionID`, `stockQuantity`, `unitPrice`, `variationName1`, `variation1`, `variationName2`, `variation2`, `productID`) 
                VALUES ('','$stockArr[$p]','$priceArr[$p]','$vName1','$option1[$i]','$vName2','$option2[$j]','$prodID')";
                for ($i = 0; $i < count($option1); $i++){
                    $count = 0;
                    for ($j = 0; $j < count($option2); $j++) {
                        if($count == 0){
                            $p++;
                        }
                        $prodOptResult = mysqli_query($conn, $insertProdOption);
                        if($prodOptResult){
                            $prodOptStatus = true;
                        } else if (!$prodOptResult) {
                            $prodOptStatus = true;
                            exit;
                        }
                    }
                }
            } else if ($enableVariation == true) {
                $insertProdOption = "INSERT INTO `productoption`(`productOptionID`, `stockQuantity`, `unitPrice`, `variationName1`, `variation1`, `productID`) 
                VALUES ('','$stockArr[$p]','$priceArr[$p]','$vName1','$option1[$i]','$prodID')";
                for ($i = 0; $i < count($option1); $i++){
                    $p++;
                    $prodOptResult = mysqli_query($conn, $insertProdOption);
                    if($prodOptResult){
                        $prodOptStatus = true;
                    } else if (!$prodOptResult) {
                        $prodOptStatus = true;
                        exit;
                    }
                }
            }

            if($prodOptStatus) {
                echo "<script type='text/javascript'>alert('Product added successfully.'); window.location.href = 'addProduct.php';</script>";
            }
        }
    } else {
        echo "Error: ". $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
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
                position: ;
                background-color: #DBF3FA ;
                padding: 13px;
                font-size: 12px;
            }
        </style>
    </head>
    <body>
        
        <form method="POST" action = "addProduct.php">
            <div class="container">
            <p id="demo">Add Product Form</p>
            Product Images
            <input type="file" name="image" required accept="image/jpg, image/jpeg, image/png">
            <table border="1">
            <div class="basic-information">
                <tr>
                    <td>Product Name</td>
                    <td><input type="text" name="productName" placeholder="Enter name of the product"></td>
                </tr>

                <div class="row">
                <tr>
                    <td>Category</td>
                    <td><select name="field1[]" multiple multiselect-max-items="3" required>
                    <?php
                        $sql = "SELECT * FROM `category` ORDER BY name;";
                        $all_categories = mysqli_query($conn,$sql);
                        while($category = mysqli_fetch_array($all_categories, MYSQLI_ASSOC)):;
                    ?>
                        <option value ="<?php echo $category["categoryID"];?>">
                        <?php echo $category["name"];?>
                        </option>
                    <?php endwhile; ?>
                    </select></td>
                </tr>
                </div>

                

                <tr>
                    <td>Description</td>
                    
                    <td><textarea name="description" rows ="8" cols="50" required
                    onmouseover="showTooltip('Help buyers to decide if the product meets their needs by creating an informative description with: <br> - Product specification <br> - Uses and benefits <br> - Warranties/expiry date and etc.')"
                    onmouseout="hideTooltip()"></textarea></td>
                    
                    <input type="hidden" id="tbenableVariation1" name="tbenableVariation1" value=false>
                    <input type="hidden" id="tbenableVariation2" name="tbenableVariation2" value=false>
                </tr>
            </div>
            <div id="tooltip"></div>
            </table>

            <div id="price-stock"> <br>
                Price (RM) <input type="text" placeholder="Enter Price" id="price" name="price"> &nbsp&nbsp
                Stock <input type="text" placeholder="Enter Amount" id="stock" name="stock">
            </div>


            <div class="sales-information"><br>
                Variation <input type="button" value="Enable Variations" id="btn-enable-variation"><br><br>
                    <div class="enable-variation1" id="enable-variation1" style="display: none;">
                        Variation 1 <input type="text" placeholder="eg:color, etc." id="v1" name="v1"><br><br>
                            
                            Options &nbsp <input type="button" value="Add Option" onclick="addTextbox();"><br><br>
                                <div id="add-variation1">
                                <input type="text" placeholder="eg:Red, etc." id="variation1" name="option1[]">
                                </div>
                                <br><br><input type="button" value="Enable Variation 2" id="btn-enable-variation2"><br><br>
                    </div>

                    <div class="enable-variation2" id="enable-variation2" style="display: none;">
                            Variation 2 <input type="text" placeholder="eg:size, etc." id="v2" name="v2"><br><br>
                            Options &nbsp <input type="button" value="Add Option" onclick="addTextbox2();"> <br><br>
                                <div id="add-variation2">
                                    <input type="text" placeholder="eg:S,M, etc." id="size1" name="option2[]">
                                </div></td>
                    </div>
                    <br><input type="button" id="createTable" name="createTable" value="Confirm" onclick="generateTable()" style="display: none;"><br><br>
            </div>
         
            
            <div id="tableCreated">
                
            </div>
            
            <br><tr><td colspan="2"><input type="submit" name="btn-submit" value="Add Product" id="btn-submit" onclick="return confirm('Are you sure you want to add this product?');"></td></tr></table><br><br>
            </div>
        </form>
      

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

    <?php
        include "../admin/bar/adminfooter.php";
    ?>
</html>