<?php


require "../MAIN/Dbconn.php"; 

//$draw = $_POST['draw'];

$find_data = mysqli_query($con, "SELECT * FROM service_main sm INNER JOIN brands b ON sm.br_id = b.br_id INNER JOIN series se ON sm.se_id = se.se_id INNER JOIN products P ON sm.mo_id = P.pr_id INNER JOIN services sr ON sm.sr_id = sr.sr_id");
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


?>