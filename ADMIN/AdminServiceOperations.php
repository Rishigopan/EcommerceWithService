<?php
require "../MAIN/Dbconn.php";
include './CommonFunctions.php';


$cart_table = 'servicetabletemp';
$userId = $_COOKIE['custidcookie'];
$DateToday = date('Y-m-d H:i:s');
$TimeNow = date('H:i:s');


$InService = 3;
$OnPickup = 1;
$ForDelivery = 9;
$StartDiagnosis = 4;
$TrackerOnTech = 'Tech';
$TrackerOnCacel = 'Cancelled';
$TrackerOnDelivered = 'Delivered';
$TrackerOnPickup = 'Pickup';
$TrackerOnDelivery = 'Delivery';
$StartService = 5;
$StartTesting = 6;
$FInishService = 8;
$CompleteService = 10;
$Cancelled = 11;


function GetServiceStatus($con, $ServiceOrderId){
    $CheckServiceStatusQuery =  mysqli_query($con, "SELECT stat,techId FROM servicebill WHERE serviceBillId = '$ServiceOrderId'");
    if(mysqli_num_rows($CheckServiceStatusQuery) > 0){
        foreach($CheckServiceStatusQuery as $CheckServiceStatusQueryResult){
            $ServiceStatus = $CheckServiceStatusQueryResult['stat'];
            $Technician = $CheckServiceStatusQueryResult['techId'];
        }
        return json_encode(array('Status' => true,'ServiceStatus' => $ServiceStatus,'Technician' => $Technician, 'Message' => 'Record Found'));
    }else{
        return json_encode(array('Status' => false,'ServiceStatus' => 0,'Message' => 'No Records Found'));
    }
}


