<?php


include '../MAIN/Dbconn.php';

//include "./CommonFunctions.php";

$userId = $_COOKIE['custidcookie'];

$timeNow = date("Y-m-d h:i:s");



$tempPurchaseTable = 'purchase_temp_table';
$tempAddDiscountTable = 'purchasediscounttemp';
$tempOtherChargeTable = 'purchaseotherchargetemp';






//Create Empty Row
function CreateEmptyRow($connString, $Table, $rowId)
{
    $RowId = $rowId;
    $tempPurchaseTable = $Table;
    $ConnectionString = $connString;
    $findMaxTemp = mysqli_query($ConnectionString, "SELECT MAX(purchasetempid) FROM $tempPurchaseTable");
    foreach ($findMaxTemp as $findMaxTempResult) {
        $MaxTempOld = $findMaxTempResult['MAX(purchasetempid)'];
    }

    if ($RowId == $MaxTempOld) {
        $MaxTemp = $MaxTempOld + 1;
        $CreateEmptyRow = mysqli_query($ConnectionString, "INSERT INTO $tempPurchaseTable(`purchasetempid`, `itembarcode`, `itemname`, `itemid`, `itemcode`, `pieces`, `itemunit`, `qty`, `rate`, `inclusive`, `inddiscountpercentage`, `inddiscountamount`, `cp`, `producttotalamount`, `purchasetax`, `taxamount`, `amount`, `lc`, `cgstpercentage`, `cgstamt`, `sgstpercentage`, `sgstamt`, `igstpercentage`, `igstamt`, `cesspercentage`, `cessamount`, `hsn`, `addcesspercentage`, `addcessamount`, `wasqty`, `mrp`, `salestax`, `sp`, `expdate`, `batch`) VALUES ('$MaxTemp','0','','0','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','','0','0','0','0','0','0','','')");
        if ($CreateEmptyRow) {
            return 'Success';
        } else {
            return 'Cancel';
        }
    } else {
        return 'Success';
    }
}


//Calcularte Inclusive tax
function CalculateIncTax($igst, $Total)
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
}


//Calculate Exclusive tax
function CalculateExcTax($igst, $Total)
{
    $IGST = floatval($igst);
    $CGST = floatval($igst / 2.00);
    $SGST = floatval($igst / 2.00);
    $Total = $Total;

    $IGSTMutliplier = ($IGST / 100);
    $CGSTMutliplier = ($CGST / 100);
    $SGSTMutliplier = ($SGST / 100);

    $IGSTAmt = round(($Total * $IGSTMutliplier), 3);
    $CGSTAmt = round(($Total * $CGSTMutliplier), 3);
    $SGSTAmt = round(($Total * $SGSTMutliplier), 3);
    $GrossAmt = $Total;
    $TotalAmt = $Total + $IGSTAmt;


    $CalculatedValues = json_encode(array('IGST' => $IGST, 'CGST' => $CGST, 'SGST' => $SGST, 'IGSTAmt' => $IGSTAmt, 'CGSTAmt' => $CGSTAmt, 'SGSTAmt' => $SGSTAmt, 'GrossAmt' => $GrossAmt, 'TotalAmt' => $TotalAmt));
    return $CalculatedValues;
}



//Calculates tax, amount, gross
function CalculateTax($ConnString, $IsInclusive, $IGST, $GrossAmount, $tempPurchaseTable, $RowId)
{
    if ($IsInclusive == 1) {
        $InclTaxArray = json_decode(CalculateIncTax($IGST, $GrossAmount));
        //print_r($InclTaxArray);
        $InclIGST = $InclTaxArray->IGST;
        $InclCGST = $InclTaxArray->CGST;
        $InclSGST = $InclTaxArray->SGST;
        $InclIGSTAmt = $InclTaxArray->IGSTAmt;
        $InclCGSTAmt = $InclTaxArray->CGSTAmt;
        $InclSGSTAmt = $InclTaxArray->SGSTAmt;
        $InclGrossAmt = $InclTaxArray->GrossAmt;

        $UpdateValuesInTable = mysqli_query($ConnString, "UPDATE $tempPurchaseTable SET `cgstpercentage`='$InclCGST',`cgstamt`='$InclCGSTAmt',`sgstpercentage`='$InclSGST',`sgstamt`='$InclSGSTAmt',`igstpercentage`='$InclIGST',`igstamt`='$InclIGSTAmt',`producttotalamount`= '$InclGrossAmt',`amount`= '$GrossAmount' WHERE purchasetempid = '$RowId'");

        if ($UpdateValuesInTable) {
            $EmptyRowResult = CreateEmptyRow($ConnString, $tempPurchaseTable, $RowId);
            if ($EmptyRowResult == 'Success') {
                return 'Success';
            } else {
                return 'Cancel';
            }
        } else {
            return 'Cancel';
        }
    } else {
        $ExclTaxArray = json_decode(CalculateExcTax($IGST, $GrossAmount));
        //print_r($InclTaxArray);
        $ExclIGST = $ExclTaxArray->IGST;
        $ExclCGST = $ExclTaxArray->CGST;
        $ExclSGST = $ExclTaxArray->SGST;
        $ExclIGSTAmt = $ExclTaxArray->IGSTAmt;
        $ExclCGSTAmt = $ExclTaxArray->CGSTAmt;
        $ExclSGSTAmt = $ExclTaxArray->SGSTAmt;
        $ExclGrossAmt = $ExclTaxArray->GrossAmt;
        $ExclTotalAmt = $ExclTaxArray->TotalAmt;

        $UpdateValuesInTable = mysqli_query($ConnString, "UPDATE $tempPurchaseTable SET `cgstpercentage`='$ExclCGST',`cgstamt`='$ExclCGSTAmt',`sgstpercentage`='$ExclSGST',`sgstamt`='$ExclSGSTAmt',`igstpercentage`='$ExclIGST',`igstamt`='$ExclIGSTAmt',`producttotalamount`= '$ExclGrossAmt',`amount`= '$ExclTotalAmt' WHERE purchasetempid = '$RowId'");

        if ($UpdateValuesInTable) {
            $EmptyRowResult = CreateEmptyRow($ConnString, $tempPurchaseTable, $RowId);
            if ($EmptyRowResult == 'Success') {
                return 'Success';
            } else {
                return 'Cancel';
            }
        } else {
            return 'Cancel';
        }
    }
}


