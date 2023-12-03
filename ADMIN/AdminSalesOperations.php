<?php

require "../MAIN/Dbconn.php"; 

include './CommonFunctions.php';

$cart_table = 'salestabletemp';

$DateToday = date('Y-m-d H:i:s');
$userId = $_COOKIE['custidcookie'];



//Calculate Inclusive tax
/* function CalculateIncTax($igst, $Total)
{
    $IGST = floatval($igst);
    $CGST = floatval($igst / 2.00);
    $SGST = floatval($igst / 2.00);
    $Total = $Total;

    $IGSTMutliplier = ($IGST + 100) / 100;
    $CGSTMutliplier = ($CGST + 100) / 100;
    $SGSTMutliplier = ($SGST + 100) / 100;

    $IGSTAmt = round(($Total - ($Total / $IGSTMutliplier)), 3);
    $CGSTAmt = round(($Total - ($Total / $CGSTMutliplier)), 3);
    $SGSTAmt = round(($Total - ($Total / $SGSTMutliplier)), 3);
    $GrossAmt = round(($Total / $IGSTMutliplier), 3);


    $CalculatedValues = json_encode(array('IGST' => $IGST, 'CGST' => $CGST, 'SGST' => $SGST, 'IGSTAmt' => $IGSTAmt, 'CGSTAmt' => $CGSTAmt, 'SGSTAmt' => $SGSTAmt, 'GrossAmt' => $GrossAmt));
    return $CalculatedValues;
} */

// function CalculateIncTax($igst, $Total)
// {
//     $IGST = floatval($igst);
//     $CGST = floatval($igst / 2.00);
//     $SGST = floatval($igst / 2.00);
//     $Total = $Total;

//     $IGSTMutliplier = ($IGST + 100) / 100;
//     //$CGSTMutliplier = ($CGST + 100) / 100;
//     //$SGSTMutliplier = ($SGST + 100) / 100;

//     $IGSTAmt = round(($Total - ($Total / $IGSTMutliplier)), 3);
//     //$CGSTAmt = round(($Total - ($Total / $CGSTMutliplier)), 3);
//     //$SGSTAmt = round(($Total - ($Total / $SGSTMutliplier)), 3);
//     $CGSTAmt = round(($IGSTAmt/2), 3);
//     $SGSTAmt = round(($IGSTAmt/2), 3);
//     $GrossAmt = round(($Total / $IGSTMutliplier), 3);


//     $CalculatedValues = json_encode(array('IGST' => $IGST, 'CGST' => $CGST, 'SGST' => $SGST, 'IGSTAmt' => $IGSTAmt, 'CGSTAmt' => $CGSTAmt, 'SGSTAmt' => $SGSTAmt, 'GrossAmt' => $GrossAmt));
//     return $CalculatedValues;
// }


// //Calculate Exclusive tax
// function CalculateExcTax($igst, $Total)
// {
//     $IGST = floatval($igst);
//     $CGST = floatval($igst / 2.00);
//     $SGST = floatval($igst / 2.00);
//     $Total = $Total;

//     $IGSTMutliplier = ($IGST / 100);
//     $CGSTMutliplier = ($CGST / 100);
//     $SGSTMutliplier = ($SGST / 100);

//     $IGSTAmt = round(($Total * $IGSTMutliplier), 3);
//     $CGSTAmt = round(($Total * $CGSTMutliplier), 3);
//     $SGSTAmt = round(($Total * $SGSTMutliplier), 3);
//     $GrossAmt = $Total;
//     $TotalAmt = $Total + $IGSTAmt;


//     $CalculatedValues = json_encode(array('IGST' => $IGST, 'CGST' => $CGST, 'SGST' => $SGST, 'IGSTAmt' => $IGSTAmt, 'CGSTAmt' => $CGSTAmt, 'SGSTAmt' => $SGSTAmt, 'GrossAmt' => $GrossAmt, 'TotalAmt' => $TotalAmt));
//     return $CalculatedValues;
// }



// //Calculates tax, amount, gross
// function CalculateTax($ConnString, $IsInclusive, $IGST, $GrossAmount, $tempPurchaseTable, $RowId, $UserId)
// {
//     $UserId = $UserId;
//     if ($IsInclusive == 1) {
//         $InclTaxArray = json_decode(CalculateIncTax($IGST, $GrossAmount));
//         //print_r($InclTaxArray);
//         $InclIGST = $InclTaxArray->IGST;
//         $InclCGST = $InclTaxArray->CGST;
//         $InclSGST = $InclTaxArray->SGST;
//         $InclIGSTAmt = $InclTaxArray->IGSTAmt;
//         $InclCGSTAmt = $InclTaxArray->CGSTAmt;
//         $InclSGSTAmt = $InclTaxArray->SGSTAmt;
//         $InclGrossAmt = $InclTaxArray->GrossAmt;

//         $UpdateValuesInTable = mysqli_query($ConnString, "UPDATE $tempPurchaseTable SET `cgstpercentage`='$InclCGST',`cgstamt`='$InclCGSTAmt',`sgstpercentage`='$InclSGST',`sgstamt`='$InclSGSTAmt',`igstpercentage`='$InclIGST',`igstamt`='$InclIGSTAmt',`producttotalamount`= '$InclGrossAmt',`amount`= '$GrossAmount' WHERE cart_id = '$RowId' AND userId = '$UserId'");

//         if ($UpdateValuesInTable) {
//             return 'Success';
//         } else {
//             return 'Cancel';
//         }
//     } else {
//         $ExclTaxArray = json_decode(CalculateExcTax($IGST, $GrossAmount));
//         //print_r($InclTaxArray);
//         $ExclIGST = $ExclTaxArray->IGST;
//         $ExclCGST = $ExclTaxArray->CGST;
//         $ExclSGST = $ExclTaxArray->SGST;
//         $ExclIGSTAmt = $ExclTaxArray->IGSTAmt;
//         $ExclCGSTAmt = $ExclTaxArray->CGSTAmt;
//         $ExclSGSTAmt = $ExclTaxArray->SGSTAmt;
//         $ExclGrossAmt = $ExclTaxArray->GrossAmt;
//         $ExclTotalAmt = $ExclTaxArray->TotalAmt;

//         $UpdateValuesInTable = mysqli_query($ConnString, "UPDATE $tempPurchaseTable SET `cgstpercentage`='$ExclCGST',`cgstamt`='$ExclCGSTAmt',`sgstpercentage`='$ExclSGST',`sgstamt`='$ExclSGSTAmt',`igstpercentage`='$ExclIGST',`igstamt`='$ExclIGSTAmt',`producttotalamount`= '$ExclGrossAmt',`amount`= '$ExclTotalAmt' WHERE cart_id = '$RowId' AND userId = '$UserId'");

//         if ($UpdateValuesInTable) {
//             return 'Success';
//         } else {
//             return 'Cancel';
//         }
//     }
// }


// //Calculate discount and discount Amount
// function CalculateDiscount($InitialAmount, $DiscountAmount, $DiscountPercentage)
// {


//     if ($DiscountPercentage == '') {
//         $DiscountedAmount = $InitialAmount - $DiscountAmount;
//         $DiscountPercentage = ($DiscountAmount / $InitialAmount) * 100;
//     } else {
//         $DiscountedAmount = $InitialAmount - (($DiscountPercentage / 100) * $InitialAmount);
//         $DiscountAmount = $InitialAmount - $DiscountedAmount;
//     }


//     $DiscountResult =  json_encode(array('Amount' => $InitialAmount, 'DiscountAmount' => $DiscountAmount, 'DiscountedAmount' => $DiscountedAmount, 'DiscountPercentage' => $DiscountPercentage));
//     return $DiscountResult;
// }



