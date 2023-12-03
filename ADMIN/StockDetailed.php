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

$PageTitle = 'StockDetailed';

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
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5>Stock Detailed</h5>
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
        <div id="Content" class="mb-5 sales_report">

            <div class="container-fluid">


                <div class="toolbar">
                    <div class="card card-body shadow-sm">
                        <div class="row justify-content-between">
                            <div class="col-7 col-md-6">
                                <div class="col-12 col-md-6">
                                    <label for="Search" class="d-flex">
                                        <span class="mt-2">Search</span>
                                        <input type="text" class="form-control ms-2 shadow-none" id="searchbox">
                                    </label>
                                </div>
                            </div>

                            <div class="col-5 col-md-3">

                                <?php


                                if (isset($_GET['PID'])) {
                                    $ParentItemId = $_GET['PID'];
                                } else {
                                    $ParentItemId = '';
                                ?>
                                    <select name="" class="form-select" id="FilterProduct">
                                        <option value="">Product</option>
                                        <?php

                                        $findAllProducts = mysqli_query($con, "SELECT parent_item_id, name FROM products WHERE pr_id = parent_item_id;");
                                        if (mysqli_num_rows($findAllProducts) > 0) {
                                            foreach ($findAllProducts as $ProductResults) {
                                                echo '<option value="' . $ProductResults["parent_item_id"] . '">' . $ProductResults["name"] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">No Results</option>';
                                        }

                                        ?>
                                    </select>
                                <?php
                                }

                                ?>





                                <!-- <h5 class="mt-2"><strong>Customer Wise Report</strong></h5> -->
                            </div>


                        </div>
                    </div>
                </div>

                <div class="card card-body mt-3 px-0">
                    <div class="table-responsive">
                        <table class="table nowrap table-hover text-center" id="service_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">Product Id</th>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Product Code</th>
                                    <th class="text-center">Current Stock</th>
                                    <th class="text-center">Color</th>
                                    <th class="text-center">Barcode</th>
                                    <th class="text-center">IMEI</th>
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

    <script>
        $(document).ready(function() {



            var table = $('#service_table').DataTable({
                "processing": true,
                //"responsive": true,
                "ajax": "StockDetailedData.php",
                "scrollY": "600px",
                "scrollX": true,
                "scrollCollapse": true,
                "fixedHeader": true,
                "dom": '<"top"il>rt<"bottom"p>',
                "pagingType": 'first_last_numbers',
                // "language": {
                //     "paginate": {
                //         "previous": "<i class='bi bi-caret-left-fill'></i>",
                //         "next": "<i class='bi bi-caret-right-fill'></i>"
                //     }
                // },
                "columns": [{
                        data: 'pr_id',
                        searchable: false
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'pr_code',
                        searchable: false
                    },
                    {
                        data: 'current_stock',
                        render: $.fn.dataTable.render.number(',', '0', null, null, null),
                        searchable: false
                    },
                    {
                        data: 'colorName',
                    },
                    {
                        data: 'barcode',
                    },
                    {
                        data: 'imei',
                    },
                    {
                        data: 'parent_item_id',
                        visible:false
                    },
                ]
            });



            $('#searchbox').keyup(function() {
                table.search($(this).val()).draw();
            });


            var ProductParentId = '<?php echo  $ParentItemId ?>'
            console.log(ProductParentId);

            if (ProductParentId == '') {
                $('#FilterProduct').on('change', function(e) {
                    var ProductFilter = $(this).val();
                    console.log(ProductFilter);
                    //dataTable.column(6).search('\\s' + status + '\\s', true, false, true).draw();
                    //table.column(7).search(ProductFilter,true,false).draw();
                    table.column(7).search('\\b' + ProductFilter + '\\b', true, false, true).draw();
                });
            }
            else{
                //table.column(7).search(ProductParentId).draw();
                table.column(7).search('\\b' + ProductParentId + '\\b', true, false, true).draw();
            }




        });
    </script>



    <?php
    include "../MAIN/Footer.php";
    ?>


</body>

</html>