  

  <?php

require "../MAIN/Dbconn.php"; 

    $userId = $_COOKIE['custidcookie'];

    $timeNow = date("Y-m-d h:i:s");



    ///////////////////  SERVICE TYPE STARTING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    
        //ADD SERVICE TYPE
        if(isset($_POST['serviceTypeName']) && !empty($_POST['serviceTypeName'])){

            $ServiceTypeName = $_POST['serviceTypeName'];
            $serviceImage = $_FILES['serviceImage']['name'];
            $extension = pathinfo($serviceImage, PATHINFO_EXTENSION);
            $servicetempimage = $_FILES['serviceImage']['tmp_name'];
            mysqli_autocommit($con,FALSE);
            $max_service_type_id = mysqli_query($con, "SELECT MAX(sr_id) FROM services");
            foreach($max_service_type_id as $max_service_type_id_result){
                $maxServiceTypeId = $max_service_type_id_result['MAX(sr_id)'] + 1;
            }
            
            $check_Service_type_already = mysqli_query($con, "SELECT service_name FROM services WHERE service_name = '$ServiceTypeName'");
            if(mysqli_num_rows($check_Service_type_already) > 0){
                echo json_encode(array('addServiceType' => 0));
            }
            else{

                if(!empty($_FILES['serviceImage']['name'])){

                    $ServiceTypeRandomNumber = rand(10000,99999);
                    $final_serviceimage_name = $maxServiceTypeId."_".$ServiceTypeRandomNumber.".".$extension;
                    $serviceFolder = "../assets/img/SERVICE/".$final_serviceimage_name;

                    if(move_uploaded_file($servicetempimage, $serviceFolder)){

                        $service_type_add_query = mysqli_query($con, "INSERT INTO services (sr_id,service_name,service_img,sr_created,sr_createdTime) 
                        VALUES ('$maxServiceTypeId','$ServiceTypeName','$final_serviceimage_name','$userId','$timeNow')");
            
                        if($service_type_add_query){
                            mysqli_commit($con);
                            echo json_encode(array('addServiceType' => 1));
                        }
                        else{
                            mysqli_rollback($con);
                            echo json_encode(array('addServiceType' => 2));
                        }
                    }
                    else{
                        mysqli_rollback($con);
                        echo json_encode(array('addServiceType' => 2));
                    }
                }
                else{
                    $service_type_add_query = mysqli_query($con, "INSERT INTO services (sr_id,service_name,sr_created,sr_createdTime) VALUES ('$maxServiceTypeId','$ServiceTypeName','$userId','$timeNow')");
                    if($service_type_add_query){
                        mysqli_commit($con);
                        echo json_encode(array('addServiceType' => 1));
                    }
                    else{
                        mysqli_rollback($con);
                        echo json_encode(array('addServiceType' => 2));
                    }
                }
            }
        }
        else{
        
        }


        //EDIT SERVICE TYPE
        if(isset($_POST['editServiceTypeId']) && !empty($_POST['editServiceTypeId'])){
            $editServiceTypeId = $_POST['editServiceTypeId'];

            $editServiceType = mysqli_query($con, "SELECT service_name FROM services WHERE sr_id = '$editServiceTypeId'");
            if(mysqli_num_rows($editServiceType) > 0){
                foreach($editServiceType as $editServiceTypes){
                    $editServiceTypeName = $editServiceTypes['service_name'];
                    echo json_encode(array('EditServiceTypeName' => $editServiceTypeName));
                    }
            }
            else{
                echo json_encode(array('EditServiceType' => 'error'));
            }
        }
        else{
            
        }


        //DELETE SERVICE TYPE
        if(isset($_POST['deleteServiceTypeId'])){
            $delServiceType = $_POST['deleteServiceTypeId'];
            $del_check_service_type_already = mysqli_query($con, "SELECT sr_id FROM service_main WHERE sr_id = '$delServiceType'");
            if(mysqli_num_rows($del_check_service_type_already) > 0){
                echo json_encode(array('DelServiceType' => 0));
            }
            else{
                $delServiceTypeImage_query = mysqli_query($con, "SELECT service_img FROM services WHERE sr_id = '$delServiceType'");
                foreach( $delServiceTypeImage_query as $delServiceTypeImages){
                    $delServiceTypeImage = $delServiceTypeImages['service_img'];
                    $delServiceTypeImagePath = "../assets/img/SERVICE/".$delServiceTypeImages['service_img'];
                }
                if($delServiceTypeImage != null){
                    if(file_exists($delServiceTypeImagePath) == 1){
                        clearstatcache();
                        if(unlink($delServiceTypeImagePath)){
                            $delServiceTypeWithImage = mysqli_query($con, "DELETE FROM services WHERE sr_id = '$delServiceType'");
                            if($delServiceTypeWithImage){
                                echo json_encode(array('DelServiceType' => 1));
                            }
                            else{
                                echo json_encode(array('DelServiceType' => 2));
                            }
                        }
                        else{
                            echo json_encode(array('DelServiceType' => 2));
                        }  
                    }else{
                        $delServiceTypeWithoutImage = mysqli_query($con, "DELETE FROM services WHERE sr_id = '$delServiceType'");
                        if($delServiceTypeWithoutImage){
                            echo json_encode(array('DelServiceType' => 1));
                        }
                        else{
                            echo json_encode(array('DelServiceType' => 2));
                        }
                    }
                }
                else{
                    $delServiceTypeWithoutImage = mysqli_query($con, "DELETE FROM services WHERE sr_id = '$delServiceType'");
                    if($delServiceTypeWithoutImage){
                        echo json_encode(array('DelServiceType' => 1));
                    }
                    else{
                        echo json_encode(array('DelServiceType' => 2));
                    }
                }
            }
        }
        else{
            
        }



        //UPDATE SERVICE TYPE
        if(isset($_POST['editServiceTypeName']) && !empty($_POST['editServiceTypeName'])){
            $updateServiceTypeId = $_POST['editServiceTypeid'];
            $updateServiceTypeName = $_POST['editServiceTypeName'];
            $updateServiceImage = $_FILES['editServiceImage']['name'];
            $updateServiceExtension = pathinfo($updateServiceImage, PATHINFO_EXTENSION);
            $updateServicetempimage = $_FILES['editServiceImage']['tmp_name'];
            $updateServiceTypeRandNumber = rand(10000, 99999);
            $updatefinal_ServiceImage_name = $updateServiceTypeId."_".$updateServiceTypeRandNumber.".".$updateServiceExtension;
            $updateServicefolder = "../assets/img/SERVICE/".$updatefinal_ServiceImage_name;


            $check_update_service_type_already = mysqli_query($con, "SELECT service_name FROM services WHERE service_name = '$updateServiceTypeName' AND sr_id  <> '$updateServiceTypeId'");
            if(mysqli_num_rows($check_update_service_type_already) > 0){
                echo json_encode(array('updateServiceType' => 0));
                }
            else{
                if(!empty($_FILES['editServiceImage']['name'])){
                    $serviceTypeFetch_query = mysqli_query($con, "SELECT service_img FROM services WHERE sr_id = '$updateServiceTypeId'");
                    foreach($serviceTypeFetch_query as $serviceType_result){
                        $ServiceImageValue = $serviceType_result['service_img'];
                        $ServiceImagePath = "../assets/img/SERVICE/".$serviceType_result['service_img'];
                    }
                    if($ServiceImageValue != null){
                        if(file_exists($ServiceImagePath) == 1){
                            clearstatcache();
                            if(unlink($ServiceImagePath)){
                                if(move_uploaded_file($updateServicetempimage, $updateServicefolder)){
                                    $service_type_update_query = mysqli_query($con, "UPDATE services SET service_name = '$updateServiceTypeName',service_img = '$updatefinal_ServiceImage_name',sr_updated = '$userId', sr_updatedTime = '$timeNow' WHERE sr_id = '$updateServiceTypeId'");
                                    if($service_type_update_query){
                                        echo json_encode(array('updateServiceType' => 1));
                                    }
                                    else{
                                        echo json_encode(array('updateServiceType' => 2));
                                    }
                                }
                            }
                            else{
                                echo json_encode(array('updateServiceType' => 3));
                            }  
                        }
                        else{
                            if(move_uploaded_file($updateServicetempimage, $updateServicefolder)){
                                $service_type_update_query = mysqli_query($con, "UPDATE services SET service_name = '$updateServiceTypeName',service_img = '$updatefinal_ServiceImage_name',sr_updated = '$userId', sr_updatedTime = '$timeNow' WHERE sr_id = '$updateServiceTypeId'");
                                if($service_type_update_query){
                                    echo json_encode(array('updateServiceType' => 1));
                                }
                                else{
                                    echo json_encode(array('updateServiceType' => 2));
                                }
                            }
                        }
                    }
                    else{
                        if(move_uploaded_file($updateServicetempimage, $updateServicefolder)){
                            $service_type_update_query = mysqli_query($con, "UPDATE services SET service_name = '$updateServiceTypeName',service_img = '$updatefinal_ServiceImage_name',sr_updated = '$userId', sr_updatedTime = '$timeNow' WHERE sr_id = '$updateServiceTypeId'");
                            if($service_type_update_query){
                                echo json_encode(array('updateServiceType' => 1));
                            }
                            else{
                                echo json_encode(array('updateServiceType' => 2));
                            }
                        }
                    } 
                }
                else{
                    $service_type_update_query = mysqli_query($con, "UPDATE services SET service_name = '$updateServiceTypeName',sr_updated = '$userId', sr_updatedTime = '$timeNow' WHERE sr_id = '$updateServiceTypeId'");
                    if($service_type_update_query){
                        echo json_encode(array('updateServiceType' => 1));
                    }
                    else{
                        echo json_encode(array('updateServiceType' => 2));
                    }
                }
            }
        }
        else{
        
        }


    ///////////////// SERVICE TYPE ENDING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    ///////////////// SERVICE STARTING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

        //ADD SERVICE 
        if(isset($_POST['SelectBrandService']) && !empty($_POST['SelectBrandService'])){

            $ServiceBrandId = $_POST['SelectBrandService'];
            $ServiceSeriesId = $_POST['SelectSeriesService'];
            $ServiceModelId = $_POST['SelectModelService'];
            $ServiceServiceId = $_POST['SelectService'];
            $ServiceCost = $_POST['ServiceAmount'];
            $ServiceComm = ($_POST['ServiceCommission'] != '' ) ? $_POST['ServiceCommission'] : 0;
            $ServiceTax = ($_POST['ServiceTax'] != '' ) ? $_POST['ServiceTax'] : 0;
            
            
            $check_Service_already = mysqli_query($con, "SELECT main_id FROM service_main WHERE br_id = '$ServiceBrandId' AND se_id = '$ServiceSeriesId' AND mo_id = '$ServiceModelId' AND sr_id = '$ServiceServiceId'");
            if(mysqli_num_rows($check_Service_already) > 0){
                echo json_encode(array('addService' => 0));
            }
            else{
                mysqli_autocommit($con,FALSE);
                $max_service_id = mysqli_query($con, "SELECT MAX(main_id) FROM service_main");
                if( mysqli_num_rows($max_service_id) > 0){
                    foreach($max_service_id as $max_main_result){
                        $max_main =  $max_main_result['MAX(main_id)'] + 1;
                    }
                    $service_add_query = mysqli_query($con, "INSERT INTO service_main (main_id,sr_id,br_id,se_id,mo_id,cost,tax,commission,sm_created,sm_createdTime) 
                    VALUES ('$max_main','$ServiceServiceId','$ServiceBrandId','$ServiceSeriesId','$ServiceModelId','$ServiceCost','$ServiceTax','$ServiceComm','$userId','$timeNow')");
        
                    if($service_add_query){
                        mysqli_commit($con);
                        echo json_encode(array('addService' => 1));
                    }
                    else{
                        mysqli_rollback($con);
                        echo json_encode(array('addService' => 2));
                    }
                }
                else{
                    mysqli_rollback($con);
                    echo json_encode(array('addService' => 3));
                }
            }
        }
        else{
        
        }



        //EDIT SERVICES
        if(isset($_POST['editServiceId']) && !empty($_POST['editServiceId'])){
            $editServiceId = $_POST['editServiceId'];

            $editService = mysqli_query($con, "SELECT CAST(tax AS SIGNED) AS tax,main_id,sr_id,br_id,se_id,mo_id,cost,commission FROM service_main WHERE  main_id = '$editServiceId'");
            if(mysqli_num_rows($editService) > 0){
                while ($editResult = mysqli_fetch_assoc($editService)) {
                    //$EditResponse[] = $editResult;
                    echo json_encode($editResult);
                }
            }
            else{
                echo json_encode(array('EditService' => 'error'));
            }
        }
        else{
            
        }


        //DELETE SERVICES
        if(isset($_POST['deleteServiceId'])){
            $delService = $_POST['deleteServiceId'];
            $del_check_service_already = mysqli_query($con, "SELECT main_sr_id FROM service_items WHERE main_sr_id = '$delService'");
            if(mysqli_num_rows($del_check_service_already) > 0){
                echo json_encode(array('DelService' => 0));
            }
            else{
                mysqli_autocommit($con,FALSE);
                $delServiceTypeWithImage = mysqli_query($con, "DELETE FROM service_main WHERE main_id = '$delService'");
                if($delServiceTypeWithImage){
                    mysqli_commit($con);
                    echo json_encode(array('DelService' => 1));
                }
                else{
                    mysqli_rollback($con);
                    echo json_encode(array('DelService' => 2));
                }  
            }
        }
        else{
            
        }



        //UPDATE SERVICE 
        if(isset($_POST['UpdateServiceId']) && !empty($_POST['UpdateServiceId'])){

            $UpdateServiceId = $_POST['UpdateServiceId'];
            $UpdateServiceBrandId = $_POST['EditSelectBrandService'];
            $UpdateServiceSeriesId = $_POST['EditSelectSeriesService'];
            $UpdateServiceModelId = $_POST['EditSelectModelService'];
            $UpdateServiceServiceId = $_POST['EditSelectService'];
            $UpdateServiceCost = $_POST['EditServiceAmount'];
            $UpdateServiceComm = ($_POST['EditServiceCommission'] != '') ? $_POST['EditServiceCommission'] : 0;
            $UpdateServiceTax = ($_POST['EditServiceTax'] != '') ? $_POST['EditServiceTax'] : 0;
            
            
            $check_Service_Update_exists = mysqli_query($con, "SELECT main_id FROM service_main WHERE br_id = '$UpdateServiceBrandId' AND se_id = '$UpdateServiceSeriesId' AND mo_id = '$UpdateServiceModelId' AND sr_id = '$UpdateServiceServiceId' AND main_id <> '$UpdateServiceId'");
            if(mysqli_num_rows($check_Service_Update_exists) > 0){
                echo json_encode(array('updateService' => 0));
            }
            else{
                mysqli_autocommit($con,FALSE);
                $service_update_query = mysqli_query($con, "UPDATE service_main SET sr_id ='$UpdateServiceServiceId',br_id ='$UpdateServiceBrandId',se_id ='$UpdateServiceSeriesId',mo_id ='$UpdateServiceModelId',cost ='$UpdateServiceCost',tax ='$UpdateServiceTax',commission ='$UpdateServiceComm',sm_updated ='$userId',sm_updatedTime ='$timeNow' WHERE main_id = '$UpdateServiceId'");
        
                if($service_update_query){
                    mysqli_commit($con);
                    echo json_encode(array('updateService' => 1));
                }
                else{
                    mysqli_rollback($con);
                    echo json_encode(array('updateService' => 2));
                }
                
            }
        }
        else{
        
        }
    ///////////////////  SERVICE ENDING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

?>