//Calculate discount and discount Amount
function CalculateDiscount($InitialAmount, $DiscountAmount, $DiscountPercentage)
{


    if ($DiscountPercentage == '') {
        $DiscountedAmount = $InitialAmount - $DiscountAmount;
        $DiscountPercentage = ($DiscountAmount / $InitialAmount) * 100;
    } else {
        $DiscountedAmount = $InitialAmount - (($DiscountPercentage / 100) * $InitialAmount);
        $DiscountAmount = $InitialAmount - $DiscountedAmount;
    }


    $DiscountResult =  json_encode(array('Amount' => $InitialAmount, 'DiscountAmount' => $DiscountAmount, 'DiscountedAmount' => $DiscountedAmount, 'DiscountPercentage' => $DiscountPercentage));
    return $DiscountResult;
}


//Update addtional cess and cess amounts
function CalculateCessAndAdditionalCess($connstring, $itemid, $temppurchasetable)
{

    $ConnString = $connstring;
    $ItemId = $itemid;
    $tempPurchaseTable = $temppurchasetable;
    $FindItemCessAndAdditionalCess = mysqli_query($ConnString, "SELECT cesspercentage,addcesspercentage,producttotalamount FROM $tempPurchaseTable WHERE purchasetempid = '$ItemId'");
    foreach ($FindItemCessAndAdditionalCess as $FindItemCessAndAdditionalCessResult) {
        $CessPerc = $FindItemCessAndAdditionalCessResult['cesspercentage'];
        $AddCessPerc = $FindItemCessAndAdditionalCessResult['addcesspercentage'];
        $Gross = $FindItemCessAndAdditionalCessResult['producttotalamount'];
    }

    $CalculatedCess = json_decode(CalculateExcTax($CessPerc, $Gross))->IGSTAmt;
    $CalculatedAdditionalCess = json_decode(CalculateExcTax($AddCessPerc, $Gross))->IGSTAmt;

    $UpdateCessAmounts = mysqli_query($ConnString, "UPDATE $tempPurchaseTable SET cessamount = '$CalculatedCess' , addcessamount = '$CalculatedAdditionalCess' WHERE purchasetempid = '$ItemId'");
    if ($UpdateCessAmounts) {
        return "Success";
    } else {
        return "Failed";
    }
    //return $CalculatedCess.'-'.$CalculatedAdditionalCess;

}


//Find Totals of all Amounts
function FindAllTotalAmounts($connstring, $tempadddiscounttable, $temppurchasetable, $tempotherchargetable)
{

    $Connstring = $connstring;
    $TempAddDiscountTable = $tempadddiscounttable;
    $TempPurchaseTable = $temppurchasetable;
    $TempOtherChargeTable = $tempotherchargetable;

    $TOTALTAX = 0;
    $TOTALGROSS = 0;
    $TOTALNETWITHOUTROUNDOFF = 0;
    $TOTALCESS = 0;
    $TOTALADDCESS = 0;
    $TOTALOTHERCHARGES = 0;
    $TOTALADDDISCOUNT = 0;
    $TOTALINDDISCOUNT = 0;

    $FindOtherCharges =  mysqli_query($Connstring, "SELECT SUM(otherchargeamount) FROM $TempOtherChargeTable");
    if (mysqli_num_rows($FindOtherCharges) > 0) {
        foreach ($FindOtherCharges as $FindOtherChargesResult) {
            $OtherCharge  = $FindOtherChargesResult['SUM(otherchargeamount)'];
        }
    } else {
        $OtherCharge = 0;
    }

    $TOTALOTHERCHARGES += $OtherCharge;
    $TOTALNETWITHOUTROUNDOFF += $OtherCharge;

    $FindAddDiscount =  mysqli_query($Connstring, "SELECT SUM(discountamount) FROM $TempAddDiscountTable");
    if (mysqli_num_rows($FindAddDiscount) > 0) {
        foreach ($FindAddDiscount as $FindAddDiscountResult) {
            $AddDiscount  = $FindAddDiscountResult['SUM(discountamount)'];
        }
    } else {
        $AddDiscount = 0;
    }

    $TOTALADDDISCOUNT += $AddDiscount;
    $TOTALNETWITHOUTROUNDOFF -= $AddDiscount;


    $FindTotal = mysqli_query($Connstring, "SELECT SUM(igstamt) AS TOTALTAX ,SUM(producttotalamount) AS GROSSTOTAL, SUM(cessamount) AS TOTALCESS, SUM(addcessamount) AS TOTALADDCESS, SUM(inddiscountamount) AS TOTALINDDISC FROM $TempPurchaseTable");
    foreach ($FindTotal as $FindTotalResult) {
        $TOTALTAX += $FindTotalResult['TOTALTAX'];
        $TOTALGROSS += $FindTotalResult['GROSSTOTAL'];
        $TOTALCESS += $FindTotalResult['TOTALCESS'];
        $TOTALADDCESS += $FindTotalResult['TOTALADDCESS'];
        $TOTALINDDISCOUNT += $FindTotalResult['TOTALINDDISC'];
    }



    $TOTALNETWITHOUTROUNDOFF += ($TOTALTAX + $TOTALGROSS);
    $TOTALWITHROUND = round($TOTALNETWITHOUTROUNDOFF);
    $ROUNDOFF = round(($TOTALWITHROUND - $TOTALNETWITHOUTROUNDOFF), 1);

    return json_encode(array('FindTotalStatus' => 1, 'TotalTax' => $TOTALTAX, 'TotalGross' => $TOTALGROSS, 'TotalNet' => $TOTALWITHROUND, 'RoundOff' => $ROUNDOFF, 'TotalNetNoRound' => $TOTALNETWITHOUTROUNDOFF, 'TotalCess' => $TOTALCESS, 'TotalAddCess' => $TOTALADDCESS, 'TotalOtherCharge' => $TOTALOTHERCHARGES, 'TotalAddDiscount' => $TOTALADDDISCOUNT, 'TotalIndDiscount' => $TOTALINDDISCOUNT));
}



