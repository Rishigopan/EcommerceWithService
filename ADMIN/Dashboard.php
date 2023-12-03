<?php

require "../MAIN/Dbconn.php"; 

if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

    if ($_COOKIE['custtypecookie'] != 'admin') {
        header("location:../login.php");
    } else {
    }
} else {
    header("location:../login.php");
}

$month_now = date("m");
$day_now = date("d");
$year_now = date("Y");

$PageTitle = 'Dashboard';
?>



<!doctype html>
<html lang="en">

<head>

    <?php

    require "../MAIN/Header.php";

    ?>

</head>

<body>



    <!--NAVBAR-->
    <nav class="navbar shadow-sm fixed-top">
        <div class="container-fluid">
            <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
            <a class="navbar-text">
                <h5>Dashboard</h5>
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


    <div id="Content">
        <div class="container-fluid dashboard">

            <div class="row">
                <!--SERVICE SUMMARY-->
                <div class="col-md-8 col-xl-5 col-12 mb-3">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h6 class="my-auto ">Yearly Service Summary</h6>
                                <div>
                                    <select name="" id="select_year" class="form-select py-0  shadow-none">
                                        <option hidden value=""> <?php echo $year_now; ?> </option>
                                        <?php
                                        $fetch_year = mysqli_query($con, "SELECT DISTINCT(YEAR(pickup_date)) AS years FROM service_order");
                                        foreach ($fetch_year as $years) {
                                            echo '<option value=' . $years['years'] . '>' . $years['years'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="charts">
                                <canvas id="mybarChart" width="" height=""></canvas>
                            </div>
                            <?php

                            $data_year_service = "";
                            $label_year_service = "";
                            $sql_year_service = "SELECT DATE_FORMAT(pickup_date, '%b') AS month ,COUNT(so_id) FROM `service_order` WHERE YEAR(pickup_date) = '$year_now' GROUP BY MONTH(pickup_date);";
                            $result_year_service = mysqli_query($con, $sql_year_service);

                            // Create data in comma seperated string
                            while ($row_year_service = mysqli_fetch_assoc($result_year_service)) {
                                $label_year_service .= "'" . $row_year_service['month'] . "',";
                                $data_year_service .= $row_year_service['COUNT(so_id)'] . ",";
                            }

                            // Remove the last comma from the string
                            $new_label_year_service = trim($label_year_service, ",");
                            $new_data_year_service = trim($data_year_service, ",");
                            //echo $new_data_year_service;
                            //echo $new_label_year_service;

                            ?>
                        </div>
                    </div>
                </div>

                <!--SERVICE MODES-->
                <div class="col-md-4 col-xl-3 col-12 mb-3">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h6 class="my-auto">Service Modes</h6>
                                <div>
                                    <select name="" id="select_month" class="form-select py-0 shadow-none ">
                                        <option hidden value=""> <?php echo date("F"); ?> </option>
                                        <?php

                                        $fetch_months = mysqli_query($con, "SELECT DISTINCT(MONTH(pickup_date)) AS month, DATE_FORMAT(pickup_date, '%M') AS month_name FROM service_order WHERE YEAR(pickup_date) = '$year_now'");
                                        foreach ($fetch_months as $months) {
                                            echo '<option value=' . $months['month'] . '>' . $months['month_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="charts">
                                <canvas id="mypieChart" width="" height=""></canvas>
                            </div>
                            <?php

                            $data_dough = "";
                            $sql_dough = "SELECT pickup_mode, COUNT(so_id) FROM service_order WHERE MONTH(pickup_date) = '$month_now' AND YEAR(pickup_date) = '$year_now' GROUP BY pickup_mode";
                            $result_dough = mysqli_query($con, $sql_dough);

                            // Create data in comma seperated string
                            while ($row_dough = mysqli_fetch_assoc($result_dough)) {
                                $data_dough .= $row_dough['COUNT(so_id)'] . ",";
                            }

                            // Remove the last comma from the string
                            $new_data_dough = trim($data_dough, ",");
                            //$new_data_dough;

                            ?>
                        </div>
                    </div>
                </div>


                <!--MIN CARDS-->
                <div class="col-md-5 col-xl-4 col-12 mb-3">
                    <div class="col-12">
                        <div class="card mincard shadow-sm">
                            <div class="card-body mincard-body" style="background-color: rgba(245, 4, 20,1)">
                                <div class="row g-0 align-items-center mincard-col">
                                    <div class="col">
                                        <div class="d-flex">
                                            <?php
                                            $active_query = mysqli_query($con, "SELECT COUNT(so_id) FROM service_order WHERE stat NOT IN(0,3) AND in_service IN (0,1)");
                                            if (mysqli_num_rows($active_query) > 0) {
                                                foreach ($active_query as $active) {
                                                    $active_services = $active['COUNT(so_id)'];
                                                }
                                            } else {
                                                $active_services = 0;
                                            }

                                            ?>
                                            <h3 data-target="120" class="count"> <?php echo $active_services; ?></h3>
                                        </div>
                                        <h6 class="d-none d-sm-block">Active Services</h6>
                                    </div>
                                    <div class="col-auto">
                                        <i class="material-icons ico-card" style="font-size: 50px; opacity: 0.7;">build</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="card mincard shadow-sm">
                            <div class="card-body mincard-body" style="background-color: rgba(245,255,255,1)">
                                <div class="row g-0 align-items-center mincard-col" style="color: #F50414;">
                                    <div class="col">
                                        <div class="d-flex">
                                            <?php

                                            $revenue_query = mysqli_query($con, "SELECT SUM(total) FROM `order_details` WHERE MONTH(purchase_date) = '$month_now' AND DAY(purchase_date) = '$day_now' AND pay_status = 'Paid' AND cancel_status <> 1");
                                            if (mysqli_num_rows($revenue_query) > 0) {
                                                foreach ($revenue_query as $revenue) {
                                                    $total_revenue = $revenue['SUM(total)'];
                                                }
                                            } else {
                                                $total_revenue = 0;
                                            }
                                            ?>
                                            <h3 data-target="120" class="count"> &#8377; <?php echo number_format($total_revenue) ?></h3>

                                        </div>
                                        <h6 class="d-none d-sm-block">Sales Amount</h6>
                                    </div>
                                    <div class="col-auto">
                                        <i class="material-icons ico-card" style="font-size: 50px; opacity: 1;">paid</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <div class="card mincard shadow-sm">
                            <div class="card-body mincard-body" style="background-color:rgba(245, 4, 20,1);">
                                <div class="row g-0 align-items-center mincard-col">
                                    <div class="col">
                                        <div class="d-flex">
                                            <?php
                                            $sales_query = mysqli_query($con, "SELECT COUNT(order_id) FROM `order_details` WHERE cancel_status <> '1' AND DAY(purchase_date) = '$day_now' AND MONTH(purchase_date) = '$month_now'");
                                            if (mysqli_num_rows($sales_query) > 0) {
                                                foreach ($sales_query as $sales) {
                                                    $total_sales = $sales['COUNT(order_id)'];
                                                }
                                            } else {
                                                $total_sales = 0;
                                            }
                                            ?>
                                            <h3 data-target="120" class="count"> <?php echo $total_sales ?> </h3>
                                        </div>
                                        <h6 class="d-none d-sm-block">Total Sales</h6>
                                    </div>
                                    <div class="col-auto">
                                        <i class="material-icons ico-card" style="font-size: 50px; opacity: 0.7;">point_of_sale</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="card mincard shadow-sm">
                            <div class="card-body mincard-body" style="background-color: rgba(255, 255, 255,1);">
                                <div class="row g-0 align-items-center mincard-col" style="color: #F50414;">
                                    <div class="col">
                                        <div class="d-flex">
                                            <?php
                                            $user_query = mysqli_query($con, "SELECT COUNT(user_id) FROM `user_details` WHERE type = 'customer'");
                                            if (mysqli_num_rows($user_query) > 0) {
                                                foreach ($user_query as $users) {
                                                    $total_users = $users['COUNT(user_id)'];
                                                }
                                            } else {
                                                $total_users = 0;
                                            }
                                            ?>
                                            <h3 data-target="120" class="count"><?php echo $total_users; ?></h3>
                                        </div>
                                        <h6 class="d-none d-sm-block">Total Users</h6>
                                    </div>
                                    <div class="col-auto">
                                        <i class="material-icons ico-card" style="font-size: 50px; opacity: 1;">face</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="card mincard shadow-sm">
                            <div class="card-body mincard-body" style="background-color:rgba(245, 4, 20,1);">
                                <div class="row g-0 align-items-center mincard-col">
                                    <div class="col">
                                        <div class="d-flex">
                                            <?php
                                            $service_amount = mysqli_query($con, "SELECT SUM(sm.cost) AS total_service FROM service_order so INNER JOIN service_items si ON so.so_id = si.so_id INNER JOIN service_main sm ON si.main_sr_id = sm.main_id WHERE so.tracker = 'Completed' AND DAY(delivered_date) = '$day_now' AND MONTH(delivered_date) = '$month_now'");
                                            if (mysqli_num_rows($service_amount) > 0) {
                                                foreach ($service_amount as $services) {
                                                    $total_services = $services['total_service'];
                                                }
                                            } else {
                                                $total_services = 0;
                                            }
                                            ?>
                                            <h3 data-target="120" class="count"> &#8377; <?php echo number_format($total_services);  ?> </h3>
                                        </div>
                                        <h6 class="d-none d-sm-block">Service Amount</h6>
                                    </div>
                                    <div class="col-auto">
                                        <i class="material-icons ico-card" style="font-size: 50px; opacity: 0.7;">paid</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>


                <!--TASKS SUMMARY-->
                <div class="col-md-7 col-xl-6 col-12 mb-3">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h6 class="my-auto">Tasks Summary</h6>
                                <input type="date" class="form-control py-0 shadow-none" style="width: 180px;">
                            </div>
                        </div>
                        <div class="card-body px-1 p-0 table-responsive" id="Table_card">
                            <table class="table table-borderless">
                                <thead class="text-muted">
                                    <tr>
                                        <th>No.</th>
                                        <th>Service</th>
                                        <th>Technician</th>
                                        <th>Progress</th>
                                        <th>Deadline</th>
                                    </tr>
                                </thead>
                                <tbody class="text-muted">
                                    <tr>
                                        <td>1</td>
                                        <td> <a href=""> Screen Replacement</a></td>
                                        <td>Sudhakar</td>
                                        <td><span class="badge success rounded-pill">Completed</span></td>
                                        <td>22 Aug 2022</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td> <a href=""> Screen Replacement</a></td>
                                        <td>Sudhakar</td>
                                        <td><span class="badge inprogress rounded-pill">Inprogress</span></td>
                                        <td>22 Aug 2022</td>
                                    </tr>



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



                <!--SALES SUMMARY-->
                <div class="col-md-6 col-xl-6 col-12 mb-3">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h6 class="my-auto">Yearly Sales Summary</h6>
                                <div>
                                    <select name="" id="sales_year" class="form-select py-0  shadow-none">
                                        <option hidden value=""> <?php echo $year_now; ?> </option>
                                        <?php
                                        $fetch_sales_year = mysqli_query($con, "SELECT DISTINCT(YEAR(purchase_date)) AS years FROM order_details");
                                        foreach ($fetch_sales_year as $sales_years) {
                                            echo '<option value=' . $sales_years['years'] . '>' . $sales_years['years'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="charts">
                                <canvas id="mylineChart" width="" height=""></canvas>
                            </div>
                            <?php

                            $data_sales = "";
                            $label_sales = "";
                            $sql_sales = "SELECT DATE_FORMAT(purchase_date, '%M') AS month_sales , SUM(total)  AS total_sales FROM `order_details` WHERE pay_status = 'Paid' AND cancel_status <> '1' AND YEAR(purchase_date) = '$year_now' GROUP BY  MONTH(purchase_date)";
                            $result_sales = mysqli_query($con, $sql_sales);

                            // Create data in comma seperated string
                            while ($row_sales = mysqli_fetch_assoc($result_sales)) {
                                $label_sales .= "'" . $row_sales['month_sales'] . "',";
                                $data_sales .= $row_sales['total_sales'] . ",";
                            }

                            // Remove the last comma from the string
                            $new_label_sales = trim($label_sales, ",");
                            $new_data_sales = trim($data_sales, ",");
                            //echo  $new_label_sales;
                            //echo $new_data_sales; 
                            ?>
                        </div>
                    </div>
                </div>


                <!--SERVICE TYPES-->
                <div class="col-md-6 col-xl-6 col-12 mb-3">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h6 class="my-auto">Monthly Service Types</h6>
                                <div>
                                    <select name="" id="select_month_type" class="form-select py-0 shadow-none ">
                                        <option hidden value=""> <?php echo date("F"); ?> </option>
                                        <?php
                                        $fetch_months = mysqli_query($con, "SELECT DISTINCT(MONTH(pickup_date)) AS month, DATE_FORMAT(pickup_date, '%M') AS month_name FROM service_order WHERE YEAR(pickup_date) = '$year_now'");
                                        foreach ($fetch_months as $months) {
                                            echo '<option value=' . $months['month'] . '>' . $months['month_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="charts">
                                <canvas id="mybarChart2" width="" height=""></canvas>
                            </div>
                            <?php

                            $data_service_type = "";
                            $label_service_type = "";
                            $sql_service_type = "SELECT s.service_name AS service_names, COUNT(s.service_name) AS totals FROM service_items si INNER JOIN service_main sm ON si.main_sr_id = sm.main_id INNER JOIN services s ON sm.sr_id = s.sr_id INNER JOIN service_order so ON si.so_id = so.so_id AND MONTH(pickup_date) = '$month_now' AND YEAR(pickup_date) = '$year_now' GROUP BY s.service_name;";
                            $result_service_type = mysqli_query($con, $sql_service_type);

                            // Create data in comma seperated string
                            while ($row_service_type = mysqli_fetch_assoc($result_service_type)) {
                                $label_service_type .= "'" . $row_service_type['service_names'] . "',";
                                $data_service_type .= $row_service_type['totals'] . ",";
                            }

                            // Remove the last comma from the string
                            $new_data_service_type = trim($data_service_type, ",");
                            $new_label_service_type = trim($label_service_type, ",");
                            //echo $new_data_service_type;
                            //echo $new_label_service_type;
                            ?>
                        </div>
                    </div>
                </div>


                <!--EMPLOYEE SUMMARY-->
                <div class="col-md-6 col-xl-6 col-12 mb-3">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h6 class="my-auto">Employee Summary</h6>
                                <div class="d-flex">
                                    <div>
                                        <select name="" id="employee_month" class="form-select py-0 shadow-none ">
                                            <option hidden value=""> <?php echo date("F"); ?> </option>
                                            <?php
                                            $fetch_months = mysqli_query($con, "SELECT DISTINCT(MONTH(pickup_date)) AS month, DATE_FORMAT(pickup_date, '%M') AS month_name FROM service_order WHERE YEAR(pickup_date) = '2022'");
                                            foreach ($fetch_months as $months) {
                                                echo '<option value=' . $months['month'] . '>' . $months['month_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="ms-3">
                                        <select name="" id="" class="form-select py-0 shadow-none">
                                            <option value="">Technician</option>
                                            <option value="">Delivery</option>

                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="charts">
                                <canvas id="mybarChart3" width="" height=""></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <script>
        /*LINE CHART sales  start */
        var sales_data = [<?= $new_data_sales ?>];
        var sales_label = [<?= $new_label_sales ?>];
        const line = document.getElementById('mylineChart').getContext("2d");
        const mylineChart = new Chart(line, {
            type: 'line',
            data: {
                labels: sales_label,
                datasets: [{
                    label: 'Total Sales',
                    data: sales_data,
                    borderColor: 'rgba(245, 4, 20,1)',
                    borderWidth: 2,
                    tension: 0,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        grid: {
                            borderDash: [9, 3],
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(250,250,250,1)',
                        borderColor: 'rgba(0,0,0,1)',
                        borderWidth: 0.2,
                        bodyColor: 'rgba(0,0,0,1)',
                        titleColor: 'rgba(0,0,0,1)'
                    }
                }
            }
        });

        $('#sales_year').change(function() {

            var sale_year = $(this).val();
            //console.log(sale_year);

            $.ajax({
                method: "POST",
                url: "DashboardData.php",
                data: {
                    sale_year: sale_year
                },
                dataType: "JSON",
                success: function(data) {
                    //console.log(data);

                    var month_sales = [];
                    var total_sales = [];

                    for (var count = 0; count < data.length; count++) {
                        month_sales.push(data[count].month_sales);
                        total_sales.push(data[count].total_sales);
                    }


                    var line_data = {
                        labels: month_sales,
                        datasets: [{
                            label: 'No. of Services',
                            data: total_sales,
                            borderColor: 'rgba(245, 4, 20,1)',
                            borderWidth: 2,
                            tension: 0,
                            fill: false
                        }]
                    };

                    mylineChart.data = line_data;
                    mylineChart.update();

                }
            });
        });
        /*LINE CHART  end */



        /*BAR CHART 2 service types start*/
        var month_type_data = [<?= $new_data_service_type ?>];
        var month_type_label = [<?= $new_label_service_type ?>];
        const ctxxxr = document.getElementById('mybarChart2').getContext("2d");

        const mybarChart2 = new Chart(ctxxxr, {
            type: 'bar',
            data: {
                labels: month_type_label,
                datasets: [{
                    label: 'No. of Services',
                    data: month_type_data,
                    backgroundColor: 'rgba(245, 4, 20,1)',
                    borderRadius: 10,
                    barPercentage: 0.3
                }]
            },
            options: {
                scales: {
                    y: {
                        grid: {
                            borderDash: [9, 3],
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: 'rgba(250,250,250,1)',
                        borderColor: 'rgba(0,0,0,1)',
                        borderWidth: 0.2,
                        bodyColor: 'rgba(0,0,0,1)',
                        titleColor: 'rgba(0,0,0,1)'
                    }
                }
            }
        });



        $('#select_month_type').change(function() {

            var type_month = $(this).val();
            //console.log(type_month);

            $.ajax({
                method: "POST",
                url: "DashboardData.php",
                data: {
                    type_month: type_month
                },
                dataType: "JSON",
                success: function(data) {
                    //console.log(data);

                    var service_names = [];
                    var service_count = [];

                    for (var count = 0; count < data.length; count++) {
                        service_names.push(data[count].service_name);
                        service_count.push(data[count].service_count);
                    }


                    var bar2_service_data = {
                        labels: service_names,
                        datasets: [{
                            label: 'No. of Services',
                            color: '#fff',
                            data: service_count,
                            backgroundColor: 'rgba(245, 4, 20,1)',
                            borderRadius: 10,
                            barPercentage: 0.3
                        }]
                    };

                    mybarChart2.data = bar2_service_data;
                    mybarChart2.update();

                }
            });
        });


        /*BAR CHART 2  end*/



        /*BAR CHART total services start*/
        var year_wise_data = [<?= $new_data_year_service ?>];
        var year_wise_label = [<?= $new_label_year_service ?>];
        const ctxrx = document.getElementById('mybarChart').getContext("2d");
        const mybarChart = new Chart(ctxrx, {
            type: 'bar',
            data: {
                labels: year_wise_label,
                datasets: [{
                    label: 'Total Services',
                    data: year_wise_data,
                    backgroundColor: 'rgba(245, 4, 20,1)',
                    borderRadius: 10,
                    barPercentage: 0.3
                }]
            },
            options: {
                scales: {
                    y: {
                        grid: {
                            borderDash: [9, 3],
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: 'rgba(250,250,250,1)',
                        borderColor: 'rgba(0,0,0,1)',
                        borderWidth: 0.2,
                        bodyColor: 'rgba(0,0,0,1)',
                        titleColor: 'rgba(0,0,0,1)'
                    }
                }
            }
        });

        $('#select_year').change(function() {

            var year = $(this).val();
            //console.log(year);

            $.ajax({
                method: "POST",
                url: "DashboardData.php",
                data: {
                    year: year
                },
                dataType: "JSON",
                success: function(data) {
                    //console.log(data);

                    var month = [];
                    var services = [];

                    for (var count = 0; count < data.length; count++) {
                        month.push(data[count].month);
                        services.push(data[count].services);
                    }


                    var bar_yeardata = {
                        labels: month,
                        datasets: [{
                            label: 'Total Services',
                            color: '#fff',
                            data: services,
                            backgroundColor: 'rgba(245, 4, 20,1)',
                            borderRadius: 10,
                            barPercentage: 0.3
                        }]
                    };

                    mybarChart.data = bar_yeardata;
                    mybarChart.update();

                }
            });
        });
        /*BAR CHART End*/


        /*DOUGH CHART service_mode Start*/
        var val = [<?= $new_data_dough ?>];
        const ctx = document.getElementById('mypieChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Doorstep", "Shop"],
                datasets: [{
                    label: '# of Services',
                    color: '#fff',
                    data: val,
                    backgroundColor: [
                        'rgba(245, 4, 20,1)',
                        'rgba(211, 211, 211,1)'
                    ],
                    borderWidth: 0.5,
                    borderRadius: 0,
                    weight: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(250,250,250,1)',
                        borderColor: 'rgba(0,0,0,1)',
                        borderWidth: 0.2,
                        bodyColor: 'rgba(0,0,0,1)',
                        titleColor: 'rgba(0,0,0,1)'
                    }
                }
            }
        });

        $('#select_month').change(function() {

            var month = $(this).val();
            //console.log(month);

            $.ajax({
                method: "POST",
                url: "DashboardData.php",
                data: {
                    month: month
                },
                dataType: "JSON",
                success: function(data) {
                    //console.log(data);

                    var servicemode = [];
                    var total = [];

                    for (var count = 0; count < data.length; count++) {
                        servicemode.push(data[count].service_mode);
                        total.push(data[count].total);
                    }

                    var chart_data = {
                        labels: servicemode,
                        datasets: [{
                            label: 'Counts',
                            color: '#fff',
                            data: total,
                            backgroundColor: [
                                'rgba(245, 4, 20,1)',
                                'rgba(211, 211, 211,1)'
                            ],
                            borderWidth: 0.5,
                            borderRadius: 0,
                            weight: 1
                        }]
                    };

                    myChart.data = chart_data;
                    myChart.update();
                }
            });
        });

        /*DOUGH CHART  End*/
    </script>

    <?php
    include "../MAIN/Footer.php";
    ?>


</body>

</html>