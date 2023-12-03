<?php



require '../MAIN/Dbconn.php';

require '../ADMIN/CommonFunctions.php';

$userId = 210; //Random Customer
$DateToday = date('Y-m-d h:i:s');



session_start();

// Get Service type
if (isset($_GET['SRID'])) {
    $_SESSION['ServiceSelected'] = $_GET['SRID'];
    header('location:BrandSelection.php');
}


// Get Brand
if (isset($_GET['Brand'])) {
    $_SESSION['brand_name'] = $_GET['Brand'];
    //$_SESSION['ServiceSelected'] = $_GET['ServiceType'];
    header('location:ModelSelection.php');
}

//Get Model
if (isset($_GET['Model'])) {
    $_SESSION['model_name'] = $_GET['Model'];
    header('location:ServiceSelection.php');
}

//Get Service
if (isset($_POST['Service_btn'])) {
    $_SESSION['service_check'] = $_POST['services'];
    /* foreach($_SESSION['service_check'] as $mx){
        $new_query = mysqli_query($con, "SELECT * FROM services WHERE sr_id = '$mx'");
        foreach($new_query as $results){
            echo $results['service_name'];
        }
        //echo $mx;
    }*/
    header('location:LocationSelection.php');
}


//Get Location
if (isset($_GET['location'])) {
    $_SESSION['Service_location'] = $_GET['location'];
    // echo $_SESSION['Service_location'];
    header('location:DateSelection.php');
}


//Get Date & Time
if (isset($_POST['Date_btn'])) {
    $_SESSION['selectDate'] = $_POST['Date_pick'];
    $_SESSION['time'] = $_POST['time_radio'];
    //echo $_SESSION['time'].$_SESSION['selectDate'];
    header('location:FillInformation.php');
}



//Get Customer Details
if (isset($_POST['Info_btn'])) {
    $_SESSION['Cname'] = $_POST['cust_name'];
    $_SESSION['Cphone'] = $_POST['cust_phone'];
    $_SESSION['Cemail'] = $_POST['cust_email'];
    $_SESSION['Ccenter'] = $_POST['service_center'];
    $_SESSION['Caddress'] = $_POST['cust_address'];
    $_SESSION['Ccity'] = $_POST['cust_city'];
    $_SESSION['Cstate'] = $_POST['cust_state'];
    $_SESSION['Cpincode'] = $_POST['cust_pincode'];
    $_SESSION['Cdetails'] = $_POST['add_details'];

    //  echo $_SESSION['Cname'].$_SESSION['Cphone'].$_SESSION['Cemail'].$_SESSION['Ccenter'].$_SESSION['Caddress'].$_SESSION['Ccity'].$_SESSION['Cstate'].$_SESSION['Cpincode'].$_SESSION['Cdetails'];

    Header('location:ServicePayment.php');
}


