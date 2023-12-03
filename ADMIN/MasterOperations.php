<?php 

require "../MAIN/Dbconn.php"; 

    $userId = $_COOKIE['custidcookie'];

    $timeNow = date("Y-m-d h:i:s");
   

    
//////////////////////////////////   CATEGORY STARTING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
   
    //ADD CATEGORY 
    if(isset($_POST['CategoryName']) && !empty($_POST['CategoryName'])){
        $Category = $_POST['CategoryName'];
        mysqli_autocommit($con,FALSE);
        try{
            $CheckCategoryAlready = mysqli_query($con, "SELECT type_name FROM types WHERE type_name = '$Category'");
            if(mysqli_num_rows($CheckCategoryAlready) > 0){
                throw new Exception("Category Already Exists!","0");
            }
            else{
                $FetchMaxId = mysqli_query($con, "SELECT MAX(ty_id) FROM types");
                foreach($FetchMaxId as $FetchMaxIdResult){
                    $MaxId =  $FetchMaxIdResult['MAX(ty_id)'] + 1;
                }
                $AddQuery = mysqli_query($con, "INSERT INTO types (ty_id,type_name,t_created,t_createdTime) VALUES ('$MaxId','$Category','$userId','$timeNow')");
                if($AddQuery){
                    mysqli_commit($con);
                    echo json_encode(array('Status' => 1, 'Message' => 'Category Added Successfully'));
                }
                else{
                    mysqli_rollback($con);
                    throw new Exception("Failed Adding Category!","2");
                }
            }
        }
        catch(Exception $e){
            echo json_encode(array('Status' => $e->getCode(),'Message' => $e->getMessage()));
        }
    }
    else{
        
    }


    //EDIT CATEGORY 
    if(isset($_POST['editTypeId']) && !empty($_POST['editTypeId'])){
        $editTypeId = $_POST['editTypeId'];

        $editType = mysqli_query($con, "SELECT ty_id,type_name FROM types WHERE ty_id = '$editTypeId'");
        if(mysqli_num_rows($editType) > 0){
            foreach($editType as $editTypes){
                $typeEditName = $editTypes['type_name'];
                echo json_encode(array('Edittypename' => $typeEditName));
            }
        }
        else{
            echo json_encode(array('Edittype' => 'error'));
        }
    }
    else{
        
    }



    //DELETE CATEGORY 
    if(isset($_POST['deleteTypeId']) && !empty($_POST['deleteTypeId'])){
        $delTypeId = $_POST['deleteTypeId'];

        $check_type_Inuse = mysqli_query($con, "SELECT type FROM products WHERE type = '$delTypeId'");
        if(mysqli_num_rows($check_type_Inuse) > 0){
            echo json_encode(array('Deltype' => 0));
        }
        else{
            mysqli_autocommit($con,FALSE);
            $delType = mysqli_query($con, "DELETE  FROM types WHERE ty_id = '$delTypeId'");
            if($delType){
                mysqli_commit($con);
                echo json_encode(array('Deltype' => 1));
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('Deltype' => 2));
            }
        }
    }
    else{
        
    }

   

    //UPDATE CATEGORY 
    if(isset($_POST['editTypeName']) && !empty($_POST['editTypeName'])){
        $updateType = $_POST['editTypeName'];
        $updateTypeId = $_POST['updateTypeId'];

        $check_typename_already = mysqli_query($con, "SELECT type_name FROM types WHERE type_name = '$updateType' AND ty_id <> '$updateTypeId'");
        if(mysqli_num_rows($check_typename_already) > 0){
            echo json_encode(array('updateType' => 0));
        }
        else{
            mysqli_autocommit($con,FALSE);
            $type_update_query = mysqli_query($con, "UPDATE types SET type_name = '$updateType',t_updated = '$userId',t_updatedTime = '$timeNow' WHERE ty_id = '$updateTypeId'");
            if($type_update_query){
                mysqli_commit($con);
                echo json_encode(array('updateType' => 1));
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('updateType' => 2));
            }
        }
    }
    else{
        
    }



//////////////////////////////////   CATEGORY ENDING   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\