//////////////////////////////////  PURCHASE STARTING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\



//Delete All Items in Temp Table
if (isset($_POST['delAll'])) {

    mysqli_autocommit($con, FALSE);
    $ClearMainTable = mysqli_query($con, "DELETE FROM $tempPurchaseTable");
    $ClearOtherChargeTable = mysqli_query($con, "UPDATE $tempOtherChargeTable SET otherchargeamount = '0'");
    $ClearAddDiscountTable = mysqli_query($con, "UPDATE $tempAddDiscountTable SET discountamount = '0'");

    if($ClearMainTable && $ClearOtherChargeTable && $ClearAddDiscountTable){
        if(CreateEmptyRow($con, $tempPurchaseTable, 0) == 'Success'){
            mysqli_commit($con);
            echo json_encode(array('delAllStatus' => 1));
        }else{
            mysqli_rollback($con);
            echo json_encode(array('delAllStatus' => 0));
        }
    } else {
        mysqli_rollback($con);
        echo json_encode(array('delAllStatus' => 0));
    }
}




//Add Item
if (isset($_POST['itemAddId']) && !empty($_POST['itemAddId']) && !empty($_POST['AddItemRow'])) {

    $AddproductId = $_POST['itemAddId'];
    $AddProductRowId = $_POST['AddItemRow'];

    $FetchItemDetails =  mysqli_query($con, "SELECT * FROM products WHERE pr_id = '$AddproductId'");
    foreach ($FetchItemDetails as $FetchItemDetailsResults) {
        $ItemName = $FetchItemDetailsResults['name'];
        $ItemBarcode = $FetchItemDetailsResults['barcode'];
        $ItemCode = $FetchItemDetailsResults['pr_code'];
        $ItemUnit = $FetchItemDetailsResults['unitid'];
        $ItemInclusive = $FetchItemDetailsResults['inclusive'];
        $ItemCp = $FetchItemDetailsResults['cp'];
        $ItemLastCp = $FetchItemDetailsResults['lastcp'];
        $ItemIgst = $FetchItemDetailsResults['IGST'];
        $ItemMrp = $FetchItemDetailsResults['mrp'];
        $ItemBatch = $FetchItemDetailsResults['batch'];
        $ItemExpiry = $FetchItemDetailsResults['expiryDate'];
        $ItemSp = $FetchItemDetailsResults['sp'];
        $ItemUserCode = $FetchItemDetailsResults['usercode'];
        $ItemHsn = $FetchItemDetailsResults['hsn'];
    }


    $InsertIntoTempTable = mysqli_query($con, "UPDATE `purchase_temp_table` SET `itemname`= '$ItemName', `qty`= '0',`itembarcode`='$ItemBarcode',`itemid`='$AddproductId',`itemcode`='$ItemCode',`pieces`='1.000',`itemunit`='$ItemUnit',`rate`='$ItemCp',`inclusive`='$ItemInclusive',`inddiscountpercentage`='0.00',`inddiscountamount`='0.000',`cp`='$ItemCp',`producttotalamount`='0.000',`igstpercentage`='$ItemIgst',`igstamt`='0.000',`purchasetax`='$ItemIgst',`taxamount`='0.000',`amount`='0.000',`lc`='$ItemLastCp',`hsn`='$ItemHsn',`wasqty`='0.000',`mrp`='$ItemMrp',`salestax`='$ItemIgst',`sp`='$ItemSp',`expdate`='$ItemExpiry',`batch`='$ItemBatch' WHERE purchasetempid = '$AddProductRowId'");

    if ($InsertIntoTempTable) {
        echo json_encode(array('addItem' => '1'));
    } else {
        echo json_encode(array('addItem' => '0'));
    }
}





//Change Qty
if (isset($_POST['ChangeQtyValue']) && !empty($_POST['ChangeQtyValue']) && !empty($_POST['ChangeQtyRow'])) {

    $ChangeQtyValue = $_POST['ChangeQtyValue'];
    $ChangeQtyRow = $_POST['ChangeQtyRow'];

    $FindRateFromTempTable = mysqli_query($con, "SELECT rate,inclusive,inddiscountpercentage,igstpercentage FROM $tempPurchaseTable WHERE purchasetempid = '$ChangeQtyRow'");
    foreach ($FindRateFromTempTable as $FindRateFromTempTableResult) {
        $IGSTP = $FindRateFromTempTableResult['igstpercentage'];
        $IsInclusive = $FindRateFromTempTableResult['inclusive'];
        $DiscPercnt = $FindRateFromTempTableResult['inddiscountpercentage'];
    }

    $BeforeGrossAmount = $ChangeQtyValue * $FindRateFromTempTableResult['rate'];
    $DiscountResult =  json_decode(CalculateDiscount($BeforeGrossAmount, '', $DiscPercnt));
    $DiscPercent = $DiscountResult->DiscountPercentage;
    $DiscountedAmt = $DiscountResult->DiscountedAmount;
    $DiscountAmt = $DiscountResult->DiscountAmount;
    $GrossAmount = $DiscountedAmt;

    $UpdateQtyinTable = mysqli_query($con, "UPDATE $tempPurchaseTable SET qty = '$ChangeQtyValue',inddiscountamount = '$DiscountAmt' WHERE purchasetempid = '$ChangeQtyRow'");
    if ($UpdateQtyinTable) {

        $TaxChangesResult =  CalculateTax($con, $IsInclusive, $IGSTP, $GrossAmount, $tempPurchaseTable, $ChangeQtyRow);
        if ($TaxChangesResult == 'Success') {
            $CessCalculateResult = CalculateCessAndAdditionalCess($con, $ChangeQtyRow, $tempPurchaseTable);
            if ($CessCalculateResult == 'Success') {
                echo json_encode(array('changeQty' => '1'));
            } else {
                echo json_encode(array('changeQty' => '0'));
            }
        } else {
            echo json_encode(array('changeQty' => '0'));
        }
    }
}





