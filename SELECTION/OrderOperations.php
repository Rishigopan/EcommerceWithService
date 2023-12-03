<?php

require "../MAIN/Dbconn.php";

require "../ADMIN/CommonFunctions.php";
date_default_timezone_set("Asia/kolkata");


$userId = $_COOKIE['custidcookie'];
$cart_table = $_COOKIE['custidcookie'] . $_COOKIE['custnamecookie'] . '_cart';
$wish_table  = $_COOKIE['custidcookie'] . $_COOKIE['custnamecookie'] . '_wishlist';
$DateToday = date("Y-m-d h:i:s");


session_start();

if (isset($_REQUEST['save_ship'])) {

    $_SESSION['f_name'] = $_POST['first'];
    $_SESSION['l_name'] = $_POST['last'];
    $_SESSION['phone'] = $_POST['mobile'];
    $_SESSION['email'] = $_POST['email_id'];
    $_SESSION['address'] = $_POST['adddresses'];
    $_SESSION['city'] = $_POST['city'];
    $_SESSION['state'] = $_POST['state'];
    $_SESSION['pincode'] = $_POST['pincode'];
    $_SESSION['NearbyTaluk'] = $_POST['NearbyTaluk'];
    $_SESSION['ord_details'] = $_POST['ord_details'];

    header("location:Payment.php");
    exit;
}