//////////////////////////////////  SERIES STARTING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    //ADD SERIES
    if(isset($_POST['seriesName']) && !empty($_POST['seriesName'])){
        $Series = $_POST['seriesName'];
        $SeriesBrandId = $_POST['brandSelect'];
        mysqli_autocommit($con,FALSE);
        try{
            $CheckSeriesExists = mysqli_query($con, "SELECT series_name FROM series WHERE series_name = '$Series' AND br_id = '$SeriesBrandId' ");
            if(mysqli_num_rows($CheckSeriesExists) > 0){
                throw new Exception("Series Already Exists!","0");
            }
            else{
                $FetchMaxId = mysqli_query($con, "SELECT MAX(se_id) FROM series");
                foreach( $FetchMaxId as $FetchMaxIdResult){
                    $MaxId =  $FetchMaxIdResult['MAX(se_id)'] + 1;
                }
                $AddQuery = mysqli_query($con, "INSERT INTO series (se_id,br_id,series_name,se_created,se_createdTime) VALUES ('$MaxId','$SeriesBrandId','$Series','$userId','$timeNow')");
    
                if($AddQuery){
                    mysqli_commit($con);
                    echo json_encode(array('Status' => 1, 'Message' => 'Series Added Successfully'));
                }
                else{
                    mysqli_rollback($con);
                    throw new Exception("Failed Adding Series!","2");
                }
            }
        }
        catch(Exception $e){
            echo json_encode(array('Status' => $e->getCode(),'Message' => $e->getMessage()));
        }
    }
    else{
        
    }


    //EDIT SERIES
    if(isset($_POST['editSeriesId']) && !empty($_POST['editSeriesId'])){
        $editSeriesId = $_POST['editSeriesId'];

        $editSeries = mysqli_query($con, "SELECT b.br_id,series_name FROM series s INNER JOIN brands b ON s.br_id = b.br_id  WHERE se_id = '$editSeriesId'");
        if(mysqli_num_rows($editSeries) > 0){
            foreach($editSeries as $editSeriess){
                $seriesEditName = $editSeriess['series_name'];
                $seriesEditBrand = $editSeriess['br_id'];
                echo json_encode(array('EditSeriesName' => $seriesEditName,'EditSeriesBrand' => $seriesEditBrand));
            }
        }
        else{
            echo json_encode(array('EditSeries' => 'error'));
        }
    }
    else{
        
    }


    //DELETE SERIES
    if(isset($_POST['deleteSeriesId']) && !empty($_POST['deleteSeriesId'])){
        $deleteSeriesId = $_POST['deleteSeriesId'];

        $check_series_Inuse = mysqli_query($con, "SELECT series FROM products WHERE series = '$deleteSeriesId'");
        if(mysqli_num_rows($check_series_Inuse) > 0){
            echo json_encode(array('Delseries' => 0));
        }
        else{
            mysqli_autocommit($con,FALSE);
            $delSeries = mysqli_query($con, "DELETE  FROM series WHERE se_id = '$deleteSeriesId'");
            if($delSeries){
                mysqli_commit($con);
                echo json_encode(array('Delseries' => 1));
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('Delseries' => 2));
            }
        }
    }
    else{
        
    }



    //UPDATE SERIES
    if(isset($_POST['editSeriesName']) && !empty($_POST['editSeriesName'])){
        $updateSeriesId = $_POST['updateSeriesId'];
        $updateSeries = $_POST['editSeriesName'];
        $updateBrandId = $_POST['brandSelectSeries'];

        $check_seriesname_already = mysqli_query($con, "SELECT series_name FROM series WHERE series_name = '$updateSeries' AND br_id = '$updateBrandId' AND se_id <> '$updateSeriesId'");
        if(mysqli_num_rows($check_seriesname_already) > 0){
            echo json_encode(array('updateSeries' => 0));
        }
        else{
            mysqli_autocommit($con,FALSE);
            $series_update_query = mysqli_query($con, "UPDATE series SET series_name = '$updateSeries', br_id = '$updateBrandId', se_updated = '$userId', se_updatedTime = '$timeNow' WHERE se_id = '$updateSeriesId'");
            if($series_update_query){
                mysqli_commit($con);
                echo json_encode(array('updateSeries' => 1));
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('updateSeries' => 2));
            }
        }
    }
    else{
        
    }

//////////////////////////////////  SERIES ENDING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
   