//Change Rate
if (isset($_POST['ChangeRateValue']) && !empty($_POST['ChangeRateValue']) && !empty($_POST['ChangeRateRow'])) {

    $ChangeRateValue = $_POST['ChangeRateValue'];
    $ChangeRateRow = $_POST['ChangeRateRow'];

    $FindRateFromTempTable = mysqli_query($con, "SELECT qty,inclusive,igstpercentage,inddiscountpercentage FROM $tempPurchaseTable WHERE purchasetempid = '$ChangeRateRow'");
    foreach ($FindRateFromTempTable as $FindRateFromTempTableResult) {
        $IGSTP = $FindRateFromTempTableResult['igstpercentage'];
        $IsInclusive = $FindRateFromTempTableResult['inclusive'];
        $DiscPercnt = $FindRateFromTempTableResult['inddiscountpercentage'];
        $Qty = $FindRateFromTempTableResult['qty'];
    }
    $BeforeGrossAmount = $ChangeRateValue * $Qty;
    $DiscountResult =  json_decode(CalculateDiscount($BeforeGrossAmount, '', $DiscPercnt));
    //print_r($DiscountResult);
    $DiscPercent = $DiscountResult->DiscountPercentage;
    $DiscountedAmt = $DiscountResult->DiscountedAmount;
    $DiscountAmt = $DiscountResult->DiscountAmount;
    $GrossAmount = $DiscountedAmt;

    $UpdateRateinTable = mysqli_query($con, "UPDATE $tempPurchaseTable SET rate = '$ChangeRateValue',cp ='$DiscountedAmt',inddiscountpercentage = '$DiscPercent',inddiscountamount = '$DiscountAmt' WHERE purchasetempid = '$ChangeRateRow'");
    if ($UpdateRateinTable) {

        $TaxChangesResult =  CalculateTax($con, $IsInclusive, $IGSTP, $GrossAmount, $tempPurchaseTable, $ChangeRateRow);
        if ($TaxChangesResult == 'Success') {
            $CessCalculateResult = CalculateCessAndAdditionalCess($con, $ChangeRateRow, $tempPurchaseTable);
            if ($CessCalculateResult == 'Success') {
                echo json_encode(array('changeRate' => '1'));
            } else {
                echo json_encode(array('changeRate' => '0'));
            }
        } else {
            echo json_encode(array('changeRate' => '0'));
        }
    }
}




//Add Discount Amount
if (isset($_POST['ChangeDiscAmt']) && !empty($_POST['ChangeDiscAmt']) && !empty($_POST['ChangeDiscAmtRow'])) {

    $ChangeDiscAmt = $_POST['ChangeDiscAmt'];
    $ChangeDiscAmtRow = $_POST['ChangeDiscAmtRow'];

    $FindRateFromTempTable = mysqli_query($con, "SELECT rate,qty,inclusive,igstpercentage FROM $tempPurchaseTable WHERE purchasetempid = '$ChangeDiscAmtRow'");
    foreach ($FindRateFromTempTable as $FindRateFromTempTableResult) {
        $IGSTP = $FindRateFromTempTableResult['igstpercentage'];
        $IsInclusive = $FindRateFromTempTableResult['inclusive'];
        $Rate = $FindRateFromTempTableResult['rate'];
        $QTY = $FindRateFromTempTableResult['qty'];
        //$ProductTotal = $FindRateFromTempTableResult['producttotalamount'];
        //$Amount = $FindRateFromTempTableResult['amount'];
    }

    $Gross = $Rate * $QTY;

    $DiscountResult =  json_decode(CalculateDiscount($Gross, $ChangeDiscAmt, 0));

    //print_r($DiscountResult);

    $DiscPercent = $DiscountResult->DiscountPercentage;
    $DiscountedAmt = $DiscountResult->DiscountedAmount;
    $GrossAmount = $DiscountedAmt;
    $CP = $DiscountedAmt / $QTY;

    $UpdateDiscountinTable = mysqli_query($con, "UPDATE $tempPurchaseTable SET cp ='$CP',producttotalamount = '$GrossAmount',inddiscountamount = '$ChangeDiscAmt',inddiscountpercentage = '$DiscPercent' WHERE purchasetempid = '$ChangeDiscAmtRow'");
    if ($UpdateDiscountinTable) {

        $TaxChangesResult =  CalculateTax($con, $IsInclusive, $IGSTP, $GrossAmount, $tempPurchaseTable, $ChangeDiscAmtRow);
        if ($TaxChangesResult == 'Success') {
            $CessCalculateResult = CalculateCessAndAdditionalCess($con, $ChangeDiscAmtRow, $tempPurchaseTable);
            if ($CessCalculateResult == 'Success') {
                echo json_encode(array('ChangeDiscAmt' => '1'));
            } else {
                echo json_encode(array('ChangeDiscAmt' => '0'));
            }
        } else {
            echo json_encode(array('ChangeDiscAmt' => '0'));
        }
    }
}




