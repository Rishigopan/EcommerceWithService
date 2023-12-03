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
$PageTitle = 'StockSummary';
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
                    <h5>Stock Summary</h5>
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
                        <div class="d-flex justify-content-between">
                            <div>
                                <label for="Search" class="d-flex">
                                    <span class="mt-2">Search</span>
                                    <input type="text" class="form-control ms-2" id="searchbox" style="width: 20rem;">
                                </label>

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
                                    <th class="text-center">View Detailed</th>
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
                "ajax": "StockSummaryData.php",
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
                        data: 'parent_item_id',
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'pr_code',
                    },
                    {
                        data: 'currentStock',
                    },
                    {
                        data: 'parent_item_id',
                        "render": function(data, type, row, meta) {
                            if (type == 'display') {
                                //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                                data = '<div class="">  <a class="btn btn_actions btn_edit me-3" data-bs-toggle="tooltip" data-bs-custom-class="view-tooltip" data-bs-placement="top" data-bs-title="View Detailed" href="StockDetailed.php?PID=' + data + '" ><i class="material-icons">zoom_in</i> </a></div>'
                            }
                            return data;
                        }
                    }

                ]
            });



            $('#searchbox').keyup(function() {
                table.search($(this).val()).draw();
            });

        });
    </script>



    <?php
    include "../MAIN/Footer.php";
    ?>


</body>

</html>