//////////////////////////////////  BRAND STARTING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
   
    //ADD BRAND
    if(isset($_POST['BrandName']) && !empty($_POST['BrandName'])){

        $BrandName = $_POST['BrandName'];
        $BrandImage = $_FILES['BrandImage']['name'];
        $BrandImageExtension = pathinfo($BrandImage, PATHINFO_EXTENSION);
        $BrandTempImage = $_FILES['BrandImage']['tmp_name'];
        $BrandIsSales = isset($_POST['AddBrandSale']) ? "YES" : "NO" ;
        $BrandIsService = isset($_POST['AddBrandService']) ? "YES" : "NO" ;

        try{

            $CheckBrandAlready = mysqli_query($con, "SELECT brand_name FROM brands WHERE brand_name = '$BrandName'");
            if (mysqli_num_rows($CheckBrandAlready) > 0) {
                throw new Exception("Brand Already Exists!","0");
            } else {
                mysqli_autocommit($con,FALSE);
                $FetchMaxId = mysqli_query($con, "SELECT MAX(br_id) FROM brands");
                foreach($FetchMaxId as $FetchMaxIdResult){
                    $MaxId = $FetchMaxIdResult['MAX(br_id)'] + 1;
                }
                if (!empty($_FILES['BrandImage']['name'])) {
                    $ImageRandomNumber = rand(10000, 99999);
                    $FinalImageName = $MaxId . "_" . $ImageRandomNumber . "." . $BrandImageExtension;
                    $ImageFolder = "../assets/img/BRAND/" . $FinalImageName;
                    if (move_uploaded_file($BrandTempImage, $ImageFolder)) {
                        $BrandAddQuery = mysqli_query($con, "INSERT INTO brands (br_id,brand_name,brand_img,isSales,isService,b_created,b_createdTime) 
                        VALUES ('$MaxId','$BrandName','$FinalImageName','$BrandIsSales','$BrandIsService','$userId','$timeNow')");
                        GOTO BrandInsertResult;
                    } else {
                        mysqli_rollback($con);
                        throw new Exception("Failed Adding Brand!","2");
                    }
                } else {
                    $BrandAddQuery = mysqli_query($con, "INSERT INTO brands (br_id,brand_name,isSales,isService,b_created,b_createdTime) 
                    VALUES ('$MaxId','$BrandName','$BrandIsSales','$BrandIsService','$userId','$timeNow')");
                    GOTO BrandInsertResult;
                }
                BrandInsertResult:
                if ($BrandAddQuery) {
                    mysqli_commit($con);
                    echo json_encode(array('Status' => 1, 'Message' => 'Brand Added Successfully'));
                } else {
                    mysqli_rollback($con);
                    throw new Exception("Failed Adding Brand!","2");
                }
            }
        }
        catch(Exception $e){
            echo json_encode(array('Status' => $e->getCode(),'Message' => $e->getMessage()));
        }
    }
    else{
    
    }


    //EDIT BRAND
    if(isset($_POST['editBrandId']) && !empty($_POST['editBrandId'])){
        $editBrandId = $_POST['editBrandId'];

        $editBrand = mysqli_query($con, "SELECT brand_name,isSales,isService FROM brands WHERE br_id = '$editBrandId'");
        if(mysqli_num_rows($editBrand) > 0){
            foreach($editBrand as $editBrands){
                $brandEditName = $editBrands['brand_name'];
                $brandIsSales = $editBrands['isSales'];
                $brandIsService = $editBrands['isService'];
                echo json_encode(array('EditBrandName' => $brandEditName,'IsSales' => $brandIsSales,'IsService' => $brandIsService));
            }
        }
        else{
            echo json_encode(array('EditBrand' => 'error'));
        }
    }
    else{
        
    }


    //DELETE BRAND
    if(isset($_POST['deleteBrandId'])){
        $delBrand = $_POST['deleteBrandId'];

        $check_brand_exists = mysqli_query($con, "SELECT br_id FROM series WHERE br_id = '$delBrand'");
        if(mysqli_num_rows($check_brand_exists) > 0){
            echo json_encode(array('Delbrand' => 0));
        }
        else{
            $delBrandImage_query = mysqli_query($con, "SELECT brand_img FROM brands WHERE br_id = '$delBrand'");
            foreach( $delBrandImage_query as $delBrandImages){
                $delBrandImage = $delBrandImages['brand_img'];
                $delBrandImagePath = "../assets/img/BRAND/".$delBrandImages['brand_img'];
            }
            if($delBrandImage != null){
                if(file_exists($delBrandImagePath) == 1){
                    clearstatcache();
                    if(unlink($delBrandImagePath)){
                        $delBrandWithImage = mysqli_query($con, "DELETE FROM brands WHERE br_id = '$delBrand'");
                        if($delBrandWithImage){
                            echo json_encode(array('Delbrand' => 1));
                        }
                        else{
                            echo json_encode(array('Delbrand' => 2));
                        }
                    }
                    else{
                        echo json_encode(array('Delbrand' => 2));
                    }  
                }else{
                    $delBrandWithoutImage = mysqli_query($con, "DELETE FROM brands WHERE br_id = '$delBrand'");
                    if($delBrandWithoutImage){
                        echo json_encode(array('Delbrand' => 1));
                    }
                    else{
                        echo json_encode(array('Delbrand' => 2));
                    }
                }
            }
            else{
                $delBrandWithoutImage = mysqli_query($con, "DELETE FROM brands WHERE br_id = '$delBrand'");
                if($delBrandWithoutImage){
                    echo json_encode(array('Delbrand' => 1));
                }
                else{
                    echo json_encode(array('Delbrand' => 2));
                }
            }
        }

        
    }



    //UPDATE BRAND
    if(isset($_POST['editbrand_name']) && !empty($_POST['editbrand_name'])){
        $updateBrandId = $_POST['UpdateBrandId'];
        $updateBrandName = $_POST['editbrand_name'];
        $updateBrandIsSales =  isset($_POST['UpdateBrandSale']) ? "YES" : "NO" ;
        $updateBrandIsService = isset($_POST['UpdateBrandService']) ? "YES" : "NO" ;
        $updateBrandImage = $_FILES['edit_brand_image']['name'];
        $updateBrandextension = pathinfo($updateBrandImage, PATHINFO_EXTENSION);
        $updateBrandtempimage = $_FILES['edit_brand_image']['tmp_name'];
        $updateBrandRandomNumber = rand(10000,99999);
        $updatefinal_Brandimage_name = $updateBrandId."_".$updateBrandRandomNumber.".".$updateBrandextension;
        $updateBrandfolder = "../assets/img/BRAND/".$updatefinal_Brandimage_name;


        $check_update_brand_already = mysqli_query($con, "SELECT brand_name FROM brands WHERE brand_name = '$updateBrandName' AND br_id  <> '$updateBrandId'");
        if(mysqli_num_rows($check_update_brand_already) > 0){
            echo json_encode(array('updateBrand' => 0));
        }
        else{
            if(!empty($_FILES['edit_brand_image']['name'])){
                $brandFetch_query = mysqli_query($con, "SELECT brand_img FROM brands WHERE br_id = '$updateBrandId'");
                foreach($brandFetch_query as $brand_result){
                    $BrandimageValue = $brand_result['brand_img'];
                    $BrandimagePath = "../assets/img/BRAND/".$brand_result['brand_img'];
                }
                if($BrandimageValue != null){
                    if(file_exists($updateBrandfolder) == 1){
                        clearstatcache();
                        if(move_uploaded_file($updateBrandtempimage, $updateBrandfolder)){
                            $brand_update_query = mysqli_query($con, "UPDATE brands SET brand_name = '$updateBrandName',brand_img = '$updatefinal_Brandimage_name',b_updated = '$userId', b_updatedTime = '$timeNow', isSales = '$updateBrandIsSales', isService = '$updateBrandIsService' WHERE br_id = '$updateBrandId'");
                            if($brand_update_query){
                                echo json_encode(array('updateBrand' => 1));
                            }
                            else{
                                echo json_encode(array('updateBrand' => 2));
                            }
                        }
                    }
                    else{
                        if(move_uploaded_file($updateBrandtempimage, $updateBrandfolder)){
                            $brand_update_query = mysqli_query($con, "UPDATE brands SET brand_name = '$updateBrandName',brand_img = '$updatefinal_Brandimage_name',b_updated = '$userId', b_updatedTime = '$timeNow', isSales = '$updateBrandIsSales', isService = '$updateBrandIsService' WHERE br_id = '$updateBrandId'");
                            if($brand_update_query){
                                echo json_encode(array('updateBrand' => 1));
                            }
                            else{
                                echo json_encode(array('updateBrand' => 2));
                            }
                        }
                    }
                }
                else{
                    if(move_uploaded_file($updateBrandtempimage, $updateBrandfolder)){
                        $brand_update_query = mysqli_query($con, "UPDATE brands SET brand_name = '$updateBrandName',brand_img = '$updatefinal_Brandimage_name',b_updated = '$userId', b_updatedTime = '$timeNow', isSales = '$updateBrandIsSales', isService = '$updateBrandIsService' WHERE br_id = '$updateBrandId'");
                        if($brand_update_query){
                            echo json_encode(array('updateBrand' => 1));
                        }
                        else{
                            echo json_encode(array('updateBrand' => 2));
                        }
                    }
                } 
           }
           else{
                $brand_update_query = mysqli_query($con, "UPDATE brands SET brand_name = '$updateBrandName',b_updated = '$userId', b_updatedTime = '$timeNow' ,isSales = '$updateBrandIsSales' , isService = '$updateBrandIsService' WHERE br_id = '$updateBrandId'");
                if($brand_update_query){
                    echo json_encode(array('updateBrand' => 1));
                }
                else{
                    echo json_encode(array('updateBrand' => 2));
                }
           }
        }
    }
    else{
       
    }


//////////////////////////////////  BRAND ENDING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\




//////////////////////////////////  MODEL STARTING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\



    //ADD MODEL
    if(isset($_POST['model_name']) && !empty($_POST['model_name'])){

        $seriesId = $_POST['series_select_m'];
        $modelName = $_POST['model_name'];
        $modelImage = $_FILES['model_image']['name'];
        $modelextension = pathinfo($modelImage, PATHINFO_EXTENSION);
        $modeltempimage = $_FILES['model_image']['tmp_name'];
        mysqli_autocommit($con,FALSE);
        $max_model_id = mysqli_query($con, "SELECT MAX(mo_id) FROM models");
        foreach($max_model_id as $max_model_id_result){
            $max_modelid = $max_model_id_result['MAX(mo_id)'] + 1;
        }
        
        $check_model_already = mysqli_query($con, "SELECT model_name FROM models WHERE model_name = '$modelName' AND se_id = '$seriesId'");
        if(mysqli_num_rows($check_model_already) > 0){
            echo json_encode(array('addModel' => 0));
        }
        else{
            if(!empty($_FILES['model_image']['name'])){
                
                $ModelRandomNumber = rand(10000,99999);
                $final_modelimage_name = $max_modelid."_".$ModelRandomNumber.".".$modelextension;
                $modelFolder = "../assets/img/MODEL/".$final_modelimage_name;

                if(move_uploaded_file($modeltempimage, $modelFolder)){
                    $model_add_query = mysqli_query($con, "INSERT INTO models (mo_id,se_id,model_name,model_img,m_created,m_createdTime) 
                    VALUES ('$max_modelid','$seriesId','$modelName','$final_modelimage_name','$userId','$timeNow')");
                    if($model_add_query){
                        mysqli_commit($con);
                        echo json_encode(array('addModel' => 1));
                    }
                    else{
                        mysqli_rollback($con);
                        echo json_encode(array('addModel' => 2));
                    }
                }
                else{
                    mysqli_rollback($con);
                    echo json_encode(array('addModel' => 2));
                }
            }
            else{
                $model_add_query = mysqli_query($con, "INSERT INTO models (mo_id,se_id,model_name,m_created,m_createdTime) VALUES ('$max_modelid','$seriesId','$modelName','$userId','$timeNow')");
                if($model_add_query){
                    mysqli_commit($con);
                    echo json_encode(array('addModel' => 1));
                }
                else{
                    mysqli_rollback($con);
                    echo json_encode(array('addModel' => 2));
                }
            }
        }
    }
    else{

    }


    //EDIT MODEL
    if(isset($_POST['editModelId']) && !empty($_POST['editModelId'])){
        $editModelId = $_POST['editModelId'];

        $editModel = mysqli_query($con, "SELECT model_name,m.se_id,b.br_id FROM models m  INNER JOIN series s ON m.se_id = s.se_id INNER JOIN brands b ON s.br_id = b.br_id  WHERE m.mo_id = '$editModelId'");
        if(mysqli_num_rows($editModel) > 0){
            foreach($editModel as $editModels){
                $modelEditName = $editModels['model_name'];
                $modelEditBrand = $editModels['br_id'];
                $modelEditSeries = $editModels['se_id'];
                echo json_encode(array('EditModelName' => $modelEditName,'EditModelBrand' => $modelEditBrand,'EditModelSeries' => $modelEditSeries));
            }
        }
        else{
            echo json_encode(array('EditModel' => 'error'));
        }
    }
    else{
        
    }



    //DELETE MODEL
    if(isset($_POST['deleteModelId'])){
        $delModel = $_POST['deleteModelId'];
        $check_model_exists = mysqli_query($con, "SELECT mo_id FROM service_main WHERE mo_id = '$delModel'");
        if(mysqli_num_rows($check_model_exists) > 0){
            echo json_encode(array('Delmodel' => 0));
        }
        else{
            $delModelImage_query = mysqli_query($con, "SELECT model_img FROM models WHERE mo_id = '$delModel'");
            foreach( $delModelImage_query as $delModelImages){
                $delModelImage = $delModelImages['model_img'];
                $delModelImagePath = "../assets/img/MODEL/".$delModelImages['model_img'];
            }
            if($delModelImage != null){
                if(file_exists($delModelImagePath) == 1){
                    clearstatcache();
                    if(unlink($delModelImagePath)){
                        $delModelWithImage = mysqli_query($con, "DELETE FROM models WHERE mo_id = '$delModel'");
                        if($delModelWithImage){
                            echo json_encode(array('Delmodel' => 1));
                        }
                        else{
                            echo json_encode(array('Delmodel' => 2));
                        }
                    }
                    else{
                        echo json_encode(array('Delmodel' => 2));
                    } 
                }else{
                    $delModelWithoutImage = mysqli_query($con, "DELETE FROM models WHERE mo_id = '$delModel'");
                    if($delModelWithoutImage){
                        echo json_encode(array('Delmodel' => 1));
                    }
                    else{
                        echo json_encode(array('Delmodel' => 2));
                    }
                }    
            }
            else{
                $delModelWithoutImage = mysqli_query($con, "DELETE FROM models WHERE mo_id = '$delModel'");
                if($delModelWithoutImage){
                    echo json_encode(array('Delmodel' => 1));
                }
                else{
                    echo json_encode(array('Delmodel' => 2));
                }
            }
        }

        


    }




    //UPDATE MODEL
    if(isset($_POST['edit_model_name']) && !empty($_POST['edit_model_name'])){
        $updateModelId = $_POST['edit_modelId'];
        $updateModalSeriesId = $_POST['series_update_m'];
        $updateModelName = $_POST['edit_model_name'];
        $updateModelImage = $_FILES['edit_model_image']['name'];
        $updateModelextension = pathinfo($updateModelImage, PATHINFO_EXTENSION);
        $updateModeltempimage = $_FILES['edit_model_image']['tmp_name'];
        $updateModelRandomNumber = rand(10000,99999);
        $updatefinal_Modelimage_name = $updateModelId."_".$updateModelRandomNumber.".".$updateModelextension;
        
        $updateModelfolder = "../assets/img/MODEL/".$updatefinal_Modelimage_name;


        $check_update_model_already = mysqli_query($con, "SELECT model_name FROM models WHERE model_name = '$updateModelName' AND se_id = '$updateModalSeriesId' AND mo_id  <> '$updateModelId'");
        if(mysqli_num_rows($check_update_model_already) > 0){
            echo json_encode(array('updateModel' => 0));  
        }
        else{
            if(!empty($_FILES['edit_model_image']['name'])){
                $modelFetch_query = mysqli_query($con, "SELECT model_img FROM models WHERE mo_id = '$updateModelId'");
                foreach($modelFetch_query as $model_result){
                    $ModelimageValue = $model_result['model_img'];
                    $ModelimagePath = "../assets/img/MODEL/".$model_result['model_img'];
                }
                if($ModelimageValue != null){
                    if(file_exists($ModelimagePath) == 1){
                        clearstatcache();
                        if(unlink($ModelimagePath)){
                            if(move_uploaded_file($updateModeltempimage, $updateModelfolder)){
                                $model_update_query = mysqli_query($con, "UPDATE models SET model_name = '$updateModelName',model_img = '$updatefinal_Modelimage_name',se_id = '$updateModalSeriesId', m_updated = '$userId', m_updatedTime = '$timeNow' WHERE mo_id = '$updateModelId'");
                                if($model_update_query){
                                    echo json_encode(array('updateModel' => 1));
                                }
                                else{
                                    echo json_encode(array('updateModel' => 2));
                                }
                            }
                        }
                        else{
                            echo json_encode(array('updateModel' => 3));
                        }
                    }else{
                        if(move_uploaded_file($updateModeltempimage, $updateModelfolder)){
                            $model_update_query = mysqli_query($con, "UPDATE models SET model_name = '$updateModelName',model_img = '$updatefinal_Modelimage_name',se_id = '$updateModalSeriesId', m_updated = '$userId', m_updatedTime = '$timeNow' WHERE mo_id = '$updateModelId'");
                            if($model_update_query){
                                echo json_encode(array('updateModel' => 1));
                            }
                            else{
                                echo json_encode(array('updateModel' => 2));
                            }
                        }
                    }
                }
                else{
                    if(move_uploaded_file($updateModeltempimage, $updateModelfolder)){
                        $model_update_query = mysqli_query($con, "UPDATE models SET model_name = '$updateModelName',model_img = '$updatefinal_Modelimage_name',se_id = '$updateModalSeriesId', m_updated = '$userId', m_updatedTime = '$timeNow' WHERE mo_id = '$updateModelId'");
                        if($model_update_query){
                            echo json_encode(array('updateModel' => 1));
                        }
                        else{
                            echo json_encode(array('updateModel' => 2));
                        }
                    }
                } 
            }
           else{
            $model_update_query = mysqli_query($con, "UPDATE models SET model_name = '$updateModelName',se_id = '$updateModalSeriesId', m_updated = '$userId', m_updatedTime = '$timeNow' WHERE mo_id = '$updateModelId'");
            if($model_update_query){
                echo json_encode(array('updateModel' => 1));
            }
            else{
                echo json_encode(array('updateModel' => 2));
            }
           }
        }
    }
    else{
       
    }

//////////////////////////////////  MODEL ENDING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\



  
//////////////////////////////////   NEARBY TALUK STARTING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
   
    //ADD NEARBY TALUK 
    if(isset($_POST['NearbyTalukName']) && !empty($_POST['NearbyTalukName'])){
        $NearbyTaluk = $_POST['NearbyTalukName'];

        $CheckExists = mysqli_query($con, "SELECT nearbyTaluk FROM nearby_master WHERE nearbyTaluk = '$NearbyTaluk'");
        if(mysqli_num_rows($CheckExists) > 0){
            echo json_encode(array('AddNearbyTaluk' => 0));
        }
        else{
            $AddNearbyTaluk = mysqli_query($con, "INSERT INTO `nearby_master`(`nearbyTaluk`,`employeeAssigned`,`createdBy`,`createdDate`) VALUES ('$NearbyTaluk','0','$userId','$timeNow')");

            if($AddNearbyTaluk){
                mysqli_commit($con);
                echo json_encode(array('AddNearbyTaluk' => 1));
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('AddNearbyTaluk' => 2));
            }
        }
    }
    else{
        
    }


    //EDIT NEARBY TALUK 
    if(isset($_POST['EditNearbyTalukId']) && !empty($_POST['EditNearbyTalukId'])){
        $EditNearbyTalukId = $_POST['EditNearbyTalukId'];
        $EditNearbyTaluk = mysqli_query($con, "SELECT nearbyTaluk FROM nearby_master WHERE nearbyId = '$EditNearbyTalukId'");
        if(mysqli_num_rows($EditNearbyTaluk) > 0){
            foreach($EditNearbyTaluk as $EditNearbyTaluks){
                $EditNearbyTalukName = $EditNearbyTaluks['nearbyTaluk'];
                echo json_encode(array('EditNearbyTalukName' => $EditNearbyTalukName));
            }
        }
        else{
            echo json_encode(array('EditNearbyTalukName' => 'error'));
        }
    }
    else{
        
    }



    //DELETE NEARBY TALUK 
    if(isset($_POST['DeleteNearbyTalukId']) && !empty($_POST['DeleteNearbyTalukId'])){
        $DeleteNearbyTalukId = $_POST['DeleteNearbyTalukId'];

        // $check_type_Inuse = mysqli_query($con, "SELECT type FROM products WHERE type = '$delTypeId'");
        // if(mysqli_num_rows($check_type_Inuse) > 0){
        //     echo json_encode(array('Deltype' => 0));
        // }
        // else{
            mysqli_autocommit($con,FALSE);
            $DeleteNearbyTaluk = mysqli_query($con, "DELETE  FROM nearby_master WHERE nearbyId = '$DeleteNearbyTalukId'");
            if($DeleteNearbyTaluk){
                mysqli_commit($con);
                echo json_encode(array('DelNearbyTaluk' => 1));
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('DelNearbyTaluk' => 2));
            }
        // }
    }
    else{
        
    }

   

    //UPDATE NEARBY TALUK 
    if(isset($_POST['UpdateNearbyTalukId']) && !empty($_POST['UpdateNearbyTalukId'])){
        $UpdateNearbyTalukName = $_POST['UpdateNearbyTalukName'];
        $UpdateNearbyTalukId = $_POST['UpdateNearbyTalukId'];

        $CheckNearbyAlreadyExists = mysqli_query($con, "SELECT nearbyTaluk FROM nearby_master WHERE nearbyTaluk = '$UpdateNearbyTalukName' AND nearbyId <> '$UpdateNearbyTalukId'");
        if(mysqli_num_rows($CheckNearbyAlreadyExists) > 0){
            echo json_encode(array('UpdateNearbyTaluk' => 0));
        }
        else{
            mysqli_autocommit($con,FALSE);
            $UpdateNearbyMaster = mysqli_query($con, "UPDATE nearby_master SET nearbyTaluk = '$UpdateNearbyTalukName',updatedBy = '$userId',updatedDate = '$timeNow' WHERE nearbyId = '$UpdateNearbyTalukId'");
            if($UpdateNearbyMaster){
                mysqli_commit($con);
                echo json_encode(array('UpdateNearbyTaluk' => 1));
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('UpdateNearbyTaluk' => 2));
            }
        }
    }
    else{
        
    }