//Add Discount Percentage
if (isset($_POST['ChangeDiscPercent']) && !empty($_POST['ChangeDiscPercent']) && !empty($_POST['ChangeDiscPercentRow'])) {

    $ChangeDiscPercent = $_POST['ChangeDiscPercent'];
    $ChangeDiscPercentRow = $_POST['ChangeDiscPercentRow'];

    $FindRateFromTempTable = mysqli_query($con, "SELECT rate,qty,inclusive,igstpercentage FROM $tempPurchaseTable WHERE purchasetempid = '$ChangeDiscPercentRow'");
    foreach ($FindRateFromTempTable as $FindRateFromTempTableResult) {
        $IGSTP = $FindRateFromTempTableResult['igstpercentage'];
        $IsInclusive = $FindRateFromTempTableResult['inclusive'];
        $Rate = $FindRateFromTempTableResult['rate'];
        $QTY = $FindRateFromTempTableResult['qty'];
        // $ProductTotal = $FindRateFromTempTableResult['producttotalamount'];
        // $Amount = $FindRateFromTempTableResult['amount'];
    }


    $Gross = $Rate * $QTY;
    $DiscountResult =  json_decode(CalculateDiscount($Gross, 0, $ChangeDiscPercent));

    //print_r($DiscountResult);
    $DiscPercent = $DiscountResult->DiscountPercentage;
    $DiscountedAmt = $DiscountResult->DiscountedAmount;
    $DiscountAmt = $DiscountResult->DiscountAmount;
    $GrossAmount = $DiscountedAmt;
    $CP = $GrossAmount / $QTY;


    $UpdateDiscountinTable = mysqli_query($con, "UPDATE $tempPurchaseTable SET cp ='$CP',producttotalamount = '$GrossAmount',inddiscountamount = '$DiscountAmt',inddiscountpercentage = '$DiscPercent' WHERE purchasetempid = '$ChangeDiscPercentRow'");
    if ($UpdateDiscountinTable) {

        $TaxChangesResult =  CalculateTax($con, $IsInclusive, $IGSTP, $GrossAmount, $tempPurchaseTable, $ChangeDiscPercentRow);
        if ($TaxChangesResult == 'Success') {
            $CessCalculateResult = CalculateCessAndAdditionalCess($con, $ChangeDiscPercentRow, $tempPurchaseTable);
            if ($CessCalculateResult == 'Success') {
                echo json_encode(array('ChangeDiscPercent' => '1'));
            } else {
                echo json_encode(array('ChangeDiscPercent' => '0'));
            }
        } else {
            echo json_encode(array('ChangeDiscPercent' => '0'));
        }
    }
}



//Change Tax Type
if (isset($_POST['ChangeTaxType']) && !empty($_POST['ChangeTaxTypeRow'])) {

    $ChangeTaxType = $_POST['ChangeTaxType'];
    $ChangeTaxTypeRow = $_POST['ChangeTaxTypeRow'];
    $IsInclusive = $ChangeTaxType;

    $FindRateFromTempTable = mysqli_query($con, "SELECT cp,rate,qty,inddiscountamount,inddiscountpercentage,igstpercentage FROM $tempPurchaseTable WHERE purchasetempid = '$ChangeTaxTypeRow'");
    foreach ($FindRateFromTempTable as $FindRateFromTempTableResult) {
        $IGSTP = $FindRateFromTempTableResult['igstpercentage'];
        $Rate = $FindRateFromTempTableResult['rate'];
        $QTY = $FindRateFromTempTableResult['qty'];
        $CP = $FindRateFromTempTableResult['cp'];
        $DiscPercnt = $FindRateFromTempTableResult['inddiscountpercentage'];
        $DiscAmt = $FindRateFromTempTableResult['inddiscountamount'];
    }

    if ($DiscPercnt > 0 || $DiscAmt > 0) {
        $GrossAmount = $CP * $QTY;
    } else {
        $GrossAmount = $Rate * $QTY;
    }


    $UpdateTaxTypeTable = mysqli_query($con, "UPDATE $tempPurchaseTable SET inclusive = '$ChangeTaxType' WHERE purchasetempid = '$ChangeTaxTypeRow'");
    if ($UpdateTaxTypeTable) {

        $TaxChangesResult =  CalculateTax($con, $IsInclusive, $IGSTP, $GrossAmount, $tempPurchaseTable, $ChangeTaxTypeRow);
        if ($TaxChangesResult == 'Success') {
            $CessCalculateResult = CalculateCessAndAdditionalCess($con, $ChangeTaxTypeRow, $tempPurchaseTable);
            if ($CessCalculateResult == 'Success') {
                echo json_encode(array('ChangeTaxTypeResult' => '1'));
            } else {
                echo json_encode(array('ChangeTaxTypeResult' => '0'));
            }
        } else {
            echo json_encode(array('ChangeTaxTypeResult' => '0'));
        }
    }
}




//Delete Item From Purchase Table
if (isset($_POST['delValue'])) {

    $DeleteItem = $_POST['delValue'];

    $checkEmptyQuery = mysqli_query($con, "SELECT itemid FROM $tempPurchaseTable WHERE purchasetempid = '$DeleteItem'");
    foreach ($checkEmptyQuery as $checkEmptyQueryResult) {
        $ItemId = $checkEmptyQueryResult['itemid'];
    }

    if ($ItemId != 0) {
        $delete_query =  mysqli_query($con, "DELETE FROM $tempPurchaseTable WHERE purchasetempid = '$DeleteItem'");

        if ($delete_query) {
            echo json_encode(array('delStatus' => '1'));
        } else {
            echo json_encode(array('delStatus' => '0'));
        }
    } else {
        echo json_encode(array('delStatus' => '0'));
    }
}



