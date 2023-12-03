<?php

require "../MAIN/Dbconn.php"; 



if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

    if ($_COOKIE['custtypecookie'] == 'executive' || $_COOKIE['custtypecookie'] == 'admin') {
        echo "";
    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}
$PageTitle = 'InitialStock';

?>




<!doctype html>
<html lang="en">


<head>


    <?php

    require "../MAIN/Header.php";

    ?>

</head>






<body class="" style="background-color: #eeeeee;">


    <!-- Modal -->
    <div class="modal" id="itemModal" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add an Item</h5>
                    <button type="button" id="itemCloseBtn" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white">
                    <form action="" id="add_item">
                        <div class="product_details">
                            <div class="inputs">
                                <label class="form-label" for="Product">Product</label>
                                <select name="product" class="form-select" id="Product" required>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="inputs">
                                        <label class="form-label" for="Quantity">Quantity</label>
                                        <input type="number" min="0" class="form-control" id="Quantity" placeholder="" name="quantity" min="1" required>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="inputs">
                                        <label class="form-label" for="Unitprice">Unit Price</label>
                                        <input type="number" min="0" class="form-control" id="Unitprice" placeholder="" name="unitPrice" min="1" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <input class="form-check-input" type="checkbox" name="individual" id="IsIndividualBarcode" value="YES">
                                    <label class="form-check-label" for="IsIndividualBarcode">
                                        Is Individual Barcode
                                    </label>
                                </div>

                                <!-- <div class="col-12">
                                    <input class="form-check-input" type="radio" name="individual" id="NotIndividualBarcode" value="NO" checked hidden>
                                    <label class="form-check-label" for="NotIndividualBarcode" hidden>
                                        Not Individual Barcode
                                    </label>
                                </div> -->

                            </div>

                            <div class="mt-4 text-center">
                                <button type="submit" class="btn btn_submit ">Add item</button>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>



    <div class="wrapper">

        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5>Initial Stock</h5>
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
                <div id="main_card_Products" class="card card-body shadow-sm">
                    <div class="row">

                        <div class="col-md-5 col-12">

                            <form id="Add_Purchase" method="POST" novalidate>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <label for="Invoice_no" class="form-label">Invoice No.</label>
                                        <input type="number" class="form-control py-1" min="0" id="Invoice_no" name="invoiceNo" required>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="Invoice_no" class="form-label">Supplier Name</label>
                                        <input type="text" class="form-control  py-1" id="Supplier_name" name="supplierName">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="Invoice_date" class="form-label">Invoice Date</label>
                                        <input type="date" class="form-control py-1" max="<?= date('Y-m-d', strtotime('+50 years')) ?>" id="Invoice_date" name="invoiceDate">
                                    </div>




                                    <div class="d-flex justify-content-between mt-5">
                                        <button class="btn btn_submit rounded-pill py-2 px-5" data-bs-toggle="modal" data-bs-target="#itemModal" type="button">Add Product</button>

                                        <button class="btn btn_submit rounded-pill py-3 px-5 " type="submit">Save Purchase</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-7 col-12">
                            <div class="px-1 pb-3 mt-2 ">
                                <!-- <h5 class=" ps-1 my-auto">All Products</h5> -->

                                <div class="card card-body mt-2 py-2 px-0" id="purchaseTable">
                                    <table class="table table-borderless table-striped text-center text-nowrap" id="ProductTable" style="width: 100%;">
                                        <thead class="">
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Barcode</th>
                                                <th>IMEI</th>
                                                <th>Tax</th>
                                                <th class="">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
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


        //get the cart data in purchase
        function getPurchaseTempData() {
            var action = 'fetch_data';

            $.ajax({
                method: "POST",
                url: "InitialStockExtras.php",
                data: {
                    action: action
                },
                success: function(data) {
                    $('#purchaseTable').html(data);
                }
            });
        }



        //list products in initial stock
        function ProductSelectInitialStock() {
            var selectProduct = 'fetch_data';
            $.ajax({
                method: "POST",
                url: "InitialStockExtras.php",
                data: {
                    selectProduct: selectProduct
                },
                success: function(data) {
                    //console.log(data);
                    $('#Product').html(data);
                }
            });
        }



        $(document).ready(function() {

            ProductSelectInitialStock(); //get products

            getPurchaseTempData(); //get cart details



            $('#itemCloseBtn').click(function() {
                $('#add_item')[0].reset();
            });


            //Delete all items from cart
            $('#purchaseTable').on('click', '.clearAllBtn', function() {

                let confirmation = window.confirm("Do you want to clear this Purchase?");
                if (confirmation == true) {
                    var delAll = '*';
                    $.ajax({
                        type: "POST",
                        url: "InitialStockOperations.php",
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
                                getPurchaseTempData();
                                toastr.error("Failed Deleting All");
                            } else if (response.delAllStatus == "1") {
                                getPurchaseTempData();
                                toastr.success("Successfully Deleted All");
                            } else {
                                toastr.error("Some Error Occured");
                            }
                        }
                    });
                    getPurchaseTempData();
                }

            });


            /* Add items */
            $(function() {

                let validator = $('#add_item').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                $(document).on('submit', '#add_item', (function(g) {
                    g.preventDefault();
                    var itemData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "InitialStockOperations.php",
                        data: itemData,
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
                                getPurchaseTempData();
                                //$('#itemModal').modal('hide');
                                $('#add_item')[0].reset();
                            } else if (response.addItem == "2") {
                                toastr.error("Failed Adding Product");
                                getPurchaseTempData();
                            } else if (response.addItem == "3") {
                                toastr.success("Product Updated Successfully");
                                getPurchaseTempData();
                                //$('#itemModal').modal('hide');
                                $('#add_item')[0].reset();
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


            //delete items from cart
            $('#purchaseTable').on('click', '.delete_btn', function() {
                var delValue = $(this).val();
                console.log(delValue);
                $.ajax({
                    type: "POST",
                    url: "InitialStockOperations.php",
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
                            toastr.error("Delete failed");
                        } else if (deleteResponse.delStatus == 1) {
                            toastr.success("Successfully Deleted");
                            getPurchaseTempData();
                        } else {
                            toastr.error("some error occured");
                        }
                    }
                });
            });


            //update imei in cart
            $('#purchaseTable').on('change', '.change_imei', function() {
                var imeiValue = $(this).val();
                var imeiID = $(this).attr('id');
                console.log(imeiValue);
                console.log(imeiID);
                $.ajax({
                    type: "POST",
                    url: "InitialStockOperations.php",
                    data: {
                        imeiValue: imeiValue,
                        imeiID: imeiID
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var imeiResponse = JSON.parse(data);
                        console.log(imeiResponse);
                        if (imeiResponse.updtImei == 0) {
                            toastr.error("Updating IMEI failed");
                        } else if (imeiResponse.updtImei == 1) {
                            //toastr.success("Successfully Updated IMEI");
                            getPurchaseTempData();
                        } else {
                            toastr.error("some error occured");
                        }
                    }
                });
            });


            //update barcode in cart
            $('#purchaseTable').on('change', '.change_barcode', function() {
                var barValue = $(this).val();
                var barID = $(this).attr('id');
                console.log(barValue);
                console.log(barID);

                $.ajax({
                    type: "POST",
                    url: "InitialStockOperations.php",
                    data: {
                        barValue: barValue,
                        barID: barID
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var barResponse = JSON.parse(data);
                        if (barResponse.updtBarcode == 0) {
                            toastr.error("Update Barcode failed");
                        } else if (barResponse.updtBarcode == 1) {
                            //toastr.success("Successfully Updated Barcode");
                            getPurchaseTempData();
                        } else if (barResponse.updtBarcode == 3) {
                            toastr.warning("Barcode Exists");
                            getPurchaseTempData();
                        }else {
                            toastr.error("some error occured");
                        }
                    }
                });

            });


            //update color in cart
            $('#purchaseTable').on('change', '.change_color', function() {
                var ColorValue = $(this).val();
                var ColorID = $(this).attr('id');
                console.log(ColorValue);
                console.log(ColorID);

                $.ajax({
                    type: "POST",
                    url: "InitialStockOperations.php",
                    data: {
                        ColorValue: ColorValue,
                        ColorID: ColorID
                    },
                    beforeSend: function() {
                        $('#displayCart').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#displayCart').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var ColorResponse = JSON.parse(data);
                        if (ColorResponse.updtColor == 0) {
                            toastr.error("Update Color failed");
                        } else if (ColorResponse.updtColor == 1) {
                            //toastr.success("Successfully Updated Color");
                            getPurchaseTempData();
                        } else {
                            toastr.error("some error occured");
                        }
                    }
                });

            });



            /* Add order */
            $(function() {

                let validator = $('#Add_Purchase').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {

                    if ($(el).is('#Supplier_name') && $(el).val().match(/[0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)) {
                        return 'Only allowed alphabets';
                    } else if ($(el).is('#Supplier_name,#Invoice_no') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#Add_Purchase', (function(e) {
                    e.preventDefault();
                    var orderData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "InitialStockOperations.php",
                        data: orderData,
                        beforeSend: function() {
                            $('#addCategoryForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#addCategoryForm').removeClass("disable");
                            var orderResponse = JSON.parse(data);
                            if (orderResponse.Success == "1") {
                                $('#Add_Purchase')[0].reset();
                                toastr.success("Successfully Purchased All Itmes");
                                getPurchaseTempData();
                            } else if (orderResponse.Success == "2") {
                                toastr.error("Failed Purchase");

                            } else if (orderResponse.Success == "0") {
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
            /* Add order */






        });
    </script>


    <?php
    include "../MAIN/Footer.php";
    ?>

</body>

</html>