//////////////////////////////////  NEARBY TALUKE ENDING   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


//////////////////////////////////  ASSIGN NEARBY TALUK AGENT   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


    //ASSIGN NEARBY TALUK AGENT
    if(isset($_POST['AssignAgentId']) && isset($_POST['NearbyTalukId'])){

        mysqli_autocommit($con, FALSE);
        $NearbyTalukId = $_POST['NearbyTalukId'];
        $AssignAgentId = $_POST['AssignAgentId'];
        $AssignNearbyTalukAgent = mysqli_query($con, "UPDATE nearby_master SET employeeAssigned = '$AssignAgentId' WHERE nearbyId = '$NearbyTalukId'");

        if($AssignNearbyTalukAgent){
            mysqli_commit($con);
            echo json_encode(array('AssignedAgent' => 1));
        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('AssignedAgent' => 2));
        }
    }
    


    //REMOVE NEARBY TALUK AGENT
    if(isset($_POST['RemoveNearbyTalukId']) && !empty($_POST['RemoveNearbyTalukId'])){

        mysqli_autocommit($con, FALSE);
        $RemoveNearbyTalukId = $_POST['RemoveNearbyTalukId'];
        $RemoveAssignNearbyTalukAgent = mysqli_query($con, "UPDATE nearby_master SET employeeAssigned = 0 WHERE nearbyId = '$RemoveNearbyTalukId'");

        if($RemoveAssignNearbyTalukAgent){
            mysqli_commit($con);
            echo json_encode(array('RemoveAssignedAgent' => 1));
        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('RemoveAssignedAgent' => 2));
        }
    }
   

