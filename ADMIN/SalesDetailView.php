<!doctype html>
<html lang="en">
<?php 


require "../MAIN/Dbconn.php"; 

    $YearBack = date('y');
    $YearNow = date('Y', strtotime('-1 year'));

?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Invoice</title>


    <style>
        body {
            /* width: 21cm; */
            /* height: 29.7cm; */
            margin: 0px 300px;
            height: 100vh;
            box-sizing: border-box;
            /* border: 2px solid black; */
        }

        @media only print {
            body {
            width: 21cm;
            /* height: 29.7cm; */
            /* margin: 0px 300px; */
            margin: 0px 0px;
            height: 100vh;
            box-sizing: border-box;
            /* border: 2px solid black; */
        }
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
                <h6 class="">INVOICE</h6>
                <h1>TECHSTOP</h1>
                <p class="Address">Friendly Outlet, Mudavoorpara Jn,  Vedivechankoil, 695501 <br> Ph: 7594858777, 7594859777 </p>
            </div>
            <div class="text-end">
                <p class="gstin" style="visibility: hidden;">  GSTIN :- 32BBNPN2375J1ZE</p>
            </div>
        </div>

        <?php

        if (isset($_GET['OID'])) {

            $OrderId = $_GET['OID'];

            $FetchInvoiceMain = mysqli_query($con, "SELECT * FROM bill WHERE billid = '$OrderId'");
            while ($FetchInvoiceMainResult = mysqli_fetch_array($FetchInvoiceMain)) {
                $SaleDate = $FetchInvoiceMainResult['billdate'];
                $newDate = date("d-M-Y h:i:s A", strtotime($SaleDate));
        ?>


                <div id="Invoice_details" class="d-flex justify-content-between px-3">

                    <div class="d-block py-3 my-auto">
                        <h5>Invoice to:</h5>
                        <p class="mb-1">
                            <?php echo $FetchInvoiceMainResult['customername'] . '&nbsp;'; ?> , <br> <?php echo $FetchInvoiceMainResult['contactno']; ?> , <br> <?php echo $FetchInvoiceMainResult['address']; ?>
                        </p>
                    </div>

                    <div class="d-block text-end py-3 my-auto">
                        <h5>Invoice No: </h5>
                        <h6 style="font-size: 0.9rem;">TCSP/<?= $FetchInvoiceMainResult['billid'].'/'.$YearNow .'_'.$YearBack ?> </h6>
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
                                <th class="text-end">Disc</th>
                                <th class="text-end">GST%</th>
                                <th class="text-end">GST</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $BillDetailedQuery = mysqli_query($con, "SELECT P.name AS PNAME, P.barcode AS PBARCODE, P.imei AS PIMEI, B.brand_name AS BNAME,BD.qty AS BDQTY,BD.discountamount AS BDDSCNT,BD.salestax AS BDTAXP,BD.igstamt AS BDTAX,BD.rate AS BDAMT, BD.gross AS BDGROSS,BD.amount AS BDTOTAL FROM billdetailed BD INNER JOIN products P ON BD.itemid = P.pr_id INNER JOIN brands B ON P.brand = B.br_id WHERE BD.billid = '$OrderId'");
                            $Counter = 0;
                            foreach ($BillDetailedQuery as $BillDetailedQueryResult) {
                                $Counter++;
                            ?>
                                <tr>
                                    <td><?= $Counter; ?></td>
                                    <td>
                                        <?php
                                            echo $BillDetailedQueryResult['BNAME'] . '&nbsp;' . $BillDetailedQueryResult['PNAME'] .'</br>'; 
                                            if($BillDetailedQueryResult['PIMEI'] != 0){ echo 'IMEI : '. $BillDetailedQueryResult['PIMEI'] ; }
                                        ?>
                                    </td>
                                    <td class="text-end"><?php echo number_format($BillDetailedQueryResult['BDQTY']); ?></td>
                                    <td class="text-end"><?php echo number_format($BillDetailedQueryResult['BDAMT'], '2', '.', ','); ?></td>
                                    <td class="text-end"><?php echo number_format($BillDetailedQueryResult['BDGROSS'], '2', '.', ','); ?> </td>
                                    <td class="text-end"><?php echo number_format($BillDetailedQueryResult['BDDSCNT'], '2', '.', ','); ?></td>
                                    <td class="text-end"><?php echo number_format($BillDetailedQueryResult['BDTAXP'], '0', '.', ','); ?> %</td>
                                    <td class="text-end"><?php echo number_format($BillDetailedQueryResult['BDTAX'], '2', '.', ','); ?> </td>
                                    <td class="text-end"><?php echo number_format($BillDetailedQueryResult['BDTOTAL'], '2', '.', ','); ?> </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>


                <div class="d-flex justify-content-between px-3">

                    <div class="d-block pt-3">
                        <!-- <div>
                            <h6 class="text-muted"><i>Thank You, Visit Again</i></h6>
                        </div> -->
                        <!-- <div class="pt-2">
                            <h6>Payment Details:</h6>
                            <h6 style="font-size: 0.8rem;"> CASH <?php // echo $FetchInvoiceMainResult['payment_mode'];
                                                                    ?></h6>
                        </div> -->
                        <!-- <div class="pt-3">
                            <h6>Terms and Conditions</h6>
                            <p style="font-size: 0.8rem; max-width: 300px;">
                              
                            </p>
                        </div> -->
                    </div>

                    <div class="mt-3">
                            <?php 
                                $FindTaxSplit = mysqli_query($con, "SELECT SUM(cgstamt) AS CGSTAMT, SUM(sgstamt) AS SGSTAMT  FROM billdetailed WHERE billid = '$OrderId'");
                                foreach($FindTaxSplit as $FindTaxSplitResult){
                                    $CGST = $FindTaxSplitResult['CGSTAMT'];
                                    $SGST = $FindTaxSplitResult['SGSTAMT'];
                                }
                            ?>
                        <h6> <?php if($FetchInvoiceMainResult['totaldiscount'] > 0){ echo 'Your Total Discount  :-  ₹ '.number_format($FetchInvoiceMainResult['totaldiscount'], '2', '.', ',');  }else{ } ?>  </h6>

                        
                    </div>

                    <div class="d-block pt-3">
                        <table>
                            <thead>
                                <tr>
                                    <th>Subtotal : </th>
                                    <th class="text-end"><?php echo number_format($FetchInvoiceMainResult['grossamount'], '2', '.', ','); ?></th>
                                </tr>
                                <!-- <tr style=" border-bottom: 2px solid #f50414;">
                                    <th>Tax : </th>
                                    <th class="text-end"><?php echo number_format($FetchInvoiceMainResult['totaltaxamount'], '2', '.', ','); ?></th>
                                </tr> -->
                                <tr>
                                    <th>SGST : </th>
                                    <th class="text-end"><?php echo number_format( $SGST, '2', '.', ','); ?></th>
                                </tr>
                                <tr style=" border-bottom: 2px solid #f50414;">
                                    <th>CGST : </th>
                                    <th class="text-end"><?php echo number_format( $CGST, '2', '.', ','); ?></th>
                                </tr>
                                <!-- <tr >
                                    <th>Discount : </th>
                                    <th class="text-end"><?php echo number_format($FetchInvoiceMainResult['totaldiscount'], '2', '.', ','); ?></th>
                                </tr> -->
                                <tr>
                                    <th style="font-size: 1.3rem;">Total : </th>
                                    <th style="font-size: 1.3rem;" class="text-end"><?php echo number_format($FetchInvoiceMainResult['netamount'], '2', '.', ','); ?></th>
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
        // window.onload = (event) => {
        //     window.print();
        // };
      
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