// //Update addtional cess and cess amounts
// function CalculateCessAndAdditionalCess($connstring, $itemid, $temppurchasetable, $UserId)
// {

//     $UserId = $UserId;
//     $ConnString = $connstring;
//     $ItemId = $itemid;
//     $tempPurchaseTable = $temppurchasetable;
//     $FindItemCessAndAdditionalCess = mysqli_query($ConnString, "SELECT cesspercentage,addcesspercentage,producttotalamount FROM $tempPurchaseTable WHERE cart_id = '$ItemId' AND userId = '$UserId'");
//     foreach ($FindItemCessAndAdditionalCess as $FindItemCessAndAdditionalCessResult) {
//         $CessPerc = $FindItemCessAndAdditionalCessResult['cesspercentage'];
//         $AddCessPerc = $FindItemCessAndAdditionalCessResult['addcesspercentage'];
//         $Gross = $FindItemCessAndAdditionalCessResult['producttotalamount'];
//     }

//     $CalculatedCess = json_decode(CalculateExcTax($CessPerc, $Gross))->IGSTAmt;
//     $CalculatedAdditionalCess = json_decode(CalculateExcTax($AddCessPerc, $Gross))->IGSTAmt;

//     $UpdateCessAmounts = mysqli_query($ConnString, "UPDATE $tempPurchaseTable SET cessamount = '$CalculatedCess' , addcessamount = '$CalculatedAdditionalCess' WHERE cart_id = '$ItemId' AND userId = '$UserId'");
//     if ($UpdateCessAmounts) {
//         return "Success";
//     } else {
//         return "Failed";
//     }
//     //return $CalculatedCess.'-'.$CalculatedAdditionalCess;

// }



// //Find Totals of all Amounts
// function FindAllTotalAmounts($connstring, $temppurchasetable, $UserId)
// {

//     $UserId = $UserId;
//     $Connstring = $connstring;
//     //$TempAddDiscountTable = $tempadddiscounttable;
//     $TempPurchaseTable = $temppurchasetable;
//     //$TempOtherChargeTable = $tempotherchargetable;

//     $TOTALQTY = 0;
//     $TOTALTAX = 0;
//     $TOTALGROSS = 0;
//     $TOTALNETWITHOUTROUNDOFF = 0;
//     $TOTALCESS = 0;
//     $TOTALADDCESS = 0;
//     $TOTALOTHERCHARGES = 0;
//     $TOTALADDDISCOUNT = 0;
//     $TOTALINDDISCOUNT = 0;
//     $TOTALSGST = 0;
//     $TOTALCGST = 0;

//     // $FindOtherCharges =  mysqli_query($Connstring, "SELECT SUM(otherchargeamount) FROM $TempOtherChargeTable");
//     // if (mysqli_num_rows($FindOtherCharges) > 0) {
//     //     foreach ($FindOtherCharges as $FindOtherChargesResult) {
//     //         $OtherCharge  = $FindOtherChargesResult['SUM(otherchargeamount)'];
//     //     }
//     // } else {
//     //     $OtherCharge = 0;
//     // }

//     // $TOTALOTHERCHARGES += $OtherCharge;
//     // $TOTALNETWITHOUTROUNDOFF += $OtherCharge;

//     // $FindAddDiscount =  mysqli_query($Connstring, "SELECT SUM(discountamount) FROM $TempAddDiscountTable");
//     // if (mysqli_num_rows($FindAddDiscount) > 0) {
//     //     foreach ($FindAddDiscount as $FindAddDiscountResult) {
//     //         $AddDiscount  = $FindAddDiscountResult['SUM(discountamount)'];
//     //     }
//     // } else {
//     //     $AddDiscount = 0;
//     // }

//     // $TOTALADDDISCOUNT += $AddDiscount;
//     // $TOTALNETWITHOUTROUNDOFF -= $AddDiscount;


//     $FindTotal = mysqli_query($Connstring, "SELECT SUM(quantity) AS TOTALQTY, SUM(SGSTAmt) AS TOTALSGST, SUM(CGSTAmt) AS TOTALCGST, SUM(igstamt) AS TOTALTAX ,SUM(producttotalamount) AS GROSSTOTAL, SUM(cessamount) AS TOTALCESS, SUM(addcessamount) AS TOTALADDCESS, SUM(inddiscountamount) AS TOTALINDDISC FROM $TempPurchaseTable WHERE userId = $UserId");
//     foreach ($FindTotal as $FindTotalResult) {
//         $TOTALTAX += $FindTotalResult['TOTALTAX'];
//         $TOTALGROSS += $FindTotalResult['GROSSTOTAL'];
//         $TOTALCESS += $FindTotalResult['TOTALCESS'];
//         $TOTALADDCESS += $FindTotalResult['TOTALADDCESS'];
//         $TOTALINDDISCOUNT += $FindTotalResult['TOTALINDDISC'];
//         $TOTALSGST += $FindTotalResult['TOTALSGST'];
//         $TOTALCGST += $FindTotalResult['TOTALCGST'];
//         $TOTALQTY += $FindTotalResult['TOTALQTY'];
//     }



//     $TOTALNETWITHOUTROUNDOFF += ($TOTALTAX + $TOTALGROSS);
//     $TOTALWITHROUND = round($TOTALNETWITHOUTROUNDOFF);
//     $ROUNDOFF = round(($TOTALWITHROUND - $TOTALNETWITHOUTROUNDOFF), 1);

//     return json_encode(array('FindTotalStatus' => 1, 'TotalQty' => $TOTALQTY, 'TotalTax' => $TOTALTAX, 'TotalCgst' => $TOTALCGST, 'TotalSgst' => $TOTALSGST, 'TotalGross' => $TOTALGROSS, 'TotalNet' => $TOTALWITHROUND, 'RoundOff' => $ROUNDOFF, 'TotalNetNoRound' => $TOTALNETWITHOUTROUNDOFF, 'TotalCess' => $TOTALCESS, 'TotalAddCess' => $TOTALADDCESS, 'TotalOtherCharge' => $TOTALOTHERCHARGES, 'TotalAddDiscount' => $TOTALADDDISCOUNT, 'TotalIndDiscount' => $TOTALINDDISCOUNT));
// }




// if (isset($_POST['place_order'])) {

//     $biller = $_POST['biller'];
//     $first = $_POST['first'];
//     $last = $_POST['last'];
//     $phone = $_POST['mobile'];
//     $email = $_POST['email_id'];
//     $address = $_POST['adddresses'];
//     $city = $_POST['city'];
//     $state = $_POST['state'];
//     $pincode = $_POST['pincode'];
//     $details = $_POST['ord_details'];

//     date_default_timezone_set("Asia/kolkata");
//     $Date_purchase = date("Y-m-d h:i:sa");



//     $price_fetch = mysqli_query($con, "SELECT SUM(price * quantity) FROM products INNER JOIN $cart_table USING (pr_id)");
//     while ($price_result = mysqli_fetch_assoc($price_fetch)) {
//         $total = $price_result['SUM(price * quantity)'];
//     }

//     $add_query = mysqli_query($con, "INSERT INTO order_details (first_name,last_name,phone,email,location,city,state,pincode,add_details,payment_mode,total,purchase_date,delivery_status,biller_id) VALUES ('$first','$last','$phone','$email','$address','$city','$state','$pincode','$details','$mode','$total','$Date_purchase','Delivered','$biller')");

