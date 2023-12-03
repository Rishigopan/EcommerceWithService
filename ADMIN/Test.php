<?php




require "../MAIN/Dbconn.php"; 



if(isset($_GET['SearchProducts'])){
    $SearchValue = $_GET['SearchProducts'];
    $find_data = mysqli_query($con, "SELECT P.pr_id,P.current_stock,P.imei,P.barcode,CONCAT(B.brand_name, ' ',P.name) as ProductName FROM products P INNER JOIN brands B ON P.brand = B.br_id
    ");
    if(mysqli_num_rows($find_data) > 0){
        while ($dataRow = mysqli_fetch_assoc($find_data)) {
            $rows[] = $dataRow;
        }
    }
    else{
        $rows = array();
    }
    echo json_encode($rows);
}










?>