<?php

require "../MAIN/Dbconn.php"; 



//Select Brands
if (isset($_POST["selectBrand"])) {

    $fetch_selectBrand = mysqli_query($con, "SELECT br_id,brand_name FROM brands");

    echo '<option value="" hidden>Select a Brand</option>';
    if (mysqli_num_rows($fetch_selectBrand) > 0) {
        foreach ($fetch_selectBrand as $selectBrand) {
    ?>
            <option value="<?php echo $selectBrand['br_id']; ?>"> <?php echo $selectBrand['brand_name']; ?> </option>

        <?php

        }
    } else {
        echo '';
    }
}


//Select Series
if (isset($_POST["selectSeries"])) {

    $BrandId = $_POST['selectSeries'];

    $fetch_selectSeries = mysqli_query($con, "SELECT se_id,series_name FROM series WHERE br_id = '$BrandId'");


    if (mysqli_num_rows($fetch_selectSeries) > 0) {
        foreach ($fetch_selectSeries as $selectSeries) {
        ?>
            <option value="<?php echo $selectSeries['se_id']; ?>"> <?php echo $selectSeries['series_name']; ?> </option>

        <?php

        }
    } else {
        echo '<option value="" hidden>Select a Series</option>';
    }
}



//Select Series on Edit
if (isset($_POST["selectSeriesEdit"])) {

    $fetch_selectSeriesEdit = mysqli_query($con, "SELECT se_id,series_name FROM series");

    echo '<option value="" hidden>Select a Series</option>';
    if (mysqli_num_rows($fetch_selectSeriesEdit) > 0) {
        foreach ($fetch_selectSeriesEdit as $selectSeriesEdit) {
        ?>
            <option value="<?php echo $selectSeriesEdit['se_id']; ?>"> <?php echo $selectSeriesEdit['series_name']; ?> </option>

        <?php

        }
    } else {
        echo '';
    }
}




//Find Item details on Barcode
if (isset($_POST['BarcodeProductId'])) {

    $BarProductId = $_POST['BarcodeProductId'];
    $FindProductDetails = mysqli_query($con, "SELECT * FROM products P INNER JOIN brands B ON P.brand = B.br_id WHERE P.pr_id = '$BarProductId'");
    foreach ($FindProductDetails as $FindProductDetailsResult) {
        $ProductName = $FindProductDetailsResult['name'];
        $ProductMrp = $FindProductDetailsResult['mrp'];
        $ProductSp = $FindProductDetailsResult['price'];
        $ProductBarcode = $FindProductDetailsResult['barcode'];
        $ProductColor = $FindProductDetailsResult['color'];
        $ProductMini = $FindProductDetailsResult['mini_desc'];
        $ProductBrand = $FindProductDetailsResult['brand_name'];
    }

    echo json_encode(array('Status' => 1, 'Name' => $ProductName, 'MRP' => $ProductMrp, 'SP' => $ProductSp, 'Barcode' => $ProductBarcode, 'Mini' => $ProductMini, 'Color' => $ProductColor , 'Brand' => $ProductBrand));
}




//Show Assigned Agents of nearby Taluk
if (isset($_POST["ShowAssignedAgents"])) {

    $FindNearbyAssignedData = mysqli_query($con, "SELECT N.nearbyId,N.nearbyTaluk,N.employeeAssigned,U.first_name FROM nearby_master N LEFT JOIN user_details U ON N.employeeAssigned = U.user_id ");
    if(mysqli_num_rows($FindNearbyAssignedData) > 0){
        $AssignCount = 0;
        foreach($FindNearbyAssignedData as $FindNearbyAssignedDataResults){
            $AssignCount ++;
            ?>
            <tr>
                <td><?= $AssignCount ?></td>
                <td><?= $FindNearbyAssignedDataResults['nearbyTaluk'] ?></td>
                <td> 
                    <div class="row">
                        <div class="col-lg-3 col-0"></div>
                        <div class="col-lg-5 col-12">
                            <select class="form-select AssignNearbyAgent" data-nearby="<?= $FindNearbyAssignedDataResults['nearbyId'] ?>">
                                <?php   
                                    if($FindNearbyAssignedDataResults['employeeAssigned'] != 0){
                                        echo '<option value="'.$FindNearbyAssignedDataResults['employeeAssigned'] .'">'.$FindNearbyAssignedDataResults['first_name'].'</option>';
                                    }else{
                                        echo '<option value="">Assign Agent</option>';
                                    }
                                
                                    $FindEmployees = mysqli_query($con, "SELECT user_id,first_name FROM user_details WHERE type ='delivery'");
                                    foreach($FindEmployees as $FindEmployeesResult){
                                        echo '<option value="'.$FindEmployeesResult["user_id"].'">'.$FindEmployeesResult["first_name"].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-3 col-0"></div>
                    </div>
                </td>
                <td>  <button class="btn btn-warning RemoveAgent rounded-pill px-2" value="<?= $FindNearbyAssignedDataResults['nearbyId'] ?>"> Remove </button> </td>
            </tr>

            <?php
        }
    }
   
    
}



?>