//     if ($add_query) {
//         $order_fetch = mysqli_query($con, "SELECT order_id FROM order_details WHERE phone = $phone ORDER BY purchase_date DESC LIMIT 1");
//         while ($order_result = mysqli_fetch_array($order_fetch)) {
//             $order_id = $order_result['order_id'];
//             $cart_fetch = mysqli_query($con, "SELECT * FROM $cart_table");
//             while ($cart_row = mysqli_fetch_array($cart_fetch)) {
//                 $pro_id = $cart_row['pr_id'];
//                 $quantity = $cart_row['quantity'];
//                 $pro_fetch = mysqli_query($con, "SELECT * FROM products WHERE pr_id = $pro_id");
//                 while ($pro_result = mysqli_fetch_array($pro_fetch)) {
//                     $price = $pro_result['price'];
//                     $pr_name = $pro_result['brand'] . '' . $pro_result['name'];
//                 }
//                 $order_add = mysqli_query($con, "INSERT INTO order_items (order_id,pr_id,quantity,price,pr_name) VALUES ('$order_id','$pro_id','$quantity','$price','$pr_name')");
//             }
//         }
//         if ($order_add) {
//             $added =  mysqli_query($con, "DELETE FROM $cart_table");

//             if ($added) {
//                 mysqli_close($con);
//                 session_destroy();
//                 header('location:AdminConfirmation.php');
//                 exit;
//             }
//         } else {
//             echo "Can't clear the cart";
//         }
//     } else {
//         echo "Order Failed";
//     }
// }



// //cancel order in confirmation screen
// if (isset($_POST['cancel_id'])) {

//     $CancelId = $_POST['cancel_id'];

//     $cancel_query = mysqli_query($con, "UPDATE order_details SET cancel_status = '1' WHERE order_id = '$CancelId'");

//     if ($cancel_query) {
//         echo "Order is Cancelled";
//     } else {
//         echo "Failed Cancelling this Order";
//     }
// }



// //update payment in confirmation screen
// if (isset($_POST['pay_id'])) {

//     $PayId = $_POST['pay_id'];

//     $Paid_query = mysqli_query($con, "UPDATE order_details SET pay_status = 'Paid' WHERE order_id = '$PayId'");

//     if ($Paid_query) {
//         echo "Payment Received";
//     } else {
//         echo "Payment Failed";
//     }
// }

// //Add product to cart
// if (isset($_POST['product_id'])) {
//     $id = $_POST['product_id'];

//     $check = mysqli_query($con, "SELECT * FROM $cart_table WHERE pr_id = '$id'");
//     if (mysqli_num_rows($check) > 0) {
//         $updated  = mysqli_query($con, "UPDATE $cart_table SET quantity = quantity+1 WHERE pr_id = '$id'");
//         if ($updated) {
//             echo "Updated Successfully";
//         } else {
//             echo "Update Query error";
//         }
//     } else {
//         $added  = mysqli_query($con, "INSERT INTO $cart_table (pr_id,quantity) VALUES ('$id',1) ");
//         if ($added) {
//             echo "Added successfully";
//         } else {
//             echo "Add Query error";
//         }
//     }
// }





// if (isset($_GET['del_id'])) {

//     $delete_id = $_GET['del_id'];
//     $deleted = mysqli_query($con, "DELETE FROM $cart_table WHERE cart_id = $delete_id");

//     if ($deleted) {

//         mysqli_close($con);
//         header("location:AdminShoppingcart.php");
//         exit;
//     } else {
//         echo "Removal of Product Failed";
//     }
// }



// if (isset($_GET['ad_id'])) {
//     $add_id = $_GET['ad_id'];

//     $check = mysqli_query($con, "SELECT * FROM $cart_table WHERE pr_id = '$add_id'");
//     if (mysqli_num_rows($check) > 0) {
//         mysqli_close($con);
//         header('location:AdminShoppingcart.php');
//         exit;
//     } else {
//         $added  = mysqli_query($con, "INSERT INTO $cart_table (pr_id,quantity) VALUES ('$add_id',1) ");
//         if ($added) {
//             mysqli_close($con);
//             header('location:AdminShoppingcart.php');
//             exit;
//         } else {
//             echo "Couldn't add product";
//         }
//     }
// }








