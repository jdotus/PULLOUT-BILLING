<?php
    include('dbcon.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pullout Billing</title>

    <link rel="stylesheet" href="style.css">
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
    <body> 

    <!-- Modal content -->
    <div class="modal-contents">
                <!-- Close Button -->


                <h3 class="title">PULL OUT BILLING</h3>

                <div class="containers">
                <?php   

                    if(isset(($_POST['submit']))) {
                        $sinumber=mysqli_real_escape_string($con,$_POST["sinumber"]);
                        $sidate=date("Y-m-d",strtotime($_POST["sidate"]));
                        $soldto=mysqli_real_escape_string($con,$_POST["soldto"]);
                        $tin=mysqli_real_escape_string($con,$_POST["tin"]);
                        $address=mysqli_real_escape_string($con,$_POST["address"]);
    
                        $quantity = mysqli_real_escape_string($con, $_POST["quantity"]);
                        $model = mysqli_real_escape_string($con, $_POST["model"]);
                        $serial = mysqli_real_escape_string($con, $_POST["serial"]);
                        $item_description = mysqli_real_escape_string($con, $_POST["item_description"]);
                        $copies = mysqli_real_escape_string($con, $_POST["copies"]);
                        $unitprice = mysqli_real_escape_string($con, $_POST["unitprice"]);
                        $colorType = mysqli_real_escape_string($con, $_POST["colortype"]);
                        $totalprice = mysqli_real_escape_string($con, $_POST["totalprice"]);
                        
                        //VAT
                        $total_sale=mysqli_real_escape_string($con,$_POST["total_sale"]);
                        $vat=mysqli_real_escape_string($con,$_POST["vat"]);
                        $total_amount_payable=mysqli_real_escape_string($con,$_POST["total_amount_payable"]);
                        
                        $firstStmnt = $con->prepare("INSERT INTO pullout billing (si_num, sold_to, si_date, tin, address, total_sale, vat, total_ammount_payable) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

                        if ($firstStmnt === false) {
                            die('Prepare() failed: ' . htmlspecialchars($con->error));
                        }

                        $firstStmnt->bind_param('ssssssss', $sinumber,$soldto,$sidate,$tin,$address,$total_sale,$vat,$total_amount_payable);

                        if($firstStmnt->execute()) {
                            $secondStmnt = $con->prepare("INSERT INTO pullout billing (model, serial,item_description, copies, total_price, unit_price, color_type) VALUES (?, ?, ?, ?, ?, ?, ?)");

                            if ($secondStmnt === false) {
                                die('Prepare() failed: ' . htmlspecialchars($con->error));
                            }

                            $secondStmnt->bind_param('sssssss', $model, $serial, $item_description, $copies, $totalprice, $unitprice, $colorType);

                            for($i = 0; $i < count($_POST['description']); $i++) {

                            }
                        }
                    }
                ?>

                    <form action="perserial.php" method="post" autocomplete="off">
                        <div class="display-flex">
                            <div class="left-side">
                                <label for="si-number">Invoice No</label>
                                <input type="number" id="si-number" name="sinumber">
                                
                                <label for="sidate">Invoice Date</label><br>
                                
                                <input type="date" id="sidate" name="sidate"  value="<?php echo date("Y-m-d");?>" require>
                                <br>
                            </div>
                            <div class="right-side">
                                <label for="soldto">Name</label>
                                <input type="text" id="soldto" name="soldto">

                                <label for="tin">TIN</label>
                                <input type="text" id="tin" name="tin">
                                
                                <label for="address">ADDRESS: </label>
                                
                                <input type="text" id="address" name="address">
                                
                                <!-- <label for="description">Description</label>
                                <input type="text" id="description" name="description"> -->
                            
                            </div>
                        </div>
                        <h4> Product Details </h4>
                        <div class="bottom-part display-flex-bottom" id="input-container">
                            
                            <!-- <div id="inline-block-quantity">
                                <label for="quantity">Quantity</label>
                                <input class="quantity" type="text" id="quantity" name='quantity'>
                            </div> -->

                            <div id="inline-block-model">
                                <label for="model">Model</label>
                                <!-- <input class="model" type="text" id="model" name='model'> -->
                            </div>

                            <div id="inline-block-serial">
                                <label for="serial">Serial</label>
                                <!-- <input class="serial" type="number" id="serial" name='serial'> -->
                            </div>

                            <div id="inline-block-description">
                                <label for="item_description">Item Description</label>
                                <!-- <input class="item_description" type="number" id="item_description" name='item_description'> -->
                                 <!-- <textarea name="item_description" id="item_description" rows="2" cols="50" ></textarea> -->
                            </div>

                            <div id="inline-block-color-type">
                                <label for="colortype">Color Type</label>
                                <!-- <input class="colortype" type="text" id="colortype" name='colortype'> -->
                            </div>

                            <div id="inline-block-copies">
                                <label for="copies">Copies Made</label>
                                <!-- <input class="copies" type="number" id="copies" name='copies'> -->
                            </div>
                            
                            <div id="inline-block-unitprice">
                                <label class="unitprice" for="unitprice">Cost/Copy</label>
                                
                                <!-- <input class="unitprice" type="number" step="0.01" min="0" id="unitprice" name='unitprice'> -->
                                
                            </div>

                            <div id="inline-block-totalprice">
                                <label class="totalprice" for="totalprice">Total Price </label>
                                
                                <!-- <input class="totalprice" type="number" step="0.01" min="0" id="totalprice" name='totalprice'> -->
                            </div>



                        </div>
                        

                        <div class="display-flex-VAT">
                            <div class="right-side">
                                
                                <label for="total_sale">Total Sale</label> 
                                <input type="number" step="0.01" min="0" id="total_sale" name="total_sale">
                                
                                <label for="vat">VAT</label>
                                <input type="number" step="0.01" min="0" id="vat" name="vat">

                                <label for="total_amount_payable">Total Amount Payable</label>
                                <input type="number" step="0.01" min="0" id="total_amount_payable" name="total_amount_payable">
                                
                            </div>
                        </div>
                            
                        <div class="inputContainer">
                            <button class="submit" type="submit" name="submit">Submit</button>
                            <button id="addInput" type="button">Add Input</button>
                            <button id="removeInput" type="button" >Remove Input</button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>

        <script src="style.js"></script>
    </body>
</html>