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

$PageTitle = 'Product';

?>




<!doctype html>
<html lang="en">


<head>


    <?php

    require "../MAIN/Header.php";

    ?>

</head>


<body class="" style="background-color: #eeeeee;">

    <div class="wrapper">
        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5>Add Product</h5>
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

                            <form id="Add_Product" method="POST">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <label for="SelectType" class="form-label">Category</label>
                                        <select class="form-select py-1" id="SelectType" name="type" required>

                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="SelectBrand" class="form-label">Brand</label>
                                        <select class="form-select py-1" id="SelectBrand" name="brand" required>


                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="SelectProductType" class="form-label">Type</label>
                                        <select class="form-select py-1" id="SelectProductType" name="ProductType" required>


                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="choose_image" class="form-label">Main Image</label>
                                        <input type="file" class="form-control  py-1" id="choose_image" accept=".jpg" name="main_image" required>
                                    </div>
                                    <div class="col-md-5 mt-2">
                                        <label for="Add_Name" class="form-label">Product Name</label>
                                        <input class="form-control py-1" id="Add_Name" placeholder="Enter Product Name" name="product" required>
                                    </div>
                                    <div class="col-md-7 mt-2">
                                        <label for="Add_Name" class="form-label">Mini Description</label>
                                        <input class="form-control py-1" id="Add_mini" placeholder="Enter Mini Description" name="mini_desc" required>
                                    </div>
                                    <div class="col-12 mt-2 col-md-4">
                                        <label for="more_image" class="form-label">More Images</label>
                                        <input type="file" class="form-control py-1" id="more_image" name="multi_image[]" accept=".png ,.jpg" required multiple>
                                    </div>
                                    <div class="col-12 mt-2 col-md-4">
                                        <label for="select_tax" class="form-label">Tax %</label>
                                        <select id="select_tax" class="form-select  py-1" name="tax">
                                            <option value="">Select Tax</option>
                                            <option value="10">10</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mt-2 col-md-4">
                                        <label for="Add_amount" class="form-label">Selling Price</label>
                                        <input type="number" class="form-control  py-1" id="Add_amount" placeholder="Enter Amount" name="price" required>
                                    </div>
                                    <div class="col-12 mt-2 col-md-3">
                                        <label for="Add_warranty" class="form-label">Warranty</label>
                                        <input type="number" class="form-control  py-1" id="Add_warranty" placeholder="In Days" name="warranty" required>
                                    </div>
                                    <div class="col-12 mt-2 col-md-3">
                                        <label for="Add_code" class="form-label">Product Code</label>
                                        <input type="text" class="form-control py-1" id="Add_code" placeholder="Code" name="code" required>
                                    </div>
                                    <div class="col-12 mt-md-5 col-md-2">
                                        <input class="form-check-input" type="checkbox" name="Isimei" value="YES" id="imeicheck">
                                        <label class="form-check-label" for="imeicheck">
                                            Is IMEI
                                        </label>
                                    </div>
                                    <div class="col-12 mt-md-5 col-md-2" hidden>
                                        <input class="form-check-input" type="checkbox" name="Isbarcode" checked value="YES" id="barcodeCheck">
                                        <label class="form-check-label" for="barcodeCheck">
                                            Is Barcode
                                        </label>
                                    </div>
                                    <div class="col-12 mt-2 col-md-4">
                                        <label for="Add_barcode" class="form-label">Barcode</label>
                                        <input type="text" class="form-control py-1" id="Add_barcode" placeholder="Barcode" name="barcode" required>
                                    </div>

                                    <div class="col-12 mt-2 col-md-12">
                                        <label for="Add_desc" class="form-label">Enter Description</label>
                                        <textarea class="form-control " id="Add_desc" cols="10" rows="10" placeholder="Enter Description of the Product" name="description"></textarea>
                                    </div>
                                    <div class="col-12 mt-3 text-center">

                                        <button class="btn btn_submit rounded-pill py-1" type="submit">Add Product</button>

                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-7 col-12">
                            <div class="px-1 pb-3 mt-2 ">
                                <h5 class=" ps-1 my-auto">All Products</h5>

                                <div class="card card-body mt-2 py-2 px-0">
                                    <table class="table table-borderless table-striped text-nowrap" id="ProductTable" style="width: 100%;">
                                        <thead class="">
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Image</th>
                                                <th>Code</th>
                                                <th>Type</th>
                                                <th>Brand</th>
                                                <th>Name</th>
                                                <th>Mini Desc</th>
                                                <!-- <th>Stock</th> -->
                                                <th>Price</th>
                                                <th>Tax</th>
                                                <th>Warranty</th>
                                                <th class="text-center">Edit</th>
                                                <th class="text-center">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">

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

    <script src="../JS/product.js"></script>

    <script>
        $(document).ready(function() {



            get_type_select();

            get_brand_select();


            //////////////////////////////  PRODUCT MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


            //product table
            var productTable = $('#ProductTable').DataTable({
                "processing": true,
                "ajax": "ProductData.php",
                "scrollY": "500px",
                "scrollX": true,
                //"serverSide": true,
                //"serverMethod": 'post',
                //"responsive": true,
                "fixedHeader": true,
                "dom": '<"top"fl>rt<"bottom"ip>',
                //"select":true,
                "fixedColumns": {
                    left: 2,
                    right: 2
                },
                "columns": [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'img',
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<img class="img-fluid "  src="../assets/img/PRODUCTS/' + data + '">  </img>';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'pr_code',
                    },
                    {
                        data: 'type_name',
                    },
                    {
                        data: 'brand_name',
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'mini_desc',
                    },
                    /*  { 
                         data: 'current_stock',
                     }, */
                    {
                        data: 'price',
                    },
                    {
                        data: 'tax',
                        render: $.fn.dataTable.render.number(null, null, 2, null, ' %')
                    },
                    {
                        data: 'warranty',
                        render: $.fn.dataTable.render.number(null, null, 0, null, ' Days')
                    },
                    {
                        data: 'pr_id',
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<button class="edit_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'pr_id',
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<button class="delete_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">delete</i> </button>';
                            }
                            return data;
                        }
                    }
                ]
            });


            //add  product
            $(function() {

                let validator = $('#Add_Product').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#Add_Name,#Add_mini,#Add_amount,#Add_warranty') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#Add_Product', (function(a) {
                    a.preventDefault();
                    var ProductData = new FormData(this);
                    //console.log(ProductData);
                    $.ajax({
                        type: "POST",
                        url: "ProductMasterOperations.php",
                        data: ProductData,
                        success: function(data) {
                            console.log(data);
                            var ProductResponse = JSON.parse(data);
                            if (ProductResponse.addProduct == "1") {
                                toastr.success("Success Adding a New Product");
                                $('#Add_Product')[0].reset();
                                productTable.ajax.reload();
                            } else if (ProductResponse.addProduct == "0") {
                                toastr.warning("Cannot Add a Product That is Already Present");
                            } else if (ProductResponse.addProduct == "2") {
                                toastr.error("Error While Adding New Product");
                            } else {
                                toastr.error("Error While Adding New Product");
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }));

            });


            //delete product
            $('#ProductTable tbody').on('click', '.delete_btn', (function() {
                var deleteProductId = $(this).val();
                //console.log(deleteProductId);
                var ConfirmProductDelete = confirm("Are you sure, you want to delete this product?");
                if (ConfirmProductDelete == true) {
                    $.ajax({
                        method: "POST",
                        url: "ProductMasterOperations.php",
                        data: {
                            deleteProductId: deleteProductId
                        },
                        beforeSend: function() {
                            $('#addCategoryForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            var DeleteProductResponse = JSON.parse(data);
                            if (DeleteProductResponse.DelProduct == "1") {
                                toastr.success("Successfully Deleted Product");
                                productTable.ajax.reload();
                            } else if (DeleteProductResponse.DelProduct == "0") {
                                toastr.warning("Cannot Delete a Product That is Already in Use");
                            } else if (DeleteProductResponse.DelProduct == "2") {
                                toastr.error("Error While Deleting");
                            } else {
                                toastr.error("Error While Deleting");
                            }
                        },
                        error: function() {
                            alert("Error");
                        }
                    });
                } else {
                    toastr.info("Cancelled");
                }

            }));

            //////////////////////////////  PRODUCT MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\




        });
    </script>


    <?php
    include "../MAIN/Footer.php";
    ?>

</body>

</html>