if (isset($_POST['Pay_btn'])) {


    $CustId = $userId;
    $CustomerName = $_SESSION['Cname'];
    $CustomerPhone = $_SESSION['Cphone'];
    $CustomerAddress = $_SESSION['Caddress'];
    $CustomerEmail = $_SESSION['Cemail'];
    $CustomerState = $_SESSION['Cstate'];
    $CustomerCity = $_SESSION['Ccity'];
    $CustomerPincode = $_SESSION['Cpincode'];
    $InvoiceDate = $DateToday;
    $PickupDate = $_SESSION['selectDate'];
    $PickupTime = $_SESSION['time'];
    $PickupMode = $_SESSION['Service_location'];
    $BillType = 'OSR';
    //$PaymentStatus = '';
    $ModeOfPay = $_POST['mode'];
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
    $Remarks = $_SESSION['Cdetails'];
    $Jobcardid = 0;
    $Pointsamount = 0;
    $Pointsamount = 0;
    $Redeempoint = 0;
    $Redeemamount = 0;
    $Totalearnedpoints = 0;
    $Totalredeemedpoints = 0;
    $Totalearnedamount = 0;
    $Totalredeemedamount = 0;
    $Despatchaddress = $_SESSION['Cdetails'];
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
    $CollectedItems = '';
    $deliveryCharge = 0;
    $ActualAmount = 0;
    $PaymentStatus = 'Unpaid';
    $Advance = 0;
    $BillDate = $DateToday;

    // $_SESSION['mode'] = $_POST['mode'];
    // $brand = $_SESSION['brand_name'];
    // $model = $_SESSION['model_name'];
    // $mode = $_SESSION['mode'];
    // $location = $_SESSION['Service_location'];
    // $date = $_SESSION['selectDate'];
    // $time = $_SESSION['time'];
    // $name = $_SESSION['Cname'];
    // $phone = $_SESSION['Cphone'];
    // $email = $_SESSION['Cemail'];
    // $nearby = $_SESSION['Ccenter'];
    // $address = $_SESSION['Caddress'];
    // $city = $_SESSION['Ccity'];
    // $state = $_SESSION['Cstate'];
    // $pincode = $_SESSION['Cpincode'];
    // $add_details = $_SESSION['Cdetails'];
    //print_r($_SESSION['service_check']);


    try {
        mysqli_autocommit($con, FALSE);

        $FetchServiceId = mysqli_query($con, "SELECT MAX(serviceBillId),MAX(serviceBillNo),COUNT(serviceBillId) FROM servicebill");
        foreach ($FetchServiceId as $FetchServiceIdResults) {
            $ServiceBillId = $FetchServiceIdResults['MAX(serviceBillId)'] + 1;
            $TableBillNo = $FetchServiceIdResults['MAX(serviceBillNo)'];
            $RowCount = $FetchServiceIdResults['COUNT(serviceBillId)'];
        }

        if ($RowCount == 0) {
            $BillNo = 'THP2301';
        } else {
            $TableBillNo = intval(substr($TableBillNo, 3, strlen($TableBillNo)));
            $BillNo  = 'THP' . ($TableBillNo + 1);
        }


        $SelectedServices = $_SESSION['service_check'];
        $SelectedServicesCount = count($SelectedServices);
        $ServiceDetailedCounter = 0;
        $TotalQty = $SelectedServicesCount;
        $TotalTax = 0;
        $TotalGross = 0;
        $CashAmount = 0;
        $TotalNet = 0;
        $TotalRoundoff = 0;
        $TotalCess =  0;
        $TotalAddCess =  0;
        $TotalOthercharge = 0;
        $TotalDiscount = 0;
        $TotalIndDiscount = 0;


        if ($SelectedServicesCount > 0) {

            foreach ($SelectedServices as $SelectedServicesList) {

                $FindItemDetails = mysqli_query($con, "SELECT SM.main_id,SM.se_id,SM.br_id,SM.sr_id,SM.mo_id,SM.cost,SM.tax,SM.commission,P.name,B.brand_name,S.service_name FROM service_main SM INNER JOIN brands B ON SM.br_id = B.br_id INNER JOIN products P ON SM.mo_id = P.pr_id INNER JOIN services S ON SM.sr_id = S.sr_id WHERE SM.main_id = '$SelectedServicesList'");
                foreach ($FindItemDetails as $FindItemDetailsResults) {
                    $MainId = $FindItemDetailsResults['main_id'];
                    $Brand = $FindItemDetailsResults['br_id'];
                    $Model = $FindItemDetailsResults['mo_id'];
                    $Series = $FindItemDetailsResults['se_id'];
                    $ServiceId = $FindItemDetailsResults['sr_id'];
                    $ServiceCost = $FindItemDetailsResults['cost'];
                    $ServiceCommission = $FindItemDetailsResults['commission'];
                    $ServiceTax = $FindItemDetailsResults['tax'];
                    $BrandName = $FindItemDetailsResults['brand_name'];
                    $ModelName = $FindItemDetailsResults['name'];
                    $ServiceName = $FindItemDetailsResults['service_name'];
                    $Qty = 1;
                    $Rate = $ServiceCost;
                    $Inclusive = 1;
                    $IndDiscPerc = 0;
                    $IndDiscAmt = 0;
                    $Sp = $ServiceCost;
                    $Mrp = $ServiceCost;
                    $Amt = $ServiceCost;
                    $Lc = 0;
                    $CessPerc = 0;
                    $CessAmt = 0;
                    $Hsn = 0;
                    $AddCessPerc = 0;
                    $AddCessAmt = 0;
                    $Pack = 0;
                    $CompletedStatus = '';


                    $TaxCalculation = json_decode(CalculateIncTax($ServiceTax, $ServiceCost));


                    //print_r($TaxCalculation);

                    $Taxamt = $TaxCalculation->IGSTAmt;
                    $ProductTotal = $TaxCalculation->GrossAmt;
                    $CGSTPER = $TaxCalculation->CGST;
                    $CGSTAMT = $TaxCalculation->CGSTAmt;
                    $SGSTPER = $TaxCalculation->SGST;
                    $SGSTAMT = $TaxCalculation->SGSTAmt;
                    $IGSTPER = $TaxCalculation->IGST;
                    $IGSTAMT = $TaxCalculation->IGSTAmt;
                    $TotalTax += $Taxamt;
                    $TotalGross += $ProductTotal;
                    $TotalNet += $ServiceCost;


                    $FindMaxServiceDetailed = mysqli_query($con, "SELECT MAX(serviceDetailedId) FROM servicedetailed");
                    foreach ($FindMaxServiceDetailed as $FindMaxServiceDetailedResults) {
                        $MaxServiceDetailed = $FindMaxServiceDetailedResults['MAX(serviceDetailedId)'] + 1;
                    }

                    $InsertIntoServiceDetailedQuery = "INSERT INTO `servicedetailed` (`serviceDetailedId`,`serviceBillId`,`serviceId`,`brand`,`model`,`brandName`,`modelName`,`serviceName`,`qty`,`rate`,`discountpercentage`,`discountamount`,`sp`,`gross`,`salestax`,`tax`,`amount`,`serialid`,`schemedetailedid`,`SalesManId`,`cgstpercentage`,`cgstamt`,`sgstpercentage`,`sgstamt`,`igstpercentage`,`igstamt`,`inclusive`,`cesspercentage`,`cessamount`,`mrp`,`hsn`,`addcesspercentage`,`addcessamount`,`lastcp`,`unitid`,`factor`,`TCS`,`TCSamt`,`Serial_No`,`completedStatus`) VALUES('$MaxServiceDetailed','$ServiceBillId','$MainId','$Brand','$Model','$BrandName','$ModelName','$ServiceName','$Qty','$Rate','$IndDiscPerc','$IndDiscAmt','$Sp','$ProductTotal','$ServiceTax','$Taxamt','$Amt','0','0','$userId','$CGSTPER','$CGSTAMT','$SGSTPER','$SGSTAMT','$IGSTPER','$IGSTAMT','$Inclusive','$CessPerc','$CessAmt','$Mrp','$Hsn','$AddCessPerc','$AddCessAmt','0','0','0','0','0','0','$CompletedStatus')";

                    //insert into Service detailed
                    $InsertIntoServiceDetailed = mysqli_query($con, $InsertIntoServiceDetailedQuery);

                    if ($InsertIntoServiceDetailed) {
                        $ServiceDetailedCounter++;
                    } else {
                        //throw new Exception("Failed Adding Record!", "0");
                    }
                }
            }

            // if (intval($Advance) == intval($TotalNet)) {
            //     $PaymentStatus = 'Paid';
            // } else {
            //     $PaymentStatus = 'Unpaid';
            // }

            if($ServiceDetailedCounter == $SelectedServicesCount){
                $ServiceQuery = "INSERT INTO `servicebill`(`serviceBillId`,`serviceBillNo`,`billType`,`billDate`,`custId`,`custName`,`custPhone`,`custEmail`,`serviceCenter`,`custAddress`,`custCity`,`custState`,`custPincode`,`custDetails`,`pickupDate`,`pickupTime`,`pickupMode`,`modeOfPay`,`paymentStatus`,`grossAmount`,`totalTaxAmount`,`totalAmount`,`servicebillcol`,`totalDiscount`,`paidAmount`,`deliveryCharge`,`stat`,`pickupAgentname`,`pickupAgentid`,`techId`,`techAgentName`,`serviceStatus`,`inService`,`inTransit`,`tracker`,`deliveryAgentId`,`deliveryAgentName`,`createdBy`,`createdDate`) VALUES ('$ServiceBillId','$BillNo','$BillType','$BillDate','$CustId','$CustomerName','$CustomerPhone','$CustomerEmail','','$CustomerAddress','$CustomerCity','$CustomerState','$CustomerPincode','$Remarks','$PickupDate','$PickupTime','$PickupMode','$ModeOfPay','$PaymentStatus','$TotalGross','$TotalTax','$TotalNet','','$TotalDiscount','$Advance','$deliveryCharge','0','','0','0','','','0','0','0','0','','$userId','$DateToday')";

                //insert into Service table
                $InsertIntoServiceMain = mysqli_query($con, $ServiceQuery);
                if($InsertIntoServiceMain){
                    //echo "inserted";
                    mysqli_commit($con);
                    header('location:ServiceConfirmation.php');
                }else{
                    mysqli_rollback($con);
                    throw new Exception("Failed Placing Order!", "0");
                }
            }else{
                mysqli_rollback($con);
                throw new Exception("Failed Placing Order!", "0");
            }

        } else {
            mysqli_rollback($con);
            throw new Exception("Service Cart is Empty!", "0");
        }
    } catch (Exception $e) {
        echo json_encode(array('Status' => false, 'Message' => $e->getMessage()));
    }







    // $ServiceIDs = implode(",", $_SESSION['service_check']);
    // $SumQuery = "SELECT SUM(cost) FROM service_main WHERE mo_id = '$model' AND br_id = '$brand' AND sr_id IN($ServiceIDs)";
    // $sumquery = mysqli_query($con, "SELECT SUM(cost) FROM service_main WHERE main_id IN($ServiceIDs)");
    // foreach($sumquery as $sumresult){
    //     $total =  $sumresult['SUM(cost)'];
    // }

    // if($location == 'Doorstep'){
    //     $Service_order = mysqli_query($con , "INSERT INTO service_order (cust_name,cust_phone,cust_email,service_center,cust_address,cust_city,cust_state,cust_pincode,cust_details,brand,model,pickup_date,pickup_time,pickup_mode,mode_of_pay,total,tracker) VALUES 

    //                             ('$name','$phone','$email','$nearby','$address','$city','$state','$pincode','$add_details','$brand','$model','$date','$time','$location','$mode','$total','null')");
    // }
    // else{
    //     $Service_order = mysqli_query($con , "INSERT INTO service_order (cust_name,cust_phone,cust_email,service_center,cust_address,cust_city,cust_state,cust_pincode,cust_details,brand,model,pickup_date,pickup_time,pickup_mode,mode_of_pay,total,tracker) VALUES 

    //                             ('$name','$phone','$email','$nearby','$address','$city','$state','$pincode','$add_details','$brand','$model','$date','$time','$location','$mode','$total','shop')");
    // }

    // if($Service_order){
    //     foreach($_SESSION['service_check'] as $mx){

    //         $service_items = mysqli_query($con, "INSERT INTO service_items (so_id,main_sr_id) VALUES ((SELECT so_id FROM service_order WHERE cust_phone = '$phone' ORDER BY so_id DESC LIMIT 1),'$mx')");

    //     }
    //     /*foreach($_SESSION['service_check'] as $mx){
    //         $query = mysqli_query($con, "SELECT * FROM service_main WHERE sr_id = '$mx' AND mo_id = '$model' AND br_id = '$brand'");
    //         while($result = mysqli_fetch_array($query)){
    //             $s_name = $result['service'];
    //             $s_price = $result['cost'];
    //             $service_items = mysqli_query($con, "INSERT INTO service_items (so_id,sr_id,service,price) VALUES ((SELECT so_id FROM service_order WHERE cust_phone = '$phone' ORDER BY so_id DESC LIMIT 1),'$mx','$s_name','$s_price')");
    //         }
    //     }*/
    // }
    // else{
    //     echo "Transaction Query error";
    // }
    // if($Service_order && $service_items){
    //     header('location:ServiceConfirmation.php');
    // }
    // else{
    //     echo "Transaction Failed";
    // }
}