//Find Total of All Amounts
if (isset($_POST['FindTotal'])) {

    $TOTALTAX = 0;
    $TOTALGROSS = 0;
    $TOTALNETWITHOUTROUNDOFF = 0;
    $TOTALCESS = 0;
    $TOTALADDCESS = 0;
    $TOTALOTHERCHARGES = 0;
    $TOTALADDDISCOUNT = 0;

    $FindOtherCharges =  mysqli_query($con, "SELECT SUM(otherchargeamount) FROM purchaseotherchargetemp");
    if (mysqli_num_rows($FindOtherCharges) > 0) {
        foreach ($FindOtherCharges as $FindOtherChargesResult) {
            $OtherCharge  = $FindOtherChargesResult['SUM(otherchargeamount)'];
        }
    } else {
        $OtherCharge = 0;
    }

    $TOTALOTHERCHARGES += $OtherCharge;
    $TOTALNETWITHOUTROUNDOFF += $OtherCharge;

    $FindAddDiscount =  mysqli_query($con, "SELECT SUM(discountamount) FROM purchasediscounttemp");
    if (mysqli_num_rows($FindAddDiscount) > 0) {
        foreach ($FindAddDiscount as $FindAddDiscountResult) {
            $AddDiscount  = $FindAddDiscountResult['SUM(discountamount)'];
        }
    } else {
        $AddDiscount = 0;
    }

    $TOTALADDDISCOUNT += $AddDiscount;
    $TOTALNETWITHOUTROUNDOFF -= $AddDiscount;


    $FindTotal = mysqli_query($con, "SELECT SUM(igstamt) AS TOTALTAX ,SUM(producttotalamount) AS GROSSTOTAL, SUM(cessamount) AS TOTALCESS, SUM(addcessamount) AS TOTALADDCESS FROM purchase_temp_table");
    foreach ($FindTotal as $FindTotalResult) {
        $TOTALTAX += $FindTotalResult['TOTALTAX'];
        $TOTALGROSS += $FindTotalResult['GROSSTOTAL'];
        $TOTALCESS += $FindTotalResult['TOTALCESS'];
        $TOTALADDCESS += $FindTotalResult['TOTALADDCESS'];
    }



    $TOTALNETWITHOUTROUNDOFF += ($TOTALTAX + $TOTALGROSS);
    $TOTALWITHROUND = round($TOTALNETWITHOUTROUNDOFF);
    $ROUNDOFF = round(($TOTALWITHROUND - $TOTALNETWITHOUTROUNDOFF), 1);

    echo json_encode(array('FindTotalStatus' => 1, 'TotalTax' => $TOTALTAX, 'TotalGross' => $TOTALGROSS, 'TotalNet' => $TOTALWITHROUND, 'RoundOff' => $ROUNDOFF, 'TotalNetNoRound' => $TOTALNETWITHOUTROUNDOFF, 'TotalCess' => $TOTALCESS, 'TotalAddCess' => $TOTALADDCESS, 'TotalOtherCharge' => $TOTALOTHERCHARGES, 'TotalAddDiscount' => $TOTALADDDISCOUNT));
}




//Add Other Charge
if (isset($_POST['OtherChargeAmount']) && !empty($_POST['OtherChargeRow'])) {
    $OtherChargeAmount = $_POST['OtherChargeAmount'];
    $OtherChargeRow = $_POST['OtherChargeRow'];

    $UpdateOtherChargeinTable = mysqli_query($con, "UPDATE $tempOtherChargeTable SET otherchargeamount = '$OtherChargeAmount' WHERE otherchargetempid = '$OtherChargeRow'");
    if ($UpdateOtherChargeinTable) {
        echo json_encode(array('addOtherCharge' => '1'));
    } else {
        echo json_encode(array('addOtherCharge' => '2'));
    }
}


//Add Additional Discount
if (isset($_POST['AdditionalDiscountAmount']) && !empty($_POST['AdditionalDiscountRow'])) {
    $AdditionalDiscountAmount = $_POST['AdditionalDiscountAmount'];
    $AdditionalDiscountRow = $_POST['AdditionalDiscountRow'];

    $AdditionalDiscountInTable = mysqli_query($con, "UPDATE $tempAddDiscountTable SET discountamount = '$AdditionalDiscountAmount' WHERE adddiscounttempid = '$AdditionalDiscountRow'");
    if ($AdditionalDiscountInTable) {
        echo json_encode(array('addAdditionalDiscount' => '1'));
    } else {
        echo json_encode(array('addAdditionalDiscount' => '2'));
    }
}




//View Other Charges Table
if (isset($_POST['OtherChargeView'])) {
    $FindAllCharges = mysqli_query($con, "SELECT * FROM purchaseotherchargetemp");
    if (mysqli_num_rows($FindAllCharges) > 0) {
        foreach ($FindAllCharges as $FindAllChargesResult) {
            echo '
            <tr>
                <td>' . $FindAllChargesResult['otherchargename'] . '</td>
                <td><input type="text" data-row="' . $FindAllChargesResult['otherchargetempid'] . '" class="form-control numberInput InputAdjusts ChangeOtherCharge" value="' . $FindAllChargesResult['otherchargeamount'] . '"> </td>
            </tr>';
        }
    }else{
        
    }
}



//View Additional Discount Table
if (isset($_POST['AddDiscountView'])) {
    $FindAllDiscount = mysqli_query($con, "SELECT * FROM purchasediscounttemp");
    if (mysqli_num_rows($FindAllDiscount) > 0) {
        foreach ($FindAllDiscount as $FindAllDiscountResult) {
            echo '
            <tr>
                <td>' . $FindAllDiscountResult['discountname'] . '</td>
                <td><input type="text" data-row="' . $FindAllDiscountResult['adddiscounttempid'] . '" class="form-control numberInput InputAdjusts ChangeAddDiscount" value="' . $FindAllDiscountResult['discountamount'] . '"> </td>
            </tr>';
        }
    }
}





//////////////////////////////////  PURCHASE ENDING \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\







