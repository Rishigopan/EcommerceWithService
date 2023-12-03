<?php

include_once "../MAIN/Dbconn.php";
include_once "./CommonFunctions.php";

$userId = $_COOKIE['custidcookie'];

$timeNow = date("Y-m-d h:i:s");



//////////////////////////////////  PRODUCT STARTING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

//ADD PRODUCT
if (isset($_POST['type']) && !empty($_POST['type'])) {

    mysqli_autocommit($con, FALSE);

    $ProductImei = isset($_POST['Isimei']) ? $_POST['Isimei'] : "NO";
    $ProductBarcode = isset($_POST['Isbarcode']) ? $_POST['Isbarcode'] : "NO";
    $ProductIsSale = isset($_POST['IsSalesItem']) ? "1" : "0";
    $ProductIsInshopSale = isset($_POST['IsInshopSalesItem']) ? "1" : "0";
    $ProductIsOnlineSale = isset($_POST['IsOnlineSalesItem']) ? "1" : "0";
    $ProductIsService = isset($_POST['IsServiceItem']) ? "1" : "0";
    $ProductDealerService = "0";
    $ProductInshopService = "0";
    $ProductCategory = ($_POST['type'] == '') ? 0 : SanitizeInt($_POST['type']);
    $ProductBrand = ($_POST['brand'] == '') ? 0 : SanitizeInt($_POST['brand']);
    $ProductSeries = ($_POST['series'] == '') ? 0 : SanitizeInt($_POST['series']);
    //$ProductModel = ($_POST['model'] == '') ? 0 : SanitizeInt($_POST['model']);
    $ProductName = mysqli_real_escape_string($con, SanitizeInput($_POST['product']));
    $ProductTax = ($_POST['tax'] == '') ? 0 : SanitizeFloat($_POST['tax']);
    $ProductPrice = ($_POST['price'] == '') ? 0 : SanitizeFloat($_POST['price']);
    $ProductMRP = ($_POST['mrp'] == '') ? 0 : SanitizeFloat($_POST['mrp']);
    $ProductCode  = SanitizeInput($_POST['code']);
    $ProductBarcodeValueTemp = SanitizeInput($_POST['barcode']);
    $ProductColor = SanitizeInput($_POST['AddProductColor']);
    $ProductMini = SanitizeInput($_POST['mini_desc']);
    $ProductWarranty = ($_POST['warranty'] == '') ? 0 : SanitizeInt($_POST['warranty']);
    $ProductDescription = SanitizeInput($_POST['description']);
    $ProductAddType = ($_POST['ProductType'] == '') ? 0 : SanitizeInt($_POST['ProductType']);
    $ProductCP = ($_POST['cp'] == '') ? 0 : SanitizeFloat($_POST['cp']);
    $ProductHSN = ($_POST['hsn'] == '') ? 0 : SanitizeInt($_POST['hsn']);

    $ProductImage = $_FILES['main_image']['name'];
    $extension = pathinfo($ProductImage, PATHINFO_EXTENSION);
    $Producttempimage = $_FILES['main_image']['tmp_name'];

    $increment = 0;

    $max_product_id_query = mysqli_query($con, "SELECT MAX(pr_id) FROM products");
    foreach ($max_product_id_query as $max_product_id_result) {
        $maxProductId = $max_product_id_result['MAX(pr_id)'] + 1;
    }


    if ($_POST['ProductFor'] != 0) {
        $ForProduct = $_POST['ProductFor'];
        $FindProductDetails = mysqli_query($con, "SELECT brand,series FROM products WHERE pr_id = '$ForProduct'");
        foreach ($FindProductDetails as $FindProductDetailsResult) {
            $ForBrand = $FindProductDetailsResult['brand'];
            $ForSeries =  $FindProductDetailsResult['series'];
        }
    } else {
        $ForBrand = 0;
        $ForSeries = 0;
        $ForProduct = 0;
    }


    $ProductBarcodeValue = ($ProductBarcodeValueTemp > 0 || $ProductBarcodeValueTemp != '') ? $ProductBarcodeValueTemp : $maxProductId;

    $check_product_already = mysqli_query($con, "SELECT name FROM products WHERE name = '$ProductName'");
    if (mysqli_num_rows($check_product_already) > 0) {
        echo json_encode(array('addProduct' => 0));
    } else {

        $FindBarcodeExists = mysqli_query($con, "SELECT barcode FROM products WHERE barcode = '$ProductBarcodeValue'");
        if (mysqli_num_rows($FindBarcodeExists) > 0) {
            echo json_encode(array('addProduct' => 5));
        } else {
            if (!empty($_FILES['main_image']['name'])) {

                $RandNumber = rand(10000, 99999);
                $ProductImage = $_FILES['main_image']['name'];
                $extension = pathinfo($ProductImage, PATHINFO_EXTENSION);
                $finalProductImage_name = $maxProductId . '_' . $RandNumber . '.' . $extension;
                $productFolder = "../assets/img/PRODUCTS/" . $finalProductImage_name;

                if (move_uploaded_file($Producttempimage, $productFolder)) {


                    $Query = "INSERT INTO `products` (`pr_id`,`parent_item_id`,`pr_code`,`type`,`brand`,`series`,`model`,`name`,`img`,`color`,`price`,`tax`,`mini_desc`,`description`,`current_stock`,`purchased_qty`,`sold_qty`,`isimei`,`isbarcode`,`imei`,`barcode`,`warranty`,`unitid`,`inclusive`,`cp`,`lastcp`,`IGST`,`mrp`,`batch`,`sp`,`usercode`,`expiryDate`,`hsn`,`productType`,`forBrand`,`forSeries`,`forProduct`,`isServiceItem`,`isSalesItem`,`isInShopSales`,`isOnlineSales`,`isDealerService`,`isInShopService`,`p_created`,`p_createdTime`) VALUES ('$maxProductId','$maxProductId','$ProductCode','$ProductCategory','$ProductBrand','$ProductSeries','0','$ProductName','$finalProductImage_name','$ProductColor','$ProductPrice','$ProductTax','$ProductMini','$ProductDescription','0','0','0','0','$ProductBarcode','0','$ProductBarcodeValue','$ProductWarranty','0','1','$ProductCP','0','$ProductTax','$ProductMRP','0','$ProductPrice','0','0','$ProductHSN','$ProductAddType','$ForBrand','$ForSeries','$ForProduct','$ProductIsService','$ProductIsSale','$ProductIsInshopSale','$ProductIsOnlineSale','$ProductDealerService','$ProductInshopService','$userId','$timeNow')";

                    // echo $Query;

                    $query_add_product =  mysqli_query($con, $Query);

                    $images_dir = "../assets/img/ADD_IMAGE/";
                    if ($query_add_product) {
                        foreach ($_FILES['multi_image']['tmp_name'] as $key => $tmp_name) {
                            $MultipleRandNumber = rand(10000, 99999);
                            $multi_file_name = $_FILES['multi_image']['name'][$key];
                            $multi_extension = pathinfo($multi_file_name, PATHINFO_EXTENSION);
                            $new_multi_file_name = $maxProductId . '_' . $increment++ . '_' . $MultipleRandNumber . '.' . $multi_extension;
                            $multi_file_tmp = $_FILES['multi_image']['tmp_name'][$key];

                            if (move_uploaded_file($multi_file_tmp, $images_dir . $new_multi_file_name)) {
                                $query_multi =  mysqli_query($con, "INSERT INTO product_image (pr_id,images) VALUES ('$maxProductId','$new_multi_file_name')");
                            } else {
                                //echo "multi upload Failed";
                            }
                        }
                        mysqli_commit($con);
                        echo json_encode(array('addProduct' => 1));
                    } else {
                        mysqli_rollback($con);
                        echo json_encode(array('addProduct' => 2));
                    }
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('addProduct' => 3));
                }
            } else {

                $Query = "INSERT INTO `products` (`pr_id`,`parent_item_id`,`pr_code`,`type`,`brand`,`series`,`model`,`name`,`img`,`color`,`price`,`tax`,`mini_desc`,`description`,`current_stock`,`purchased_qty`,`sold_qty`,`isimei`,`isbarcode`,`imei`,`barcode`,`warranty`,`unitid`,`inclusive`,`cp`,`lastcp`,`IGST`,`mrp`,`batch`,`sp`,`usercode`,`expiryDate`,`hsn`,`productType`,`forBrand`,`forSeries`,`forProduct`,`isServiceItem`,`isSalesItem`,`isInShopSales`,`isOnlineSales`,`isDealerService`,`isInShopService`,`p_created`,`p_createdTime`) VALUES ('$maxProductId','$maxProductId','$ProductCode','$ProductCategory','$ProductBrand','$ProductSeries','0','$ProductName','','$ProductColor','$ProductPrice','$ProductTax','$ProductMini','$ProductDescription','0','0','0','0','$ProductBarcode','0','$ProductBarcodeValue','$ProductWarranty','0','1','$ProductCP','0','$ProductTax','$ProductMRP','0','$ProductPrice','0','0','$ProductHSN','$ProductAddType','$ForBrand','$ForSeries','$ForProduct','$ProductIsService','$ProductIsSale','$ProductIsInshopSale','$ProductIsOnlineSale','$ProductDealerService','$ProductInshopService','$userId','$timeNow')";

                // echo $Query;

                $query_add_product =  mysqli_query($con, $Query);

                if ($query_add_product) {
                    mysqli_commit($con);
                    echo json_encode(array('addProduct' => 1));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('addProduct' => 2));
                }
            }
        }
    }
}