if (isset($_POST['Pay_button'])) {
    
    $CustomerEmail = $_SESSION['email'];
    $CustomerCity = $_SESSION['city'];
    $CustomerState = $_SESSION['state'];
    $CustomerPincode = $_SESSION['pincode'];
    $OrderDetails = $_SESSION['ord_details'];
    $CustomerName = $_SESSION['f_name'].' '.$_SESSION['l_name'];
    $CustomerPhone = $_SESSION['phone'];
    $CustomerAddress = $_SESSION['address'];
    $CustomerNearby = $_SESSION['NearbyTaluk'];
    $InvoiceDate = $DateToday;
    $BillType = 'EC';
    $ModeOfPay = $_POST['mode'];
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

    $TotalAmountResult = json_decode(FindAllTotalAmounts($con, $cart_table, $userId));
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

    $FetchSalesId = mysqli_query($con, "SELECT MAX(billid) FROM ebill");
    foreach ($FetchSalesId as $FetchSalesIdResults) {
        $SalesId = $FetchSalesIdResults['MAX(billid)'] + 1;
    }

    $FindMaxBillNo = mysqli_query($con, "SELECT MAX(BillNo) FROM ebill WHERE type = '$BillType'");
    foreach ($FindMaxBillNo as $FindMaxBillNoResults) {
        $BillNo = $FindMaxBillNoResults['MAX(BillNo)'] + 1;
    }

    $SaleQuery = "INSERT INTO `ebill` (`billid`,`billdate`,`counterno`,`totalqty`,`grossamount`,`totaltaxamount`,`totaldiscount`,`totalamount`,`servicecharge`,`roundoff`,`netamount`,`createduserid`,`createddate`,`CancelStatus`,`CanceledUserId`,`CanceledDate`,`BillNo`,`type`,`hdcustomername`,`hdContactNo`,`hdLocation`,`deliveryboy`,`customerid`,`customername`,`contactno`,`address`,`modeofpayment`,`cashamount`,`cardamount`,`cardno`,`balanceamount`,`accharge`,`deliverycharge`,`floor`,`bankid`,`ratetypeid`,`totalcess`,`packingno`,`totalAddcess`,`printcount`,`deliverydate`,`careofid`,`feedback`,`remarks`,`jobcardid`,`pointsamount`,`point`,`redeempoint`,`redeemamount`,`totalearnedpoints`,`totalredeemedpoints`,`totalearnedAmount`,`totalredeemedAmount`,`totalothercharge`,`despatchaddress`,`vehicleid`,`routeid`,`driverid`,`rentpayable`,`totalkms`,`salesreturnid`,`salesreturnAmt`,`totalTCSamt`,`Discper`,`billnoprefix`,`customerEmail`,`customerState`,`customerCity`,`customerNearby`,`customerPincode`) VALUES ('$SalesId','$DateToday','Counter1','$TotalQty','$TotalGross','$TotalTax','$TotalIndDiscount','$TotalNet','0','$TotalRoundoff','$TotalNet','$userId','$DateToday','0','0','','$BillNo','$BillType','','','','','0','$CustomerName','$CustomerPhone','$CustomerAddress','$ModeOfPay','$CashAmount','$CardAmount','$Cardno','$Balanceamount','$Accharge','$Deliverycharge','$Floor','$Bankid','$Ratetypeid','$TotalCess','$Packingno','$TotalAddCess','$Printcount','$Deliverydate','$Careofid','$Feedback','$Remarks','$Jobcardid','$Pointsamount','$Pointsamount','$Redeempoint','$Redeemamount','$Totalearnedpoints','$Totalredeemedpoints','$Totalearnedamount','$Totalredeemedamount','$TotalOthercharge','$Despatchaddress','$Vehicleid','$Routeid','$Driverid','$Rentpayable','$Totalkms','$Salesreturnid','$Salesreturnamt','$Totaltcsamt','$Discper','$Billnoprefix','$CustomerEmail','$CustomerState','$CustomerCity','$CustomerNearby','$CustomerPincode')";

    $SaleQuery;

    //insert into Sales table
    $InsertIntoSalesMain = mysqli_query($con, $SaleQuery);


    if ($InsertIntoSalesMain) {
        $FetchFromTempSales = mysqli_query($con, "SELECT * FROM $cart_table WHERE pr_id <> 0 AND userId = '$userId'");
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


                $FindMaxSalesDetailed = mysqli_query($con, "SELECT MAX(billdetailedid) FROM ebilldetailed");
                foreach ($FindMaxSalesDetailed as $FindMaxSalesDetailedResults) {
                    $MaxSalesDetailed = $FindMaxSalesDetailedResults['MAX(billdetailedid)'] + 1;
                }

                $InsertIntoSalesDetailedQuery = "INSERT INTO `ebilldetailed` (`billdetailedid`,`billid`,`itemid`,`qty`,`rate`,`discountpercentage`,`discountamount`,`sp`,`gross`,`salestax`,`tax`,`amount`,`kitchenstatus`,`serialid`,`schemedetailedid`,`SalesManId`,`cgstpercentage`,`cgstamt`,`sgstpercentage`,`sgstamt`,`igstpercentage`,`igstamt`,`inclusive`,`cesspercentage`,`cessamount`,`mrp`,`hsn`,`addcesspercentage`,`addcessamount`,`lastcp`,`unitid`,`factor`,`TCS`,`TCSamt`,`Serial_No`) VALUES('$MaxSalesDetailed','$SalesId','$ItemId','$Qty','$Rate','$IndDiscPerc','$IndDiscAmt','$Sp','$ProductTotal','$SalesTax','$Taxamt','$Amt','0','0','0','$userId','$CGSTPER','$CGSTAMT','$SGSTPER','$SGSTAMT','$IGSTPER','$IGSTAMT','$Inclusive','$CessPerc','$CessAmt','$Mrp','$Hsn','$AddCessPerc','$AddCessAmt','0','0','0','0','0','0')";

                //insert into Sales detailed
                $InsertIntoSalesDetailed = mysqli_query($con, $InsertIntoSalesDetailedQuery);

                if ($InsertIntoSalesDetailed) {
                    if (ChangeInStock($con, $StockQty, $ItemId, 'ONLINE SALES') == 'Success') {
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


    // $add_query = mysqli_query($con, "INSERT INTO order_details (first_name,last_name,phone,email,location,city,state,pincode,add_details,payment_mode,total,purchase_date,delivery_status) VALUES ('$first','$last','$phone','$email','$address','$city','$state','$pincode','$details','$mode','$total','$Date_purchase','Not Delivered')");

    // if ($add_query) {
    //     $order_fetch = mysqli_query($con, "SELECT order_id FROM order_details WHERE phone = $phone ORDER BY purchase_date DESC LIMIT 1");
    //     while ($order_result = mysqli_fetch_array($order_fetch)) {
    //         $order_id = $order_result['order_id'];
    //         $cart_fetch = mysqli_query($con, "SELECT * FROM $cart_table");
    //         while ($cart_row = mysqli_fetch_array($cart_fetch)) {
    //             $pro_id = $cart_row['pr_id'];
    //             $quantity = $cart_row['quantity'];
    //             $pro_fetch = mysqli_query($con, "SELECT * FROM products WHERE pr_id = $pro_id");
    //             while ($pro_result = mysqli_fetch_array($pro_fetch)) {
    //                 $price = $pro_result['price'];
    //                 $pr_name = $pro_result['brand'] . '' . $pro_result['name'];
    //             }
    //             $order_add = mysqli_query($con, "INSERT INTO order_items (order_id,pr_id,quantity,price,pr_name) VALUES ('$order_id','$pro_id','$quantity','$price','$pr_name')");
    //         }
    //     }
    //     if ($order_add) {
    //         $added =  mysqli_query($con, "DELETE FROM $cart_table");

    //         if ($added) {
    //             mysqli_close($con);
    //             session_destroy();
    //             header('location:Confirmation.php');
    //             exit;
    //         }
    //     } else {
    //         echo "Can't clear the cart";
    //     }
    // } else {
    //     echo "Order Failed";
    // }
}


if (isset($_GET['del_id'])) {

    $delete_id = $_GET['del_id'];
    $deleted = mysqli_query($con, "DELETE FROM $cart_table WHERE cart_id = $delete_id");

    if ($deleted) {

        mysqli_close($con);
        header("location:ShoppingCart.php");
        exit;
    } else {
        echo "Removal of Product Failed";
    }
}


// //CHANGE CART QUANTITY
// if (isset($_POST['cartchange_id'])) {
//     $cartchange_id =  $_POST['cartchange_id'];
//     $change_val = $_POST['change_qty'];

//     mysqli_query($con, "UPDATE $cart_table SET quantity = '$change_val' WHERE cart_id = '$cartchange_id' ");
// }



if (isset($_GET['ad_id'])) {
    $add_id = $_GET['ad_id'];

    $check = mysqli_query($con, "SELECT * FROM $cart_table WHERE pr_id = '$add_id'");
    if (mysqli_num_rows($check) > 0) {

        header('location:../CUSTOMER/ShoppingCart.php');
    } else {
        $added  = mysqli_query($con, "INSERT INTO $cart_table (pr_id,quantity) VALUES ('$add_id',1) ");
        if ($added) {
            mysqli_close($con);
            header('location:../CUSTOMER/ShoppingCart.php');
            exit;
        } else {
            echo "Couldn't add product";
        }
    }
}



// //ADD PRODUCT TO CART
// if (isset($_POST['product_id'])) {
//     $id = $_POST['product_id'];

//     $check = mysqli_query($con, "SELECT * FROM $cart_table WHERE pr_id = '$id'");
//     if (mysqli_num_rows($check) > 0) {
//         $updated  = mysqli_query($con, "UPDATE $cart_table SET quantity = quantity + 1 WHERE pr_id = '$id'");
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


if (isset($_POST['add2wish_id'])) {
    $wishaddid = $_POST['add2wish_id'];

    $check_wish = mysqli_query($con, "SELECT * FROM $wish_table WHERE pr_id = '$wishaddid'");
    if (mysqli_num_rows($check_wish) > 0) {
        echo "Already present in wishlist";
    } else {
        $addedwish  = mysqli_query($con, "INSERT INTO $wish_table (pr_id) VALUES ('$wishaddid') ");

        if ($addedwish) {
            echo "successfully added to wishlist";
        } else {
            echo "Failed adding to wishlist";
        }
    }
}


if (isset($_POST['removewish_id'])) {
    $wishdelid = $_POST['removewish_id'];

    $deletewish  = mysqli_query($con, "DELETE FROM $wish_table WHERE pr_id = '$wishdelid'");

    if ($deletewish) {
        echo "successfully removed from wishlist";
    } else {
        echo "Failed removing from wishlist";
    }
}





//Add Item By Product Id
if (isset($_POST['product_id'])) {

    mysqli_autocommit($con, FALSE);
    $GivenItemIdData = $_POST['product_id'];
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

        if ($ItemStock <= 0) {
            echo json_encode(array('AddItemById' => 3)); //Item out of stock
        } else {
            $FindMaxTempCart = mysqli_query($con, "SELECT MAX(cart_id) FROM $cart_table");
            foreach ($FindMaxTempCart as $FindMaxTempCartResult) {
                $MaxTempCart = $FindMaxTempCartResult['MAX(cart_id)'] + 1;
            }

            $CheckIfItemExistsInTable = mysqli_query($con, "SELECT * FROM $cart_table WHERE pr_id = $GivenItemIdData AND userId = '$userId'");
            if (mysqli_num_rows($CheckIfItemExistsInTable) > 0) {

                foreach ($CheckIfItemExistsInTable as $CheckIfItemExistsInTableResult) {
                    $Qty = $CheckIfItemExistsInTableResult['quantity'];
                    $IGSTP = $CheckIfItemExistsInTableResult['IGSTPercentage'];
                    $IsInclusive = $CheckIfItemExistsInTableResult['inclusive'];
                    $DiscAmt = $CheckIfItemExistsInTableResult['inddiscountamount'];
                    $DiscPercnt = $CheckIfItemExistsInTableResult['inddiscountpercentage'];
                    $CartChangeId = $CheckIfItemExistsInTableResult['cart_id'];
                }

                $ChangeValue = $Qty + 1;
                if ($ChangeValue > $ItemStock) {
                    echo json_encode(array('AddItemById' => 3)); //Item out of stock
                } else {

                    $BeforeGrossAmount = $ChangeValue * $CheckIfItemExistsInTableResult['rate'];
                    $DiscountResult =  json_decode(CalculateDiscount($BeforeGrossAmount, '', $DiscPercnt));
                    $DiscPercent = $DiscountResult->DiscountPercentage;
                    $DiscountedAmt = $DiscountResult->DiscountedAmount;
                    $DiscountAmt = $DiscountResult->DiscountAmount;
                    $GrossAmount = $DiscountedAmt;

                    $UpdateQtyinTable = mysqli_query($con, "UPDATE $cart_table SET quantity = '$ChangeValue',inddiscountamount = '$DiscountAmt' WHERE cart_id = '$CartChangeId' AND userId = '$userId'");
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
            } else {

                $AddItemQuery = "INSERT INTO $cart_table (`cart_id`,`pr_id`,`quantity`,`inclusive`,`itembarcode`,`itemimei`,`inddiscountpercentage`,`inddiscountamount`,`rate`,`sp`,`mrp`,`producttotalamount`,`salestax`,`taxamount`,`amount`,`lc`,`CGSTPercentage`,`CGSTAmt`,`SGSTPercentage`,`SGSTAmt`,`IGSTPercentage`,`IGSTAmt`,`cesspercentage`,`cessamount`,`hsn`,`addcesspercentage`,`addcessamount`,`userId`) VALUES ('$MaxTempCart','$ItemId','1','$ItemInclusive','$ItemBarcode','$ItemImei','0','0','$ItemSp','$ItemSp','$ItemMrp','0','$ItemIgst','0','0','0','0','0','0','0','$ItemIgst','0','0','0','$ItemHsn','0','0','$userId')";

                //echo $AddItemQuery;

                $InsertIntoCart = mysqli_query($con, $AddItemQuery);
                if ($InsertIntoCart) {
                    $IGSTP = $ItemIgst;
                    $GrossAmount = 1 * $ItemSp;
                    $UpdateQtyinTable = mysqli_query($con, "UPDATE $cart_table SET quantity = 1 WHERE cart_id = '$MaxTempCart' AND userId = '$userId'");
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



//Change Cart quantity
if (isset($_POST['cartchange_id']) && !empty($_POST['change_qty'])) {

    //mysqli_autocommit($con, false);
    $CartChangeId =  $_POST['cartchange_id'];
    $ChangeValue = $_POST['change_qty'];


    $FindRateFromTempTable = mysqli_query($con, "SELECT rate,inclusive,inddiscountamount,inddiscountpercentage,igstpercentage FROM $cart_table WHERE cart_id = '$CartChangeId' AND userId = '$userId'");
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

    $UpdateQtyinTable = mysqli_query($con, "UPDATE $cart_table SET quantity = '$ChangeValue',inddiscountamount = '$DiscountAmt' WHERE cart_id = '$CartChangeId' AND userId = '$userId'");
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