/////////////////////////////////////////  IN SHOP SERVICE ORDER  //////////////////////////////////////////////////




    //Search for Devices
    if (isset($_GET['SearchServiceDevices'])) {
        $SearchValue = $_GET['SearchServiceDevices'];
        $find_data = mysqli_query($con, "SELECT P.pr_id,P.name,B.brand_name,S.series_name FROM products P INNER JOIN service_main SM ON P.pr_id = SM.mo_id INNER JOIN brands B ON P.brand = B.br_id INNER JOIN series S ON P.series = S.se_id WHERE P.isServiceItem = 1");
        if (mysqli_num_rows($find_data) > 0) {
            while ($dataRow = mysqli_fetch_assoc($find_data)) {
                $rows[] = $dataRow;
            }
        } else {
            $rows = array();
        }
        echo json_encode($rows);
    }



    // List the services for a selected device
    if (isset($_POST['ShowServiceList'])) {

        $ProductId = $_POST['ShowServiceList'];
        $FindServiceList = mysqli_query($con, "SELECT SM.main_id,SR.service_name,SR.service_img FROM service_main SM INNER JOIN services SR ON SM.sr_id = SR.sr_id WHERE SM.mo_id = '$ProductId'");
        if (mysqli_num_rows($FindServiceList) > 0) {
            foreach ($FindServiceList as $FindServiceListResult) {
                echo '
                <div class="col-4">
                    <ul class="list-unstyled ListServices">
                        <li class="d-flex ListItems" data-service="' . $FindServiceListResult["main_id"] . '">
                            <img src="../assets/img/SERVICE/' . $FindServiceListResult["service_img"] . '" class="ServiceImage">
                            <h6 class="ServiceTitle">' . $FindServiceListResult["service_name"] . '</h6>
                        </li>
                    </ul>
                </div>
                ';
            }
        } else {
            echo '
            <div class="col-12 text-center">
                <img src="../assets/img/result_not_found.png" height="200px" width="200px" class="img-fluid">
                <h4 class="mt-3">No Records Found</h4>
                <p class="mt-3 text-muted">Search for a device to show the available services</p>
            </div>';
        }
    }


    // Show the service items added in cart
    if (isset($_POST['ShowCartItems']) && !empty($_POST['ShowCartAction'])) {

        if($_POST['ShowCartAction'] != ''){
            $CartAction = $_POST['ShowCartAction'];
        }else{
            $CartAction = '';
        }

        $FetchCartItems = mysqli_query($con, "SELECT ServiceTempTable.cart_id,SR.service_img,SR.service_name,SM.cost,P.name,B.brand_name FROM $cart_table ServiceTempTable INNER JOIN service_main SM ON ServiceTempTable.sr_id = SM.main_id INNER JOIN services SR ON SM.sr_id = SR.sr_id INNER JOIN products P ON SM.mo_id = P.pr_id INNER JOIN brands B ON SM.br_id = B.br_id WHERE ServiceTempTable.userId = '$userId' AND cartAction = '$CartAction'");
        if (mysqli_num_rows($FetchCartItems) > 0) {


            foreach ($FetchCartItems as $FetchCartItemsResult) {
                echo '
                <li class="border-bottom pb-2 ServiceCartItems">
                    <div class="d-flex">
                        <img src="../assets/img/SERVICE/' . $FetchCartItemsResult["service_img"] . '" class="img-fluid pe-3" alt="">
                        <div class="w-100 pe-3">
                            <div class="d-md-flex d-block justify-content-between mt-2">
                                <h6 class=""> <span class="ServiceCartModel">' . $FetchCartItemsResult["brand_name"] . ' ' . $FetchCartItemsResult["name"] . '</span>
                                    <br>
                                    <span class="ServiceCartName">' . $FetchCartItemsResult["service_name"] . '</span>
                                </h6>
                                <h6 class="ServiceCartAmount text-end"> &#8377; ' . MoneyFormatIndia($FetchCartItemsResult["cost"]) . '
                                    <br><br>
                                    <button type="button" value="' . $FetchCartItemsResult["cart_id"] . '" class="btn DeleteServiceCart" ><i class="ServiceCartName material-icons"> delete </i></button>
                                </h6>
                            </div>
                        </div>
                    </div>
                </li>';

        ?>

            
        <?php
            }
        } else {
            echo '<li class="text-center">
                    <img src="../assets/img/25648039_empty_cart.png" class="img-fluid">
                    <h4 class="mt-3">Cart is Empty</h4>
                    <p class="mt-3 text-muted">Try adding something</p>
                </li>';
        }
    }



    // Add service to cart
    if (isset($_POST['AddServiceToCart']) && !empty($_POST['AddServiceToCart'])) {
        $ServiceId = $_POST['AddServiceToCart'];
        $CartAction = $_POST['AddServiceToCartAction'];

        $CheckIfExists = mysqli_query($con, "SELECT cart_id FROM $cart_table WHERE sr_id = '$ServiceId' AND userId = '$userId' AND cartAction = '$CartAction'");
        if (mysqli_num_rows($CheckIfExists) > 0) {

            echo json_encode(array('Status' => false, 'Message' => 'Record Already Exists'));
        } else {

            $FindServiceDetails =  mysqli_query($con, "SELECT * FROM service_main WHERE main_id = '$ServiceId'");
            if (mysqli_num_rows($FindServiceDetails) > 0) {
                foreach ($FindServiceDetails as $FindServiceDetailsResult) {
                    $ServiceCost = $FindServiceDetailsResult['cost'];
                    $ServiceTax = $FindServiceDetailsResult['tax'];
                    $ServiceCommission = $FindServiceDetailsResult['commission'];
                    $ItemInclusive = 1;
                }

                $FindMaxTempCart = mysqli_query($con, "SELECT MAX(cart_id) FROM $cart_table");
                foreach ($FindMaxTempCart as $FindMaxTempCartResult) {
                    $MaxTempCart = $FindMaxTempCartResult['MAX(cart_id)'] + 1;
                }

                $AddItemQuery = "INSERT INTO $cart_table (`cart_id`,`sr_id`,`quantity`,`inclusive`,`itembarcode`,`itemimei`,`inddiscountpercentage`,`inddiscountamount`,`rate`,`sp`,`mrp`,`producttotalamount`,`salestax`,`taxamount`,`amount`,`lc`,`CGSTPercentage`,`CGSTAmt`,`SGSTPercentage`,`SGSTAmt`,`IGSTPercentage`,`IGSTAmt`,`cesspercentage`,`cessamount`,`hsn`,`addcesspercentage`,`addcessamount`,`userId`,`cartAction`) VALUES ('$MaxTempCart','$ServiceId','$ItemInclusive','1','0','0','0','0','$ServiceCost','$ServiceCost','$ServiceCost','0','$ServiceTax','0','0','0','0','0','0','0','$ServiceTax','0','0','0','0','0','0','$userId','$CartAction')";

                $InsertIntoTempTable = mysqli_query($con, $AddItemQuery);
                if ($InsertIntoTempTable) {
                    $TaxChangesResult =  CalculateTax($con, $ItemInclusive, $ServiceTax, $ServiceCost, $cart_table, $MaxTempCart, $userId);
                    if ($TaxChangesResult == 'Success') {
                        mysqli_commit($con);
                        echo json_encode(array('Status' => true, 'Message' => 'Record Added Successfully'));
                    } else {
                        mysqli_rollback($con);
                        echo json_encode(array('Status' => false, 'Message' => 'Failed Adding Record'));
                    }
                }
            } else {
                echo json_encode(array('Status' => false, 'Message' => 'No Records Found'));
            }
        }
    }



    // Delete service item from cart
    if (isset($_POST['DeleteServiceCartId']) && !empty($_POST['DeleteServiceCartId'])) {
        $CartAction = $_POST['DeleteFromCartAction'];

        mysqli_autocommit($con, FALSE);
        $DeleteCartId = $_POST['DeleteServiceCartId'];
        $DeleteServiceItem =  mysqli_query($con, "DELETE FROM $cart_table WHERE cart_id = '$DeleteCartId' AND userId = '$userId' AND cartAction = '$CartAction'");

        if ($DeleteServiceItem) {
            mysqli_commit($con);
            echo json_encode(array('Status' => true, 'Message' => 'Record Deleted Successfully'));
        } else {
            mysqli_rollback($con);
            echo json_encode(array('Status' => false, 'Message' => 'Failed Deleting Record'));
        }
    }



    //Show service totals
    if (isset($_POST['ShowServiceTotal']) && !empty($_POST['ShowTotalAction'])) {
        $CartAction = $_POST['ShowTotalAction'];
        echo FindAllTotalAmounts($con, $cart_table, $userId,$CartAction);
    }



    //Delete all items from cart
    if (isset($_POST['ClearServiceCart']) && !empty($_POST['ClearAllAction'])) {
        if($_POST['ClearAllAction'] != ''){
            $CartAction = $_POST['ClearAllAction'];
        }else{
            $CartAction = '';
        }
        $DeleteAll = mysqli_query($con, "DELETE FROM  $cart_table WHERE userId = '$userId' AND cartAction = '$CartAction'");
        if ($DeleteAll) {
            echo json_encode(array('Status' => true, 'Message' => 'Cleared All Records'));
        } else {
            echo json_encode(array('Status' => false, 'Message' => 'Clear Operation Failed'));
        }
    }




    // Take service order
    if (isset($_POST['CustomerMobile']) && !empty($_POST['CustomerName'])) {

        $CustId = 0;
        $CustomerName = $_POST['CustomerName'];
        $CustomerPhone = $_POST['CustomerMobile'];
        $CustomerAddress = $_POST['CustomerAddress'];
        $CustomerEmail = '';
        $CustomerState = '';
        $CustomerCity = '';
        $CustomerPincode = 0;
        $InvoiceDate = $DateToday;
        $PickupDate = $DateToday;
        $PickupTime = '';
        $PickupMode = 'SHOP';
        $BillType = 'SR';
        //$PaymentStatus = '';
        // $ModeOfPay = $_POST['CustomerMOP'];
        //$ModeOfPay = 0;
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
        $CollectedItems = $_POST['CollectedItems'];
        $deliveryCharge = 0;
        $ActualAmount = $_POST['ActualAmount'];
        $BillDate = $DateToday;


        try{
            if($CollectedItems != ''){
                $CollectedItemsArray = explode(",", $CollectedItems);
            }else{
                $CollectedItemsArray = array();
            }
    
            if($_POST['AdvanceAmount'] && ($_POST['AdvanceAmount'] != 0)){
                $Advance =  $_POST['AdvanceAmount'];
                $ModeOfPay = $_POST['ServiceMOP'];
                if( intval($_POST['AdvanceAmount']) > intval($ActualAmount)){
                    throw new Exception("Advance Amount Cannot Be Greater Than Actual Amount!","0");
                }else{
    
                }
            }else{
                $Advance =  0;
                $ModeOfPay = '';
            }
    
            // print_r($CollectedItemsArray);
    
            mysqli_autocommit($con, FALSE);
    
            //check if temp table is empty or not
            $check_empty = mysqli_query($con, "SELECT * FROM $cart_table WHERE userId = '$userId' AND cartAction = 'ADD'");
            if (mysqli_num_rows($check_empty) > 0) {
    
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
                $FetchServiceId = mysqli_query($con, "SELECT MAX(serviceBillId),MAX(serviceBillNo),COUNT(serviceBillId) FROM servicebill");
                foreach ($FetchServiceId as $FetchServiceIdResults) {
                    $ServiceBillId = $FetchServiceIdResults['MAX(serviceBillId)'] + 1;
                    $TableBillNo = $FetchServiceIdResults['MAX(serviceBillNo)'];
                    $RowCount = $FetchServiceIdResults['COUNT(serviceBillId)'];
                }
    
                if($RowCount == 0){
                    $BillNo = 'THP2301';
                }else{
                    $TableBillNo = intval(substr($TableBillNo,3, strlen($TableBillNo)));
                    $BillNo  = 'THP'.($TableBillNo + 1);
                }
    
    
                if(intval($Advance) == intval($TotalNet)){
                    $PaymentStatus = 'Paid';
                }else{
                    $PaymentStatus = 'Unpaid';
                }
    
            
                $ServiceQuery = "INSERT INTO `servicebill`(`serviceBillId`,`serviceBillNo`,`billType`,`billDate`,`custId`,`custName`,`custPhone`,`custEmail`,`serviceCenter`,`custAddress`,`custCity`,`custState`,`custPincode`,`custDetails`,`pickupDate`,`pickupTime`,`pickupMode`,`modeOfPay`,`paymentStatus`,`grossAmount`,`totalTaxAmount`,`totalAmount`,`servicebillcol`,`totalDiscount`,`paidAmount`,`deliveryCharge`,`stat`,`pickupAgentname`,`pickupAgentid`,`techId`,`techAgentName`,`serviceStatus`,`inService`,`inTransit`,`tracker`,`deliveryAgentId`,`deliveryAgentName`,`createdBy`,`createdDate`) VALUES ('$ServiceBillId','$BillNo','$BillType','$BillDate','$CustId','$CustomerName','$CustomerPhone','$CustomerEmail','','$CustomerAddress','$CustomerCity','$CustomerState','$CustomerPincode','$Remarks','$PickupDate','$PickupTime','$PickupMode','$ModeOfPay','$PaymentStatus','$TotalGross','$TotalTax','$TotalNet','','$TotalDiscount','$Advance','$deliveryCharge','0','','0','0','','','0','0','0','0','','$userId','$DateToday')";
    
                //echo  $ServiceQuery;
    
                //insert into Service table
                $InsertIntoServiceMain = mysqli_query($con, $ServiceQuery);
    
                if ($InsertIntoServiceMain) {
    
                    $FetchFromTempService = mysqli_query($con, "SELECT * FROM $cart_table WHERE sr_id <> 0 AND userId = '$userId' AND cartAction = 'ADD'");
                    $FetchFromTempServiceRows = mysqli_num_rows($FetchFromTempService);
                    if ($FetchFromTempServiceRows > 0) {
                        $ServiceDetailedCounter = 0;
                        foreach ($FetchFromTempService as $FetchFromTempServiceResults) {
    
                            $ServiceId = $FetchFromTempServiceResults['sr_id'];
                            $Qty = $FetchFromTempServiceResults['quantity'];
                            $Rate = $FetchFromTempServiceResults['rate'];
                            $Inclusive = $FetchFromTempServiceResults['inclusive'];
                            $IndDiscPerc = $FetchFromTempServiceResults['inddiscountpercentage'];
                            $IndDiscAmt = $FetchFromTempServiceResults['inddiscountamount'];
                            $Sp = $FetchFromTempServiceResults['sp'];
                            $Mrp = $FetchFromTempServiceResults['mrp'];
                            $ProductTotal = $FetchFromTempServiceResults['producttotalamount'];
                            $ServiceTax = $FetchFromTempServiceResults['salestax'];
                            $Taxamt = $FetchFromTempServiceResults['IGSTAmt'];
                            $Amt = $FetchFromTempServiceResults['amount'];
                            $Lc = $FetchFromTempServiceResults['lc'];
                            $CGSTPER = $FetchFromTempServiceResults['CGSTPercentage'];
                            $CGSTAMT = $FetchFromTempServiceResults['CGSTAmt'];
                            $SGSTPER = $FetchFromTempServiceResults['SGSTPercentage'];
                            $SGSTAMT = $FetchFromTempServiceResults['SGSTAmt'];
                            $IGSTPER = $FetchFromTempServiceResults['IGSTPercentage'];
                            $IGSTAMT = $FetchFromTempServiceResults['IGSTAmt'];
                            $CessPerc = $FetchFromTempServiceResults['cesspercentage'];
                            $CessAmt = $FetchFromTempServiceResults['cessamount'];
                            $Hsn = $FetchFromTempServiceResults['hsn'];
                            $AddCessPerc = $FetchFromTempServiceResults['addcesspercentage'];
                            $AddCessAmt = $FetchFromTempServiceResults['addcessamount'];
                            $Pack = 0;
                            $CompletedStatus = '';
                            //$StockQty = '-' . $FetchFromTempServiceResults['quantity'];
    
    
                            $FindServiceDetails =  mysqli_query($con, "SELECT SM.sr_id,SM.br_id,SM.mo_id,B.brand_name,P.name,SR.service_name FROM service_main SM INNER JOIN brands B ON SM.br_id = B.br_id INNER JOIN products P ON SM.mo_id = P.pr_id INNER JOIN services SR ON SM.sr_id = SR.sr_id WHERE SM.main_id = '$ServiceId'");
                            if(mysqli_num_rows($FindServiceDetails) > 0){
                                foreach($FindServiceDetails as $FindServiceDetailsResult){
                                    $Brand = $FindServiceDetailsResult['br_id'];
                                    $Model = $FindServiceDetailsResult['mo_id'];
                                    $BrandName = $FindServiceDetailsResult['brand_name'];
                                    $ModelName = $FindServiceDetailsResult['name'];
                                    $ServiceName = $FindServiceDetailsResult['service_name'];
                                }
                            }else{
                                $Brand = 0;
                                $Model = 0;
                                $BrandName = '';
                                $ModelName = '';
                                $ServiceName = '';
                            }
                            
    
                            $FindMaxServiceDetailed = mysqli_query($con, "SELECT MAX(serviceDetailedId) FROM servicedetailed");
                            foreach ($FindMaxServiceDetailed as $FindMaxServiceDetailedResults) {
                                $MaxServiceDetailed = $FindMaxServiceDetailedResults['MAX(serviceDetailedId)'] + 1;
                            }
    
                            $InsertIntoServiceDetailedQuery = "INSERT INTO `servicedetailed` (`serviceDetailedId`,`serviceBillId`,`serviceId`,`brand`,`model`,`brandName`,`modelName`,`serviceName`,`qty`,`rate`,`discountpercentage`,`discountamount`,`sp`,`gross`,`salestax`,`tax`,`amount`,`serialid`,`schemedetailedid`,`SalesManId`,`cgstpercentage`,`cgstamt`,`sgstpercentage`,`sgstamt`,`igstpercentage`,`igstamt`,`inclusive`,`cesspercentage`,`cessamount`,`mrp`,`hsn`,`addcesspercentage`,`addcessamount`,`lastcp`,`unitid`,`factor`,`TCS`,`TCSamt`,`Serial_No`,`completedStatus`) VALUES('$MaxServiceDetailed','$ServiceBillId','$ServiceId','$Brand','$Model','$BrandName','$ModelName','$ServiceName','$Qty','$Rate','$IndDiscPerc','$IndDiscAmt','$Sp','$ProductTotal','$ServiceTax','$Taxamt','$Amt','0','0','$userId','$CGSTPER','$CGSTAMT','$SGSTPER','$SGSTAMT','$IGSTPER','$IGSTAMT','$Inclusive','$CessPerc','$CessAmt','$Mrp','$Hsn','$AddCessPerc','$AddCessAmt','0','0','0','0','0','0','$CompletedStatus')";
    
                            //insert into Service detailed
                            $InsertIntoServiceDetailed = mysqli_query($con, $InsertIntoServiceDetailedQuery);
    
                            if ($InsertIntoServiceDetailed) {
                                $ServiceDetailedCounter++;
                            }
                        }
    
                        if ($ServiceDetailedCounter == $FetchFromTempServiceRows) {
    
                            $CollectedItemsCount = count($CollectedItemsArray);
    
                            if(count($CollectedItemsArray) > 0){
                                $InsertOtherItemsCount = 0;
                                foreach($CollectedItemsArray as $CollectedItemsArrayResult){
    
                                    $InsertIntoCollectedItemsQuery =  "INSERT INTO `serviceothers` (`serviceBillId`,`collectedItems`,`returnStatus`) VALUES ('$ServiceBillId','$CollectedItemsArrayResult','NO')";
    
                                    $InsertIntoCollectedItems = mysqli_query($con, $InsertIntoCollectedItemsQuery);
                                    if($InsertIntoCollectedItems){
                                        $InsertOtherItemsCount++;
                                    }
                                }
                                if($CollectedItemsCount == $InsertOtherItemsCount){
                                    mysqli_commit($con);
                                    echo json_encode(array('Status' => true,'Message' => 'Record Added Successfully','ServicePrintId' => $ServiceBillId));
                                }else{
                                    mysqli_rollback($con);
                                    throw new Exception("Failed Adding Record!","0");
                                    //echo json_encode(array('Status' => false ,'Message' => 'Failed Adding Record'));
                                }
                            }else{
                                mysqli_commit($con);
                                echo json_encode(array('Status' => true,'Message' => 'Record Added Successfully','ServicePrintId' => $ServiceBillId));
                            }
    
                        } else {
                            mysqli_rollback($con);
                            throw new Exception("Failed Adding Record!","0");
                            //echo json_encode(array('Status' => false ,'Message' => 'Failed Adding Record'));
                        }
                    } else {
                        mysqli_rollback($con);
                        throw new Exception("Failed Adding Record!","0");
                       // echo json_encode(array('Status' => false ,'Message' => 'Failed Adding Record'));
                    }
                } else {
                    mysqli_rollback($con);
                    throw new Exception("Failed Adding Record!","0");
                    //echo json_encode(array('Status' => false, 'Message' => 'Failed Adding Record'));
                }
    
                
            } else {
                throw new Exception("Cart is empty!","0");
                //echo json_encode(array('Status' => false, 'Message' => 'Cart is empty'));
            }
        }
        catch(Exception $e){
            //echo json_encode(array('Status' => false, 'Message' => 'Advance Amount Cannot Be Greater Than Actual Amount'));
            echo json_encode(array('Status' => false,'Message' => $e->getMessage()));
        }
       
    }




    // Update service order
    if (isset($_POST['UpdateCustomerMobile']) && !empty($_POST['UpdateCustomerName'])) {

        $UpdateServiceBillId = $_POST['UpdateServiceBillId'];
        $CustId = 0;
        $CustomerName = $_POST['UpdateCustomerName'];
        $CustomerPhone = $_POST['UpdateCustomerMobile'];
        $CustomerAddress = $_POST['UpdateCustomerAddress'];
        $CustomerEmail = '';
        $CustomerState = '';
        $CustomerCity = '';
        $CustomerPincode = 0;
        $InvoiceDate = $DateToday;
        $PickupDate = $DateToday;
        $PickupTime = $TimeNow;
        $PickupMode = 'SHOP';
        $BillType = 'SR';
        //$PaymentStatus = '';
        // $ModeOfPay = $_POST['CustomerMOP'];
        //$ModeOfPay = 0;
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
        $CollectedItems = $_POST['UpdateCollectedItems'];
        $deliveryCharge = 0;
        $CartAction = 'EDIT';
        $UpdateActualAmount = $_POST['UpdateActualAmount'];


        try{
            if($CollectedItems != ''){
                $CollectedItemsArray = explode(",", $CollectedItems);
            }else{
                $CollectedItemsArray = array();
            }
    
            if($_POST['UpdateAdvanceAmount'] && ($_POST['UpdateAdvanceAmount'] != 0)){
                $Advance =  $_POST['UpdateAdvanceAmount'];
                $ModeOfPay = $_POST['UpdateServiceMOP'];
                if( intval($_POST['UpdateAdvanceAmount']) > intval($UpdateActualAmount)){
                    throw new Exception("Advance Amount Cannot Be Greater Than Actual Amount!","0");
                }
            }else{
                $Advance =  0;
                $ModeOfPay = '';
            }
    
            // print_r($CollectedItemsArray);
            mysqli_autocommit($con, FALSE);
    
            //check if temp table is empty or not
            $FindServiceItemsFromTempTable = mysqli_query($con, "SELECT * FROM $cart_table WHERE userId = '$userId' AND cartAction = 'EDIT'");
            $TempCartCount = mysqli_num_rows($FindServiceItemsFromTempTable);
            if($TempCartCount > 0) {
    
    
                $UpdateServiesIdArray = array();
                $UpdateServiceCounter = 0;
                foreach($FindServiceItemsFromTempTable as $FindServiceItemsFromTempTableResults){
    
    
    
                    $ServiceId = $FindServiceItemsFromTempTableResults['sr_id'];
                    $Qty = $FindServiceItemsFromTempTableResults['quantity'];
                    $Rate = $FindServiceItemsFromTempTableResults['rate'];
                    $Inclusive = $FindServiceItemsFromTempTableResults['inclusive'];
                    $IndDiscPerc = $FindServiceItemsFromTempTableResults['inddiscountpercentage'];
                    $IndDiscAmt = $FindServiceItemsFromTempTableResults['inddiscountamount'];
                    $Sp = $FindServiceItemsFromTempTableResults['sp'];
                    $Mrp = $FindServiceItemsFromTempTableResults['mrp'];
                    $ProductTotal = $FindServiceItemsFromTempTableResults['producttotalamount'];
                    $ServiceTax = $FindServiceItemsFromTempTableResults['salestax'];
                    $Taxamt = $FindServiceItemsFromTempTableResults['IGSTAmt'];
                    $Amt = $FindServiceItemsFromTempTableResults['amount'];
                    $Lc = $FindServiceItemsFromTempTableResults['lc'];
                    $CGSTPER = $FindServiceItemsFromTempTableResults['CGSTPercentage'];
                    $CGSTAMT = $FindServiceItemsFromTempTableResults['CGSTAmt'];
                    $SGSTPER = $FindServiceItemsFromTempTableResults['SGSTPercentage'];
                    $SGSTAMT = $FindServiceItemsFromTempTableResults['SGSTAmt'];
                    $IGSTPER = $FindServiceItemsFromTempTableResults['IGSTPercentage'];
                    $IGSTAMT = $FindServiceItemsFromTempTableResults['IGSTAmt'];
                    $CessPerc = $FindServiceItemsFromTempTableResults['cesspercentage'];
                    $CessAmt = $FindServiceItemsFromTempTableResults['cessamount'];
                    $Hsn = $FindServiceItemsFromTempTableResults['hsn'];
                    $AddCessPerc = $FindServiceItemsFromTempTableResults['addcesspercentage'];
                    $AddCessAmt = $FindServiceItemsFromTempTableResults['addcessamount'];
                    $Pack = 0;
                    //$StockQty = '-' . $FetchFromTempServiceResults['quantity'];
    
    
                    
    
                    $FindServiceId = $FindServiceItemsFromTempTableResults['sr_id'];
                    $CheckIfServiceExistsInOriginal = mysqli_query($con, "SELECT * FROM servicedetailed WHERE serviceBillId = '$UpdateServiceBillId' AND serviceId = '$FindServiceId'");
                    if(mysqli_num_rows($CheckIfServiceExistsInOriginal) > 0){
                        //echo "Exists";
                        $UpdateServiceCounter ++;
                    }else{
    
                        //echo "Not exists";
                        $FindServiceDetails =  mysqli_query($con, "SELECT SM.sr_id,SM.br_id,SM.mo_id,B.brand_name,P.name,SR.service_name FROM service_main SM INNER JOIN brands B ON SM.br_id = B.br_id INNER JOIN products P ON SM.mo_id = P.pr_id INNER JOIN services SR ON SM.sr_id = SR.sr_id WHERE SM.main_id = '$ServiceId'");
                        if(mysqli_num_rows($FindServiceDetails) > 0){
                            foreach($FindServiceDetails as $FindServiceDetailsResult){
                                $Brand = $FindServiceDetailsResult['br_id'];
                                $Model = $FindServiceDetailsResult['mo_id'];
                                $BrandName = $FindServiceDetailsResult['brand_name'];
                                $ModelName = $FindServiceDetailsResult['name'];
                                $ServiceName = $FindServiceDetailsResult['service_name'];
                            }
                        }else{
                            $Brand = 0;
                            $Model = 0;
                            $BrandName = '';
                            $ModelName = '';
                            $ServiceName = '';
                        }
                        
    
                    $FindMaxServiceDetailed = mysqli_query($con, "SELECT MAX(serviceDetailedId) FROM servicedetailed");
                    foreach ($FindMaxServiceDetailed as $FindMaxServiceDetailedResults) {
                        $MaxServiceDetailed = $FindMaxServiceDetailedResults['MAX(serviceDetailedId)'] + 1;
                    }
                        $InsertIntoServiceDetailedQuery = "INSERT INTO `servicedetailed` (`serviceDetailedId`,`serviceBillId`,`serviceId`,`brand`,`model`,`brandName`,`modelName`,`serviceName`,`qty`,`rate`,`discountpercentage`,`discountamount`,`sp`,`gross`,`salestax`,`tax`,`amount`,`serialid`,`schemedetailedid`,`SalesManId`,`cgstpercentage`,`cgstamt`,`sgstpercentage`,`sgstamt`,`igstpercentage`,`igstamt`,`inclusive`,`cesspercentage`,`cessamount`,`mrp`,`hsn`,`addcesspercentage`,`addcessamount`,`lastcp`,`unitid`,`factor`,`TCS`,`TCSamt`,`Serial_No`) VALUES('$MaxServiceDetailed','$UpdateServiceBillId','$ServiceId','$Brand','$Model','$BrandName','$ModelName','$ServiceName','$Qty','$Rate','$IndDiscPerc','$IndDiscAmt','$Sp','$ProductTotal','$ServiceTax','$Taxamt','$Amt','0','0','$userId','$CGSTPER','$CGSTAMT','$SGSTPER','$SGSTAMT','$IGSTPER','$IGSTAMT','$Inclusive','$CessPerc','$CessAmt','$Mrp','$Hsn','$AddCessPerc','$AddCessAmt','0','0','0','0','0','0')";
    
                        //insert into Service detailed
                        $InsertIntoServiceDetailed = mysqli_query($con, $InsertIntoServiceDetailedQuery);
    
                        if ($InsertIntoServiceDetailed) {
                            $UpdateServiceCounter++;
                        }
                    }
    
                    array_push($UpdateServiesIdArray,$FindServiceId);
    
                }
    
    
                if($TempCartCount == $UpdateServiceCounter){
    
                    if(count($UpdateServiesIdArray) > 0){
                        $UpdateServiesIds = implode(",", $UpdateServiesIdArray);
                        $DeleteRemovedServices = mysqli_query($con, "DELETE FROM servicedetailed WHERE serviceBillId = '$UpdateServiceBillId' AND serviceId NOT IN ($UpdateServiesIds)");
                        if($DeleteRemovedServices){
                            //echo "deleted";
                        }else{
                            //echo "not deleted";
                        }
                    }else{
    
                    }
    
                    $RemoveOtherItems = mysqli_query($con, "DELETE FROM serviceothers WHERE serviceBillId = '$UpdateServiceBillId'");
                    if($RemoveOtherItems){
                        $UpdateOtherItemsCount = count($CollectedItemsArray);
                        $UpdateOtherItemsCounter = 0;
                        if($UpdateOtherItemsCount > 0){
                            foreach($CollectedItemsArray as $CollectedItemsArrayitems){ 
                                $InsertIntoCollectedItemsQuery =  "INSERT INTO `serviceothers` (`serviceBillId`,`collectedItems`,`returnStatus`) VALUES ('$UpdateServiceBillId','$CollectedItemsArrayitems','NO')";
                                $InsertIntoCollectedItems = mysqli_query($con, $InsertIntoCollectedItemsQuery);
                                if($InsertIntoCollectedItems){
                                    $UpdateOtherItemsCounter++;
                                }
                            } 
                        }
                    }
    
                    if($UpdateOtherItemsCount == $UpdateOtherItemsCounter){
                        $TotalAmountResult = json_decode(FindAllTotalAmounts($con, $cart_table, $userId,$CartAction));
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
        
        
                        if(intval($Advance) == intval($TotalNet)){
                            $PaymentStatus = 'Paid';
                        }else{
                            $PaymentStatus = 'Unpaid';
                        }
                        
        
                        $UpdateServiceQuery = "UPDATE `servicebill` SET `custName` = '$CustomerName',`custPhone` = '$CustomerPhone',`custAddress` = '$CustomerAddress',`modeOfPay` = '$ModeOfPay',`paymentStatus` = '$PaymentStatus',`grossAmount` = '$TotalGross',`totalTaxAmount` = '$TotalTax',`totalAmount` = '$TotalNet',`totalDiscount` = '$TotalDiscount',`paidAmount` = '$Advance',`updatedBy` = '$userId',`updatedDate` = '$DateToday' WHERE `serviceBillId` = '$UpdateServiceBillId'";
        
                        //echo  $ServiceQuery;
            
                        //Update Service table
                        $UpdateServiceMain = mysqli_query($con, $UpdateServiceQuery);
        
                        if($UpdateServiceMain){
                            mysqli_commit($con);
                            echo json_encode(array('Status' => true,'Message' => 'Record Updated Successfully','UpdateServicePrintId' => $UpdateServiceBillId));
                        }else{
                            mysqli_rollback($con);
                            throw new Exception("Failed Updating Record!","0");
                            //echo json_encode(array('Status' => false, 'Message' => 'Failed Updating Record'));
                        }
            
                    }  
                }
    
            } else {
                throw new Exception("Cart is empty!","0");
                //echo json_encode(array('Status' => false, 'Message' => 'Cart is empty'));
            }
    
        }
        catch(Exception $e){
            echo json_encode(array('Status' => false,'Message' => $e->getMessage()));
        }

    
    }




