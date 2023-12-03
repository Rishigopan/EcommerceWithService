<?php


require "../MAIN/Dbconn.php"; 



$tempPurchaseTable = 'purchase_temp';

//Display cart items
if (isset($_POST["action"])) {

?>

    <div class="d-flex justify-content-between mb-2 px-3">
        <h4 class="m-0 pb-2 my-auto">Purchase Products</h4>
        <button class="btn py-0 shadow-none btn-danger clearAllBtn" type="button">Clear all</button>
    </div>

    <div class="table-responsive">

    

    <table class="table-striped table table_items">
        <thead class="text-center">
            <tr>
                <th>Sl No.</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Barcode</th>
                <th>IMEI</th>
                <th>Color</th>
                <th class="text-center">Delete</th>
            </tr>
        </thead>
        <tbody class="text-center">
    <?php
    $fetchCart = mysqli_query($con, "SELECT temp.pr_id AS tempPrid,p.name,p.parent_item_id,temp.current_stock,temp.price,temp.barcode,temp.imei,(SELECT SUM(temp.current_stock) FROM purchase_temp temp INNER JOIN products p ON temp.parent_item_id = p.parent_item_id WHERE temp.parent_item_id = p.pr_id) AS itemCount,(SELECT SUM(temp.price*temp.current_stock) FROM purchase_temp temp INNER JOIN products p ON temp.parent_item_id = p.parent_item_id WHERE temp.parent_item_id = p.pr_id) AS totalPrice FROM `purchase_temp` temp INNER JOIN products p ON temp.parent_item_id = p.parent_item_id WHERE temp.parent_item_id = p.pr_id");

    
    if (mysqli_num_rows($fetchCart) > 0) {
    foreach ($fetchCart as $Cart) {


?>
    <tr>
        <td><?php echo $Cart['tempPrid'];?></td>
        <td><?php echo $Cart['name']; ?></td>
        <td><?php echo number_format($Cart['current_stock']);  ?></td>
        <td><?php echo $Cart['price']; ?></td>
        <td><input type="text" id="<?php echo $Cart['tempPrid']; ?>" class="form-control numberInput change_barcode text-center px-1 m-0" value="<?php echo $Cart['barcode'];?>"></td>
        <td><input type="number" id="<?php echo $Cart['tempPrid']; ?>" class="form-control numberInput change_imei text-center px-1 m-0" value="<?php echo $Cart['imei'];?>"></td>
        <td><input type="text" id="<?php echo $Cart['tempPrid']; ?>" class="form-control numberInput change_color text-center px-1 m-0" value="<?php //echo $Cart['barcode'];?>"></td>
        <td><button class="btn px-2 py-1 delete_btn btn_delete shadow-none ms-3" type="button" value="<?php echo $Cart['tempPrid'];?>" > <i class="material-icons">delete</i> </button></td>
    </tr>
        <?php

        }
?>

        </tbody>

        </table>

        </div>


        <div class="d-flex justify-content-between mt-2 px-3">
            <h5 class="text-end">Total Qty : <span>(<?php if($Cart['itemCount'] > 0){echo number_format($Cart['itemCount']) ;} else{ echo '0'; }  ?>) Nos</span></h5>
            <h5 class="text-end">Total Amount: <span>(<?php echo number_format($Cart['totalPrice'],'2','.',',') ;?> )</span></h5>
        </div>



<?php
    } 
    else {
        ?>

            <tr>
                <td class="text-center" colspan="7"> <strong>Please add some products</strong> </td>
            </tr>

        <?php
    }



?>
    <?php
}

?>


