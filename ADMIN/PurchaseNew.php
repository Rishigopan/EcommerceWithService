<?php

include '../MAIN/Dbconn.php';


if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

    if ($_COOKIE['custtypecookie'] == 'executive' || $_COOKIE['custtypecookie'] == 'admin') {
        echo "";
    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}
$PageTitle = 'Purchase';

?>




<!doctype html>
<html lang="en">


<head>


    <?php

    require "../MAIN/Header.php";

    ?>

    <style>
        .itemInput {
            min-width: 300px;
            border: none;
            background-color: transparent;
            box-shadow: none !important;
        }

        .numberInput {
            min-width: 120px;
            text-align: end;
            border: none;
            background-color: transparent;
            box-shadow: none !important;
        }

        #PurchaseTable .tpadd {
            padding: 13px;
        }

        table tbody {
            background-color: rgb(255, 255, 255) !important;
        }

        table.dataTable .sorting {
            background-color: rgb(235, 233, 233) !important;
        }

        .tableSub {
            max-height: 100px;
        }

        .purchase_main label {
            font-weight: 500;
        }

        .purchase_main .purchase_main_right input {
            border: none;
            border-bottom: 1px solid lightgray;
            box-shadow: none;
            border-radius: 0;
        }

        /* width */

        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        /* Track */

        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px lightgray;
            border-radius: 30px;
        }

        /* Handle */

        ::-webkit-scrollbar-thumb {
            background: grey;
            border-radius: 10px;
        }

        /* Handle on hover */

        ::-webkit-scrollbar-thumb:hover {
            background: rgb(98, 98, 98);
        }

        .purchase_sub table thead {
            background-color: rgb(235, 233, 233);
            position: sticky;
            top: 0;
        }

        .Purchase_details .netamount label {
            margin-top: 12px;
            font-size: 20px;
            font-weight: 700;
        }

        .Purchase_details .netamount input {
            font-size: 26px;
            padding: 15px 0px;
            font-weight: 700;
        }

        #NetAmount {
            background-color: lightgray;
            color: red;
        }

        .controldiv {
            width: 100%;
            position: fixed;
            bottom: 0;
            padding: 15px 30px;
            background-color: rgb(244, 242, 242);
        }

        .controldiv .btn_save {
            background-color: red;
            border-radius: 10px;
            padding: 10px 30px;
            color: white;
            font-weight: 600;
        }

        .controldiv .btn_clear {
            background-color: rgb(179, 179, 179);
            border-radius: 10px;
            padding: 10px 30px;
            color: white;
            font-weight: 600;
        }
    </style>

</head>






