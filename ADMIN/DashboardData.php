<?php

require "../MAIN/Dbconn.php"; 

    //DOUGH CHART SERVICE MODE
    if(isset($_POST["month"])){
        $year_service_mode = date("Y");
        $mon = $_POST["month"];
        $query = "SELECT pickup_mode, COUNT(so_id) FROM service_order WHERE MONTH(pickup_date) = '$mon' AND YEAR(pickup_date) = '$year_service_mode' GROUP BY pickup_mode";
    

        $result = mysqli_query($con,$query);

        $data = array();

        foreach($result as $row)
        {
            $data[] = array(
                'service_mode' =>	$row["pickup_mode"],
                'total'	=>	$row["COUNT(so_id)"],
            );
        }

        echo json_encode($data);
    }


    //BAR CHART SEVICE TOTAL
    if(isset($_POST["year"])){
        $year = $_POST["year"];
        $query_year = "SELECT DATE_FORMAT(pickup_date, '%b') AS month ,COUNT(so_id) FROM `service_order` WHERE YEAR(pickup_date) = '$year' GROUP BY MONTH(pickup_date)";
    

        $result_year = mysqli_query($con,$query_year);

        $data_year = array();

        foreach($result_year as $row_year)
        {
            $data_year[] = array(
                'month' =>	$row_year["month"],
                'services'	=>	$row_year["COUNT(so_id)"],
            );
        }

        echo json_encode($data_year);
    }

    //BAR CHART 2 SERVICE TYPES
    if(isset($_POST["type_month"])){
        $type_month = $_POST["type_month"];
        $type_year = date("Y");
        $query_type = "SELECT  s.service_name AS service_names, COUNT(s.service_name) AS totals FROM service_items si INNER JOIN service_main sm ON si.main_sr_id = sm.main_id INNER JOIN services s ON sm.sr_id = s.sr_id INNER JOIN service_order so ON si.so_id = so.so_id AND MONTH(pickup_date) = '$type_month' AND YEAR(pickup_date) = '$type_year' GROUP BY s.service_name";
    

        $result_type = mysqli_query($con,$query_type);

        $data_type = array();

        foreach($result_type as $row_type)
        {
            $data_type[] = array(
                'service_name' =>	$row_type["service_names"],
                'service_count'	=>	$row_type["totals"],
            );
        }

        echo json_encode($data_type);
    }



    //LINE CHART SALES
    if(isset($_POST["sale_year"])){
        $sale_year = $_POST["sale_year"];
        $query_sales = "SELECT DATE_FORMAT(purchase_date, '%M') AS month_sales , SUM(total)  AS total_sales FROM `order_details` WHERE pay_status = 'Paid' AND cancel_status <> '1' AND YEAR(purchase_date) = '$sale_year' GROUP BY  MONTH(purchase_date)";
    

        $result_sales = mysqli_query($con,$query_sales);

        $data_sales = array();

        foreach($result_sales as $row_sales)
        {
            $data_sales[] = array(
                'month_sales' =>	$row_sales["month_sales"],
                'total_sales'	=>	$row_sales["total_sales"],
            );
        }

        echo json_encode($data_sales);
    }



?>