//////////////////////////////////  ASSIGN NEARBY TALUK AGENT   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\




/////////////////////////////////  COLOR STARTING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    //ADD COLOR
    if (isset($_POST['ColorName']) && !empty($_POST['ColorName'])) {

        $ColorName = $_POST['ColorName'];
        $ColorImage = $_FILES['ColorImage']['name'];
        $ColorImageExtension = pathinfo($ColorImage, PATHINFO_EXTENSION);
        $ColorTempImage = $_FILES['ColorImage']['tmp_name'];
        mysqli_autocommit($con,FALSE);
        try{

            $CheckColorAlready = mysqli_query($con, "SELECT colorName FROM color WHERE ColorName = '$ColorName'");
            if (mysqli_num_rows($CheckColorAlready) > 0) {
                throw new Exception("Color Already Exists!","0");
            } else {
               
                $FindMaxColorid = mysqli_query($con, "SELECT MAX(colorId) FROM color");
                foreach($FindMaxColorid as $FindMaxColoridResult){
                    $MaxColorId =  $FindMaxColoridResult['MAX(colorId)'] + 1;
                }
                if (!empty($_FILES['ColorImage']['name'])) {
                    $ImageRandomNumber = rand(10000, 99999);
                    $FinalImageName = $MaxColorId . "_" . $ImageRandomNumber . "." . $ColorImageExtension;
                    $ImageFolder = "../assets/img/COLOR/" . $FinalImageName;
                    if (move_uploaded_file($ColorTempImage, $ImageFolder)) {
                        $ColorAddQuery = mysqli_query($con, "INSERT INTO color (colorId,colorName,colorImage,createdBy,createdDate) 
                            VALUES ('$MaxColorId','$ColorName','$FinalImageName','$userId','$timeNow')");
                        GOTO ColorInsertResult;
                    } else {
                        mysqli_rollback($con);
                        throw new Exception("Failed Adding Color!","2");
                    }
                } else {
                    $ColorAddQuery = mysqli_query($con, "INSERT INTO color (colorId,colorName,createdBy,createdDate) 
                    VALUES ('$MaxColorId','$ColorName','$userId','$timeNow')");
                    GOTO ColorInsertResult;
                }
                ColorInsertResult:
                if ($ColorAddQuery) {
                    mysqli_commit($con);
                    echo json_encode(array('Status' => 1, 'Message' => 'Color Added Successfully'));
                    //header('HTTP/1.0 200 Record Saved Successfully');
                } else {
                    mysqli_rollback($con);
                    throw new Exception("Failed Adding Color!","2");
                }
            }
        }
        catch(Exception $e){
            echo json_encode(array('Status' => $e->getCode(),'Message' => $e->getMessage()));
        }
    }else{
    }


    //EDIT COLOR
    if (isset($_POST['EditColorId']) && !empty($_POST['EditColorId'])) {
        $EditColorId = $_POST['EditColorId'];
        try{
            $EditColor = mysqli_query($con, "SELECT colorName FROM color WHERE colorId = '$EditColorId'");
            if (mysqli_num_rows($EditColor) > 0) {
                foreach ($EditColor as $EditColorResult) {
                    $EditColorName = $EditColorResult['colorName'];
                    echo json_encode(array('Status' => '1', 'Message' => 'Details Retreived Successfully', 'ColorName' => $EditColorName));
                }
            } else {
                throw new Exception("No Records Found","0");
            }
        }
        catch(Exception $e){
            echo json_encode(array('Status' => $e->getCode(),'Message' => $e->getMessage()));
        }
    } else {
    }


    //DELETE COLOR
    if (isset($_POST['DeleteColorId'])) {
        $DeleteColorId = $_POST['DeleteColorId'];
        try{
            $DelCheckColorAlready = mysqli_query($con, "SELECT color FROM products WHERE color = '$DeleteColorId'");
            if (mysqli_num_rows($DelCheckColorAlready) > 0) {
                throw new Exception("Color Already Exists","0");
            } else {
                $DelColorImageQuery = mysqli_query($con, "SELECT colorImage FROM color WHERE colorId = '$DeleteColorId'");
                foreach ($DelColorImageQuery as $DelColorImageResults) {
                    $DelColorImage = $DelColorImageResults['colorImage'];
                    $DelColorImagePath = "../assets/img/COLOR/" . $DelColorImageResults['colorImage'];
                }
                if ($DelColorImage != null) {
                    if (file_exists($DelColorImagePath) == 1) {
                        clearstatcache();
                        unlink($DelColorImagePath);
                    }
                }
                GOTO DeleteResult;
                
                DeleteResult:
                $DeleletColor = mysqli_query($con, "DELETE FROM color WHERE colorId = '$DeleteColorId'");
                if ($DeleletColor) {
                    echo json_encode(array('Status' => 1,'Message' => 'Color Deleted Successfully'));
                } else {
                    throw new Exception("Failed Deleting Color","2");
                }
            }
        }
        catch(Exception $e){
            echo json_encode(array('Status' => $e->getCode(),'Message' => $e->getMessage()));
        }

        
    } else {
    }



    //UPDATE COLOR
    if (isset($_POST['UpdateColorId']) && !empty($_POST['UpdateColorId'])) {
        $UpdateColorId = $_POST['UpdateColorId'];
        $UpdateColorName = $_POST['UpdateColorName'];
        $UpdateColorImage = $_FILES['UpdateColorImage']['name'];
        $UpdateColorExtension = pathinfo($UpdateColorImage, PATHINFO_EXTENSION);
        $UpdateColorTempimage = $_FILES['UpdateColorImage']['tmp_name'];
        $UpdateColorRandNumber = rand(10000, 99999);
        $UpdateFinalColorImage = $UpdateColorId . "_" . $UpdateColorRandNumber . "." . $UpdateColorExtension;
        $UpdateColorFolder = "../assets/img/COLOR/" . $UpdateFinalColorImage;

        try{

            $CheckUpdateColorAlready = mysqli_query($con, "SELECT colorName FROM color WHERE colorName = '$UpdateColorName' AND colorId  <> '$UpdateColorId'");
            if (mysqli_num_rows($CheckUpdateColorAlready) > 0) {
                throw new Exception("Color Already Exists","0");
            } else {
                if (!empty($_FILES['UpdateColorImage']['name'])) {
                    $FetchColorImage = mysqli_query($con, "SELECT colorImage FROM color WHERE colorId = '$UpdateColorId'");
                    foreach ($FetchColorImage as $ColorImageResult) {
                        $colorImageValue = $ColorImageResult['colorImage'];
                        $colorImagePath = "../assets/img/COLOR/" . $ColorImageResult['colorImage'];
                    }
                    if ($colorImageValue != null) {
                        if (file_exists($colorImagePath) == 1) {
                            clearstatcache();
                            unlink($colorImagePath);
                        }
                    }
                    if (move_uploaded_file($UpdateColorTempimage, $UpdateColorFolder)) {
                        $ImageOrNot = ",colorImage = '$UpdateFinalColorImage'";
                        GOTO UpdateColorResult;
                    }
                    else{
                        throw new Exception("Failed Updating Color","2");
                    }
                } else {
                    $ImageOrNot = '';
                    GOTO UpdateColorResult;
                }
            }

            UpdateColorResult:
            $ColorUpdateQuery = mysqli_query($con, "UPDATE color SET colorName = '$UpdateColorName'".$ImageOrNot.",updatedBy = '$userId', updatedDate = '$timeNow' WHERE colorId = '$UpdateColorId'");

            if ($ColorUpdateQuery) {
                echo json_encode(array('Status' => 1,'Message' => 'Successfully Updated Color'));
            } else {
                throw new Exception("Failed Updating Color","2");
            }

        }
        catch(Exception $e){
            echo json_encode(array('Status' => $e->getCode(),'Message' => $e->getMessage()));
        }            
    } else {
    }


///////////////////////////////// COLOR ENDING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\