/////////////////////////////////////////    IN SHOP SERVICE ORDER    //////////////////////////////////////////////////




////////////////////////////////////////    SERVICE ORDERS     ///////////////////////////////////////////////


    // Check Service Status
    if(isset($_POST['CheckServiceStatus']) && !empty($_POST['CheckStatusBillId'])){
        $CheckStatusBillId = $_POST['CheckStatusBillId'];
        $CheckServiceStatusQuery =  mysqli_query($con, "SELECT stat,techId,pickupAgentid,deliveryAgentId FROM servicebill WHERE serviceBillId = '$CheckStatusBillId'");
        if(mysqli_num_rows($CheckServiceStatusQuery) > 0){
            foreach($CheckServiceStatusQuery as $CheckServiceStatusQueryResult){
                $ServiceStatus = $CheckServiceStatusQueryResult['stat'];
                $Technician = $CheckServiceStatusQueryResult['techId'];
                $Pickup = $CheckServiceStatusQueryResult['pickupAgentid'];
                $Delivery = $CheckServiceStatusQueryResult['deliveryAgentId'];
            }
            echo json_encode(array('Status' => true,'ServiceStatus' => $ServiceStatus,'Technician' => $Technician,'Pickup' => $Pickup,'Delivery' => $Delivery, 'Message' => 'Record Found'));
        }else{
            echo json_encode(array('Status' => false,'ServiceStatus' => 0,'Message' => 'No Records Found'));
        }

    }


    //Assign An Agent (Delivery/pickup/technician) and change status
    if (isset($_POST['AssignAgentId']) && isset($_POST['ServiceOrderId']) && isset($_POST['AgentType'])) {

        try{

            $AssignAgentId = $_POST['AssignAgentId'];
            $ServiceOrderId = $_POST['ServiceOrderId'];
            $AssignAgentName = $_POST['AssignAgentName'];
            $AssignType = $_POST['AgentType'];
    
            if($AssignType == 'PICKUP'){
    
                $UpdateQuery = "UPDATE servicebill SET pickupAgentid = '$AssignAgentId', pickupAgentname = '$AssignAgentName',stat = '$OnPickup', tracker = '$TrackerOnPickup', updatedBy = '$userId', updatedDate = '$DateToday'  WHERE serviceBillId = '$ServiceOrderId'";
                $AgentTitle = 'Pickup Agent';

            }elseif($AssignType == 'TECH'){
    
                $UpdateQuery = "UPDATE servicebill SET techId = '$AssignAgentId', techAgentName = '$AssignAgentName',stat = '$InService', tracker = '$TrackerOnTech', updatedBy = '$userId', updatedDate = '$DateToday'  WHERE serviceBillId = '$ServiceOrderId'";
                $AgentTitle = 'Technician';

            }elseif($AssignType == 'DELIVERY'){

                $UpdateQuery = "UPDATE servicebill SET deliveryAgentId = '$AssignAgentId', techAgentName = '$AssignAgentName',stat = '$ForDelivery', tracker = '$TrackerOnDelivery', updatedBy = '$userId', updatedDate = '$DateToday'  WHERE serviceBillId = '$ServiceOrderId'";
                $AgentTitle = 'Delivery Agent';

            }else{
                throw new Exception("Failed Updating Record","434");
            }

            $AssignAgent =  mysqli_query($con, $UpdateQuery);

            if($AssignAgent){
                echo json_encode(array('Status' => true, 'Message' => ''.$AgentTitle.' Is Assigned To The Service'));
            }else{
                throw new Exception("Failed Updating Record","434");
            }

        }catch(Exception $e){
            echo json_encode(array('Status' => false,'Code' => $e->getCode() , 'Message' => $e->getMessage()));
        } 

    }



    // Complete Service And Handover To Customer
    if(isset($_POST['HandoverServiceOrderId']) && !empty($_POST['ServiceCollectedAmount'])){

        $HandoverServiceOrderId = $_POST['HandoverServiceOrderId'];
        $ServiceCollectedAmount = $_POST['ServiceCollectedAmount'];
        $ServiceActualAmount = $_POST['ServiceActualAmount'];
        $ServiceModeOfPay = $_POST['ServiceModeOfPay'];
        $ServicePaidAmount = $_POST['ServicePaidAmount'];

        $PayingAmount = $ServicePaidAmount + $ServiceCollectedAmount;

        if($PayingAmount > $ServiceActualAmount){

            echo json_encode(array('Status' => false, 'Message' => 'Amount Cannot Be Greater Than Total Amount'));

        }else{
            if($ServiceActualAmount == $PayingAmount){
                $PaymentStatus = 'Paid';
            }else{
                $PaymentStatus = 'Unpaid';
            }

            $UpdateCompleteService =  mysqli_query($con, "UPDATE servicebill SET stat = '$CompleteService' , modeOfPay = '$ServiceModeOfPay' , paymentStatus = '$PaymentStatus' , paidAmount = paidAmount + '$ServiceCollectedAmount' , tracker = '$TrackerOnDelivered', updatedBy = '$userId', updatedDate = '$DateToday'  WHERE serviceBillId = '$HandoverServiceOrderId'");
            if($UpdateCompleteService){
                echo json_encode(array('Status' => true, 'Message' => 'Service Has Completed And Handovered To Customer', 'ServiceOrderId' => $HandoverServiceOrderId));
            }else{
                echo json_encode(array('Status' => false, 'Message' => 'Failed Updating Record'));
            }
           
        }

        

    }


    // Fetch Service Details For Handover
    if(isset($_POST['FetchServiceDetailsId']) && !empty(isset($_POST['FetchServiceDetailsId']))){
        $FetchServiceDetailsId = $_POST['FetchServiceDetailsId'];

        $FetchServiceDetailsQuery = mysqli_query($con, "SELECT * FROM servicebill WHERE serviceBillId = '$FetchServiceDetailsId'");
        if(mysqli_num_rows($FetchServiceDetailsQuery) > 0){
            foreach($FetchServiceDetailsQuery as $FetchServiceDetailsQueryResults){
                $OrderAmount = $FetchServiceDetailsQueryResults['totalAmount'];
                $CustomerName = $FetchServiceDetailsQueryResults['custName'];
                $PaidAmount = $FetchServiceDetailsQueryResults['paidAmount'];
            }
            $PendingAmount = $OrderAmount - $PaidAmount;
            echo json_encode(array('Status' => true, 'OrderAmount' => $OrderAmount, 'PendingAmount' => $PendingAmount, 'PaidAmount' => $PaidAmount, 'CustomerName' => $CustomerName,'Message' => 'No Records Found'));
        }else{
            echo json_encode(array('Status' => false, 'Message' => 'No Records Found'));
        }
    }


    // Cancel Service Order
    if (isset($_POST['CancelServiceOrderId']) && !empty($_POST['CancelServiceOrderId'])) {

        $CancelServiceOrderId = $_POST['CancelServiceOrderId'];

        $CancelServiceOrder =  mysqli_query($con, "UPDATE servicebill SET stat = '$Cancelled', tracker = '$TrackerOnCacel', updatedBy = '$userId', updatedDate = '$DateToday'  WHERE serviceBillId = '$CancelServiceOrderId'");
        if($CancelServiceOrder){
            echo json_encode(array('Status' => true, 'Message' => 'Service Cancelled'));
        }else{
            echo json_encode(array('Status' => true, 'Message' => 'Failed Updating Record'));
        }

    }


    // Get The List of All Services In a Service Order
    if(isset($_POST['FetchServiceDetailedList'])){
        
        $ServiceOrderId = $_POST['FetchServiceDetailedList'];

        $FindServiceDetailedListQuery = "SELECT SD.serviceBillId,B.brand_name,P.name,S.service_name,SD.rate FROM servicedetailed SD INNER JOIN service_main SM ON SD.serviceId = SM.main_id INNER JOIN brands B ON SM.br_id = B.br_id INNER JOIN products P ON SM.mo_id = P.pr_id INNER JOIN services S ON SM.sr_id = S.sr_id WHERE SD.serviceBillId = '$ServiceOrderId'";
        $FindServiceDetailedList = mysqli_query($con, $FindServiceDetailedListQuery);
        if(mysqli_num_rows($FindServiceDetailedList) > 0){
            $Table = '';
            $Table .= 
            '<div class="ChildTableContainer">
            <table class="ChildTable">
                <thead>
                    <tr>
                        <th>Sl No.</th>
                        <th>Brand</th>
                        <th>Product</th>
                        <th>Service</th>
                        <th>Rate</th>
                    </tr>
                </thead>
            <tbody>';
            $RowCounter = 0;
            foreach($FindServiceDetailedList as $FindServiceDetailedListResults){
                $RowCounter++;
                $Table .=
                '<tr>
                    <td>'.$RowCounter.'</td>
                    <td>'.$FindServiceDetailedListResults["brand_name"].'</td>
                    <td>'.$FindServiceDetailedListResults["name"].'</td>
                    <td>'.$FindServiceDetailedListResults["service_name"].'</td>
                    <td>'.$FindServiceDetailedListResults["rate"].'</td>
                </tr>';
            }
            $Table .= 
            '</tbody>
            </table>
            </div>';

            //echo $Table;
        }else{
            $Table = '<div class="text-lg-center text-start">No Records Found<div>';
        }

        echo json_encode(array('Status' => true, 'Content' => $Table));


    }