<body class="" style="background-color: #eeeeee;">






    <div class="wrapper">

        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5>Purchase</h5>
                </a>
                <a href="../profile.php">
                    <i class="material-icons">account_circle</i>
                </a>
            </div>
        </nav>


        <!--SIDEBAR-->
        <?php

        include '../MAIN/Sidebar.php';

        ?>


        <!--CONTENT-->
        <div id="Content" class="mb-5">

            <div class="container-fluid main_container">

                <form class="" id="PurchaseForm">

                    <div class="row justify-content-between purchase_main">
                        <div class="col-3">
                            <div class="mb-2 row">
                                <label for="purchase_supplier" class="col-sm-3 col-form-label">Supplier</label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="PurchaseSupplier" id="purchase_supplier">
                                        <option selected value="">Choose</option>
                                        <option value="1">Rajesh</option>
                                    </select>
                                </div>
                            </div>
                            <div class=" row">
                                <label for="purchase_remarks" class="col-sm-3 col-form-label">Remarks</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="purchase_remarks" name="PurchaseRemarks">
                                </div>
                            </div>
                        </div>
                        <div class="col-3 purchase_main_right">
                            <div class="mb-2 row">
                                <label for="purchase_invoice" class="col-sm-3 col-form-label">Invoice No</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="purchase_invoice" name="PurchaseInvoice">
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label for="purchase_inv_date" class="col-sm-3 col-form-label">Inv Date</label>
                                <div class="col-sm-9">
                                    <input type="datetime-local" class="form-control" id="purchase_inv_date" name="PurchaseInvDate">
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label for="" class="col-sm-3 col-form-label">Land Date</label>
                                <div class="col-sm-9">
                                    <input type="datetime-local" class="form-control" id="purchase_land_date" name="PurchaseLandDate">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row controldiv">
                        <div class="d-flex justify-content-end">
                            <button type="button" id="ClearAllButton" class="btn btn_clear me-5">Clear</button>
                            <button type="submit" class="btn btn_save">Save</button>
                        </div>
                    </div>


                </form>




                <div class="mt-2 tableDiv">

                    <table class="table table-bordered" id="PurchaseTable">
                        <thead class="text-nowrap">
                            <tr>
                                <th></th>
                                <th>No</th>
                                <th>Barcode</th>
                                <th>Item</th>
                                <th>Code</th>
                                <th>Qty</th>
                                <th>Wastage Qty</th>
                                <th>Unit</th>
                                <th>Pieces</th>
                                <th>Rate</th>
                                <th>Inc</th>
                                <th>Disc %</th>
                                <th>Disc Amt</th>
                                <th>CP</th>
                                <th>LC</th>
                                <th>Gross</th>
                                <th>Tax %</th>
                                <th>Tax Amt</th>
                                <th>Amount</th>
                                <th>MRP</th>
                                <th>Cess %</th>
                                <th>Cess Amt</th>
                                <th>AddCess %</th>
                                <th>AddCess Amt</th>
                                <th>Batch</th>
                                <th>Exp Date</th>
                                <th>SP</th>
                                <th>Sales Tax %</th>
                                <th>HSN</th>
                            </tr>
                        </thead>

                        <tbody class="text-nowrap">



                        </tbody>
                    </table>


                </div>



                <div class="mt-4 row  purchase_sub">

                    <div class="col-3">

                        <div class="table-responsive col-12 tableSub">
                            <table class="table table-bordered text-nowrap" id="AdditionalDiscountTable">
                                <thead>
                                    <tr>
                                        <th>Discount</th>
                                        <th>Amount</th>
                                        <!-- <th>Amount %</th> -->
                                    </tr>
                                </thead>
                                <tbody id="AdditionalDiscountBody">

                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive mt-4 col-12 tableSub">
                            <table class="table table-bordered text-nowrap" id="OtherChargeTable">
                                <thead>
                                    <tr>
                                        <th>Other Charge</th>
                                        <th>Amount</th>
                                        <!-- <th>Amount %</th> -->
                                    </tr>
                                </thead>
                                <tbody id="OtherChargeBody">

                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="col-9 Purchase_details">

                        <div class="row">

                            <div class="col-4">
                                <div class="row">
                                    <div class="col-5">
                                        <h6>Gross Amount</h6>
                                    </div>
                                    <div class="col-1">
                                        <h6>:</h6>
                                    </div>
                                    <div class="col-5">
                                        <h6 id="GrossAmountShow">0</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <h6>Total Tax Amount</h6>
                                    </div>
                                    <div class="col-1">
                                        <h6>:</h6>
                                    </div>
                                    <div class="col-5">
                                        <h6 id="GrossTotalAmount">0</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <h6>Total Cess</h6>
                                    </div>
                                    <div class="col-1">
                                        <h6>:</h6>
                                    </div>
                                    <div class="col-5">
                                        <h6 id="TotalCessAmount">0</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <h6> Total Add. Cess</h6>
                                    </div>
                                    <div class="col-1">
                                        <h6>:</h6>
                                    </div>
                                    <div class="col-5">
                                        <h6 id="TotalAddCessAmount">0</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="row">
                                    <div class="col-5">
                                        <h6>Total Other Charge</h6>
                                    </div>
                                    <div class="col-1">
                                        <h6>:</h6>
                                    </div>
                                    <div class="col-5">
                                        <h6 id="TotalOtherCharges">0</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <h6>Total Discount</h6>
                                    </div>
                                    <div class="col-1">
                                        <h6> : </h6>
                                    </div>
                                    <div class="col-5">
                                        <h6 id="TotalAddDiscount">0</h6>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row justify-content-end">

                            <div class="col-6">
                                <div class="mb-2 row">
                                    <label for="" class="col-sm-4 col-form-label"> <strong>Round off</strong> </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="0" id="RoundOff">
                                    </div>
                                </div>
                                <div class="mb-2 row netamount">
                                    <label for="inputPassword" class="col-sm-4 col-form-label"> <strong>Net Amount</strong> </label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control text-center" value="0.000" id="NetAmount">
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </div>


    </div>


    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>





    <script>
        $(document).ready(function() {

            FindTotals();
            ShowOtherCharge();
            ShowAddDiscount();

            //Find All totals
            function FindTotals() {
                var FindTotal = 'TotalFetch';
                $.ajax({
                    type: "POST",
                    url: "PurchaseOperations.php",
                    data: {
                        FindTotal: FindTotal
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var TotalResponse = JSON.parse(data);
                        if (TotalResponse.FindTotalStatus == "1") {
                            $('#GrossAmountShow').text(TotalResponse.TotalGross);
                            $('#GrossTotalAmount').text(TotalResponse.TotalTax);
                            $('#NetAmount').val(TotalResponse.TotalNet);
                            $('#RoundOff').val(TotalResponse.RoundOff);
                            $('#TotalCessAmount').text(TotalResponse.TotalCess);
                            $('#TotalAddCessAmount').text(TotalResponse.TotalAddCess);
                            $('#TotalOtherCharges').text(TotalResponse.TotalOtherCharge);
                            $('#TotalAddDiscount').text(TotalResponse.TotalAddDiscount);
                        } else if (TotalResponse.FindTotalStatus == "2") {


                        } else {
                            toastr.error("Some Error Occured");
                        }
                    }

                });
            }

            //Show other charge table
            function ShowOtherCharge() {
                var OtherChargeView = 'chargetablefetch';
                $.ajax({
                    type: "POST",
                    url: "PurchaseOperations.php",
                    data: {
                        OtherChargeView: OtherChargeView
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        $('#OtherChargeBody').html(data);
                    }
                });
            }

            //show additional discount
            function ShowAddDiscount() {
                var AddDiscountView = 'discounttablefetch';
                $.ajax({
                    type: "POST",
                    url: "PurchaseOperations.php",
                    data: {
                        AddDiscountView: AddDiscountView
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        $('#AdditionalDiscountBody').html(data);
                    }
                });
            }


            //function to delete all datas
            function DeleteAll() {
                var delAll = 'deleteAll';
                $.ajax({
                    type: "POST",
                    url: "PurchaseOperations.php",
                    data: {
                        delAll: delAll
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var response = JSON.parse(data);
                        if (response.delAllStatus == "0") {
                            toastr.error("Failed Deleting All");
                        } else if (response.delAllStatus == "1") {
                            PurchaseTable.ajax.reload(null, false);
                            FindTotals();
                            ShowOtherCharge();
                            ShowAddDiscount();
                            toastr.success("Successfully Deleted All");
                        } else {
                            toastr.error("Some Error Occured");
                        }
                    }
                });
            }

            //purchase table
            var PurchaseTable = $('#PurchaseTable').DataTable({
                "processing": true,
                "ajax": "PurchaseNewData.php",
                "scrollY": "265px",
                "scrollX": true,
                "fixedColumns": {
                    left: 7
                },
                "scrollCollapse": true,
                "fixedHeader": true,
                "dom": 'rt',
                "language": {
                    "paginate": {
                        "previous": "<i class='bi bi-caret-left-fill'></i>",
                        "next": "<i class='bi bi-caret-right-fill'></i>"
                    }
                },
                "columns": [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return '<button class="btn btn-danger p-1 delete_btn" value="' + data.purchasetempid + '"> <i class="text-white bx bxs-trash"></i> </button>';
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'itembarcode',
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            data = '<select data-row="' + data.purchasetempid + '" class="form-select SelectItem itemInput"> <option value="" > ' + data.itemname + ' </option>  <?php $findItems = mysqli_query($con, "SELECT * FROM products");
                                                                                                                                                                                    foreach ($findItems as $findItemsResult) { ?>  <option value="<?= $findItemsResult["pr_id"] ?>" > <?= $findItemsResult["name"] ?>  </option>  <?php } ?>    </select>';
                            return data;
                        }
                    },
                    {
                        data: 'itemcode',
                        "visible":false
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            data = '<input data-row="' + data.purchasetempid + '" class="form-control changeQty numberInput" type="number" value="' + data.qty + '">';
                            return data;
                        }
                    },
                    {
                        data: 'wasqty',
                        "visible":false
                    },
                    {
                        data: 'itemunit',
                        "visible":false
                    },
                    {
                        data: 'pieces',
                        "visible":false
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            data = '<input data-row="' + data.purchasetempid + '" class="form-control changeRate numberInput" type="number" value="' + data.rate + '">';
                            return data;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            if (data.inclusive == 1) {
                                NewData = '<input data-row="' + data.purchasetempid + '" class="changeTaxType" type="checkbox" value="' + data.inclusive + '" checked>';
                            } else {
                                NewData = '<input data-row="' + data.purchasetempid + '" class="changeTaxType" type="checkbox" value="' + data.inclusive + '">';
                            }
                            return NewData;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            data = '<input data-row="' + data.purchasetempid + '" class="form-control changeDiscPercent numberInput" type="number" value="' + data.inddiscountpercentage + '">';
                            return data;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            data = '<input data-row="' + data.purchasetempid + '" class="form-control changeDiscAmt numberInput" type="number" value="' + data.inddiscountamount + '">';
                            return data;
                        }
                    },
                    {
                        data: 'cp',
                        
                    },
                    {
                        data: 'lc',
                        "visible":false
                    },
                    {
                        data: 'producttotalamount',
                    },
                    {
                        data: 'igstpercentage',
                    },
                    {
                        data: 'igstamt',
                    },
                    {
                        data: 'amount',
                    },
                    {
                        data: 'mrp',
                    },
                    {
                        data: 'cesspercentage',
                    },
                    {
                        data: 'cessamount',
                    },
                    {
                        data: 'addcesspercentage',
                        "visible":false
                    },
                    {
                        data: 'addcessamount',
                        "visible":false
                    },
                    {
                        data: 'batch',
                        "visible":false
                    },
                    {
                        data: 'expdate',
                        "visible":false
                    },
                    {
                        data: 'sp',
                    },
                    {
                        data: 'salestax',
                    },
                    {
                        data: 'hsn',
                    },
                ]

            });


            //Delete all items from cart
            $('#PurchaseForm').on('click', '#ClearAllButton', function() {
                let confirmation = window.confirm("Do you want to clear this Purchase?");
                if (confirmation == true) {
                    DeleteAll();
                }else{

                }
            });


            //add item in table
            $('#PurchaseTable').on('change', '.SelectItem', (function() {
                var itemAddId = $(this).val();
                var AddItemRow = $(this).data("row");
                console.log(itemAddId);
                console.log(AddItemRow);
                $.ajax({
                    type: "POST",
                    url: "PurchaseOperations.php",
                    data: {
                        itemAddId: itemAddId,
                        AddItemRow: AddItemRow
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var response = JSON.parse(data);
                        if (response.addItem == "1") {
                            toastr.success("Product Added Successfully");
                            PurchaseTable.ajax.reload(null, false);
                            FindTotals();
                        } else if (response.addItem == "2") {
                            toastr.error("Failed Adding Product");

                        } else if (response.addItem == "3") {
                            toastr.success("Product Updated Successfully");

                        } else {
                            toastr.error("Some Error Occured");
                        }
                    }
                });
            }));


            //change quantity
            $('#PurchaseTable').on('change', '.changeQty', (function() {
                var ChangeQtyValue = $(this).val();
                var ChangeQtyRow = $(this).data("row");
                console.log(ChangeQtyValue);
                console.log(ChangeQtyRow);
                $.ajax({
                    type: "POST",
                    url: "PurchaseOperations.php",
                    data: {
                        ChangeQtyValue: ChangeQtyValue,
                        ChangeQtyRow: ChangeQtyRow
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var response = JSON.parse(data);
                        if (response.changeQty == "1") {
                            toastr.success("Quantity Changed Successfully");
                            PurchaseTable.ajax.reload(null, false);
                            FindTotals();
                        } else if (response.changeQty == "2") {
                            toastr.error("Failed Changing Quantity");

                        } else if (response.changeQty == "3") {
                            toastr.success("Product Updated Successfully");

                        } else {
                            toastr.error("Some Error Occured");
                        }
                    }
                });
            }));


            //change rate
            $('#PurchaseTable').on('change', '.changeRate', (function() {
                var ChangeRateValue = $(this).val();
                var ChangeRateRow = $(this).data("row");
                console.log(ChangeRateValue);
                console.log(ChangeRateRow);
                $.ajax({
                    type: "POST",
                    url: "PurchaseOperations.php",
                    data: {
                        ChangeRateValue: ChangeRateValue,
                        ChangeRateRow: ChangeRateRow
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var response = JSON.parse(data);
                        if (response.changeRate == "1") {
                            toastr.success("Rate Changed Successfully");
                            PurchaseTable.ajax.reload(null, false);
                            FindTotals();
                        } else if (response.changeRate == "2") {
                            toastr.error("Failed Changing Rate");

                        } else if (response.changeRate == "3") {
                            toastr.success("Product Updated Successfully");

                        } else {
                            toastr.error("Some Error Occured");
                        }
                    }
                });
            }));



            //change discount Amount
            $('#PurchaseTable').on('change', '.changeDiscAmt', (function() {
                var ChangeDiscAmt = $(this).val();
                var ChangeDiscAmtRow = $(this).data("row");
                console.log(ChangeDiscAmt);
                console.log(ChangeDiscAmtRow);
                $.ajax({
                    type: "POST",
                    url: "PurchaseOperations.php",
                    data: {
                        ChangeDiscAmt: ChangeDiscAmt,
                        ChangeDiscAmtRow: ChangeDiscAmtRow
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var response = JSON.parse(data);
                        if (response.ChangeDiscAmt == "1") {
                            toastr.success("Discount Amount Changed Successfully");
                            PurchaseTable.ajax.reload(null, false);
                            FindTotals();
                        } else if (response.ChangeDiscAmt == "2") {
                            toastr.error("Failed Changing Discount Amount");

                        } else if (response.ChangeDiscAmt == "3") {
                            toastr.success("Product Updated Successfully");

                        } else {
                            toastr.error("Some Error Occured");
                        }
                    }
                });
            }));


            //change discount Percentage
            $('#PurchaseTable').on('change', '.changeDiscPercent', (function() {
                var ChangeDiscPercent = $(this).val();
                var ChangeDiscPercentRow = $(this).data("row");
                console.log(ChangeDiscPercent);
                console.log(ChangeDiscPercentRow);
                $.ajax({
                    type: "POST",
                    url: "PurchaseOperations.php",
                    data: {
                        ChangeDiscPercent: ChangeDiscPercent,
                        ChangeDiscPercentRow: ChangeDiscPercentRow
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var response = JSON.parse(data);
                        if (response.ChangeDiscPercent == "1") {
                            toastr.success("Discount Percentage Changed Successfully");
                            PurchaseTable.ajax.reload(null, false);
                            FindTotals();
                        } else if (response.ChangeDiscPercent == "2") {
                            toastr.error("Failed Changing Discount Percentage");

                        } else if (response.ChangeDiscPercent == "3") {
                            toastr.success("Product Updated Successfully");

                        } else {
                            toastr.error("Some Error Occured");
                        }
                    }
                });
            }));


            //change Tax type
            $('#PurchaseTable').on('change', '.changeTaxType', (function() {
                var ChangeTaxTypeRow = $(this).data("row");
                var ChangeTaxTypeState = $(this).is(':checked');
                if (ChangeTaxTypeState == true) {
                    ChangeTaxType = 1;
                } else {
                    ChangeTaxType = 0;
                }
                console.log(ChangeTaxTypeState);
                console.log(ChangeTaxType);
                console.log(ChangeTaxTypeRow);
                $.ajax({
                    type: "POST",
                    url: "PurchaseOperations.php",
                    data: {
                        ChangeTaxType: ChangeTaxType,
                        ChangeTaxTypeRow: ChangeTaxTypeRow
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var response = JSON.parse(data);
                        if (response.ChangeTaxTypeResult == "1") {
                            toastr.success("Tax Type Changed Successfully");
                            PurchaseTable.ajax.reload(null, false);
                            FindTotals();
                        } else if (response.ChangeTaxTypeResult == "2") {
                            toastr.error("Failed Changing Tax Type");

                        } else if (response.ChangeTaxTypeResult == "3") {
                            toastr.success("Product Updated Successfully");

                        } else {
                            toastr.error("Some Error Occured");
                        }
                    }
                });
            }));



            //delete items from cart
            $('#PurchaseTable').on('click', '.delete_btn', function() {
                var delValue = $(this).val();
                console.log(delValue);
                $.ajax({
                    type: "POST",
                    url: "PurchaseOperations.php",
                    data: {
                        delValue: delValue
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var deleteResponse = JSON.parse(data);
                        console.log(deleteResponse);
                        if (deleteResponse.delStatus == 0) {
                            toastr.error("Cannot Delete Empty Row");
                        } else if (deleteResponse.delStatus == 1) {
                            PurchaseTable.ajax.reload(null, false);
                            FindTotals();
                            toastr.success("Successfully Deleted");
                        } else {
                            toastr.error("some error occured");
                        }
                    }
                });
            });



            //Add other charges
            $('#OtherChargeTable').on('change', '.ChangeOtherCharge', function() {
                var OtherChargeAmount = $(this).val();
                var OtherChargeRow = $(this).data("row");
                console.log(OtherChargeAmount);
                console.log(OtherChargeRow);
                $.ajax({
                    type: "POST",
                    url: "PurchaseOperations.php",
                    data: {
                        OtherChargeAmount: OtherChargeAmount,
                        OtherChargeRow: OtherChargeRow
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var response = JSON.parse(data);
                        if (response.addOtherCharge == "1") {
                            toastr.success("Other Charge Added Successfully");
                            FindTotals();
                        } else if (response.addOtherCharge == "2") {
                            toastr.error("Failed Adding Other Charge");

                        } else if (response.addOtherCharge == "3") {
                            toastr.success("Other Charge Updated Successfully");

                        } else {
                            toastr.error("Some Error Occured");
                        }
                    }
                });

            });


            //Add additional discount
            $('#AdditionalDiscountTable').on('change', '.ChangeAddDiscount', function() {
                var AdditionalDiscountAmount = $(this).val();
                var AdditionalDiscountRow = $(this).data("row");
                console.log(AdditionalDiscountAmount);
                console.log(AdditionalDiscountRow);
                $.ajax({
                    type: "POST",
                    url: "PurchaseOperations.php",
                    data: {
                        AdditionalDiscountAmount: AdditionalDiscountAmount,
                        AdditionalDiscountRow: AdditionalDiscountRow
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var response = JSON.parse(data);
                        if (response.addAdditionalDiscount == "1") {
                            toastr.success("Additional Discount Added Successfully");
                            FindTotals();
                        } else if (response.addAdditionalDiscount == "2") {
                            toastr.error("Failed Adding Additional Discount");

                        } else if (response.addOtherCharge == "3") {
                            toastr.success("Additional Discount Updated Successfully");

                        } else {
                            toastr.error("Some Error Occured");
                        }
                    }
                });

            });



            /* Add Purchase */
            $(function() {

                let validator = $('#PurchaseForm').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {

                    // if ($(el).is('#Supplier_name') && $(el).val().match(/[0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)) {
                    //     return 'Only allowed alphabets';
                    // } else if ($(el).is('#Supplier_name,#Invoice_no') && $(el).val().trim().length == 0) {
                    //     return 'Cannot be empty';
                    // }
                }

                $(document).on('submit', '#PurchaseForm', (function(e) {
                    e.preventDefault();
                    var orderData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "PurchaseOperations.php",
                        data: orderData,
                        beforeSend: function() {
                            $('#PurchaseForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#PurchaseForm').removeClass("disable");
                            var PurchaseResponse = JSON.parse(data);
                            if (PurchaseResponse.PurchaseSuccess == "1") {
                                $('#PurchaseForm')[0].reset();
                                DeleteAll();
                                toastr.success("Successfully Purchased All Itmes");
                            } else if (PurchaseResponse.PurchaseSuccess == "2") {
                                toastr.error("Failed Purchase");
                            } else if (PurchaseResponse.PurchaseSuccess == "0") {
                                toastr.warning("Please Add Something To Purchase");
                            } else {
                                toastr.error("Some Error Occured");
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }));

            });
            /* Add Purchase */


        });
    </script>


    <?php
    include "../MAIN/Footer.php";
    ?>

</body>

</html>