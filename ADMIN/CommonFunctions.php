<?php

require "../MAIN/Dbconn.php";


    //Santize the the string and change to uppercase
    function SanitizeInput($input)
    {
        $input = trim($input);
        $input = htmlspecialchars($input);
        $input = stripslashes($input);
        return $input;
    }


    //sanitize the input integer
    function SanitizeInt($intinput)
    {
        $intinput = trim($intinput);
        $intinput = htmlspecialchars($intinput);
        $intinput = stripslashes($intinput);
        $intinput = filter_var($intinput, FILTER_SANITIZE_NUMBER_INT);
        return $intinput;
    }

    //sanitize the decimal
    function SanitizeFloat($floatinput)
    {
        $floatinput = trim($floatinput);
        $floatinput = htmlspecialchars($floatinput);
        $floatinput = stripslashes($floatinput);
        $floatinput = filter_var($floatinput, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        return $floatinput;
    }


    //Change stock while purchase
    function ChangeInStock($connstring, $qty, $itemid, $stockchangetype)
    {

        $ConnString = $connstring;
        $Qty = $qty;
        $ItemId = $itemid;
        $StockChangeType = $stockchangetype;


        $FindParentItemId = mysqli_query($ConnString, "SELECT parent_item_id FROM products WHERE pr_id = '$ItemId'");
        foreach ($FindParentItemId as $FindParentItemIdResult) {
            $ParentItemId = $FindParentItemIdResult['parent_item_id'];
        }


        if ($StockChangeType == 'PURCHASE') {
            $ChangeStockResult = mysqli_query($connstring, "UPDATE products SET purchased_qty = purchased_qty + $Qty WHERE parent_item_id = '$ParentItemId'");
        } elseif ($StockChangeType == 'SALES') {
            $ChangeStockResult = mysqli_query($connstring, "UPDATE products SET sold_qty = sold_qty + $Qty, current_stock = current_stock + $Qty  WHERE pr_id = '$ItemId'");
        }elseif ($StockChangeType == 'ONLINE SALES') {
            $ChangeStockResult = mysqli_query($connstring, "UPDATE products SET online_stock = online_stock + $Qty WHERE pr_id = '$ItemId'");
        }

        if ($ChangeStockResult) {
            return "Success";
        } else {
            return "Failed";
        }
    }



    function CalculateIncTax($igst, $Total)
    {
        $IGST = floatval($igst);
        $CGST = floatval($igst / 2.00);
        $SGST = floatval($igst / 2.00);
        $Total = $Total;

        $IGSTMutliplier = ($IGST + 100) / 100;
        //$CGSTMutliplier = ($CGST + 100) / 100;
        //$SGSTMutliplier = ($SGST + 100) / 100;

        $IGSTAmt = round(($Total - ($Total / $IGSTMutliplier)), 3);
        //$CGSTAmt = round(($Total - ($Total / $CGSTMutliplier)), 3);
        //$SGSTAmt = round(($Total - ($Total / $SGSTMutliplier)), 3);
        $CGSTAmt = round(($IGSTAmt / 2), 3);
        $SGSTAmt = round(($IGSTAmt / 2), 3);
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
    function CalculateTax($ConnString, $IsInclusive, $IGST, $GrossAmount, $tempPurchaseTable, $RowId, $UserId)
    {
        $UserId = $UserId;
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

            $UpdateValuesInTable = mysqli_query($ConnString, "UPDATE $tempPurchaseTable SET `cgstpercentage`='$InclCGST',`cgstamt`='$InclCGSTAmt',`sgstpercentage`='$InclSGST',`sgstamt`='$InclSGSTAmt',`igstpercentage`='$InclIGST',`igstamt`='$InclIGSTAmt',`producttotalamount`= '$InclGrossAmt',`amount`= '$GrossAmount' WHERE cart_id = '$RowId' AND userId = '$UserId'");

            if ($UpdateValuesInTable) {
                return 'Success';
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

            $UpdateValuesInTable = mysqli_query($ConnString, "UPDATE $tempPurchaseTable SET `cgstpercentage`='$ExclCGST',`cgstamt`='$ExclCGSTAmt',`sgstpercentage`='$ExclSGST',`sgstamt`='$ExclSGSTAmt',`igstpercentage`='$ExclIGST',`igstamt`='$ExclIGSTAmt',`producttotalamount`= '$ExclGrossAmt',`amount`= '$ExclTotalAmt' WHERE cart_id = '$RowId' AND userId = '$UserId'");

            if ($UpdateValuesInTable) {
                return 'Success';
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
    function CalculateCessAndAdditionalCess($connstring, $itemid, $temppurchasetable, $UserId)
    {

        $UserId = $UserId;
        $ConnString = $connstring;
        $ItemId = $itemid;
        $tempPurchaseTable = $temppurchasetable;
        $FindItemCessAndAdditionalCess = mysqli_query($ConnString, "SELECT cesspercentage,addcesspercentage,producttotalamount FROM $tempPurchaseTable WHERE cart_id = '$ItemId' AND userId = '$UserId'");
        foreach ($FindItemCessAndAdditionalCess as $FindItemCessAndAdditionalCessResult) {
            $CessPerc = $FindItemCessAndAdditionalCessResult['cesspercentage'];
            $AddCessPerc = $FindItemCessAndAdditionalCessResult['addcesspercentage'];
            $Gross = $FindItemCessAndAdditionalCessResult['producttotalamount'];
        }

        $CalculatedCess = json_decode(CalculateExcTax($CessPerc, $Gross))->IGSTAmt;
        $CalculatedAdditionalCess = json_decode(CalculateExcTax($AddCessPerc, $Gross))->IGSTAmt;

        $UpdateCessAmounts = mysqli_query($ConnString, "UPDATE $tempPurchaseTable SET cessamount = '$CalculatedCess' , addcessamount = '$CalculatedAdditionalCess' WHERE cart_id = '$ItemId' AND userId = '$UserId'");
        if ($UpdateCessAmounts) {
            return "Success";
        } else {
            return "Failed";
        }
        //return $CalculatedCess.'-'.$CalculatedAdditionalCess;

    }



    //Find Totals of all Amounts
    function FindAllTotalAmounts($connstring, $temppurchasetable, $UserId , $CartAction = 'ADD')
    {

        $UserId = $UserId;
        $Connstring = $connstring;
        //$TempAddDiscountTable = $tempadddiscounttable;
        $TempPurchaseTable = $temppurchasetable;
        //$TempOtherChargeTable = $tempotherchargetable;

        $TOTALQTY = 0;
        $TOTALTAX = 0;
        $TOTALGROSS = 0;
        $TOTALNETWITHOUTROUNDOFF = 0;
        $TOTALCESS = 0;
        $TOTALADDCESS = 0;
        $TOTALOTHERCHARGES = 0;
        $TOTALADDDISCOUNT = 0;
        $TOTALINDDISCOUNT = 0;
        $TOTALSGST = 0;
        $TOTALCGST = 0;

        // $FindOtherCharges =  mysqli_query($Connstring, "SELECT SUM(otherchargeamount) FROM $TempOtherChargeTable");
        // if (mysqli_num_rows($FindOtherCharges) > 0) {
        //     foreach ($FindOtherCharges as $FindOtherChargesResult) {
        //         $OtherCharge  = $FindOtherChargesResult['SUM(otherchargeamount)'];
        //     }
        // } else {
        //     $OtherCharge = 0;
        // }

        // $TOTALOTHERCHARGES += $OtherCharge;
        // $TOTALNETWITHOUTROUNDOFF += $OtherCharge;

        // $FindAddDiscount =  mysqli_query($Connstring, "SELECT SUM(discountamount) FROM $TempAddDiscountTable");
        // if (mysqli_num_rows($FindAddDiscount) > 0) {
        //     foreach ($FindAddDiscount as $FindAddDiscountResult) {
        //         $AddDiscount  = $FindAddDiscountResult['SUM(discountamount)'];
        //     }
        // } else {
        //     $AddDiscount = 0;
        // }

        // $TOTALADDDISCOUNT += $AddDiscount;
        // $TOTALNETWITHOUTROUNDOFF -= $AddDiscount;


        $FindTotal = mysqli_query($Connstring, "SELECT SUM(quantity) AS TOTALQTY, SUM(SGSTAmt) AS TOTALSGST, SUM(CGSTAmt) AS TOTALCGST, SUM(igstamt) AS TOTALTAX ,SUM(producttotalamount) AS GROSSTOTAL, SUM(cessamount) AS TOTALCESS, SUM(addcessamount) AS TOTALADDCESS, SUM(inddiscountamount) AS TOTALINDDISC FROM $TempPurchaseTable WHERE userId = '$UserId' AND cartAction = '$CartAction'");
        foreach ($FindTotal as $FindTotalResult) {
            $TOTALTAX += $FindTotalResult['TOTALTAX'];
            $TOTALGROSS += $FindTotalResult['GROSSTOTAL'];
            $TOTALCESS += $FindTotalResult['TOTALCESS'];
            $TOTALADDCESS += $FindTotalResult['TOTALADDCESS'];
            $TOTALINDDISCOUNT += $FindTotalResult['TOTALINDDISC'];
            $TOTALSGST += $FindTotalResult['TOTALSGST'];
            $TOTALCGST += $FindTotalResult['TOTALCGST'];
            $TOTALQTY += $FindTotalResult['TOTALQTY'];
        }



        $TOTALNETWITHOUTROUNDOFF += ($TOTALTAX + $TOTALGROSS);
        $TOTALWITHROUND = round($TOTALNETWITHOUTROUNDOFF);
        $ROUNDOFF = round(($TOTALWITHROUND - $TOTALNETWITHOUTROUNDOFF), 1);

        return json_encode(array('FindTotalStatus' => 1, 'TotalQty' => $TOTALQTY, 'TotalTax' => $TOTALTAX, 'TotalCgst' => $TOTALCGST, 'TotalSgst' => $TOTALSGST, 'TotalGross' => $TOTALGROSS, 'TotalNet' => $TOTALWITHROUND, 'RoundOff' => $ROUNDOFF, 'TotalNetNoRound' => $TOTALNETWITHOUTROUNDOFF, 'TotalCess' => $TOTALCESS, 'TotalAddCess' => $TOTALADDCESS, 'TotalOtherCharge' => $TOTALOTHERCHARGES, 'TotalAddDiscount' => $TOTALADDDISCOUNT, 'TotalIndDiscount' => $TOTALINDDISCOUNT));
    }


    function MoneyFormatIndia($number){
        $decimal = (string)($number - floor($number));
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);

        for($i=0;$i<$length;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
                $delimiter .=',';
            }
            $delimiter .=$money[$i];
        }

        $result = strrev($delimiter);
        $decimal = preg_replace("/0\./i", ".", $decimal);
        $decimal = substr($decimal, 0, 3);

        if( $decimal != '0'){
            $result = $result.$decimal;
        }

        return $result;
    }


    //echo MoneyFormatIndia(300000.094);

