<?php


require "../MAIN/Dbconn.php"; 

if(isset($_GET['CustomerOrders'])){
    $find_data = mysqli_query($con, "SELECT billid,customername,billdate,totalqty,totalamount,contactno,address FROM bill WHERE type = 'EC'");
    if(mysqli_num_rows($find_data) > 0){
        while ($dataRow = mysqli_fetch_assoc($find_data)) {
            $rows[] = $dataRow;
        }
    }
    else{
        $rows = array();
    }
    
    $dataset = array(
        //"sEcho" => 1,
        //"iTotalRecords"=> "0",
        //"iTotalDisplayRecords"=> "0",
        "aaData" => $rows
    );
    
    echo json_encode($dataset);
}




?>