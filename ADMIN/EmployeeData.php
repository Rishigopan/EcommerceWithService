<?php




require "../MAIN/Dbconn.php"; 


$find_data = mysqli_query($con, "SELECT * FROM user_details WHERE type NOT IN ('admin','customer') ORDER BY user_id DESC");
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