////////////////////////////////////////    SERVICE ORDERS     ///////////////////////////////////////////////



////////////////////////////////////////  TECH OPERATIONS  ///////////////////////////////////////////////////


    // Start Diagnosis
    if(isset($_POST['StartDiagnosis']) && !empty($_POST['StartDiagnosis'])){

        $StartDiagnosisId = $_POST['StartDiagnosis'];
        try{
            $ServiceStatus = json_decode(GetServiceStatus($con, $StartDiagnosisId));
            if($ServiceStatus -> Status == 'true'){
                if($ServiceStatus -> ServiceStatus == 11){
                    throw new Exception("This Order Had Been Cancelled!","431");
                }else{
                    $UpdateDiagnosis =  mysqli_query($con, "UPDATE servicebill SET stat = '$StartDiagnosis' WHERE serviceBillId = '$StartDiagnosisId'");
                    if($UpdateDiagnosis){
                        echo json_encode(array('Status' => true, 'Message' => 'Diagnosis Has Started'));
                    }else{
                        throw new Exception("Failed Updating Record!","434");
                        //echo json_encode(array('Status' => false, 'Message' => 'Failed Updating Record'));
                    }
                }
            }else{
                throw new Exception("Failed Updating Record!","434");
                //echo json_encode(array('Status' => false, 'Message' => 'Failed Updating Record'));
            }
        }
        catch(Exception $e){
            echo json_encode(array('Status' => false,'Code' => $e->getCode() , 'Message' => $e->getMessage()));
        }
    }



    // Start Service
    if(isset($_POST['StartServiceOrderId']) && !empty($_POST['StartServiceExpectedTime'])){

        $StartServiceOrderId = $_POST['StartServiceOrderId'];
        $StartServiceExpectedTime = $_POST['StartServiceExpectedTime'];

        try{
            $ServiceStatus = json_decode(GetServiceStatus($con, $StartServiceOrderId));
            if($ServiceStatus -> Status == 'true'){
                if($ServiceStatus -> ServiceStatus == 11){
                    throw new Exception("This Order Had Been Cancelled!","431");
                }else{
                    $UpdateServiceStart =  mysqli_query($con, "UPDATE servicebill SET stat = '$StartService',expectedTime = '$StartServiceExpectedTime' WHERE serviceBillId = '$StartServiceOrderId'");
                    if($UpdateServiceStart){
                        echo json_encode(array('Status' => true, 'Message' => 'Service Has Started'));
                    }else{
                        throw new Exception("Failed Updating Record!","434");
                    }
                }
            }else{
                throw new Exception("Failed Updating Record!","434");
                //echo json_encode(array('Status' => false, 'Message' => 'Failed Updating Record'));
            }
        }
        catch(Exception $e){
            echo json_encode(array('Status' => false,'Code' => $e->getCode() , 'Message' => $e->getMessage()));
        }

    }



    // Start Testing
    if(isset($_POST['StartTesting']) && !empty($_POST['StartTesting'])){

        $StartTestingOrderId = $_POST['StartTesting'];

        try{
            $ServiceStatus = json_decode(GetServiceStatus($con, $StartTestingOrderId));
            if($ServiceStatus -> Status == 'true'){
                if($ServiceStatus -> ServiceStatus == 11){
                    throw new Exception("This Order Had Been Cancelled!","431");
                }else{
                    $UpdateStartTesting =  mysqli_query($con, "UPDATE servicebill SET stat = '$StartTesting' WHERE serviceBillId = '$StartTestingOrderId'");
                    if($UpdateStartTesting){
                        echo json_encode(array('Status' => true, 'Message' => 'Testing Has Started'));
                    }else{
                        throw new Exception("Failed Updating Record!","434");
                    }
                }
            }else{
                throw new Exception("Failed Updating Record!","434");
                //echo json_encode(array('Status' => false, 'Message' => 'Failed Updating Record'));
            }
        }
        catch(Exception $e){
            echo json_encode(array('Status' => false,'Code' => $e->getCode() , 'Message' => $e->getMessage()));
        }

    }



    // Finish Service
    if(isset($_POST['FinishService']) && !empty($_POST['FinishService'])){

        $FInishServiceOrderId = $_POST['FinishService'];

        try{
            $ServiceStatus = json_decode(GetServiceStatus($con, $FInishServiceOrderId));
            if($ServiceStatus -> Status == 'true'){
                if($ServiceStatus -> ServiceStatus == 11){
                    throw new Exception("This Order Had Been Cancelled!","431");
                }else{
                    $UpdateFInishService =  mysqli_query($con, "UPDATE servicebill SET stat = '$FInishService' WHERE serviceBillId = '$FInishServiceOrderId'");
                    if($UpdateFInishService){
                        echo json_encode(array('Status' => true, 'Message' => 'Service Has Finished'));
                    }else{
                        throw new Exception("Failed Updating Record!","434");
                    }
                }
            }else{
                throw new Exception("Failed Updating Record!","434");
                //echo json_encode(array('Status' => false, 'Message' => 'Failed Updating Record'));
            }
        }
        catch(Exception $e){
            echo json_encode(array('Status' => false,'Code' => $e->getCode() , 'Message' => $e->getMessage()));
        }
    
    }




    // View Service Order Details
    if(isset($_POST['ViewServiceOrderId']) && !empty($_POST['ViewServiceOrderId'])){

        $ViewServiceOrderId = $_POST['ViewServiceOrderId'];

        ?>

            <div class="container-fluid">

            
            
                <?php

                    $OrderId = $ViewServiceOrderId;
                    $FetchInvoiceMain = mysqli_query($con, "SELECT * FROM servicebill WHERE serviceBillId = '$OrderId'");
                    while ($FetchInvoiceMainResult = mysqli_fetch_array($FetchInvoiceMain)) {
                        $SaleDate = $FetchInvoiceMainResult['createdDate'];
                        $newDate = date("d-M-Y h:i:s A", strtotime($SaleDate));
                        ?>


                        <div id="Invoice_details" class="d-flex justify-content-between">

                            <div class="d-block py-3 my-auto">
                                <h5>Invoice to:</h5>
                                <p class="mb-1">
                                    <?php echo $FetchInvoiceMainResult['custName'] . '&nbsp;'; ?> , <br> <?php echo $FetchInvoiceMainResult['custPhone']; ?> , <br> <?php echo $FetchInvoiceMainResult['custAddress']; ?>
                                </p>
                            </div>

                            <div class="d-block text-end py-3 my-auto">
                                <h5>Invoice No: </h5>
                                <h6 style="font-size: 0.9rem;"><?= $FetchInvoiceMainResult['serviceBillNo'] ?> </h6>
                                <h5>Date: </h5>
                                <h6 style="font-size: 0.9rem;"><?php echo $newDate; ?></h6>
                            </div>

                        </div>



                        <div id="Table_main" class="">
                            <table class="table table-striped table-borderless" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Item Name</th>
                                        <th class="text-end">Qty</th>
                                        <th class="text-end">Rate</th>
                                        <th class="text-end">Amt</th>
                                        <!-- <th class="text-end">Disc</th> -->
                                        <th class="text-end">GST%</th>
                                        <th class="text-end">GST</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    //echo $BillDetailedQueryString = "SELECT * FROM servicedetailed SD INNER JOIN brands B ON SD.brand = B.br_id INNER JOIN products P ON SD.model = P.pr_id INNER JOIN service_main SM ON SD.serviceId = SM.main_id INNER JOIN services S ON SM.sr_id = S.sr_id WHERE SD.serviceBillId = '$OrderId'";

                                    $BillDetailedQuery = mysqli_query($con, "SELECT *,SD.tax AS TaxAmount FROM servicedetailed SD INNER JOIN brands B ON SD.brand = B.br_id INNER JOIN products P ON SD.model = P.pr_id INNER JOIN service_main SM ON SD.serviceId = SM.main_id INNER JOIN services S ON SM.sr_id = S.sr_id WHERE SD.serviceBillId = '$OrderId'");

                                    $Counter = 0;
                                    foreach ($BillDetailedQuery as $BillDetailedQueryResult) {
                                        $Counter++;
                                    ?>
                                        <tr>
                                            <td><?= $Counter; ?></td>
                                            <td>
                                                <?php
                                                    echo '<span style="font-size:15px;">'.$BillDetailedQueryResult['brand_name'] . '&nbsp;' . $BillDetailedQueryResult['name'].'</span></br>'; 
                                                    echo '<strong>'.$BillDetailedQueryResult['service_name'].'</strong>'; 
                                                ?>
                                            </td>
                                            <td class="text-end"><?= MoneyFormatIndia($BillDetailedQueryResult['qty']); ?></td>
                                            <td class="text-end"><?= MoneyFormatIndia($BillDetailedQueryResult['rate']); ?></td>
                                            <td class="text-end"><?= MoneyFormatIndia($BillDetailedQueryResult['gross']); ?> </td>
                                            <!-- <td class="text-end"><?= MoneyFormatIndia($BillDetailedQueryResult['BDDSCNT']); ?></td> -->
                                            <td class="text-end"><?= MoneyFormatIndia($BillDetailedQueryResult['salestax']); ?> %</td>
                                            <td class="text-end"><?= MoneyFormatIndia($BillDetailedQueryResult['TaxAmount']); ?> </td>
                                            <td class="text-end"><?= MoneyFormatIndia($BillDetailedQueryResult['amount']); ?> </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>


                        <div class="d-flex justify-content-between">

                            <div class="d-block pt-3">
                                <div class="">
                                    <h6>Collected Items :</h6>
                                    <?php 

                                        $CollectedItemsArray = array();

                                        $ListCollectedItems = mysqli_query($con, "SELECT collectedItems FROM serviceothers WHERE serviceBillId = '$OrderId'");
                                        foreach($ListCollectedItems as $ListCollectedItems){
                                            array_push($CollectedItemsArray, $ListCollectedItems['collectedItems']);
                                        }
                                    
                                        if(count($CollectedItemsArray) > 0){
                                            $CollectedItems = implode(",", $CollectedItemsArray);
                                        }else{
                                            $CollectedItems = '';
                                        }
                                    ?>
                                    <h6 style="font-size: 0.8rem;"> <?= $CollectedItems; ?> </h6>
                                </div>

                                <div class="">
                                    <h6>Amount Paid :</h6>
                                    <h6 style="font-size: 0.8rem;"> <?= MoneyFormatIndia($FetchInvoiceMainResult['paidAmount']); ?> </h6>
                                </div>
                            </div>

                            <div class="mt-3">
                                    <?php 
                                        $FindTaxSplit = mysqli_query($con, "SELECT SUM(cgstamt) AS CGSTAMT, SUM(sgstamt) AS SGSTAMT  FROM servicedetailed WHERE serviceBillId = '$OrderId'");
                                        foreach($FindTaxSplit as $FindTaxSplitResult){
                                            $CGST = $FindTaxSplitResult['CGSTAMT'];
                                            $SGST = $FindTaxSplitResult['SGSTAMT'];
                                        }
                                    ?>
                                <!-- <h6> <?php if($FetchInvoiceMainResult['totaldiscount'] > 0){ echo 'Your Total Discount  :-  ₹ '.number_format($FetchInvoiceMainResult['totaldiscount'], '2', '.', ',');  }else{ } ?>  </h6> -->

                                
                            </div>

                            <div class="d-block pt-3">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Subtotal : </th>
                                            <th class="text-end"><?= MoneyFormatIndia($FetchInvoiceMainResult['grossAmount']); ?></th>
                                        </tr>
                                        <!-- <tr style=" border-bottom: 2px solid #f50414;">
                                            <th>Tax : </th>
                                            <th class="text-end"><?= MoneyFormatIndia($FetchInvoiceMainResult['totaltaxamount']); ?></th>
                                        </tr> -->
                                        <tr>
                                            <th>SGST : </th>
                                            <th class="text-end"><?= MoneyFormatIndia( $SGST); ?></th>
                                        </tr>
                                        <tr style=" border-bottom: 2px solid #f50414;">
                                            <th>CGST : </th>
                                            <th class="text-end"><?= MoneyFormatIndia( $CGST); ?></th>
                                        </tr>
                                        <!-- <tr >
                                            <th>Discount : </th>
                                            <th class="text-end"><?= MoneyFormatIndia($FetchInvoiceMainResult['totaldiscount']); ?></th>
                                        </tr> -->
                                        <tr>
                                            <th style="font-size: 1.3rem;">Total : </th>
                                            <th style="font-size: 1.3rem;" class="text-end"><?= MoneyFormatIndia($FetchInvoiceMainResult['totalAmount']); ?></th>
                                        </tr>
                                    </thead>
                                </table>

                            

                            </div>

                        </div>

                    

                        <?php
                    }
            
                ?>


            </div>

        <?php

    }


////////////////////////////////////////  TECH OPERATIONS  ///////////////////////////////////////////////////

?>