//DELETE PRODUCT
if (isset($_POST['deleteProductId'])) {
    $delProduct = $_POST['deleteProductId'];

    $check_product_present = mysqli_query($con, "SELECT * FROM `products` WHERE current_stock = 0 AND sold_qty = 0 AND purchased_qty = 0 AND pr_id = '$delProduct'");
    if (mysqli_num_rows($check_product_present) > 0) {

        $res = array();
        $fetch_mainImage = mysqli_query($con, "SELECT img FROM products WHERE pr_id = '$delProduct'");
        $result_mainImage = mysqli_fetch_array($fetch_mainImage);
        $fetch_addImages = mysqli_query($con, "SELECT * FROM product_image WHERE pr_id = '$delProduct'");
        $main_Image_path = "../assets/img/PRODUCTS/" . $result_mainImage['img'];

        if ($fetch_addImages) {
            while ($result_addImages = mysqli_fetch_array($fetch_addImages)) {
                $tmp_var = $result_addImages['images'];
                $sub_path = "../assets/img/ADD_IMAGE/" . $tmp_var;
                $res[$tmp_var] = @unlink($sub_path);
            }
            mysqli_query($con, "DELETE FROM product_image WHERE pr_id = '$delProduct'");
            if (unlink($main_Image_path)) {
                $success =  mysqli_query($con, "DELETE FROM products WHERE pr_id = '$delProduct'");
                if ($success) {
                    echo json_encode(array('DelProduct' => 1));
                } else {
                    echo json_encode(array('DelProduct' => 2));
                }
            } else {
                $success =  mysqli_query($con, "DELETE FROM products WHERE pr_id = '$delProduct'");
                if ($success) {
                    echo json_encode(array('DelProduct' => 1));
                } else {
                    echo json_encode(array('DelProduct' => 2));
                }
            }
        } else {
            $success =  mysqli_query($con, "DELETE FROM products WHERE pr_id = '$delProduct'");
            if ($success) {
                echo json_encode(array('DelProduct' => 1));
            } else {
                echo json_encode(array('DelProduct' => 2));
            }
        }
    } else {
        echo json_encode(array('DelProduct' => 0));
    }
}




