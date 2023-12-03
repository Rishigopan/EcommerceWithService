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
$PageTitle = 'ProductType';

?>

<!doctype html>
<html lang="en">

<head>

    <?php

    require "../MAIN/Header.php";

    ?>


</head>

<body>

    <div class="wrapper">
        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top ">
            <div class="container-fluid">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5> Add Type</h5>
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
        <div id="Content">


            <div class="container-fluid">

                <div class="container-fluid px-5 masters">
                    <div class="row gx-5">
                        <div class="col-lg-5">
                            <div class="card card-body px-5 py-4">
                                <form id="AddProductType" action="" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-12 mt-3">
                                            <label for="add_product_type" class="form-label">Type Name</label>
                                            <input type="text" class="form-control" id="add_product_type" name="ProductTypeName" placeholder="Enter a Type Name" required>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="add_product_type_image" class="form-label">Type Image</label>
                                            <input type="file" class="form-control" id="add_product_type_image" name="TypeImage">
                                        </div>
                                        <div class="col-12 mt-3 text-center">
                                            <button class="btn btn_submit shadow-none rounded-pill" type="submit">Add Type</button>
                                        </div>
                                    </div>
                                </form>

                                <form id="UpdateProductType" action="" method="POST" enctype="multipart/form-data" style="display: none;">
                                    <div class="row">
                                        <div class="col-12 mt-3">
                                            <input type="text" class="form-control" id="update_product_type_id" name="UpdateProductTypeId" hidden>
                                            <label for="update_product_type" class="form-label">Type Name</label>
                                            <input type="text" class="form-control" id="update_product_type" name="UpdateProductTypeName" placeholder="Enter a Type Name">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="update_product_type_image" class="form-label">Type Image</label>
                                            <input type="file" class="form-control" id="update_product_type_image" name="UpdateTypeImage">
                                        </div>
                                        <div class="col-12 mt-3 text-center">
                                            <button class="btn btn_submit shadow-none rounded-pill" type="submit">Update Type</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="card card-body px-0">
                                <div class="table-responsive">
                                    <table class="table table-borderless text-nowrap" id="ProductTypeTable" style="width:100%;">
                                        <thead class="text-nowrap">
                                            <tr class="text-nowrap">
                                                <th class="text-center">Id</th>
                                                <th class="text-center">Image</th>
                                                <th class="text-center">Type</th>
                                                <th class="text-center">Edit</th>
                                                <th class="text-center">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">

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

    <script src="../JS/masters.js?ver=1.8"></script>

    <script>
        $(document).ready(function() {

          

            //////////////////////////////  PRODUCT TYPE MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

            //Data table
            var ProductTypeTable = $('#ProductTypeTable').DataTable({
                "processing": true,
                "ajax": "ProductTypeData.php",
                "scrollX": true,
                "scrollY": "500px",
                //"serverSide": true,
                //"serverMethod": 'post',
                //"responsive": true,
                "fixedHeader": true,
                "dom": '<"top"fl>rt<"bottom"ip>',
                //"select":true,
                "fixedColumns": {
                    left: 1,
                    right: 2
                },
                "columns": [{
                        data: 'productTypeId',
                    },
                    {
                        data: 'productTypeImage',
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<img class="img-fluid brand_img"  src="../assets/img/TYPE/' + data + '">  </img>';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'productTypeName',
                    },
                    {
                        data: 'productTypeId',
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<button class="edit_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'productTypeId',
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<button class="delete_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">delete</i> </button>';
                            }
                            return data;
                        }
                    }

                ]


            });


            //Add Product types
            $(function() {

                let validator = $('#AddProductType').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#add_product_type') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#AddProductType', (function(a) {
                    a.preventDefault();
                    var ProductTypedata = new FormData(this);
                    //console.log(ProductTypedata);
                    $.ajax({
                        type: "POST",
                        url: "ProductMasterOperations.php",
                        data: ProductTypedata,
                        beforeSend: function() {
                            //NProgress.start();
                        },
                        success: function(data) {
                            console.log(data);
                            var response = JSON.parse(data);
                            if (response.Status == "1") {
                                swal("Success", response.Message, "success");
                                $('#AddProductType')[0].reset();
                                ProductTypeTable.ajax.reload(null, false);
                            } else if (response.Status == "0") {
                                swal("Warning", response.Message, "warning");
                            } else if (response.Status == "2") {
                                swal("Error", response.Message, "error");
                            } else {
                                swal("Some Error Occured!!!", "Please Try Again", "error");
                            }
                        },
                        error: function() {
                            swal(
                                "Some Error Occured!!!",
                                "Please Refresh The Page...",
                                "error"
                            );
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }));

            });


            //Update Product types
            $(function() {

                let validator = $('#UpdateProductType').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#update_product_type') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#UpdateProductType', (function(a) {
                    a.preventDefault();
                    var UpdateProductTypedata = new FormData(this);
                    //console.log(updateProductTypedata);
                    $.ajax({
                        type: "POST",
                        url: "ProductMasterOperations.php",
                        data: UpdateProductTypedata,
                        success: function(data) {
                            console.log(data);
                            var UpdateProductTypeResponse = JSON.parse(data);
                            if (UpdateProductTypeResponse.UpdateProductType == "1") {
                                toastr.success("Successfully Updated Type");
                                $('#UpdateProductType')[0].reset();
                                $('#AddProductType').show();
                                $('#UpdateProductType').hide();
                                ProductTypeTable.ajax.reload(null, false);
                            } else if (UpdateProductTypeResponse.UpdateProductType == "0") {
                                toastr.warning("Product Type Name Already Exists");
                            } else if (UpdateProductTypeResponse.UpdateProductType == "2") {
                                toastr.error("Error While Updating Product Type");
                            } else {
                                toastr.error("Error While Updating Product Type");
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }));

            });


            //Edit Product types
            $('#ProductTypeTable tbody').on('click', '.edit_btn', (function() {
                var EditProductTypeId = $(this).val();
                console.log(EditProductTypeId);

                $.ajax({
                    method: "POST",
                    url: "ProductMasterOperations.php",
                    data: {
                        EditProductTypeId: EditProductTypeId
                    },
                    beforeSend: function() {
                        $('#UpdateProductType').addClass("disable");
                    },
                    success: function(data) {
                        console.log(data);
                        var EditProductType = JSON.parse(data);
                        if (EditProductType.EditProductType == 'error') {
                            toastr.error("Some Error Occured");
                        } else {
                            $('#AddProductType').hide();
                            $('#UpdateProductType').show();
                            $('#update_product_type').val(EditProductType.EditProductTypeName);
                            $('#update_product_type_id').val(EditProductTypeId);
                        }
                    },
                    error: function() {
                        alert("Error");
                    }
                })
            }));


            //Delete Product types
            $('#ProductTypeTable tbody').on('click', '.delete_btn', (function() {
                var DeleteProductTypeId = $(this).val();
                //console.log(DeleteProductTypeId);
                var ConfirmProductTypeDelete = confirm("Are you sure, you want to delete this product type?");
                if (ConfirmProductTypeDelete == true) {
                    $.ajax({
                        method: "POST",
                        url: "ProductMasterOperations.php",
                        data: {
                            DeleteProductTypeId: DeleteProductTypeId
                        },
                        beforeSend: function() {
                            $('#AddProductType').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            var DeleteProductTypeResponse = JSON.parse(data);
                            if (DeleteProductTypeResponse.DelProductType == "1") {
                                toastr.success("Successfully Deleted Product Type");
                                ProductTypeTable.ajax.reload(null, false);
                            } else if (DeleteProductTypeResponse.DelProductType == "0") {
                                toastr.warning("Cannot Delete a Product Type That is Already in Use");
                            } else if (DeleteProductTypeResponse.DelProductType == "2") {
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


            //////////////////////////////  PRODUCT TYPE MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\




        });
    </script>


    <?php
    include "../MAIN/Footer.php";
    ?>


</body>

</html>