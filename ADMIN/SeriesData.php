<?php




require "../MAIN/Dbconn.php"; 


$find_data = mysqli_query($con, "SELECT se_id,brand_name,series_name FROM series s INNER JOIN brands b ON s.br_id = b.br_id ORDER BY brand_name ASC");
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