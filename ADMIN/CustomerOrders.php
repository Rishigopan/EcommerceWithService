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
$PageTitle = 'SalesOrders';
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
                    <h5>Sales Orders</h5>
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




        <!-- DELETE MODAL -->
        <div class="modal fade" id="cancel_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-end">
                            <button type="button" class="btn-close bg-white shadow-none" data-bs-dismiss="modal" aria-label="Close" style="width: 50px;"></button>
                        </div>
                        <h4 class="mb-4 text-center">Do You want to cancel this service ?</h4>
                        <div class="text-center">
                            <button type="button" class="btn me-3">Yes</button>
                            <button type="button" class="btn ">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!--CONTENT-->
        <div id="Content" class="mb-5">


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
                                        <input type="text" class="form-control ms-2 w-75" id="min" name="min" readonly>
                                    </label>

                                </div>
                                <div class="ms-3">
                                    <label for="max" class="d-flex">
                                        <span class="mt-2">To</span>
                                        <input type="text" class="form-control ms-2 w-75" id="max" name="max" readonly>
                                    </label>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card card-body mt-3 px-0">
                    <table class="table table-hover" id="CustomerOrdersTable" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">Bill Id</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Contact No</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Details</th>
                                <!-- <th class="">Actions</th> -->
                                <!-- <th class="text-center">Pay Status</th>
                                    <th>M.O.P</th>
                                    <th>Purchase Date</th>
                                    <th>Delivery Status</th>
                                    <th>Delivery Agent</th>
                                    <th>Expected Date</th>
                                    <th>Biller</th> -->
                            </tr>
                        </thead>
                        <tbody class="text-center">


                        </tbody>
                    </table>
                </div>

            </div>


        </div>

    </div>




    <script>
        var minDate, maxDate;

        // Custom filtering function which will search data in column four between two values
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var min_date = document.getElementById("min").value;
                var min = new Date(min_date);
                //console.log(min);
                var max_date = document.getElementById("max").value;
                var max = new Date(max_date);

                var startDate = new Date(data[4]);
                //window.confirm(startDate);
                if (!min_date && !max_date) {
                    return true;
                }
                if (!min_date && startDate <= max) {
                    return true;
                }
                if (!max_date && startDate >= min) {
                    return true;
                }
                if (startDate <= max && startDate >= min) {
                    return true;
                }
                return false;
            }
        );


        // Create date inputs
        minDate = new DateTime($('#min'), {
            format: 'M/D/YYYY'
        });
        maxDate = new DateTime($('#max'), {
            format: 'M/D/YYYY'
        });


        // Refilter the table
        $('#min, #max').on('change', function() {
            MasterTable.draw();
        });


        //data Table
        var MasterTable = $('#CustomerOrdersTable').DataTable({
            "processing": true,
            "responsive": true,
            "ajax": "OtherDatas.php?CustomerOrders",
            "scrollY": "500px",
            //"scrollX": true,
            "scrollCollapse": true,
            //"fixedHeader": true,
            "dom": 'rt<"bottom"ip>',
            "pageLength": 10,
            "pagingType": 'simple_numbers',
            "language": {
                "paginate": {
                    "previous": "<i class='bi bi-caret-left-fill'></i>",
                    "next": "<i class='bi bi-caret-right-fill'></i>"
                }
            },
            "columns": [{
                    data: 'billid'
                },
                {
                    data: 'customername'
                },
                {
                    data: 'contactno'
                },
                {
                    data: 'billdate',
                    render: function(data, type, row, meta) {
                        if (type === 'sort') {
                            return data;
                        }
                        return moment(data).format("MMM D , YYYY");
                    }
                },
                {
                    data: 'totalqty',
                    searchable: false
                },
                
                {
                    data: 'totalamount',
                    searchable: false
                },
               
                {
                    data: 'billid',
                    searchable: false,
                    orderable: false,
                    "render": function(data, type, row, meta) {
                        if (type == 'display') {
                            data =
                                '<div class="d-flex justify-content-center">  <a class="btn shadow-none btn-info p-0 px-2" data-bs-toggle="tooltip" data-bs-custom-class="view-tooltip" data-bs-placement="top" data-bs-title="View"  target="_blank" href="ViewSalesOrder.php?OID=' + data + '">View Order</a>  </div>'
                        }
                        return data;
                    }
                },

              
            ]
        });
    </script>

    <?php
    include "../MAIN/Footer.php";
    ?>

</body>

</html>