/////////////////////////////////////////////////////////////////////Sales Starts Here///////////////////////////////////////////////////////////////////////////////


    //Search for products
    if(isset($_GET['SearchProducts'])){
        $SearchValue = $_GET['SearchProducts'];
        $find_data = mysqli_query($con, "SELECT P.pr_id,P.current_stock,P.imei,P.barcode,CONCAT(B.brand_name, ' ',P.name) as ProductName FROM products P INNER JOIN brands B ON P.brand = B.br_id WHERE P.isInShopSales = 1
        ");
        if(mysqli_num_rows($find_data) > 0){
            while ($dataRow = mysqli_fetch_assoc($find_data)) {
                $rows[] = $dataRow;
            }
        }
        else{
            $rows = array();
        }
        echo json_encode($rows);
    }



    //Delete all Items from cart
    if(isset($_POST['DeleteAll']) && !empty($_POST['DeleteAllAction'])){
        $DeleteAllAction = $_POST['DeleteAllAction'];
        $DeleteAll = mysqli_query($con, "DELETE FROM  $cart_table WHERE userId = '$userId' AND cartAction = '$DeleteAllAction'");
        if($DeleteAll){
            echo json_encode(array('DelAll' => 1));
        }else{
            echo json_encode(array('DelAll' => 2));
        }
    }



    //Add Item By Barcode
    if (isset($_POST['FindItem'])) {

        mysqli_autocommit($con, FALSE);
        $GivenItemData = $_POST['FindItem'];
        $AddItemBarcodeAction = $_POST['AddItemBarcodeAction'];
        $FindItemByData =  mysqli_query($con, "SELECT * FROM products WHERE barcode = '$GivenItemData'");
        if (mysqli_num_rows($FindItemByData) > 0) {

            foreach ($FindItemByData as $FindItemByDataResult) {
                $ItemId = $FindItemByDataResult['pr_id'];
                $ItemName = $FindItemByDataResult['name'];
                $ItemImei = $FindItemByDataResult['imei'];
                $ItemBarcode = $FindItemByDataResult['barcode'];
                $ItemCode = $FindItemByDataResult['pr_code'];
                $ItemUnit = $FindItemByDataResult['unitid'];
                $ItemInclusive = $FindItemByDataResult['inclusive'];
                $ItemCp = $FindItemByDataResult['cp'];
                $ItemLastCp = $FindItemByDataResult['lastcp'];
                $ItemIgst = $FindItemByDataResult['IGST'];
                $ItemMrp = $FindItemByDataResult['mrp'];
                $ItemBatch = $FindItemByDataResult['batch'];
                $ItemExpiry = $FindItemByDataResult['expiryDate'];
                $ItemSp = $FindItemByDataResult['sp'];
                // $ItemUserCode = $FindItemByDataResult['usercode'];
                $ItemHsn = $FindItemByDataResult['hsn'];
            }

            $FindMaxTempCart = mysqli_query($con, "SELECT MAX(cart_id) FROM $cart_table");
            foreach ($FindMaxTempCart as $FindMaxTempCartResult) {
                $MaxTempCart = $FindMaxTempCartResult['MAX(cart_id)'] + 1;
            }

            $CheckIfItemExistsInTable = mysqli_query($con, "SELECT * FROM $cart_table WHERE itembarcode = $GivenItemData AND userId = '$userId' AND cartAction = '$AddItemBarcodeAction'");
            if(mysqli_num_rows($CheckIfItemExistsInTable) > 0){
                
                foreach($CheckIfItemExistsInTable as $CheckIfItemExistsInTableResult){
                    $Qty = $CheckIfItemExistsInTableResult['quantity'];
                    $IGSTP = $CheckIfItemExistsInTableResult['IGSTPercentage'];
                    $IsInclusive = $CheckIfItemExistsInTableResult['inclusive'];
                    $DiscAmt = $CheckIfItemExistsInTableResult['inddiscountamount'];
                    $DiscPercnt = $CheckIfItemExistsInTableResult['inddiscountpercentage'];
                    $CartChangeId = $CheckIfItemExistsInTableResult['cart_id'];
                }

                $ChangeValue = $Qty + 1;
                $BeforeGrossAmount = $ChangeValue * $CheckIfItemExistsInTableResult['rate'];
                $DiscountResult =  json_decode(CalculateDiscount($BeforeGrossAmount, '', $DiscPercnt));
                $DiscPercent = $DiscountResult->DiscountPercentage;
                $DiscountedAmt = $DiscountResult->DiscountedAmount;
                $DiscountAmt = $DiscountResult->DiscountAmount;
                $GrossAmount = $DiscountedAmt;

                $UpdateQtyinTable = mysqli_query($con, "UPDATE $cart_table SET quantity = '$ChangeValue',inddiscountamount = '$DiscountAmt' WHERE cart_id = '$CartChangeId' AND userId = '$userId' AND cartAction = '$AddItemBarcodeAction'");
                if ($UpdateQtyinTable) {
                    $TaxChangesResult =  CalculateTax($con, $IsInclusive, $IGSTP, $GrossAmount, $cart_table, $CartChangeId, $userId);
                    if ($TaxChangesResult == 'Success') {
                        $CessCalculateResult = CalculateCessAndAdditionalCess($con, $CartChangeId, $cart_table, $userId);
                        if ($CessCalculateResult == 'Success') {
                            mysqli_commit($con);
                            echo json_encode(array('AddItem' => 1));
                        } else {
                            mysqli_rollback($con);
                            echo json_encode(array('AddItem' => 2));
                        }
                    } else {
                        mysqli_rollback($con);
                        echo json_encode(array('AddItem' => 2));
                    }
                }

                
            }
            else{
                $AddItemQuery = "INSERT INTO $cart_table (`cart_id`,`pr_id`,`quantity`,`inclusive`,`itembarcode`,`itemimei`,`inddiscountpercentage`,`inddiscountamount`,`rate`,`sp`,`mrp`,`producttotalamount`,`salestax`,`taxamount`,`amount`,`lc`,`CGSTPercentage`,`CGSTAmt`,`SGSTPercentage`,`SGSTAmt`,`IGSTPercentage`,`IGSTAmt`,`cesspercentage`,`cessamount`,`hsn`,`addcesspercentage`,`addcessamount`,`userId`,`cartAction`) VALUES ('$MaxTempCart','$ItemId','1','$ItemInclusive','$ItemBarcode','$ItemImei','0','0','$ItemSp','$ItemSp','$ItemMrp','0','$ItemIgst','0','0','0','0','0','0','0','$ItemIgst','0','0','0','$ItemHsn','0','0','$userId','$AddItemBarcodeAction')";

                //echo $AddItemQuery;
        
                $InsertIntoCart = mysqli_query($con, $AddItemQuery);
                if ($InsertIntoCart) {
                    $IGSTP = $ItemIgst;
                    $GrossAmount = 1 * $ItemSp;
                    $UpdateQtyinTable = mysqli_query($con, "UPDATE $cart_table SET quantity = 1 WHERE cart_id = '$MaxTempCart' AND userId = '$userId' AND cartAction = '$AddItemBarcodeAction'");
                    if ($UpdateQtyinTable) {
                        $TaxChangesResult =  CalculateTax($con, $ItemInclusive, $IGSTP, $GrossAmount, $cart_table, $MaxTempCart, $userId);
                        if ($TaxChangesResult == 'Success') {
                            $CessCalculateResult = CalculateCessAndAdditionalCess($con, $MaxTempCart, $cart_table, $userId);
                            if ($CessCalculateResult == 'Success') {
                                mysqli_commit($con);
                                echo json_encode(array('AddItem' => 1));
                            } else {
                                mysqli_rollback($con);
                                echo json_encode(array('AddItem' => 2));
                            }
                        } else {
                            mysqli_rollback($con);
                            echo json_encode(array('AddItem' => 2));
                        }
                    }
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('AddItem' => 2));
                }
            }
        } else {
            mysqli_rollback($con);
            echo json_encode(array('AddItem' => 0));
        }
    }




    //Add Item By IMEI
    if (isset($_POST['FindItemIMEI'])) {

        mysqli_autocommit($con, FALSE);
        $GivenItemIMEIData = $_POST['FindItemIMEI'];
        $AddItemIMEIAction = $_POST['AddItemIMEIAction'];
        $FindItemByIMEIData =  mysqli_query($con, "SELECT * FROM products WHERE imei = '$GivenItemIMEIData' AND imei <> 0");
        if (mysqli_num_rows($FindItemByIMEIData) > 0) {

            foreach ($FindItemByIMEIData as $FindItemByIMEIDataResult) {
                $ItemId = $FindItemByIMEIDataResult['pr_id'];
                $ItemName = $FindItemByIMEIDataResult['name'];
                $ItemImei = $FindItemByIMEIDataResult['imei'];
                $ItemBarcode = $FindItemByIMEIDataResult['barcode'];
                $ItemCode = $FindItemByIMEIDataResult['pr_code'];
                $ItemUnit = $FindItemByIMEIDataResult['unitid'];
                $ItemInclusive = $FindItemByIMEIDataResult['inclusive'];
                $ItemCp = $FindItemByIMEIDataResult['cp'];
                $ItemLastCp = $FindItemByIMEIDataResult['lastcp'];
                $ItemIgst = $FindItemByIMEIDataResult['IGST'];
                $ItemMrp = $FindItemByIMEIDataResult['mrp'];
                $ItemBatch = $FindItemByIMEIDataResult['batch'];
                $ItemExpiry = $FindItemByIMEIDataResult['expiryDate'];
                $ItemSp = $FindItemByIMEIDataResult['sp'];
                // $ItemUserCode = $FindItemByIMEIDataResult['usercode'];
                $ItemHsn = $FindItemByIMEIDataResult['hsn'];
                $ItemStock = $FindItemByIMEIDataResult['current_stock'];
            }

            if($ItemStock <= 0){
                echo json_encode(array('AddItemIMEI' => 3)); //Item out of stock
            }else{

                $FindMaxTempCart = mysqli_query($con, "SELECT MAX(cart_id) FROM $cart_table");
                foreach ($FindMaxTempCart as $FindMaxTempCartResult) {
                    $MaxTempCart = $FindMaxTempCartResult['MAX(cart_id)'] + 1;
                }

                $CheckIfItemExistsInTable = mysqli_query($con, "SELECT * FROM $cart_table WHERE itemimei = '$GivenItemIMEIData' AND userId = '$userId' AND cartAction = '$AddItemIMEIAction'");
                if(mysqli_num_rows($CheckIfItemExistsInTable) > 0){
                    mysqli_rollback($con);
                    echo json_encode(array('AddItemIMEI' => 4));
                }else{
                    $AddItemIMEIQuery = "INSERT INTO $cart_table (`cart_id`,`pr_id`,`quantity`,`inclusive`,`itembarcode`,`itemimei`,`inddiscountpercentage`,`inddiscountamount`,`rate`,`sp`,`mrp`,`producttotalamount`,`salestax`,`taxamount`,`amount`,`lc`,`CGSTPercentage`,`CGSTAmt`,`SGSTPercentage`,`SGSTAmt`,`IGSTPercentage`,`IGSTAmt`,`cesspercentage`,`cessamount`,`hsn`,`addcesspercentage`,`addcessamount`,`userId`,`cartAction`) VALUES ('$MaxTempCart','$ItemId','1','$ItemInclusive','$ItemBarcode','$ItemImei','0','0','$ItemSp','$ItemSp','$ItemMrp','0','$ItemIgst','0','0','0','0','0','0','0','$ItemIgst','0','0','0','$ItemHsn','0','0','$userId','$AddItemIMEIAction')";
                    //echo $AddItemQuery;
                    $InsertIntoCartIMEI = mysqli_query($con, $AddItemIMEIQuery);
                    if ($InsertIntoCartIMEI) {
                        $IGSTP = $ItemIgst;
                        $GrossAmount = 1 * $ItemSp;
                        $UpdateQtyinTable = mysqli_query($con, "UPDATE $cart_table SET quantity = 1 WHERE cart_id = '$MaxTempCart' AND userId = '$userId' AND cartAction = '$AddItemIMEIAction'");
                        if ($UpdateQtyinTable) {
                            $TaxChangesResult =  CalculateTax($con, $ItemInclusive, $IGSTP, $GrossAmount, $cart_table, $MaxTempCart, $userId);
                            if ($TaxChangesResult == 'Success') {
                                $CessCalculateResult = CalculateCessAndAdditionalCess($con, $MaxTempCart, $cart_table, $userId);
                                if ($CessCalculateResult == 'Success') {
                                    mysqli_commit($con);
                                    echo json_encode(array('AddItemIMEI' => '1'));
                                } else {
                                    mysqli_rollback($con);
                                    echo json_encode(array('AddItemIMEI' => '0'));
                                }
                            } else {
                                mysqli_rollback($con);
                                echo json_encode(array('AddItemIMEI' => '0'));
                            }
                        }
                    } else {
                        mysqli_rollback($con);
                        echo json_encode(array('AddItemIMEI' => 2));
                    }
                }
            }

        } else {
            mysqli_rollback($con);
            echo json_encode(array('AddItemIMEI' => 0));
        }
    }




    //Add Item By Product Id
    if (isset($_POST['FindProductById']) && !empty($_POST['AddItemAction'])) {

        mysqli_autocommit($con, FALSE);
        $GivenItemIdData = $_POST['FindProductById'];
        $AddItemAction = $_POST['AddItemAction'];
        $FindItemByIdData =  mysqli_query($con, "SELECT * FROM products WHERE pr_id = '$GivenItemIdData'");
        if (mysqli_num_rows($FindItemByIdData) > 0) {


            foreach ($FindItemByIdData as $FindItemByDataResult) {
                $ItemId = $FindItemByDataResult['pr_id'];
                $ItemName = $FindItemByDataResult['name'];
                $ItemImei = $FindItemByDataResult['imei'];
                $ItemBarcode = $FindItemByDataResult['barcode'];
                $ItemCode = $FindItemByDataResult['pr_code'];
                $ItemUnit = $FindItemByDataResult['unitid'];
                $ItemInclusive = $FindItemByDataResult['inclusive'];
                $ItemCp = $FindItemByDataResult['cp'];
                $ItemLastCp = $FindItemByDataResult['lastcp'];
                $ItemIgst = $FindItemByDataResult['IGST'];
                $ItemMrp = $FindItemByDataResult['mrp'];
                $ItemBatch = $FindItemByDataResult['batch'];
                $ItemExpiry = $FindItemByDataResult['expiryDate'];
                $ItemSp = $FindItemByDataResult['sp'];
                // $ItemUserCode = $FindItemByDataResult['usercode'];
                $ItemHsn = $FindItemByDataResult['hsn'];
                $ItemStock = $FindItemByDataResult['current_stock'];
            }

            if($ItemStock <= 0){
                echo json_encode(array('AddItemById' => 3)); //Item out of stock
            }else{
                $FindMaxTempCart = mysqli_query($con, "SELECT MAX(cart_id) FROM $cart_table");
                foreach ($FindMaxTempCart as $FindMaxTempCartResult) {
                    $MaxTempCart = $FindMaxTempCartResult['MAX(cart_id)'] + 1;
                }
        
                $CheckIfItemExistsInTable = mysqli_query($con, "SELECT * FROM $cart_table WHERE pr_id = $GivenItemIdData AND userId = '$userId' AND cartAction = '$AddItemAction'");
                if(mysqli_num_rows($CheckIfItemExistsInTable) > 0){
                    
                    foreach($CheckIfItemExistsInTable as $CheckIfItemExistsInTableResult){
                        $Qty = $CheckIfItemExistsInTableResult['quantity'];
                        $IGSTP = $CheckIfItemExistsInTableResult['IGSTPercentage'];
                        $IsInclusive = $CheckIfItemExistsInTableResult['inclusive'];
                        $DiscAmt = $CheckIfItemExistsInTableResult['inddiscountamount'];
                        $DiscPercnt = $CheckIfItemExistsInTableResult['inddiscountpercentage'];
                        $CartChangeId = $CheckIfItemExistsInTableResult['cart_id'];
                    }
                    
                    $ChangeValue = $Qty + 1;
                    if($ChangeValue > $ItemStock){
                        echo json_encode(array('AddItemById' => 3)); //Item out of stock
                    }else{

                        $BeforeGrossAmount = $ChangeValue * $CheckIfItemExistsInTableResult['rate'];
                        $DiscountResult =  json_decode(CalculateDiscount($BeforeGrossAmount, '', $DiscPercnt));
                        $DiscPercent = $DiscountResult->DiscountPercentage;
                        $DiscountedAmt = $DiscountResult->DiscountedAmount;
                        $DiscountAmt = $DiscountResult->DiscountAmount;
                        $GrossAmount = $DiscountedAmt;
            
                        $UpdateQtyinTable = mysqli_query($con, "UPDATE $cart_table SET quantity = '$ChangeValue',inddiscountamount = '$DiscountAmt' WHERE cart_id = '$CartChangeId' AND userId = '$userId' AND cartAction = '$AddItemAction'");
                        if ($UpdateQtyinTable) {
                            $TaxChangesResult =  CalculateTax($con, $IsInclusive, $IGSTP, $GrossAmount, $cart_table, $CartChangeId, $userId);
                            if ($TaxChangesResult == 'Success') {
                                $CessCalculateResult = CalculateCessAndAdditionalCess($con, $CartChangeId, $cart_table, $userId);
                                if ($CessCalculateResult == 'Success') {
                                    mysqli_commit($con);
                                    echo json_encode(array('AddItemById' => 1));
                                } else {
                                    mysqli_rollback($con);
                                    echo json_encode(array('AddItemById' => 2));
                                }
                            } else {
                                mysqli_rollback($con);
                                echo json_encode(array('AddItemById' => 2));
                            }
                        }
            
                    }   
                }
                else{
                        
                    $AddItemQuery = "INSERT INTO $cart_table (`cart_id`,`pr_id`,`quantity`,`inclusive`,`itembarcode`,`itemimei`,`inddiscountpercentage`,`inddiscountamount`,`rate`,`sp`,`mrp`,`producttotalamount`,`salestax`,`taxamount`,`amount`,`lc`,`CGSTPercentage`,`CGSTAmt`,`SGSTPercentage`,`SGSTAmt`,`IGSTPercentage`,`IGSTAmt`,`cesspercentage`,`cessamount`,`hsn`,`addcesspercentage`,`addcessamount`,`userId`,`cartAction`) VALUES ('$MaxTempCart','$ItemId','1','$ItemInclusive','$ItemBarcode','$ItemImei','0','0','$ItemSp','$ItemSp','$ItemMrp','0','$ItemIgst','0','0','0','0','0','0','0','$ItemIgst','0','0','0','$ItemHsn','0','0','$userId','$AddItemAction')";
        
                    //echo $AddItemQuery;
        
                    $InsertIntoCart = mysqli_query($con, $AddItemQuery);
                    if ($InsertIntoCart) {
                        $IGSTP = $ItemIgst;
                        $GrossAmount = 1 * $ItemSp;
                        $UpdateQtyinTable = mysqli_query($con, "UPDATE $cart_table SET quantity = 1 WHERE cart_id = '$MaxTempCart' AND userId = '$userId' AND cartAction = '$AddItemAction'");
                        if ($UpdateQtyinTable) {
                            $TaxChangesResult =  CalculateTax($con, $ItemInclusive, $IGSTP, $GrossAmount, $cart_table, $MaxTempCart, $userId);
                            if ($TaxChangesResult == 'Success') {
                                $CessCalculateResult = CalculateCessAndAdditionalCess($con, $MaxTempCart, $cart_table, $userId);
                                if ($CessCalculateResult == 'Success') {
                                    mysqli_commit($con);
                                    echo json_encode(array('AddItemById' => 1));
                                } else {
                                    mysqli_rollback($con);
                                    echo json_encode(array('AddItemById' => 2));
                                }
                            } else {
                                mysqli_rollback($con);
                                echo json_encode(array('AddItemById' => 2));
                            }
                        }
                    } else {
                        mysqli_rollback($con);
                        echo json_encode(array('AddItemById' => 2));
                    }
                }
            }

        } else {
            mysqli_rollback($con);
            echo json_encode(array('AddItemById' => 0));
        }
    }




    //CHANGE CART QUANTITY
    if (isset($_POST['cartchange_id']) && !empty($_POST['change_qty'])) {

        //mysqli_autocommit($con, false);
        $CartChangeId =  $_POST['cartchange_id'];
        $ChangeValue = $_POST['change_qty'];
        $ChangeQtyAction = $_POST['ChangeQtyAction'];


        $FindRateFromTempTable = mysqli_query($con, "SELECT rate,inclusive,inddiscountamount,inddiscountpercentage,igstpercentage FROM $cart_table WHERE cart_id = '$CartChangeId' AND userId = '$userId' AND cartAction = '$ChangeQtyAction'");
        foreach ($FindRateFromTempTable as $FindRateFromTempTableResult) {
            $IGSTP = $FindRateFromTempTableResult['igstpercentage'];
            $IsInclusive = $FindRateFromTempTableResult['inclusive'];
            $DiscAmt = $FindRateFromTempTableResult['inddiscountamount'];
            $DiscPercnt = $FindRateFromTempTableResult['inddiscountpercentage'];
        }


        // $BeforeGrossAmount = $ChangeValue * $FindRateFromTempTableResult['rate'];
        // $DiscountResult =  json_decode(CalculateDiscount($BeforeGrossAmount, $DiscAmt, ''));
        // $DiscPercent = $DiscountResult->DiscountPercentage;
        // $DiscountedAmt = $DiscountResult->DiscountedAmount;
        // $DiscountAmt = $DiscountResult->DiscountAmount;
        // $GrossAmount = $DiscountedAmt;

        // $UpdateQtyinTable = mysqli_query($con, "UPDATE $cart_table SET quantity = '$ChangeValue',inddiscountamount = '$DiscountAmt' WHERE cart_id = '$CartChangeId' AND userId = '$userId'");
        // if ($UpdateQtyinTable) {
        //     $TaxChangesResult =  CalculateTax($con, $IsInclusive, $IGSTP, $GrossAmount, $cart_table, $CartChangeId, $userId);
        //     if ($TaxChangesResult == 'Success') {
        //         $CessCalculateResult = CalculateCessAndAdditionalCess($con, $CartChangeId, $cart_table, $userId);
        //         if ($CessCalculateResult == 'Success') {
        //             echo json_encode(array('CartQty' => '1'));
        //         } else {
        //             echo json_encode(array('CartQty' => '0'));
        //         }
        //     } else {
        //         echo json_encode(array('CartQty' => '0'));
        //     }
        // }

        $BeforeGrossAmount = $ChangeValue * $FindRateFromTempTableResult['rate'];
        $DiscountResult =  json_decode(CalculateDiscount($BeforeGrossAmount, '', $DiscPercnt));
        $DiscPercent = $DiscountResult->DiscountPercentage;
        $DiscountedAmt = $DiscountResult->DiscountedAmount;
        $DiscountAmt = $DiscountResult->DiscountAmount;
        $GrossAmount = $DiscountedAmt;

        $UpdateQtyinTable = mysqli_query($con, "UPDATE $cart_table SET quantity = '$ChangeValue',inddiscountamount = '$DiscountAmt' WHERE cart_id = '$CartChangeId' AND userId = '$userId' AND cartAction = '$ChangeQtyAction'");
        if ($UpdateQtyinTable) {
            $TaxChangesResult =  CalculateTax($con, $IsInclusive, $IGSTP, $GrossAmount, $cart_table, $CartChangeId, $userId);
            if ($TaxChangesResult == 'Success') {
                $CessCalculateResult = CalculateCessAndAdditionalCess($con, $CartChangeId, $cart_table, $userId);
                if ($CessCalculateResult == 'Success') {
                    echo json_encode(array('CartQty' => '1'));
                } else {
                    echo json_encode(array('CartQty' => '0'));
                }
            } else {
                echo json_encode(array('CartQty' => '0'));
            }
        }
    }




    //Delete Item From Cart
    if (isset($_POST['DeleteCartId']) && !empty($_POST['DeleteCartAction'])) {

        mysqli_autocommit($con, FALSE);
        $DeleteCartId = $_POST['DeleteCartId'];
        $DeleteCartAction = $_POST['DeleteCartAction'];
        $DeleteItemByData =  mysqli_query($con, "DELETE FROM $cart_table WHERE cart_id = '$DeleteCartId' AND userId =  '$userId' AND cartAction = '$DeleteCartAction'");

        if ($DeleteItemByData) {
            mysqli_commit($con);
            echo json_encode(array('DeleteCart' => 1));
        } else {
            mysqli_rollback($con);
            echo json_encode(array('DeleteCart' => 2));
        }
    }



    //Add Discount Amount
    if (isset($_POST['DiscountChangeId'])) {

        $ChangeDiscAmt = ($_POST['DiscountChangeValue'] != '') ? $_POST['DiscountChangeValue'] : 0;
        $ChangeDiscAmtRow = $_POST['DiscountChangeId'];
        $DiscountAction = $_POST['DiscountAction'];

        $FindRateFromTempTable = mysqli_query($con, "SELECT rate,quantity,inclusive,igstpercentage FROM $cart_table WHERE cart_id = '$ChangeDiscAmtRow' AND userId = '$userId' AND cartAction = '$DiscountAction'");
        foreach ($FindRateFromTempTable as $FindRateFromTempTableResult) {
            $IGSTP = $FindRateFromTempTableResult['igstpercentage'];
            $IsInclusive = $FindRateFromTempTableResult['inclusive'];
            $Rate = $FindRateFromTempTableResult['rate'];
            $QTY = $FindRateFromTempTableResult['quantity'];
            //$ProductTotal = $FindRateFromTempTableResult['producttotalamount'];
            //$Amount = $FindRateFromTempTableResult['amount'];
        }

        $Gross = $Rate * $QTY;

        $DiscountResult =  json_decode(CalculateDiscount($Gross, $ChangeDiscAmt, ''));

        //print_r($DiscountResult);

        $DiscPercent = $DiscountResult->DiscountPercentage;
        $DiscountedAmt = $DiscountResult->DiscountedAmount;
        $GrossAmount = $DiscountedAmt;
        $CP = $DiscountedAmt / $QTY;

        $UpdateDiscountinTable = mysqli_query($con, "UPDATE $cart_table SET sp ='$CP',producttotalamount = '$GrossAmount',inddiscountamount = '$ChangeDiscAmt',inddiscountpercentage = '$DiscPercent' WHERE cart_id = '$ChangeDiscAmtRow' AND userId = '$userId' AND cartAction = '$DiscountAction'");
        if ($UpdateDiscountinTable) {

            $TaxChangesResult =  CalculateTax($con, $IsInclusive, $IGSTP, $GrossAmount, $cart_table, $ChangeDiscAmtRow, $userId);
            if ($TaxChangesResult == 'Success') {
                $CessCalculateResult = CalculateCessAndAdditionalCess($con, $ChangeDiscAmtRow, $cart_table, $userId);
                if ($CessCalculateResult == 'Success') {
                    echo json_encode(array('DiscountChange' => '1'));
                } else {
                    echo json_encode(array('DiscountChange' => '0'));
                }
            } else {
                echo json_encode(array('DiscountChange' => '0'));
            }
        }
    }



    //Show Totals
    if (isset($_POST['ShowTotal']) && !empty($_POST['ShowTotalAction'])) {
        $ShowTotalAction = $_POST['ShowTotalAction'];
        echo FindAllTotalAmounts($con, $cart_table, $userId,$ShowTotalAction);
    }


    //Add Sales
    if (isset($_POST['CustomerName']) && !empty($_POST['CustomerName'])) {

        $CustomerName = $_POST['CustomerName'];
        $CustomerPhone = $_POST['CustomerMobile'];
        $CustomerAddress = $_POST['CustomerAddress'];
        $InvoiceDate = $DateToday;
        $BillType = 'SU';
        $ModeOfPay = $_POST['CustomerMOP'];
        $CardAmount = 0;
        $Cardno = 0;
        $Balanceamount = 0;
        $Accharge = 0;
        $Deliverycharge = 0;
        $Floor = 0;
        $Bankid = 0;
        $Ratetypeid = 0;
        $Packingno = 0;
        $Printcount = 0;
        $Deliverydate = '';
        $Careofid = 0;
        $Feedback = '';
        $Remarks = '';
        $Jobcardid = 0;
        $Pointsamount = 0;
        $Pointsamount = 0;
        $Redeempoint = 0;
        $Redeemamount = 0;
        $Totalearnedpoints = 0;
        $Totalredeemedpoints = 0;
        $Totalearnedamount = 0;
        $Totalredeemedamount = 0;
        $Despatchaddress = $CustomerAddress;
        $Vehicleid = 0;
        $Routeid = 0;
        $Driverid = 0;
        $Rentpayable = 0;
        $Totalkms = 0;
        $Salesreturnid = 0;
        $Salesreturnamt = 0;
        $Totaltcsamt = 0;
        $Discper = 0;
        $Billnoprefix = '';
        $SalesAction = $_POST['SalesAction'];


        mysqli_autocommit($con, FALSE);

        //check if temp table is empty or not
        $check_empty = mysqli_query($con, "SELECT * FROM $cart_table WHERE userId = '$userId' AND cartAction = '$SalesAction'");
        if (mysqli_num_rows($check_empty) > 0) {

            $TotalAmountResult = json_decode(FindAllTotalAmounts($con, $cart_table,$userId));

            $TotalQty = $TotalAmountResult->TotalQty;
            $TotalTax = $TotalAmountResult->TotalTax;
            $TotalGross = $TotalAmountResult->TotalGross;
            $CashAmount = $TotalNet =  $TotalAmountResult->TotalNet;
            $TotalRoundoff = $TotalAmountResult->RoundOff;
            $TotalCess =  $TotalAmountResult->TotalCess;
            $TotalAddCess =  $TotalAmountResult->TotalAddCess;
            $TotalOthercharge = $TotalAmountResult->TotalOtherCharge;
            $TotalDiscount = $TotalAmountResult->TotalAddDiscount;
            $TotalIndDiscount = $TotalAmountResult->TotalIndDiscount;

            $FetchSalesId = mysqli_query($con, "SELECT MAX(billid) FROM bill");
            foreach ($FetchSalesId as $FetchSalesIdResults) {
                $SalesId = $FetchSalesIdResults['MAX(billid)'] + 1;
            }


            $FindMaxBillNo = mysqli_query($con, "SELECT MAX(BillNo) FROM bill WHERE type = '$BillType'");
            foreach ($FindMaxBillNo as $FindMaxBillNoResults) {
                $BillNo = $FindMaxBillNoResults['MAX(BillNo)'] + 1;
            }

            $SaleQuery = "INSERT INTO `bill` (`billid`,`billdate`,`counterno`,`totalqty`,`grossamount`,`totaltaxamount`,`totaldiscount`,`totalamount`,`servicecharge`,`roundoff`,`netamount`,`createduserid`,`createddate`,`CancelStatus`,`CanceledUserId`,`CanceledDate`,`BillNo`,`type`,`hdcustomername`,`hdContactNo`,`hdLocation`,`deliveryboy`,`customerid`,`customername`,`contactno`,`address`,`modeofpayment`,`cashamount`,`cardamount`,`cardno`,`balanceamount`,`accharge`,`deliverycharge`,`floor`,`bankid`,`ratetypeid`,`totalcess`,`packingno`,`totalAddcess`,`printcount`,`deliverydate`,`careofid`,`feedback`,`remarks`,`jobcardid`,`pointsamount`,`point`,`redeempoint`,`redeemamount`,`totalearnedpoints`,`totalredeemedpoints`,`totalearnedAmount`,`totalredeemedAmount`,`totalothercharge`,`despatchaddress`,`vehicleid`,`routeid`,`driverid`,`rentpayable`,`totalkms`,`salesreturnid`,`salesreturnAmt`,`totalTCSamt`,`Discper`,`billnoprefix`) VALUES ('$SalesId','$DateToday','Counter1','$TotalQty','$TotalGross','$TotalTax','$TotalIndDiscount','$TotalNet','0','$TotalRoundoff','$TotalNet','$userId','$DateToday','0','0','','$BillNo','$BillType','','','','','0','$CustomerName','$CustomerPhone','$CustomerAddress','$ModeOfPay','$CashAmount','$CardAmount','$Cardno','$Balanceamount','$Accharge','$Deliverycharge','$Floor','$Bankid','$Ratetypeid','$TotalCess','$Packingno','$TotalAddCess','$Printcount','$Deliverydate','$Careofid','$Feedback','$Remarks','$Jobcardid','$Pointsamount','$Pointsamount','$Redeempoint','$Redeemamount','$Totalearnedpoints','$Totalredeemedpoints','$Totalearnedamount','$Totalredeemedamount','$TotalOthercharge','$Despatchaddress','$Vehicleid','$Routeid','$Driverid','$Rentpayable','$Totalkms','$Salesreturnid','$Salesreturnamt','$Totaltcsamt','$Discper','$Billnoprefix')";

            $SaleQuery;

            //insert into Sales table
            $InsertIntoSalesMain = mysqli_query($con, $SaleQuery);



            if ($InsertIntoSalesMain) {

                $FetchFromTempSales = mysqli_query($con, "SELECT * FROM $cart_table WHERE pr_id <> 0 AND userId = '$userId' AND cartAction = '$SalesAction'");
                $FetchFromTempSalesRows = mysqli_num_rows($FetchFromTempSales);
                if ($FetchFromTempSalesRows > 0) {
                    $SalesDetailedCounter = 0;
                    foreach ($FetchFromTempSales as $FetchFromTempSalesResults) {

                        $ItemId = $FetchFromTempSalesResults['pr_id'];
                        $Qty = $FetchFromTempSalesResults['quantity'];
                        $Rate = $FetchFromTempSalesResults['rate'];
                        $Inclusive = $FetchFromTempSalesResults['inclusive'];
                        $IndDiscPerc = $FetchFromTempSalesResults['inddiscountpercentage'];
                        $IndDiscAmt = $FetchFromTempSalesResults['inddiscountamount'];
                        $Sp = $FetchFromTempSalesResults['sp'];
                        $Mrp = $FetchFromTempSalesResults['mrp'];
                        $ProductTotal = $FetchFromTempSalesResults['producttotalamount'];
                        $SalesTax = $FetchFromTempSalesResults['salestax'];
                        $Taxamt = $FetchFromTempSalesResults['IGSTAmt'];
                        $Amt = $FetchFromTempSalesResults['amount'];
                        $Lc = $FetchFromTempSalesResults['lc'];
                        $CGSTPER = $FetchFromTempSalesResults['CGSTPercentage'];
                        $CGSTAMT = $FetchFromTempSalesResults['CGSTAmt'];
                        $SGSTPER = $FetchFromTempSalesResults['SGSTPercentage'];
                        $SGSTAMT = $FetchFromTempSalesResults['SGSTAmt'];
                        $IGSTPER = $FetchFromTempSalesResults['IGSTPercentage'];
                        $IGSTAMT = $FetchFromTempSalesResults['IGSTAmt'];
                        $CessPerc = $FetchFromTempSalesResults['cesspercentage'];
                        $CessAmt = $FetchFromTempSalesResults['cessamount'];
                        $Hsn = $FetchFromTempSalesResults['hsn'];
                        $AddCessPerc = $FetchFromTempSalesResults['addcesspercentage'];
                        $AddCessAmt = $FetchFromTempSalesResults['addcessamount'];
                        $Pack = 0;
                        $StockQty = '-'.$FetchFromTempSalesResults['quantity'];


                        $FindMaxSalesDetailed = mysqli_query($con, "SELECT MAX(billdetailedid) FROM billdetailed");
                        foreach ($FindMaxSalesDetailed as $FindMaxSalesDetailedResults) {
                            $MaxSalesDetailed = $FindMaxSalesDetailedResults['MAX(billdetailedid)'] + 1;
                        }

                        $InsertIntoSalesDetailedQuery = "INSERT INTO `billdetailed` (`billdetailedid`,`billid`,`itemid`,`qty`,`rate`,`discountpercentage`,`discountamount`,`sp`,`gross`,`salestax`,`tax`,`amount`,`kitchenstatus`,`serialid`,`schemedetailedid`,`SalesManId`,`cgstpercentage`,`cgstamt`,`sgstpercentage`,`sgstamt`,`igstpercentage`,`igstamt`,`inclusive`,`cesspercentage`,`cessamount`,`mrp`,`hsn`,`addcesspercentage`,`addcessamount`,`lastcp`,`unitid`,`factor`,`TCS`,`TCSamt`,`Serial_No`) VALUES('$MaxSalesDetailed','$SalesId','$ItemId','$Qty','$Rate','$IndDiscPerc','$IndDiscAmt','$Sp','$ProductTotal','$SalesTax','$Taxamt','$Amt','0','0','0','$userId','$CGSTPER','$CGSTAMT','$SGSTPER','$SGSTAMT','$IGSTPER','$IGSTAMT','$Inclusive','$CessPerc','$CessAmt','$Mrp','$Hsn','$AddCessPerc','$AddCessAmt','0','0','0','0','0','0')";

                        //insert into Sales detailed
                        $InsertIntoSalesDetailed = mysqli_query($con, $InsertIntoSalesDetailedQuery);

                        if ($InsertIntoSalesDetailed) {
                            if (ChangeInStock($con, $StockQty, $ItemId, 'SALES') == 'Success') {
                                $SalesDetailedCounter++;
                            }
                        }
                    }

                    if ($SalesDetailedCounter == $FetchFromTempSalesRows) {
                        mysqli_commit($con);
                        echo json_encode(array('SalesSuccess' => 1 , 'SalesPrintId' => $SalesId));
                    } else {
                        mysqli_rollback($con);
                        echo json_encode(array('SalesSuccess' => 2));
                    }
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('SalesSuccess' => 2));
                }
            } else {
                mysqli_rollback($con);
                echo json_encode(array('SalesSuccess' => 2));
            }
        } else {
            echo json_encode(array('SalesSuccess' => 0));
        }
    }



    //Delete Sales
    if(isset($_POST['delSales'])){

        mysqli_autocommit($con, false);

        $DeleteSalesId = $_POST['delSales'];

        $DeleteCounter = 0;
        $FindBillDetailedItems = mysqli_query($con, "SELECT itemid,qty,billdetailedid FROM billdetailed WHERE billid = '$DeleteSalesId'");
        $FindBillDetailedCounter = mysqli_num_rows($FindBillDetailedItems);
        if($FindBillDetailedCounter > 0){
            foreach($FindBillDetailedItems as $FindBillDetailedItemsResult){
                $ItemQty = $FindBillDetailedItemsResult['qty'];
                $ItemId = $FindBillDetailedItemsResult['itemid'];
                $BillDetailId = $FindBillDetailedItemsResult['billdetailedid'];
                $StockChangeResult =  ChangeInStock($con,$ItemQty,$ItemId,'SALES');
                if($StockChangeResult == 'Success'){
                    $DeleteBillDetailed = mysqli_query($con, "DELETE FROM billdetailed WHERE billdetailedid = '$BillDetailId'");
                    if($DeleteBillDetailed){
                        $DeleteCounter++;
                    }else{
                    }
                }else{
                }
            }
            if($FindBillDetailedCounter == $DeleteCounter){
                $DeleteBill = mysqli_query($con, "DELETE FROM bill WHERE billid = '$DeleteSalesId'");
                if($DeleteBill){
                    mysqli_commit($con);
                    echo json_encode(array('DeleteSales' => 1));
                }else{
                    mysqli_rollback($con);
                    echo json_encode(array('DeleteSales' => 2));
                }
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('DeleteSales' => 2));
            }

        }else{
            mysqli_rollback($con);
            echo json_encode(array('DeleteSales' => 2));
        }
        
    }



/////////////////////////////////////////////////////////////////////Sales Ends Here///////////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////   Ecommerce Operations Starts here  ///////////////////////////////////////////////////////////////////////////////



    //Show All Items on sales Orders
    if(isset($_POST['ShowSalesOrderItems'])){
        $BillId = $_POST['ShowSalesOrderItems'];

        $FindEbillItems = mysqli_query($con, "SELECT * FROM ebilldetailed EBD LEFT JOIN products P ON EBD.itemid = P.pr_id WHERE EBD.billid = '$BillId'");
        $BillItemsCounter = 0;
        foreach($FindEbillItems as $FindEbillItemsResults){
            $BillItemsCounter++;
            echo'<tr>
                    <td> <input class="form-check-input" type="checkbox"> </td>
                    <td>'.$BillItemsCounter.'</td>
                    <td>'.$FindEbillItemsResults["name"].'</td>
                    <td>'.$FindEbillItemsResults["qty"].'</td>
                    <td><span class="badge text-bg-success">Approved</span></td>
                </tr>';
        }

    }



///////////////////////////////////////////////////////////   Ecommerce Operations Starts here  ///////////////////////////////////////////////////////////////////////////////
