<?php


require "../MAIN/Dbconn.php"; 


//SELECT * FROM products p INNER JOIN brands b ON p.brand = b.br_id INNER JOIN types t ON t.ty_id = p.type
$find_data = mysqli_query($con, "SELECT * FROM products P LEFT JOIN brands b ON P.brand = b.br_id LEFT JOIN types t ON t.ty_id = P.type LEFT JOIN producttype PT ON P.productType = PT.productTypeId");
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