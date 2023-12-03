<?php



require "../MAIN/Dbconn.php"; 


$find_data = mysqli_query($con, "SELECT br_id,brand_name,brand_img,isSales,isService FROM brands ORDER BY brand_name ASC");
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