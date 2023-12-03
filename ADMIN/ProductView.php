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
                    <h5>Product List</h5>
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

                        <div class="col-md-12 col-12">
                            <div class="px-1 pb-3 mt-2 ">
                                <div class="card card-body mt-2 py-2 px-0">
                                    <table class="table table-borderless table-striped text-nowrap" id="ProductTable" style="width: 100%;">
                                        <thead class="">
                                            <tr>
                                                <th class="all" >Sl No.</th>
                                                <th class="all" >Image</th>
                                                <th class="all" >Code</th>
                                                <th class="all" >Category</th>
                                                <th class="all" >Brand</th>
                                                <th class="all" >Type</th>
                                                <th class="all" >Name</th>
                                                <th class="none" >Mini Desc</th>
                                                <th class="all" >SP</th>
                                                <th class="all" >MRP</th>
                                                <th class="all" >CP</th>
                                                <th class="none" >Barcode</th>
                                                <th class="none" >IMEI</th>
                                                <th class="none" >HSN</th>
                                                <th class="all" >Tax</th>
                                                <th class="none" >Warranty</th>
                                                <th class="all text-center">Edit</th>
                                                <th class="all text-center">Delete</th>
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




            //product table
            var productTable = $('#ProductTable').DataTable({
                "processing": true,
                "ajax": "ProductData.php",
                "scrollY": "500px",
                "scrollX": true,
                //"serverSide": true,
                //"serverMethod": 'post',
                "responsive": true,
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
                        data: 'productTypeName',
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
                        data: 'sp',
                    },
                    {
                        data: 'mrp',
                    },
                    {
                        data: 'cp',
                    },
                    {
                        data: 'barcode',
                    },
                    {
                        data: 'imei',
                    },
                    {
                        data: 'hsn',
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
                                data = '<a class="edit_btn p-0 m-0 btn shadow-none" type="button" href="ProductAdd.php?PEDTID='+ data +'"> <i class="material-icons">edit</i> </a>';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'pr_id',
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<button class="delete_btn p-0 m-0  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">delete</i> </button>';
                            }
                            return data;
                        }
                    }
                ]
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
                                productTable.ajax.reload(null,false);
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

         

        });
    </script>


    <?php
    include "../MAIN/Footer.php";
    ?>

</body>

</html>