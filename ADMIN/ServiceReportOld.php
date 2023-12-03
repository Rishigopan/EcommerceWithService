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
$PageTitle = 'ServiceReport';
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
                    <h5>Service Report</h5>
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
                        <table class="table nowrap table-hover" id="service_table">
                            <thead>
                                <tr>
                                    <th data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">Order Id</th>
                                    <th>Name</th>
                                    <th>Device</th>
                                    <th>Pickup Time</th>
                                    <th>Pickup Mode</th>
                                    <th>M.O.P</th>
                                    <th>Pay Status</th>
                                    <th>Pickup Agent</th>
                                    <th>Shop Deliver Time</th>
                                    <th>Tech Agent</th>
                                    <th>Service Start</th>
                                    <th>Service Finish</th>
                                    <th>Service Status</th>
                                    <th>Delivery Agent</th>
                                    <th>Delivered Date</th>
                                    <th>Tracker</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $table_data = mysqli_query($con, "SELECT * FROM service_order so INNER JOIN brands b ON b.br_id = so.brand INNER JOIN models m ON m.mo_id = so.model");
                                while ($result = mysqli_fetch_array($table_data)) {
                                ?>
                                    <tr class="">

                                        <td class="text-center"><?php echo $result['so_id'] ?> </td>
                                        <td><?php echo $result['cust_name'] ?></td>
                                        <td><?php echo $result['brand_name'] . ' ' . $result['model_name']; ?></td>
                                        <td><?php echo date("d-m-Y", strtotime($result['pickup_date'])) . ' ' . $result['pickup_time']; ?></td>
                                        <td><?php echo $result['pickup_mode'] ?></td>
                                        <td><?php echo $result['mode_of_pay'] ?></td>
                                        <td class="text-center"> <?php if ($result["payment_status"] != "") {
                                                                        echo '<span class="badge px-3 badge-pay rounded-pill text-white">' . $result["payment_status"] . '</span>';
                                                                    } else {
                                                                        echo "";
                                                                    } ?></td>
                                        <td><?php echo $result['pickup_agentname']; ?></td>
                                        <td> <?php if ($result["shop_delivertime"] != '') {
                                                    echo date("d-m-Y h:i a", strtotime($result["shop_delivertime"]));
                                                } else {
                                                    echo "";
                                                }  ?> </td>
                                        <td><?php echo $result['tech_agentname']; ?></td>
                                        <td> <?php if ($result["tech_start"] != '') {
                                                    echo date("d-m-Y h:i a", strtotime($result["tech_start"]));
                                                } else {
                                                    echo "";
                                                }  ?></td>
                                        <td> <?php if ($result["tech_end"] != '') {
                                                    echo date("d-m-Y h:i a", strtotime($result["tech_end"]));
                                                } else {
                                                    echo "";
                                                }  ?></td>
                                        <td><?php echo $result['tech_status']; ?></td>
                                        <td><?php echo $result['delivery_agentname']; ?></td>
                                        <td> <?php if ($result["delivered_date"] != '') {
                                                    echo date("d-m-Y h:i a", strtotime($result["delivered_date"]));
                                                } else {
                                                    echo "";
                                                }  ?></td>
                                        <td><?php echo $result['tracker']; ?></td>

                                    </tr>
                                <?php
                                }
                                ?>
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
                var date = new Date(data[14]);

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
                pagingType: 'first_last_numbers',
                dom: '<"top"il>rt<"bottom"p>',
                order: [
                    [0, 'desc']
                ],
                "scrollX": true,
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