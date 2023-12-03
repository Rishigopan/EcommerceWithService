<?php

require "../MAIN/Dbconn.php"; 


$find_data = mysqli_query($con, "SELECT ty_id,type_name FROM types");
if(mysqli_num_rows($find_data) > 0){

    while ($dataRow = mysqli_fetch_assoc($find_data)) {
        $rows[] = $dataRow;
    }
}
else{
    $rows = array();
}
$dataset = array(
    "data" => $rows
);

echo json_encode($dataset);


?>