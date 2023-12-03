<?php
require "../MAIN/Dbconn.php";

// if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

//     if ($_COOKIE['custtypecookie'] == 'executive' || $_COOKIE['custtypecookie'] == 'admin') {
//         echo "";
//     } else {
//         header("location:../login.php");
//     }
// } else {
//     header("location:../login.php");
// }
$PageTitle = 'AllServices';
?>

<!doctype html>
<html lang="en">

<head>

    <?php

    require "../MAIN/Header.php";

    ?>


    <style>
        .TableCard {
            border: none;
            border-radius: 10px;
        }

        .TableCard table thead th {
            border-bottom: 1px solid rgb(240, 240, 240);
            font-weight: 700;
            font-size: 15px;
        }

        .TableCard table {
            border: none !important;
        }

        .TableCard table tbody td {
            font-weight: 500;
            color: rgb(90, 90, 90);
            font-size: 14px;
            border-bottom: 1px solid rgb(240, 240, 240);

        }

        .TableCard table tbody td button,
        .TableCard table tbody td .TableButton {
            /* margin: 0px ; */
            padding: 3px 10px;
            font-size: 12px;
            border-radius: 20px;
            font-weight: 700;
        }

        .TableCard table tbody td button i {
            font-size: 18px;
        }

        .Searchbox {
            background-color: rgb(240, 240, 240);
            border: 1px solid rgb(240, 240, 240);
        }

        .Searchbox::-webkit-input-placeholder {
            /* Edge */
            color: darkgray;
            font-weight: 500;
        }

        .Searchbox:-ms-input-placeholder {
            /* Internet Explorer 10-11 */
            color: darkgray;
            font-weight: 500;
        }

        .Searchbox::placeholder {
            color: darkgray;
            font-weight: 500;
        }
    </style>

</head>

<body>




    <div class="wrapper">
        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5>My Service Tasks</h5>
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
                    <div class="card card-body shadow-sm py-2">
                        <div class="row">
                            <div class="col-3">
                                <input type="text" class="form-control ms-2 Searchbox" id="searchbox" placeholder="Search by Customer / OrderId">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-body TableCard px-3 mt-3">
                    <div class="row mb-2">
                        <div class="col-lg-1 col-2">
                            <select class="form-control py-0" id="pagelength">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="-1">All</option>
                            </select>
                        </div>
                    </div>

                    <table class="table table-hover table-borderless text-nowrap" style="width:100%;" id="MasterTable">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Order Id</th>
                                <th>Customer</th>
                                <th>Estimated Amt</th>
                                <!-- <th>Device</th>
                                    <th>Pickup Time</th>
                                    <th>Pickup Mode</th> -->
                                <!-- <th>M.O.P</th> -->
                                <!-- <th>Pay Status</th>
                                    <th>Pickup Agent</th>
                                    <th>Shop Deliver Time</th> -->
                                <!-- <th>Technician</th> -->
                                <th>Service Status</th>
                                <th>Date</th>
                                <th>Action</th>
                                <!-- <th>Service Start</th>
                                    <th>Service Finish</th> -->

                                <!--<th>Delivery Agent</th>
                                    <th>Delivered Date</th>
                                    <th>Tracker</th> -->
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>







            </div>

        </div>


        <script>
            //Master Table
            var MasterTable = $('#MasterTable').DataTable({
                "processing": true,
                "ajax": "../ADMIN/ServiceDatas.php?TechAllServices",
                // "scrollY": "500px",
                // "scrollX": true,
                //"serverSide": true,
                //"serverMethod": 'post',
                //"responsive": true,
                "fixedHeader": true,
                "dom": 'rt<"bottom"ip>',
                //"select":true,
                // "fixedColumns": {
                //     left: 2,
                //     right: 2
                // },
                "pageLength": 10,
                "pagingType": 'simple_numbers',
                "language": {
                    "paginate": {
                        "previous": "<i class='bi bi-caret-left-fill'></i>",
                        "next": "<i class='bi bi-caret-right-fill'></i>"
                    }
                },
                "initComplete": function() {
                    //console.log("helloo");
                    $("#MasterTable").wrap("<div style='overflow:auto; width:100%;height:65vh;position:relative;'></div>");
                },
                "columns": [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },

                    {
                        data: 'serviceBillNo',
                    },
                    {
                        data: 'custName',
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            if (data.totalAmount != 0) {
                                data = '&#8377; ' + parseFloat(data.totalAmount).toLocaleString('en-IN');
                            } else {
                                data = '&#8377; 0';
                            }
                            return data;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            if (data.stat == 0) {
                                data = '<span class="badge rounded-pill text-bg-warning px-3 py-1">&nbsp;&nbsp;Pending&nbsp;&nbsp;&nbsp;</span>'
                            } else if (data.stat == 3) {
                                data = '<span class="badge rounded-pill text-bg-warning px-3 py-1">For Service</span>'
                            } else if (data.stat == 4) {
                                data = '<span class="badge rounded-pill text-bg-success px-3 py-1">&nbsp;Diagnosis&nbsp;</span>'
                            } else if (data.stat == 5) {
                                data = '<span class="badge rounded-pill text-bg-success px-3 py-1">&nbsp;In Service&nbsp;</span>'
                            } else if (data.stat == 6) {
                                data = '<span class="badge rounded-pill text-bg-success px-3 py-1">&nbsp;&nbsp;&nbsp;Testing&nbsp;&nbsp;&nbsp;</span>'
                            } else if (data.stat == 8) {
                                data = '<span class="badge rounded-pill text-bg-success px-3 py-1">Completed</span>'
                            } else if (data.stat == 11) {
                                data = '<span class="badge rounded-pill text-bg-danger px-3 py-1">&nbsp;Cancelled&nbsp;</span>'
                            } else {
                                data = '<span class="badge rounded-pill text-bg-secondary">No Status</span>'
                            }
                            return data;
                        }
                    },
                    {
                        data: 'createdDate',
                        render: function(data, type, row, meta) {
                            if (type === 'sort') {
                                return data;
                            }
                            return moment(data).format("MMM D , YYYY");
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            if (data.stat >= 8) {
                                data = '<a role="button" href="ServiceWindow.php?ServiceOrderId=' + data.serviceBillId + '" class="btn TableButton btn-outline-secondary disabled">Take Service</a>';
                            } else {
                                data = '<a role="button" href="ServiceWindow.php?ServiceOrderId=' + data.serviceBillId + '" class="btn TableButton btn-outline-info">Take Service</a>';
                            }
                            return data;
                        }
                    }
                ]
            });

            $('#searchbox').keyup(function() {
                MasterTable.search($(this).val()).draw();
            })

            $('#pagelength').on('change', function() {
                MasterTable.page.len($(this).val()).draw();
            });
        </script>



        <?php
        include "../MAIN/Footer.php";
        ?>


</body>

</html>