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


$PageTitle = 'Barcode';



?>



<!doctype html>
<html lang="en">

<head>

    <?php

    require "../MAIN/Header.php";

    ?>


    <style>
        #main_card {
            border: none;
        }

        #PrintCard {
            margin: 100px;
            padding: 50px 200px 50px 200px;
        }
    </style>

</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body text-center">
                    <h4 id="Form_result" class="text-center mt-4 mb-3"></h4>
                    <button type="button" id="btn_okay" class="btn btn_close" data-bs-dismiss="modal">Ok</button>

                </div>

            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="Delete_modal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <h5>Do you want to delete this employee?</h5>
                        <div class=" d-flex justify-content-around pt-3">
                            <button id="del_yes" class="btn btn-danger rounded-pill">Yes</button>
                            <button id="del_no" class="btn btn-primary rounded-pill" data-bs-dismiss="modal">No</button>
                        </div>
                    </div>
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
                    <h5>Barcode Print</h5>
                </a>
                <button class="btn text-white shadow-none" type="submit">
                    <i class="material-icons">notifications</i>
                </button>
            </div>
        </nav>

        <!--SIDEBAR-->
        <?php

        include '../MAIN/Sidebar.php';

        ?>

        <!--CONTENT-->
        <div id="Content" class="mb-5">

            <div class="container-fluid main_container">
                <div id="PrintCard" class="card card-body shadow">
                    <form id="BarcodePrintForm">
                        <div class="row">
                            <div class="col-12">
                                <label>Product Name</label>
                                <select class="" type="text" id="product_id" name="ProductId">
                                    <option value="">Choose Product</option>
                                    <?php
                                    $FetchItems = mysqli_query($con, "SELECT P.name,P.barcode,B.brand_name,P.color,P.imei,P.pr_id FROM products P INNER JOIN brands B ON P.brand = B.br_id");
                                    foreach ($FetchItems as $FetchItemsResult) {
                                        echo '<option value="' . $FetchItemsResult["pr_id"] . '"> ' . $FetchItemsResult["brand_name"] . ' - '.$FetchItemsResult["name"].' - '. $FetchItemsResult["color"].' - '.$FetchItemsResult["barcode"].' - '.$FetchItemsResult["imei"].' </option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <input class="form-control" type="text" name="ProductName" id="product_name" hidden>
                            <!-- <div class="col-12 mt-3">
                                <label>Product Mini Description</label>
                                <input class="form-control" type="text" step="any" name="ProductMini" id="product_mini" >
                            </div> -->
                            <div class="col-12 mt-3">
                                <label>Product Brand</label>
                                <input class="form-control" type="text" step="any" name="ProductBrand" id="product_brand">
                            </div>
                            <div class="col-12 mt-3">
                                <label>Product Color</label>
                                <input class="form-control" type="text" step="any" name="ProductColor" id="product_color">
                            </div>
                            <div class="col-12 mt-3">
                                <label>Product Barcode</label>
                                <input class="form-control" type="text" step="any" name="ProductBarcode" id="product_barcode" readonly>
                            </div>
                            <div class="col-12 mt-3">
                                <label>Product MRP</label>
                                <input class="form-control" type="number" step="any" name="ProductMrp" id="product_mrp" readonly>
                            </div>
                            <div class="col-12 mt-3">
                                <label>Product SP</label>
                                <input class="form-control" type="number" step="any" name="ProductSP" id="product_sp" readonly>
                            </div>
                            <div class="col-12 mt-3">
                                <label>Print Qty</label>
                                <input class="form-control" type="number" value="1" name="PrintQty">
                            </div>
                            <div class="col-12 mt-4 text-center">
                                <button class="btn btn_submit px-5 py-2 mt-4 rounded-pill">PRINT</button>
                            </div>


                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>


    <?php
    include "../MAIN/Footer.php";
    ?>


    <script>
        var ProductSelect = $("#product_id").selectize({
            sortField: "text",
            //openOnFocus: false
        });

        $(document).on('submit', '#BarcodePrintForm', function(t) {





            t.preventDefault();
            var PrintCheck = confirm("Are you sure?");
            if (PrintCheck == true) {
                var BarcodeData = new FormData(this);
                console.log(BarcodeData);
                $.ajax({
                    url: "BarcodePrintData.php",
                    type: "POST",
                    data: BarcodeData,
                    beforeSend: function() {},
                    success: function(data) {
                        console.log(data);
                        $('#BarcodePrintForm')[0].reset();
                        //toastr.warning(result);
                        var bulkPrint = window.open("");
                        bulkPrint.document.write(data);
                        bulkPrint.window.stop();
                        bulkPrint.window.print();
                        bulkPrint.window.close();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {

            }
        });


        $('#product_id').change(function() {
            var BarcodeProductId = $(this).val();
            $.ajax({
                url: "MasterExtras.php",
                type: "POST",
                data: {
                    BarcodeProductId: BarcodeProductId
                },
                beforeSend: function() {

                },
                success: function(data) {
                    console.log(data);
                    var ProductResponse = JSON.parse(data);
                    if (ProductResponse.Status == 1) {
                        $('#product_name').val(ProductResponse.Name);
                        $('#product_mrp').val(ProductResponse.MRP);
                        $('#product_sp').val(ProductResponse.SP);
                        $('#product_barcode').val(ProductResponse.Barcode);
                        $('#product_color').val(ProductResponse.Color);
                        //$('#product_mini').val(ProductResponse.Mini);
                        $('#product_brand').val(ProductResponse.Brand);
                    }
                },
                // cache: false,
                // contentType: false,
                // processData: false
            });
        });
    </script>


</body>

</html>