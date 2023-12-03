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
$PageTitle = 'PurchaseReport';
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
                    <h5>Purchase Report</h5>
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
                            <div class="d-flex">
                                <div class="">
                                    <label for="min" class="d-flex">
                                        <span class="mt-2">From</span>
                                        <input type="text" class="form-control ms-2 w-75" id="min" name="min">
                                    </label>

                                </div>
                                <div class="ms-3">
                                    <label for="max" class="d-flex">
                                        <span class="mt-2">To</span>
                                        <input type="text" class="form-control ms-2 w-75" id="max" name="max">
                                    </label>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-body mt-3 px-0">
                    <div class="table-responsive">
                        <table class="table nowrap table-hover" id="service_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Purchase Id</th>
                                    <th>Invoice No</th>
                                    <th>Supplier</th>
                                    <th>Date</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
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
        var minDate, maxDate;

        // Custom filtering function which will search data in column four between two values
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var min = minDate.val();
                var max = maxDate.val();
                var date = new Date(data[3]);

                if (
                    (min === null && max === null) ||
                    (min === null && date <= max) ||
                    (min <= date && max === null) ||
                    (min <= date && date <= max)
                ) {
                    return true;
                }
                return false;
            }
        );


        $(document).ready(function() {

            // Create date inputs
            minDate = new DateTime($('#min'), {
                format: 'MMMM Do YYYY'
            });
            maxDate = new DateTime($('#max'), {
                format: 'MMMM Do YYYY'
            });

            var table = $('#service_table').DataTable({
                "processing": true,
                //"responsive": true,
                "ajax": "PurchaseReportData.php",
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
                        data: 'purchase_id',
                    },
                    {
                        data: 'invoice_no',
                    },
                    {
                        data: 'supplier_name',
                    },
                    {
                        data: 'purchase_date',
                        render: function(data, type, row, meta) {
                            if (type === 'sort') {
                                return data;
                            }
                            return moment(data).format("MMM D , YYYY");
                        }
                    },
                    {
                        data: 'purchase_total_qty',
                        render: $.fn.dataTable.render.number(',', 0, null, '', null)
                    },
                    {
                        data: 'purchase_total_amt',
                        render: $.fn.dataTable.render.number(',', 0, null, '₹ ', null)
                    },
                    {
                        data: 'purchase_main_id',
                        "render": function(data, type, row, meta) {
                            if (type == 'display') {
                                //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                                data = '<div class="">  <a class="btn btn_actions btn_edit me-3" data-bs-toggle="tooltip" data-bs-custom-class="view-tooltip" data-bs-placement="top" data-bs-title="View Detailed" href="InstallmentHistory.php?opid=' + data + '" ><i class="material-icons">edit</i> </a></div>'
                            }
                            return data;
                        }
                    },
                    {
                        data: 'purchase_main_id',
                        "render": function(data, type, row, meta) {
                            if (type == 'display') {
                                //data = '<button class=" btn btn_actions btn_edit me-3  shadow-none" type="button" data-bs-toggle="tooltip" data-bs-custom-class="edit-tooltip" data-bs-placement="top" data-bs-title="Edit" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                                data = '<div class="">  <a class="btn btn_actions btn_edit me-3" data-bs-toggle="tooltip" data-bs-custom-class="view-tooltip" data-bs-placement="top" data-bs-title="View Detailed" href="InstallmentHistory.php?opid=' + data + '" ><i class="material-icons">delete</i> </a></div>'
                            }
                            return data;
                        }
                    }
                ]
            });

            // Refilter the table
            $('#min, #max').on('change', function() {
                table.draw();
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