//UPDATE PRODUCT
if (isset($_POST['UpdateProductId']) && !empty($_POST['UpdateProductCategory'])) {

    $UpdateProductParentItemId = SanitizeInt($_POST['UpdateProductParentItemId']);
    $UpdateProductId = SanitizeInt($_POST['UpdateProductId']);
    $UpdateProductName = SanitizeInput($_POST['UpdateProductName']);
    $UpdateProductCategory = ($_POST['UpdateProductCategory'] == '') ? 0 : SanitizeInt($_POST['UpdateProductCategory']);
    $UpdateProductBrand = ($_POST['UpdateProductBrand'] == '') ? 0 : SanitizeInt($_POST['UpdateProductBrand']);
    $UpdateProductSeries = ($_POST['UpdateSeries'] == '') ? 0 : SanitizeInt($_POST['UpdateSeries']);
    $UpdateProductIsSale = isset($_POST['UpdateIsSalesItem']) ? "1" : "0";
    $UpdateProductIsInshopSale = isset($_POST['UpdateIsInshopSalesItem']) ? "1" : "0";
    $UpdateProductIsOnlineSale = isset($_POST['UpdateIsOnlineSalesItem']) ? "1" : "0";
    $UpdateProductIsService = isset($_POST['UpdateIsServiceItem']) ? "1" : "0";
    $UpdateProductDealerService = "0";
    $UpdateProductInshopService = "0";
    $UpdateProductMini = SanitizeInput($_POST['UpdateProductMiniDesc']);
    $UpdateProductTax = ($_POST['UpdateProductTax'] == '') ? 0 : SanitizeFloat($_POST['UpdateProductTax']);
    $UpdateProductPrice = ($_POST['UpdateProductAmount'] == '') ? 0 : SanitizeFloat($_POST['UpdateProductAmount']);
    $UpdateProductMrp = ($_POST['UpdateProductMrp'] == '') ? 0 : SanitizeFloat($_POST['UpdateProductMrp']);
    $UpdateProductCode  = SanitizeInput($_POST['UpdateProductCode']);
    $UpdateProductColor  = SanitizeInput($_POST['UpdateProductColor']);
    $UpdateProductBarcodeTemp  = SanitizeInput($_POST['UpdateProductBarcode']);
    $UpdateProductWarranty = ($_POST['UpdateProductWarranty'] == '') ? 0 : SanitizeInt($_POST['UpdateProductWarranty']);
    $UpdateProductDescription = SanitizeInput($_POST['UpdateProductDesc']);
    $UpdateProductAddType = ($_POST['UpdateProductTypeName'] == '') ? 0 : SanitizeInt($_POST['UpdateProductTypeName']);
    $UpdateProductCP = ($_POST['UpdateProductCp'] == '') ? 0 : SanitizeFloat($_POST['UpdateProductCp']);
    $UpdateProductHSN = ($_POST['UpdateProductHsn'] == '') ? 0 : SanitizeInt($_POST['UpdateProductHsn']);
    $UpdateProductImei = (isset($_POST['UpdateProductISIMEI'])) ? $_POST['UpdateProductISIMEI'] : "NO";
    $UpdateMainFolder = '../assets/img/PRODUCTS/';

    $UpdateProductBarcode =  ($UpdateProductBarcodeTemp > 0 || $UpdateProductBarcodeTemp != 0 || $UpdateProductBarcodeTemp != '') ? $UpdateProductBarcodeTemp : $UpdateProductId;


    if ($_POST['UpdateProductFor'] != 0) {


        if ($_POST['UpdateOldProductFor'] != $_POST['UpdateProductFor']) {
            $UpdateForProduct = $_POST['UpdateProductFor'];
            $FindProductDetails = mysqli_query($con, "SELECT brand,series FROM products WHERE pr_id = '$UpdateForProduct'");
            foreach ($FindProductDetails as $FindProductDetailsResult) {
                $UpdateForBrand = $FindProductDetailsResult['brand'];
                $UpdateForSeries =  $FindProductDetailsResult['series'];
            }

            $ForProductIncluded = ", `forProduct` = '$UpdateForProduct' , `forBrand` = '$UpdateForBrand' , `forSeries` = '$UpdateForSeries'";
        } else {
            $ForProductIncluded = '';
        }
    } else {
        $ForProductIncluded = '';
    }


    // $CheckProductExists = mysqli_query($con, "SELECT * FROM products WHERE type = '$UpdateProductType' AND brand = '$UpdateProductBrand' AND name = '$UpdateProductName' AND pr_id <> '$UpdateProductId'");
    // if (mysqli_num_rows($CheckProductExists) > 0) {
    //     echo json_encode(array('UpdateProduct' => 0));
    // } else {

    $FindBarcodeExists = mysqli_query($con, "SELECT barcode FROM products WHERE barcode = '$UpdateProductBarcode' AND pr_id <> '$UpdateProductId' AND parent_item_id <> '$UpdateProductParentItemId'");
    if (mysqli_num_rows($FindBarcodeExists) > 0) {
        echo json_encode(array('UpdateProduct' => 5));
    } else {
        //Check if main image is not empty 
        if (!empty($_FILES['UpdateProductMain']['name'])) {

            $UpdateProductImage = $_FILES['UpdateProductMain']['name'];
            $UpdateExtension = pathinfo($UpdateProductImage, PATHINFO_EXTENSION);
            $UpdateProductTempImage = $_FILES['UpdateProductMain']['tmp_name'];
            $RandNumber = rand(10000, 99999);
            $UpdatedMainImageName = $UpdateProductId . '_' . $RandNumber . '.' . $UpdateExtension;
            $UpdatedMainImage = $UpdateMainFolder . $UpdateProductId . '_' . $RandNumber . '.' . $UpdateExtension;

            //Find image name from db
            $FindMainImage = mysqli_query($con, "SELECT img FROM products WHERE pr_id = '$UpdateProductId'");
            if (mysqli_num_rows($FindMainImage) > 0) {
                foreach ($FindMainImage as $FindMainImageResult) {
                    $MainImageName = $FindMainImageResult['img'];
                }
                if (trim($MainImageName) == '') {
                    $MainExistImage = $UpdateMainFolder . $MainImageName;
                    if (file_exists($MainExistImage) == 1) {
                        clearstatcache();
                        unlink($MainExistImage);
                    } else {
                    }
                } else {
                }
            } else {
            }

            if (move_uploaded_file($UpdateProductTempImage, $UpdatedMainImage)) {
                if (!empty($_FILES['UpdateProductMoreImages']['name'])) {
                    $DeleteImages = mysqli_query($con, "DELETE FROM product_image WHERE pr_id = '$UpdateProductId'");
                    $increment = 0;
                    foreach ($_FILES['UpdateProductMoreImages']['tmp_name'] as $key => $tmp_name) {
                        $increment++;
                        $MultiRandNumber = rand(10000, 99999);
                        $MultiUpdateImage = $_FILES['UpdateProductMoreImages']['name'][$key];
                        $MultiExtension = pathinfo($MultiUpdateImage, PATHINFO_EXTENSION);
                        $NewMultiUpdateImageName = $UpdateProductId . '_' . $increment . '_' . $MultiRandNumber . '.' . $MultiExtension;
                        $NewMultiUpdateImage = '../assets/img/ADD_IMAGE/' . $UpdateProductId . '_' . $increment . '_' . $MultiRandNumber . '.' . $MultiExtension;
                        $MultiUpdateImageTemp = $_FILES['UpdateProductMoreImages']['tmp_name'][$key];
                        if (move_uploaded_file($MultiUpdateImageTemp, $NewMultiUpdateImage)) {
                            $InsertQueryMulti =  mysqli_query($con, "INSERT INTO product_image (pr_id,images) VALUES ('$UpdateProductId','$NewMultiUpdateImageName')");
                        } else {
                            //echo "multi upload Failed";
                        }
                    }
                }

                $ImageIncluded = ", `img` = '$UpdatedMainImageName'";

                goto UpdateProductSection;
            }
        } else {

            $ImageIncluded = '';

            //If main image is not submitted
            if (!empty($_FILES['UpdateProductMoreImages']['name'])) {
                $DeleteImages = mysqli_query($con, "DELETE FROM product_image WHERE pr_id = '$UpdateProductId'");
                $increment = 0;
                foreach ($_FILES['UpdateProductMoreImages']['tmp_name'] as $key => $tmp_name) {
                    $increment++;
                    $MultiRandNumber = rand(10000, 99999);
                    $MultiUpdateImage = $_FILES['UpdateProductMoreImages']['name'][$key];
                    $MultiExtension = pathinfo($MultiUpdateImage, PATHINFO_EXTENSION);
                    $NewMultiUpdateImageName = $UpdateProductId . '_' . $increment . '_' . $MultiRandNumber . '.' . $MultiExtension;
                    $NewMultiUpdateImage = '../assets/img/ADD_IMAGE/' . $UpdateProductId . '_' . $increment . '_' . $MultiRandNumber . '.' . $MultiExtension;
                    $MultiUpdateImageTemp = $_FILES['UpdateProductMoreImages']['tmp_name'][$key];
                    if (move_uploaded_file($MultiUpdateImageTemp, $NewMultiUpdateImage)) {
                        $InsertQueryMulti =  mysqli_query($con, "INSERT INTO product_image (pr_id,images) VALUES ('$UpdateProductId','$NewMultiUpdateImageName')");
                    } else {
                        //echo "multi upload Failed";
                    }
                }
                goto UpdateProductSection;
            } else {
                goto UpdateProductSection;
            }
        }



        UpdateProductSection:

        $UpdateQuery = "UPDATE `products` SET `pr_code` = '$UpdateProductCode', `productType` = '$UpdateProductAddType', `type` = '$UpdateProductCategory', `brand` = '$UpdateProductBrand', `series` = '$UpdateProductSeries', `color` = '$UpdateProductColor', `name` = '$UpdateProductName', `price` = '$UpdateProductPrice', `sp` = '$UpdateProductPrice', `mrp` = '$UpdateProductMrp', `tax` = '$UpdateProductTax', `mini_desc` = '$UpdateProductMini', `description` = '$UpdateProductDescription' , `isimei` = '$UpdateProductImei', `barcode` = '$UpdateProductBarcode', `cp` = '$UpdateProductCP', `hsn` = '$UpdateProductHSN', `warranty` = '$UpdateProductWarranty', `isServiceItem` = '$UpdateProductIsService', `isSalesItem` = '$UpdateProductIsSale', `isInShopSales` = '$UpdateProductIsInshopSale', `isOnlineSales` = '$UpdateProductIsOnlineSale', `isDealerService` = '$UpdateProductDealerService', `isInShopService` = '$UpdateProductInshopService', `p_updated` = '$userId', `p_updatedTime` = '$timeNow' " . $ImageIncluded . " " . $ForProductIncluded . " WHERE `pr_id` = '$UpdateProductId'";

        $UpdateProduct = mysqli_query($con, $UpdateQuery);
        if ($UpdateProduct) {
            echo json_encode(array('UpdateProduct' => 1));
        } else {
            echo json_encode(array('UpdateProduct' => 2));
        }
    }
}



