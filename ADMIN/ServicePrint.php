<!doctype html>
<html lang="en">
<?php 


require "../MAIN/Dbconn.php"; 
require "./CommonFunctions.php"; 

    $YearBack = date('y');
    $YearNow = date('Y', strtotime('-1 year'));

?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Service Invoice</title>


    <style>
        body {
            width: 21cm;
            /* height: 29.7cm; */
            height: 100vh;
            box-sizing: border-box;
            /* border: 2px solid black; */
        }

        #Head {
            background-color: white;
            height: 130px;
            border-bottom: 3px solid #f50414;
        }

        #Head img {
            height: 100px;
            width: 100px;
            object-fit: contain;
        }

        #Head h1 {
            color: #f50414;
            font-weight: 700;
        }
              
        #Head .Address{
            font-size: 13px;
        }
        #Head .gstin{
            margin-top: 90px;
        }
        #Invoice_details {
            border-bottom: 3px solid #f50414;
        }

        #Invoice_details p {
            font-weight: 500;
            font-size: 0.8rem;
        }

        #Table_main {
            border-bottom: 3px solid #f50414;
        }

        .table {
            border-collapse: collapse;
        }

        .table thead th {
            padding: 10px 0px;
            border-bottom: 1px solid black;
        }

        .table tbody td {
            padding: 10px 0px;
        }
    </style>

    
</head>

<body>


    <div class="container-fluid">

        <!-- <div id="Head" class="d-flex justify-content-between px-3">
            <div class="">
                <img src="/IMAGES/logo-png.png" alt="">
                <h1>TECHSTOP</h1>
                <p class="Address">Friendly Outlet, Mudavoorpara Jn, <br>  Vedivechankoil, 695501 <br> Ph: 7594858777, 7594859777 </p>
            </div>
            <div class="text-end">
                <h2 class="">INVOICE</h2>
                <p class="gstin"> GSTIN :- 32BBNPN2375J1ZE</p>
            </div>
        </div> -->

        <div id="Head" class="d-flex justify-content-between">
            <div class="text-end">
                <p class="gstin"> GSTIN :- 32BBNPN2375J1ZE</p>
            </div>
            <div class="text-center">
                <h6 class="">SERVICE INVOICE</h6>
                <h1>TECHSTOP</h1>
                <p class="Address">Friendly Outlet, Mudavoorpara Jn,  Vedivechankoil, 695501 <br> Ph: 7594858777, 7594859777 </p>
            </div>
            <div class="text-end">
                <p class="gstin" style="visibility: hidden;">  GSTIN :- 32BBNPN2375J1ZE</p>
            </div>
        </div>

        <?php

        if (isset($_GET['SOID'])) {

            $OrderId = $_GET['SOID'];

            $FetchInvoiceMain = mysqli_query($con, "SELECT * FROM servicebill WHERE serviceBillId = '$OrderId'");
            while ($FetchInvoiceMainResult = mysqli_fetch_array($FetchInvoiceMain)) {
                $SaleDate = $FetchInvoiceMainResult['createdDate'];
                $newDate = date("d-M-Y h:i:s A", strtotime($SaleDate));
                ?>


                <div id="Invoice_details" class="d-flex justify-content-between px-3">

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



                <div id="Table_main" class="px-2">
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
                                    <td class="text-end"><?= $BillDetailedQueryResult['qty']; ?></td>
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


                <div class="d-flex justify-content-between px-3">

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
                                    <th class="text-end"><?php echo number_format($FetchInvoiceMainResult['totaltaxamount'], '2', '.', ','); ?></th>
                                </tr> -->
                                <tr>
                                    <th>SGST : </th>
                                    <th class="text-end"><?=  MoneyFormatIndia($SGST); ?></th>
                                </tr>
                                <tr style=" border-bottom: 2px solid #f50414;">
                                    <th>CGST : </th>
                                    <th class="text-end"><?=  MoneyFormatIndia($CGST); ?></th>
                                </tr>
                                <!-- <tr >
                                    <th>Discount : </th>
                                    <th class="text-end"><?php echo number_format($FetchInvoiceMainResult['totaldiscount'], '2', '.', ','); ?></th>
                                </tr> -->
                                <tr>
                                    <th style="font-size: 1.3rem;">Total : </th>
                                    <th style="font-size: 1.3rem;" class="text-end"><?= MoneyFormatIndia($FetchInvoiceMainResult['totalAmount']); ?></th>
                                </tr>
                            </thead>
                        </table>

                        <h6 class="mt-5"> Authorized Signatory </h6>

                    </div>

                </div>

                <div>
                    <h5 class="text-muted text-center" ><i>Thank You, Visit Again</i></h5>
                </div>


                <?php
            }
        }
        ?>


    </div>


    <script>
        window.onload = (event) => {
            window.print();
        };
    </script>




    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>