<?php




require "../MAIN/Dbconn.php"; 


$find_data = mysqli_query($con, "SELECT mo_id,model_name,series_name,brand_name,model_img FROM models m  INNER JOIN series s ON m.se_id = s.se_id INNER JOIN brands b ON s.br_id = b.br_id ORDER BY brand_name ASC");
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