//////////////////////////////////  PRODUCT ENDING \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\







///////////////////  PRODUCT TYPE STARTING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

//ADD PRODUCT TYPE
if (isset($_POST['ProductTypeName']) && !empty($_POST['ProductTypeName'])) {

    $TypeName = $_POST['ProductTypeName'];
    $TypeImage = $_FILES['TypeImage']['name'];
    $TypeImageExtension = pathinfo($TypeImage, PATHINFO_EXTENSION);
    $TypeTempImage = $_FILES['TypeImage']['tmp_name'];

    mysqli_autocommit($con,FALSE);
    try{

        $CheckTypeAlready = mysqli_query($con, "SELECT productTypeName FROM producttype WHERE productTypeName = '$TypeName'");
        if (mysqli_num_rows($CheckTypeAlready) > 0) {
            throw new Exception("Type Already Exists!","0");
        } else {
            $FetchMaxId = mysqli_query($con, "SELECT MAX(productTypeId) FROM producttype");
            foreach($FetchMaxId as $FetchMaxIdResult){
                $MaxId =  $FetchMaxIdResult['MAX(productTypeId)'] + 1;
            }
            if (!empty($_FILES['TypeImage']['name'])) {
                $ImageRandomNumber = rand(10000, 99999);
                $FinalImageName = $MaxId . "_" . $ImageRandomNumber . "." . $TypeImageExtension;
                $ImageFolder = "../assets/img/TYPE/" . $FinalImageName;
                if (move_uploaded_file($TypeTempImage, $ImageFolder)) {
                    $TypeAddQuery = mysqli_query($con, "INSERT INTO producttype (productTypeId,productTypeName,productTypeImage,createdBy,createdDate) 
                    VALUES ('$MaxId','$TypeName','$FinalImageName','$userId','$timeNow')");
                    GOTO TypeInsertResult;
                } else {
                    mysqli_rollback($con);
                    throw new Exception("Failed Adding Type!","2");
                }
            } else {
                $TypeAddQuery = mysqli_query($con, "INSERT INTO producttype (productTypeId,productTypeName,createdBy,createdDate) 
                VALUES ('$MaxId','$TypeName','$userId','$timeNow')");
                GOTO TypeInsertResult;
            }
            TypeInsertResult:
            if ($TypeAddQuery) {
                mysqli_commit($con);
                echo json_encode(array('Status' => 1, 'Message' => 'Type Added Successfully'));
            } else {
                mysqli_rollback($con);
                throw new Exception("Failed Adding Type!","2");
            }
        }
    }
    catch(Exception $e){
        echo json_encode(array('Status' => $e->getCode(),'Message' => $e->getMessage()));
    }

} else {
}


//EDIT PRODUCT TYPE
if (isset($_POST['EditProductTypeId']) && !empty($_POST['EditProductTypeId'])) {
    $EditProductTypeId = $_POST['EditProductTypeId'];
    $EditProductType = mysqli_query($con, "SELECT productTypeName FROM producttype WHERE productTypeId = '$EditProductTypeId'");
    if (mysqli_num_rows($EditProductType) > 0) {
        foreach ($EditProductType as $EditProductTypes) {
            $EditProductTypeName = $EditProductTypes['productTypeName'];
            echo json_encode(array('EditProductTypeName' => $EditProductTypeName));
        }
    } else {
        echo json_encode(array('EditProductType' => 'error'));
    }
} else {
}


//DELETE PRODUCT TYPE
if (isset($_POST['DeleteProductTypeId'])) {
    $DelProductType = $_POST['DeleteProductTypeId'];
    $DelCheckProductTypeAlready = mysqli_query($con, "SELECT productType FROM products WHERE productType = '$DelProductType'");
    if (mysqli_num_rows($DelCheckProductTypeAlready) > 0) {
        echo json_encode(array('DelProductType' => 0));
    } else {
        $DelProductTypeImageQuery = mysqli_query($con, "SELECT productTypeImage FROM producttype WHERE productTypeId = '$DelProductType'");
        foreach ($DelProductTypeImageQuery as $DelProductTypeImages) {
            $DelProductTypeImage = $DelProductTypeImages['productTypeImage'];
            $DelProductTypeImagePath = "../assets/img/TYPE/" . $DelProductTypeImages['productTypeImage'];
        }
        if ($DelProductTypeImage != null) {
            if (file_exists($DelProductTypeImagePath) == 1) {
                clearstatcache();
                if (unlink($DelProductTypeImagePath)) {
                    $DelProductTypeWithImage = mysqli_query($con, "DELETE FROM producttype WHERE productTypeId = '$DelProductType'");
                    if ($DelProductTypeWithImage) {
                        echo json_encode(array('DelProductType' => 1));
                    } else {
                        echo json_encode(array('DelProductType' => 2));
                    }
                } else {
                    echo json_encode(array('DelProductType' => 2));
                }
            } else {
                $DelProductTypeWithoutImage = mysqli_query($con, "DELETE FROM producttype WHERE productTypeId = '$DelProductType'");
                if ($DelProductTypeWithoutImage) {
                    echo json_encode(array('DelProductType' => 1));
                } else {
                    echo json_encode(array('DelProductType' => 2));
                }
            }
        } else {
            $DelProductTypeWithoutImage = mysqli_query($con, "DELETE FROM producttype WHERE productTypeId = '$DelProductType'");
            if ($DelProductTypeWithoutImage) {
                echo json_encode(array('DelProductType' => 1));
            } else {
                echo json_encode(array('DelProductType' => 2));
            }
        }
    }
} else {
}



//UPDATE PRODUCT TYPE
if (isset($_POST['UpdateProductTypeId']) && !empty($_POST['UpdateProductTypeId'])) {
    $UpdateProductTypeId = $_POST['UpdateProductTypeId'];
    $UpdateProductTypeName = $_POST['UpdateProductTypeName'];
    $UpdateProductTypeImage = $_FILES['UpdateTypeImage']['name'];
    $UpdateProductTypeExtension = pathinfo($UpdateProductTypeImage, PATHINFO_EXTENSION);
    $UpdateProductTypeTempimage = $_FILES['UpdateTypeImage']['tmp_name'];
    $UpdateProductTypeRandNumber = rand(10000, 99999);
    $UpdateFinalProductTypeImage = $UpdateProductTypeId . "_" . $UpdateProductTypeRandNumber . "." . $UpdateProductTypeExtension;
    $UpdateProductTypeFolder = "../assets/img/TYPE/" . $UpdateFinalProductTypeImage;


    $CheckUpdateproductTypeAlready = mysqli_query($con, "SELECT productTypeName FROM producttype WHERE productTypeName = '$UpdateProductTypeName' AND productTypeId  <> '$UpdateProductTypeId'");
    if (mysqli_num_rows($CheckUpdateproductTypeAlready) > 0) {
        echo json_encode(array('UpdateProductType' => 0));
    } else {
        if (!empty($_FILES['UpdateTypeImage']['name'])) {
            $ProductTypeFetchQuery = mysqli_query($con, "SELECT productTypeImage FROM producttype WHERE productTypeId = '$UpdateProductTypeId'");
            foreach ($ProductTypeFetchQuery as $ProductTypeResult) {
                $ProductTypeImageValue = $ProductTypeResult['productTypeImage'];
                $ProductTypeImagePath = "../assets/img/TYPE/" . $ProductTypeResult['productTypeImage'];
            }
            if ($ProductTypeImageValue != null) {
                if (file_exists($ProductTypeImagePath) == 1) {
                    clearstatcache();
                    if (unlink($ProductTypeImagePath)) {
                        if (move_uploaded_file($UpdateProductTypeTempimage, $UpdateProductTypeFolder)) {
                            $ProductTypeUpdateQuery = mysqli_query($con, "UPDATE producttype SET productTypeName = '$UpdateProductTypeName',productTypeImage = '$UpdateFinalProductTypeImage',updatedBy = '$userId', updatedDate = '$timeNow' WHERE productTypeId = '$UpdateProductTypeId'");
                            if ($ProductTypeUpdateQuery) {
                                echo json_encode(array('UpdateProductType' => 1));
                            } else {
                                echo json_encode(array('UpdateProductType' => 2));
                            }
                        }
                    } else {
                        echo json_encode(array('UpdateProductType' => 3));
                    }
                } else {
                    if (move_uploaded_file($UpdateProductTypeTempimage, $UpdateProductTypeFolder)) {
                        $ProductTypeUpdateQuery = mysqli_query($con, "UPDATE producttype SET productTypeName = '$UpdateProductTypeName',productTypeImage = '$UpdateFinalProductTypeImage',updatedBy = '$userId', updatedDate = '$timeNow' WHERE productTypeId = '$UpdateProductTypeId'");
                        if ($ProductTypeUpdateQuery) {
                            echo json_encode(array('UpdateProductType' => 1));
                        } else {
                            echo json_encode(array('UpdateProductType' => 2));
                        }
                    }
                }
            } else {
                if (move_uploaded_file($UpdateProductTypeTempimage, $UpdateProductTypeFolder)) {
                    $ProductTypeUpdateQuery = mysqli_query($con, "UPDATE producttype SET productTypeName = '$UpdateProductTypeName',productTypeImage = '$UpdateFinalProductTypeImage',updatedBy = '$userId', updatedDate = '$timeNow' WHERE productTypeId = '$UpdateProductTypeId'");
                    if ($ProductTypeUpdateQuery) {
                        echo json_encode(array('UpdateProductType' => 1));
                    } else {
                        echo json_encode(array('UpdateProductType' => 2));
                    }
                }
            }
        } else {
            $ProductTypeUpdateQuery = mysqli_query($con, "UPDATE producttype SET productTypeName = '$UpdateProductTypeName',updatedBy = '$userId', updatedDate = '$timeNow' WHERE productTypeId = '$UpdateProductTypeId'");
            if ($ProductTypeUpdateQuery) {
                echo json_encode(array('UpdateProductType' => 1));
            } else {
                echo json_encode(array('UpdateProductType' => 2));
            }
        }
    }
} else {
}


///////////////// PRODUCT TYPE ENDING  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\