//Add Purchase
if (isset($_POST['PurchaseSupplier']) && !empty($_POST['PurchaseSupplier'])) {

    $Supplier = $_POST['PurchaseSupplier'];
    $Remarks = $_POST['PurchaseRemarks'];
    $InvoiceNo = $_POST['PurchaseInvoice'];
    $InvoiceDate = $_POST['PurchaseInvDate'];
    $LandingDate = $_POST['PurchaseLandDate'];


    mysqli_autocommit($con, FALSE);

    //check if temp table is empty or not
    $check_empty = mysqli_query($con, "SELECT * FROM $tempPurchaseTable");
    if (mysqli_num_rows($check_empty) > 0) {

        $TotalAmountResult = json_decode(FindAllTotalAmounts($con, $tempAddDiscountTable, $tempPurchaseTable, $tempOtherChargeTable));

        $TotalTax = $TotalAmountResult->TotalTax;
        $TotalGross = $TotalAmountResult->TotalGross;
        $TotalNet =  $TotalAmountResult->TotalNet;
        $TotalRoundoff = $TotalAmountResult->RoundOff;
        $TotalCess =  $TotalAmountResult->TotalCess;
        $TotalAddCess =  $TotalAmountResult->TotalAddCess;
        $TotalOthercharge = $TotalAmountResult->TotalOtherCharge;
        $TotalDiscount = $TotalAmountResult->TotalAddDiscount;
        $TotalIndDiscount = $TotalAmountResult->TotalIndDiscount;

        $FetchPurchaseId = mysqli_query($con, "SELECT MAX(purchaseid) FROM purchase");
        foreach ($FetchPurchaseId as $FetchPurchaseIdResults) {
            $PurchaseId = $FetchPurchaseIdResults['MAX(purchaseid)'] + 1;
        }

        //$purchase_id = 'PURCHASE' . '-' . $max_master_id;

        //insert into purchase table
        $InsertIntoPurchaseMain = mysqli_query($con, "INSERT INTO `purchase` (`purchaseid`,`invoiceno`,`invoicedate`,`landingdate`,`supplierid`,`totalinddiscount`,`totalamount`,`totaltaxamount`,`totaldiscount`,`totalothercharge`,`grossamount`,`roundoff`,`netamount`,`totalcess`,`totalAddcess`,`remarks`,`formno`,`fromform`,`createduserid`,`createddate`) VALUES ('$PurchaseId','$InvoiceNo','$InvoiceDate','$LandingDate','$Supplier','$TotalIndDiscount','$TotalNet','$TotalTax','$TotalDiscount','$TotalOthercharge','$TotalGross','$TotalRoundoff','$TotalNet','$TotalCess','$TotalAddCess','$Remarks','0','PU','$userId','$timeNow');
        ");



        if ($InsertIntoPurchaseMain) {

            $FetchFromTempPurchase = mysqli_query($con, "SELECT * FROM $tempPurchaseTable WHERE itemid <> 0");
            $FetchFromTempPurchaseRows = mysqli_num_rows($FetchFromTempPurchase);
            if ($FetchFromTempPurchaseRows > 0) {
                $PurchaseDetailedCounter = 0;
                foreach ($FetchFromTempPurchase as $FetchFromTempPurchaseResults) {

                    $ItemId = $FetchFromTempPurchaseResults['itemid'];
                    $Qty = $FetchFromTempPurchaseResults['qty'];
                    $Rate = $FetchFromTempPurchaseResults['rate'];
                    $Inclusive = $FetchFromTempPurchaseResults['inclusive'];
                    $IndDiscPerc = $FetchFromTempPurchaseResults['inddiscountpercentage'];
                    $IndDiscAmt = $FetchFromTempPurchaseResults['inddiscountamount'];
                    $Cp = $FetchFromTempPurchaseResults['cp'];
                    $ProductTotal = $FetchFromTempPurchaseResults['producttotalamount'];
                    $PurchaseTax = $FetchFromTempPurchaseResults['purchasetax'];
                    $Taxamt = $FetchFromTempPurchaseResults['igstamt'];
                    $Amt = $FetchFromTempPurchaseResults['amount'];
                    $Lc = $FetchFromTempPurchaseResults['lc'];
                    $CGSTPER = $FetchFromTempPurchaseResults['cgstpercentage'];
                    $CGSTAMT = $FetchFromTempPurchaseResults['cgstamt'];
                    $SGSTPER = $FetchFromTempPurchaseResults['sgstpercentage'];
                    $SGSTAMT = $FetchFromTempPurchaseResults['sgstamt'];
                    $IGSTPER = $FetchFromTempPurchaseResults['igstpercentage'];
                    $IGSTAMT = $FetchFromTempPurchaseResults['igstamt'];
                    $CessPerc = $FetchFromTempPurchaseResults['cesspercentage'];
                    $CessAmt = $FetchFromTempPurchaseResults['cessamount'];
                    $Hsn = $FetchFromTempPurchaseResults['hsn'];
                    $AddCessPerc = $FetchFromTempPurchaseResults['addcesspercentage'];
                    $AddCessAmt = $FetchFromTempPurchaseResults['addcessamount'];
                    $Pack = 0;


                    $FindMaxPurchaseDetailed = mysqli_query($con, "SELECT MAX(purchasedetailedid) FROM purchasedetailed");
                    foreach ($FindMaxPurchaseDetailed as $FindMaxPurchaseDetailedResults) {
                        $MaxPurchaseDetailed = $FindMaxPurchaseDetailedResults['MAX(purchasedetailedid)'] + 1;
                    }

                    //insert into purchase detailed
                    $InsertIntoPurchaseDetailed = mysqli_query($con, "INSERT INTO `purchasedetailed` (`purchasedetailedid`,`purchaseid`,`itemid`,`pack`,`qty`,`rate`,`inclusive`,`inddiscountpercentage`,`inddiscountamount`,`cp`,`producttotalamount`,`purchasetax`,`taxamount`,`amount`,`lc`,`CGSTPercentage`,`CGSTAmt`,`SGSTPercentage`,`SGSTAmt`,`IGSTPercentage`,`IGSTAmt`,`cesspercentage`,`cessamount`,`hsn`,`addcesspercentage`,`addcessamount`) VALUES ('$MaxPurchaseDetailed','$PurchaseId','$ItemId','$Pack','$Qty','$Rate','$Inclusive','$IndDiscPerc','$IndDiscAmt','$Cp','$ProductTotal','$PurchaseTax','$Taxamt','$Amt','$Lc','$CGSTPER','$CGSTAMT','$SGSTPER','$SGSTAMT','$IGSTPER','$IGSTAMT','$CessPerc','$CessAmt','$Hsn','$AddCessPerc','$AddCessAmt')");

                    if ($InsertIntoPurchaseDetailed) {
                        if (ChangeInStock($con, $Qty, $ItemId, 'PURCHASE') == 'Success') {
                            $PurchaseDetailedCounter++;
                        }
                    }
                }

                if ($PurchaseDetailedCounter == $FetchFromTempPurchaseRows) {

                    //search for other charges and insert into other charge table
                    $FetchOtherCharges = mysqli_query($con, "SELECT * FROM $tempOtherChargeTable WHERE otherchargeamount > 0");
                    $FetchOtherChargesRow = mysqli_num_rows($FetchOtherCharges);
                    if ($FetchOtherChargesRow > 0) {
                        $FetchOtherChargesCounter = 0;
                        foreach ($FetchOtherCharges as $FetchOtherChargeResult) {
                            $OtherChargeId = $FetchOtherChargeResult['otherchargeid'];
                            $OtherChargeAmt = $FetchOtherChargeResult['otherchargeamount'];

                            $FindMaxPurchaseOtherChargeId = mysqli_query($con, "SELECT MAX(purchaseotherchargeid) FROM purchaseothercharge");
                            foreach ($FindMaxPurchaseOtherChargeId as $FindMaxPurchaseOtherChargeIdResult) {
                                $MaxPurchaseOtherChargeId = $FindMaxPurchaseOtherChargeIdResult['MAX(purchaseotherchargeid)'] + 1;
                            }

                            $InsertPurchaseOtherCharges = mysqli_query($con, "INSERT INTO `purchaseothercharge` (`purchaseotherchargeid`,`purchaseid`,`otherchargeid`,`otherchargeamount`) VALUES ('$MaxPurchaseOtherChargeId','$PurchaseId','$OtherChargeId','$OtherChargeAmt')");

                            if ($InsertPurchaseOtherCharges) {
                                $FetchOtherChargesCounter++;
                            }
                        }
                        if ($FetchOtherChargesCounter == $FetchOtherChargesRow) {

                            //search for additional discount and add in table
                            $FetchAdditionalDiscount = mysqli_query($con, "SELECT * FROM $tempAddDiscountTable WHERE discountamount > 0 ");
                            $FetchAdditionalDiscountRow = mysqli_num_rows($FetchAdditionalDiscount);
                            if ($FetchAdditionalDiscountRow > 0) {
                                $FetchAdditionalDiscountCounter = 0;
                                foreach ($FetchAdditionalDiscount as $FetchAddDiscountResult) {
                                    $AddDiscountId = $FetchAddDiscountResult['discountid'];
                                    $AddDiscountAmt = $FetchAddDiscountResult['discountamount'];

                                    $FindMaxPurchaseAddDiscountId = mysqli_query($con, "SELECT MAX(purchasediscountid) FROM purchasediscount");
                                    foreach ($FindMaxPurchaseAddDiscountId as $FindMaxPurchaseAddDiscountIdResult) {
                                        $MaxPurchaseAddDiscountId = $FindMaxPurchaseAddDiscountIdResult['MAX(purchasediscountid)'] + 1;
                                    }

                                    $InsertPurchaseAdditionalDiscount = mysqli_query($con, "INSERT INTO `purchasediscount` (`purchasediscountid`,`purchaseid`,`discountid`,`discountamount`) VALUES ('$MaxPurchaseAddDiscountId','$PurchaseId','$AddDiscountId','$AddDiscountAmt')");

                                    if ($InsertPurchaseAdditionalDiscount) {
                                        $FetchAdditionalDiscountCounter++;
                                    }
                                }
                                if ($FetchAdditionalDiscountRow == $FetchAdditionalDiscountCounter) {
                                    mysqli_commit($con);
                                    echo json_encode(array('PurchaseSuccess' => 1));
                                }
                            } else {
                                mysqli_commit($con);
                                echo json_encode(array('PurchaseSuccess' => 1));
                            }
                        } else {
                            mysqli_rollback($con);
                            echo json_encode(array('PurchaseSuccess' => 2));
                        }
                    } else {

                        $FetchAdditionalDiscount = mysqli_query($con, "SELECT * FROM $tempAddDiscountTable WHERE discountamount > 0 ");
                        $FetchAdditionalDiscountRow = mysqli_num_rows($FetchAdditionalDiscount);
                        if ($FetchAdditionalDiscountRow > 0) {
                            $FetchAdditionalDiscountCounter = 0;
                            foreach ($FetchAdditionalDiscount as $FetchAddDiscountResult) {
                                $AddDiscountId = $FetchAddDiscountResult['discountid'];
                                $AddDiscountAmt = $FetchAddDiscountResult['discountamount'];

                                $FindMaxPurchaseAddDiscountId = mysqli_query($con, "SELECT MAX(purchasediscountid) FROM purchasediscount");
                                foreach ($FindMaxPurchaseAddDiscountId as $FindMaxPurchaseAddDiscountIdResult) {
                                    $MaxPurchaseAddDiscountId = $FindMaxPurchaseAddDiscountIdResult['MAX(purchasediscountid)'] + 1;
                                }

                                $InsertPurchaseAdditionalDiscount = mysqli_query($con, "INSERT INTO `purchasediscount` (`purchasediscountid`,`purchaseid`,`discountid`,`discountamount`) VALUES ('$MaxPurchaseAddDiscountId','$PurchaseId','$AddDiscountId','$AddDiscountAmt')");

                                if ($InsertPurchaseAdditionalDiscount) {
                                    $FetchAdditionalDiscountCounter++;
                                }
                            }
                            if ($FetchAdditionalDiscountRow == $FetchAdditionalDiscountCounter) {
                                mysqli_commit($con);
                                echo json_encode(array('PurchaseSuccess' => 1));
                            }
                        } else {
                            mysqli_commit($con);
                            echo json_encode(array('PurchaseSuccess' => 1));
                        }
                    }
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('PurchaseSuccess' => 2));
                }
            } else {
                mysqli_rollback($con);
                echo json_encode(array('PurchaseSuccess' => 2));
            }
        } else {
            mysqli_rollback($con);
            echo json_encode(array('PurchaseSuccess' => 2));
        }
    } else {
        echo json_encode(array('PurchaseSuccess' => 0));
    }
}
