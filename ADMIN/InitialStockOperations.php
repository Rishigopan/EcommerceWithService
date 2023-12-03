<?php


require "../MAIN/Dbconn.php"; 



    $tempPurchaseTable = 'purchase_temp';

    $userId = $_COOKIE['custidcookie'];

    $timeNow = date("Y-m-d h:i:s");




//////////////////////////////////  INITIAL STOCK STARTING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\




    //Add item
    if(isset($_POST['product'])){

        $product = $_POST['product'];
        $quantity  = $_POST['quantity'];
        $unitPrice  = $_POST['unitPrice'];
        $individual  = isset($_POST['individual']) ? 'YES' : 'NO';

        $findMaxId = mysqli_query($con, "SELECT MAX(pr_id) FROM purchase_temp");
        foreach($findMaxId as $findMaxResults){
            $MAXID = $findMaxResults['MAX(pr_id)'] + 1;
        }


        if( $individual == 'YES'){

            for($i = 1; $i <= $quantity; $i++){


                $findIndMax = mysqli_query($con, "SELECT MAX(pr_id) FROM purchase_temp");
                foreach($findIndMax as $findIndMaxResults){
                    $INDMAXID = $findIndMaxResults['MAX(pr_id)'] + 1;
                }

                $insertIndividual = mysqli_query($con, "INSERT INTO purchase_temp (pr_id,parent_item_id,current_stock,price) VALUES('$INDMAXID','$product','1','$unitPrice')");
            }
            if($insertIndividual){
                echo json_encode(array('addItem' => 1));
            }

        }
        else{
            //echo json_encode(array('addItem' => '2'));//failed


            $insertNotIndividual = mysqli_query($con, "INSERT INTO purchase_temp (pr_id,parent_item_id,current_stock,price) VALUES('$MAXID','$product','$quantity','$unitPrice')");
            if($insertNotIndividual){
                echo json_encode(array('addItem' => 1));
            }
        }
        
        
        

    }


    //delete item
    if(isset($_POST['delValue'])){
    
        $DeleteItem = $_POST['delValue'];
    
        $delete_query =  mysqli_query($con, "DELETE FROM $tempPurchaseTable WHERE pr_id = '$DeleteItem'");

        if($delete_query){
            echo json_encode(array('delStatus' => '1'));
        }
        else{
            echo json_encode(array('delStatus' => '0'));
        }
        
    }


    //update imei
    if(isset($_POST['imeiValue'])){
        $imeiID = $_POST['imeiID'];
        $imeiValue = $_POST['imeiValue'];

        $edit_Imei = mysqli_query($con, "UPDATE $tempPurchaseTable SET imei = '$imeiValue' WHERE pr_id = '$imeiID'");
        if($edit_Imei){
            
            echo json_encode(array('updtImei' => 1));
        }
        else{
            echo json_encode(array('updtImei' => 0));
        }
     
    }


    //update barcode
    if(isset($_POST['barValue'])){
        $barID = $_POST['barID'];
        $barValue = $_POST['barValue'];


        $CheckBarcode = mysqli_query($con, "SELECT barcode FROM products WHERE barcode  = '$barValue'");
        if(mysqli_num_rows($CheckBarcode) > 0) {
            $edit_Barcode = mysqli_query($con, "UPDATE $tempPurchaseTable SET barcode = '' WHERE pr_id = '$barID'");
            if($edit_Barcode){
                echo json_encode(array('updtBarcode' => 3));
            }
            else{
                echo json_encode(array('updtBarcode' => 0));
            }
        }
        else{
            $edit_Barcode = mysqli_query($con, "UPDATE $tempPurchaseTable SET barcode = '$barValue' WHERE pr_id = '$barID'");
            if($edit_Barcode){
                
                echo json_encode(array('updtBarcode' => 1));
            }
            else{
                echo json_encode(array('updtBarcode' => 0));
            }
        }

        
     
    }


    //update color
    if(isset($_POST['ColorValue'])){
        $ColorID = $_POST['ColorID'];
        $ColorValue = $_POST['ColorValue'];

        $EditColor = mysqli_query($con, "UPDATE $tempPurchaseTable SET color = '$ColorValue' WHERE pr_id = '$ColorID'");
        if($EditColor){
            
            echo json_encode(array('updtColor' => 1));
        }
        else{
            echo json_encode(array('updtColor' => 0));
        }
     
    }


    //Add InitialStock
    if(isset($_POST['invoiceNo']) && !empty($_POST['invoiceNo'])){

        $invoice = $_POST['invoiceNo'];
        $supplierName = $_POST['supplierName'];
        $invoiceDate = $_POST['invoiceDate']. ' 00:00:00';


        mysqli_autocommit($con,FALSE);

        //$tempPurchaseTable = 'purchase_temp';

        $check_empty = mysqli_query($con,"SELECT * FROM purchase_temp");
        if(mysqli_num_rows($check_empty) > 0){

            $fetch_sum = mysqli_query($con, "SELECT SUM(current_stock) AS TotalStock, SUM(current_stock * price) AS TotalPrice FROM purchase_temp ");
            foreach($fetch_sum as $fetch_sum_results){
                $total_qty = $fetch_sum_results['TotalStock'];
                $totl_price = $fetch_sum_results['TotalPrice'];
            }


            $fetch_max_master = mysqli_query($con, "SELECT MAX(purchase_main_id) FROM purchase_table");
            foreach($fetch_max_master as $fetch_max_master_results){
                $max_master_id = $fetch_max_master_results['MAX(purchase_main_id)'] + 1;
            }
            
            $purchase_id = 'PURCHASE'.'-'.$max_master_id;


            $insert_into_purchase_master = mysqli_query($con, "INSERT INTO purchase_table (purchase_main_id, purchase_id,invoice_no,supplier_name, purchase_date, purchase_total_qty, purchase_total_amt, created_by, created_date) 
                VALUES ('$max_master_id','$purchase_id','$invoice','$supplierName','$invoiceDate','$total_qty','$totl_price','$userId','$timeNow')");


            if($insert_into_purchase_master){

                //mysqli_commit($con);
                //SELECT temp.parent_item_id ,temp.price ,temp.current_stock,temp.imei,temp.barcode,p.pr_code,p.type,p.brand,p.series,p.name,p.img,p.price AS itemPrice,p.tax,p.mini_desc,p.description,p.isimei,p.isbarcode,p.warranty FROM purchase_temp temp INNER JOIN products p ON p.parent_item_id = temp.parent_item_id
                $fetch_temp = mysqli_query($con, "SELECT * FROM purchase_temp");
                while($fetch_results = mysqli_fetch_array($fetch_temp)){
                    $parent_id = $fetch_results['parent_item_id'] ;
                    $quantity = $fetch_results['current_stock'];
                    $unit_price = $fetch_results['price'];
                    $imei = $fetch_results['imei'];
                    $barcode = $fetch_results['barcode'];
                    $color = $fetch_results['color'];
                    


                    $find_max_purchase_sub = mysqli_query($con, "SELECT MAX(p_id) FROM purchase_items");
                    foreach($find_max_purchase_sub as $find_max_purchase_sub_results){
                        $max_purchase_sub_id = $find_max_purchase_sub_results['MAX(p_id)'] + 1;
                    }

                    
                    $insert_into_purchase_sub = mysqli_query($con,"INSERT INTO purchase_items (p_id, p_purchase_id, p_item_parent_id, p_item_qty, p_unit_price, p_barcode, p_imei,p_color) 
                    VALUES ('$max_purchase_sub_id','$max_master_id','$parent_id','$quantity','$unit_price','$barcode','$imei','$color')");

                }

                if($insert_into_purchase_sub){



                    $fetch_temp2 = mysqli_query($con, "SELECT temp.parent_item_id ,temp.price ,temp.current_stock,temp.imei,temp.barcode,temp.color,p.pr_code,p.type,p.brand,p.series,p.name,p.img,p.price AS itemPrice,p.tax,p.mini_desc,p.description,p.isimei,p.isbarcode,p.warranty,p.unitid,p.inclusive,p.cp,p.lastcp,p.IGST,p.mrp,p.batch,p.sp,p.expiryDate,p.hsn,p.barcode,p.isSalesItem,p.isInShopSales,p.isOnlineSales FROM purchase_temp temp INNER JOIN products p ON p.parent_item_id = temp.parent_item_id WHERE temp.parent_item_id = p.pr_id");
                    while($fetch_results2 = mysqli_fetch_array($fetch_temp2)){
                        $Insparent_id = $fetch_results2['parent_item_id'] ;
                        $Insquantity = $fetch_results2['current_stock'];
                        $Insimei = $fetch_results2['imei'];
                        $Insbarcode = $fetch_results2['barcode'];
                        $InsprCode = $fetch_results2['pr_code'];
                        $Instype = $fetch_results2['type'];
                        $Insbrand = $fetch_results2['brand'];
                        $Insseries = $fetch_results2['series'];
                        $Insname = $fetch_results2['name'];
                        $Insimage = $fetch_results2['img'];
                        $InsitemPrice = $fetch_results2['itemPrice'];
                        $Instax = $fetch_results2['tax'];
                        $InsminiDesc = $fetch_results2['mini_desc'];
                        $Insdescription = $fetch_results2['description'];
                        $Insisimei = $fetch_results2['isimei'];
                        $Insisbarcode = $fetch_results2['isbarcode'];
                        $Inswarranty = $fetch_results2['warranty'];
                        $InsColor = $fetch_results2['color'];
                        $InsUnitid = $fetch_results2['unitid'];
                        $InsInclusive = $fetch_results2['inclusive'];
                        $InsCp = $fetch_results2['cp'];
                        $InsLastCp = $fetch_results2['lastcp'];
                        $InsIgst = $fetch_results2['IGST'];
                        $InsBatch = $fetch_results2['batch'];
                        $InsMrp = $fetch_results2['mrp'];
                        $InsSp = $fetch_results2['sp'];
                        $InsExpiryDate = $fetch_results2['expiryDate'];
                        $InsHsn = $fetch_results2['hsn'];
                        $ProductBarcode = $fetch_results2['barcode'];
                        $ProductIsSales = $fetch_results2['isSalesItem'];
                        $ProductIsInshop = $fetch_results2['isInShopSales'];
                        $ProductIsOnline = $fetch_results2['isOnlineSales'];
                        

                    

                        $find_max_product_id = mysqli_query($con, "SELECT MAX(pr_id) FROM products");
                        foreach($find_max_product_id as $find_max_product_id_results){
                            $max_product_id = $find_max_product_id_results['MAX(pr_id)'] + 1;
                        }


                        if(($Insimei == '') && ($Insbarcode == '')){

                            $update_products = mysqli_query($con,"UPDATE products SET current_stock = current_stock +'$Insquantity', purchased_qty = purchased_qty + '$Insquantity' WHERE parent_item_id = '$Insparent_id'");

                        }elseif(($Insimei != '') && ($Insbarcode == '')){

                            $insert_into_products = mysqli_query($con, "INSERT INTO products (pr_id,parent_item_id,pr_code,type,brand,series,img,name,tax,price,description,mini_desc,current_stock,purchased_qty,color,isimei,isbarcode,warranty,imei,barcode,unitid,inclusive,cp,lastcp,IGST,batch,mrp,sp,expiryDate,hsn,p_created,p_createdTime,isSalesItem,isInShopSales,isOnlineSales) 
                            VALUES ('$max_product_id','$Insparent_id','$InsprCode','$Instype','$Insbrand','$Insseries','$Insimage','$Insname','$Instax','$InsitemPrice','$Insdescription','$InsminiDesc','1','1','$InsColor','$Insisimei','$Insisbarcode','$Inswarranty','$Insimei','$ProductBarcode','$InsUnitid','$InsInclusive','$InsCp','$InsLastCp','$InsIgst','$InsBatch','$InsMrp','$InsSp','$InsExpiryDate','$InsHsn','$userId','$timeNow','$ProductIsSales','$ProductIsInshop','$ProductIsOnline')");
                
                        }
                        else{

                            $insert_into_products = mysqli_query($con, "INSERT INTO products (pr_id,parent_item_id,pr_code,type,brand,series,img,name,tax,price,description,mini_desc,current_stock,purchased_qty,color,isimei,isbarcode,warranty,imei,barcode,unitid,inclusive,cp,lastcp,IGST,batch,mrp,sp,expiryDate,hsn,p_created,p_createdTime,isSalesItem,isInShopSales,isOnlineSales) 
                            VALUES ('$max_product_id','$Insparent_id','$InsprCode','$Instype','$Insbrand','$Insseries','$Insimage','$Insname','$Instax','$InsitemPrice','$Insdescription','$InsminiDesc','1','1','$InsColor','$Insisimei','$Insisbarcode','$Inswarranty','$Insimei','$Insbarcode','$InsUnitid','$InsInclusive','$InsCp','$InsLastCp','$InsIgst','$InsBatch','$InsMrp','$InsSp','$InsExpiryDate','$InsHsn','$userId','$timeNow','$ProductIsSales','$ProductIsInshop','$ProductIsOnline')");

                        }
        
                    }

                    if($insert_into_products || $update_products){
                        $remove_from_table = mysqli_query($con, "DELETE FROM purchase_temp");
                        if($remove_from_table){

                            mysqli_commit($con);
                            echo json_encode(array('Success' => 1));
                            
                        }
                        else{
                            mysqli_rollback($con);
                            echo json_encode(array('Success' => 2));
                        }
                    }
                    else{
                        mysqli_rollback($con);
                        echo json_encode(array('Success' => 2));
                    }

                }
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('Success' => 2));
            }


        }
        else{
            echo json_encode(array('Success' => 0));
        }

    }




    //Delete All Items In Initial Stock
    if(isset($_POST['delAll'])){


        $delAllItems = mysqli_query($con, "DELETE FROM purchase_temp ");
        if($delAllItems){
            echo json_encode(array('delAllStatus' => 1));
        }
        else{
            echo json_encode(array('delAllStatus' => 0));
        }

    }




//////////////////////////////////  INITIAL STOCK ENDING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\



?>