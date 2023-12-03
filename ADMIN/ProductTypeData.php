<?php


require "../MAIN/Dbconn.php"; 

//$draw = $_POST['draw'];

$find_data = mysqli_query($con, "SELECT * FROM producttype");
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