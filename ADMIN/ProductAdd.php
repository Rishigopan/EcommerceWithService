<?php

include_once "../MAIN/Dbconn.php";

if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

    if ($_COOKIE['custtypecookie'] == 'executive' || $_COOKIE['custtypecookie'] == 'admin') {
        echo "";
    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}

$PageTitle = 'ProductAdd';

?>




<!doctype html>
<html lang="en">


<head>



    <?php

    include "../MAIN/Header.php";


    ?>



    <style>
        .MainDivision .card {
            border: none;
            box-shadow: 1px 3px 8px lightgray;
        }

        .MainDivision .card .card-header h6 {
            font-size: 18px;
        }

        .MainDivision .card label {
            color: #474747;
            font-weight: 500;
        }

        .MainDivision .card label span {
            color: red;
            font-weight: 700;
        }

        .MainDivision .card input:focus,
        .MainDivision .card select:focus {
            border: 1px solid #474747 !important;
        }
    </style>

</head>


<body class="" style="background-color: #eeeeee;">

    <div class="wrapper">
        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5>Add Product</h5>
                </a>
                <a href="../profile.php">
                    <i class="material-icons">account_circle</i>
                </a>
            </div>
        </nav>


        <!--SIDEBAR-->
        <?php

        include '../MAIN/Sidebar.php';
        include '../MAIN/MasterPopup.php';

        ?>


        <!--CONTENT-->
        <div id="Content" class="mb-5">

            <div class="container-fluid MainDivision">


                <?php

                $FindBrands = mysqli_query($con, "SELECT br_id,brand_name FROM brands");
                $FindCategory = mysqli_query($con, "SELECT ty_id,type_name FROM types");
                $FindType = mysqli_query($con, "SELECT productTypeId,productTypeName FROM producttype");



                if (isset($_GET['PEDTID'])) {

                    $UpdateProductId = $_GET['PEDTID'];

                    $FindAllProductDetails = mysqli_query($con, "SELECT P.*, T.type_name,B.brand_name,PT.productTypeName,S.series_name,PFOR.name AS ForProductName, PFORBRAND.brand_name AS ForBrandName FROM products P LEFT JOIN types T ON P.type = T.ty_id LEFT JOIN brands B ON P.brand = B.br_id LEFT JOIN producttype PT ON P.productType = PT.productTypeId LEFT JOIN series S ON P.series = S.se_id LEFT JOIN products PFOR ON P.forProduct = PFOR.pr_id LEFT JOIN brands PFORBRAND ON PFOR.brand = PFORBRAND.br_id WHERE P.pr_id = '$UpdateProductId'");
                    foreach ($FindAllProductDetails as $FindAllProductDetailResult) {
                        $CategoryId = $FindAllProductDetailResult['type'];
                        $BrandId = $FindAllProductDetailResult['brand'];
                        $TypeId = $FindAllProductDetailResult['productType'];
                        $SeriesId = $FindAllProductDetailResult['series'];
                        $ColorId = $FindAllProductDetailResult['color'];
                    }

                ?>

                    <form id="UpdateProduct" novalidate>

                        <input type="number" name="UpdateProductParentItemId" value="<?= $FindAllProductDetailResult['parent_item_id'] ?>" class="form-control" hidden>
                        <input type="number" name="UpdateProductId" value="<?= $UpdateProductId ?>" class="form-control" hidden>

                        <div class="card mx-5">
                            <div class="card-header">
                                <h6 class="m-0">Basic Details</h6>
                            </div>
                            <div class="card-body pb-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="update_name" class="form-label">Product Name <span>*</span> </label>
                                        <input class="form-control" id="update_name" placeholder="Enter Product Name" value="<?= $FindAllProductDetailResult['name'] ?>" name="UpdateProductName" required>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="update_product_category" class="form-label">Category <span>*</span></label>
                                        <div class="input-group">
                                            <select class="form-select py-1 UpdateShowCategories" id="update_product_category" required name="UpdateProductCategory">

                                            </select>
                                            <button class="btn btn-outline-secondary" type="button" data-bs-target="#category_modal" data-bs-toggle="modal">+</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="update_product_branch" class="form-label">Brand</label>
                                        <div class="input-group">
                                            <select class="form-select py-1 ShowAllBrands" id="update_product_branch" name="UpdateProductBrand">

                                            </select>
                                            <button class="btn btn-outline-secondary" type="button" data-bs-target="#brand_modal" data-bs-toggle="modal">+</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 mt-2">
                                        <label for="update_series" class="form-label">Series</label>
                                        <div class="input-group">
                                            <select class="form-select py-1 ShowAllSeries" id="update_series" name="UpdateSeries">

                                            </select>
                                            <button class="btn btn-outline-secondary" type="button" data-bs-target="#series_modal" data-bs-toggle="modal">+</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 mt-2">
                                        <label for="update_product_type" class="form-label">Type</label>
                                        <div class="input-group">
                                            <select class="form-select UpdateShowTypes" id="update_product_type" name="UpdateProductTypeName">

                                            </select>
                                            <button class="btn btn-outline-secondary" type="button" data-bs-target="#type_modal" data-bs-toggle="modal">+</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 mt-2">
                                        <label for="update_choose_image" class="form-label">Main Image</label>
                                        <input type="file" class="form-control" id="update_choose_image" accept=".jpg" name="UpdateProductMain">
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label for="udpate_mini" class="form-label">Mini Description</label>
                                        <input class="form-control" id="udpate_mini" placeholder="Enter Mini Description" value="<?= $FindAllProductDetailResult['mini_desc'] ?>" name="UpdateProductMiniDesc">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card mx-5 mt-4">
                            <div class="card-header">
                                <h6 class="m-0">Pricing Details</h6>
                            </div>
                            <div class="card-body pb-4">
                                <div class="row">
                                    <div class="col-12 col-md-2">
                                        <label for="update_select_tax" class="form-label">Tax %</label>
                                        <select id="update_select_tax" class="form-select" name="UpdateProductTax">
                                            <option selected hidden value="<?= $FindAllProductDetailResult['tax'] ?>"><?= number_format($FindAllProductDetailResult['tax'])  ?></option>
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="12">12</option>
                                            <option value="18">18</option>
                                            <option value="28">28</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label for="update_amount" class="form-label">Selling Price <span>*</span></label>
                                        <input type="number" min="0" class="form-control" id="update_amount" placeholder="Enter Amount" value="<?= $FindAllProductDetailResult['sp'] ?>" name="UpdateProductAmount" required>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label for="update_mrp" class="form-label">MRP <span>*</span></label>
                                        <input type="number" min="0" class="form-control" id="update_mrp" placeholder="Enter MRP" value="<?= $FindAllProductDetailResult['mrp'] ?>" name="UpdateProductMrp" required>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label for="pdate_cp" class="form-label">Cost Price <span>*</span></label>
                                        <input type="number" min="0" class="form-control" id="update_cp" placeholder="Enter CP" value="<?= $FindAllProductDetailResult['cp'] ?>" name="UpdateProductCp" required>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label for="update_warranty" class="form-label">Warranty</label>
                                        <input type="number" min="0" class="form-control" id="update_warranty" placeholder="In Days" value="<?= $FindAllProductDetailResult['warranty'] ?>" name="UpdateProductWarranty">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card mx-5 mt-4">
                            <div class="card-header">
                                <h6 class="m-0">Extra Details</h6>
                            </div>
                            <div class="card-body pb-4">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <label for="update_color" class="form-label">Color</label>
                                        <div class="input-group">
                                            <select class="form-select UpdateShowColors" id="update_color" name="UpdateProductColor">

                                            </select>
                                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#color_modal">+</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="update_hsn" class="form-label">HSN code</label>
                                        <input type="text" class="form-control" id="update_hsn" placeholder="HSN code" value="<?= $FindAllProductDetailResult['hsn'] ?>" name="UpdateProductHsn">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="update_code" class="form-label">Product Code</label>
                                        <input type="text" class="form-control" id="update_code" placeholder="Code" value="<?= $FindAllProductDetailResult['pr_code'] ?>" name="UpdateProductCode">
                                    </div>
                                    <div class="col-12 mt-2 col-md-4">
                                        <label for="update_more_image" class="form-label">More Images</label>
                                        <input type="file" class="form-control" id="update_more_image" name="UpdateProductMoreImages[]" accept=".png ,.jpg" multiple>
                                    </div>

                                    <div class="col-12 mt-2 col-md-6">
                                        <label for="update_barcode" class="form-label">Barcode</label>
                                        <input type="text" class="form-control" id="update_barcode" placeholder="Barcode" value="<?= $FindAllProductDetailResult['barcode'] ?>" name="UpdateProductBarcode">
                                    </div>
                                    <div class="col-12 mt-md-5 col-md-2">
                                        <input class="form-check-input" type="checkbox" name="UpdateProductISIMEI" value="YES" id="update_imeicheck" <?= ($FindAllProductDetailResult['isimei'] == 'YES') ? "checked"  : "" ?>>
                                        <label class="form-check-label" for="update_imeicheck">
                                            Is IMEI
                                        </label>
                                    </div>
                                    <div class="col-12 mt-md-4">
                                        <div class="row">
                                            <div class="col-lg-6 col-12">
                                                <div class="bg-light rounded-3 border border-2 py-3 px-3">
                                                    <div>
                                                        <input class="form-check-input" type="checkbox" name="UpdateIsSalesItem" value="YES" id="update_sales_item_check" <?= ($FindAllProductDetailResult['isSalesItem'] == '1') ? "checked"  : "" ?>>
                                                        <label class="form-check-label" for="update_sales_item_check">
                                                            Check if this is a Sales Item
                                                        </label>
                                                    </div>

                                                    <hr>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div>
                                                                <input class="form-check-input" type="checkbox" name="UpdateIsInshopSalesItem" value="YES" id="update_inshop_sales_item_check" <?= ($FindAllProductDetailResult['isInShopSales'] == '1') ? "checked"  : "" ?>>
                                                                <label class="form-check-label" for="update_inshop_sales_item_check">
                                                                    Inshop Sales
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 text-end">
                                                            <div>
                                                                <input class="form-check-input" type="checkbox" name="UpdateIsOnlineSalesItem" value="YES" id="update_online_sales_item_check" <?= ($FindAllProductDetailResult['isOnlineSales'] == '1') ? "checked"  : "" ?>>
                                                                <label class="form-check-label" for="update_online_sales_item_check">
                                                                    Online Sales
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12 ">
                                                <div class="bg-light rounded-3 border border-2 py-3 px-3">
                                                    <div>
                                                        <input class="form-check-input" type="checkbox" name="UpdateIsServiceItem" value="YES" id="update_service_item_check" <?= ($FindAllProductDetailResult['isServiceItem'] == '1') ? "checked"  : "" ?>>
                                                        <label class="form-check-label" for="update_service_item_check">
                                                            Check if this is a Service Item
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-12 col-md-4 mt-3">
                                        <input class="form-check-input" type="checkbox" name="UpdateIsSalesItem" value="YES" id="update_sales_item_check" <?= ($FindAllProductDetailResult['isSalesItem'] == '1') ? "checked"  : "" ?>>
                                        <label class="form-check-label" for="update_sales_item_check">
                                            Check if this is a Sales Item
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-4 mt-3">
                                        <input class="form-check-input" type="checkbox" name="UpdateIsServiceItem" value="YES" id="update_service_item_check" <?= ($FindAllProductDetailResult['isServiceItem'] == '1') ? "checked"  : "" ?>>
                                        <label class="form-check-label" for="update_service_item_check">
                                            Check if this is a Service Item
                                        </label>
                                    </div> -->
                                    <div class="col-12 mt-3 col-md-12">
                                        <label for="update_desc" class="form-label ">Enter Description</label>
                                        <textarea class="form-control TinyEditor" id="update_desc" cols="10" rows="10" placeholder="Enter Description of the Product" name="UpdateProductDesc"><?= $FindAllProductDetailResult['description'] ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card mx-5 mt-4">
                            <div class="card-header">
                                <h6 class="m-0">Accessories Only</h6>
                            </div>
                            <div class="card-body pb-4">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="update_select_product_for" class="form-label">For Product</label>
                                        <!-- <select id="select_product_for" class="SelectPlugin" name="tax">
                                                <option hidden value="0">Choose a product to make this an accessory of that product</option>

                                            </select> -->

                                        <input class="form-control" type="number'" value="<?= $FindAllProductDetailResult['forProduct'] ?>" name="UpdateOldProductFor" hidden>

                                        <select class="mb-3 form-select" id="update_select_product_for" name="UpdateProductFor">
                                            <option hidden value="<?= $FindAllProductDetailResult['forProduct'] ?>"><?= ($FindAllProductDetailResult['ForProductName'] == '') ? 'Choose a product to make this an accessory of that product' : ($FindAllProductDetailResult['ForBrandName'] . ' ' . $FindAllProductDetailResult['ForProductName']) ?></option>
                                            <?php

                                            $FindAllProducts = mysqli_query($con, "SELECT P.pr_id,P.name,B.brand_name FROM products P INNER JOIN brands B ON P.brand = B.br_id WHERE P.pr_id = P.parent_item_id AND P.pr_id <> '$UpdateProductId'");
                                            foreach ($FindAllProducts as $FindAllProductsResults) {
                                                echo '<option value="' . $FindAllProductsResults["pr_id"] . '">' . $FindAllProductsResults["brand_name"] . ' ' . $FindAllProductsResults["name"] . '</option>';
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="mx-5 mt-4 mb-5">
                            <div class="col-12 mt-3 text-center">
                                <button class="btn btn_submit rounded-pill py-2 px-4" type="submit">Update Product</button>
                            </div>
                        </div>


                    </form>

                <?php

                } else {

                    $UpdateProductId = 0;
                    $CategoryId = 0;
                    $BrandId = 0;
                    $TypeId = 0;
                    $SeriesId = 0;
                    $ColorId = 0;

                ?>

                    <div class="">

                        <form id="Add_Product" novalidate>

                            <div class="card mx-5">
                                <div class="card-header">
                                    <h6 class="m-0">Basic Details</h6>
                                </div>
                                <div class="card-body pb-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="Add_Name" class="form-label">Product Name <span>*</span> </label>
                                            <input class="form-control" id="Add_Name" placeholder="Enter Product Name" name="product" required>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="SelectType" class="form-label">Category <span>*</span></label>
                                            <div class="input-group">
                                                <select class="form-select py-1 SelectCategory" id="SelectType" required name="type">
                                                </select>
                                                <button class="btn btn-outline-secondary m-0" type="button" data-bs-target="#category_modal" data-bs-toggle="modal"> <i class="ri-add-line"></i> </button>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="SelectBrand" class="form-label">Brand</label>
                                            <div class="input-group">
                                                <select class="form-select py-1 SelectBrand" id="SelectBrand" name="brand">
                                                </select>
                                                <button class="btn btn-outline-secondary" type="button" data-bs-target="#brand_modal" data-bs-toggle="modal"><i class="ri-add-line"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 mt-2">
                                            <label for="SelectSeries" class="form-label">Series</label>
                                            <div class="input-group">
                                                <select class="form-select py-1 SelectSeries" id="SelectSeries" name="series">
                                                    <option value="0">Select a Series</option>
                                                </select>
                                                <button class="btn btn-outline-secondary" type="button" data-bs-target="#series_modal" data-bs-toggle="modal"><i class="ri-add-line"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 mt-2">
                                            <label for="SelectProductType" class="form-label">Type</label>
                                            <div class="input-group">
                                                <select class="form-select SelectProductType" id="SelectProductType" name="ProductType">
                                                </select>
                                                <button class="btn btn-outline-secondary" type="button" data-bs-target="#type_modal" data-bs-toggle="modal"><i class="ri-add-line"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 mt-2">
                                            <label for="choose_image" class="form-label">Main Image</label>
                                            <input type="file" class="form-control" id="choose_image" accept=".jpg" name="main_image">
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label for="Add_Name" class="form-label">Mini Description</label>
                                            <input class="form-control" id="Add_mini" placeholder="Enter Mini Description" name="mini_desc">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card mx-5 mt-4">
                                <div class="card-header">
                                    <h6 class="m-0">Pricing Details</h6>
                                </div>
                                <div class="card-body pb-4">
                                    <div class="row">
                                        <div class="col-12 col-md-2">
                                            <label for="select_tax" class="form-label">Tax %</label>
                                            <select id="select_tax" class="form-select" name="tax">
                                                <option value="">Select Tax</option>
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="12">12</option>
                                                <option value="18">18</option>
                                                <option value="28">28</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <label for="Add_amount" class="form-label">Selling Price <span>*</span></label>
                                            <input type="number" min="0" class="form-control" id="Add_amount" placeholder="Enter Amount" name="price" required>
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <label for="Add_mrp" class="form-label">MRP<span>*</span></label>
                                            <input type="number" min="0" class="form-control" id="Add_mrp" placeholder="Enter MRP" name="mrp" required>
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <label for="Add_cp" class="form-label">Cost Price <span>*</span></label>
                                            <input type="number" min="0" class="form-control" id="Add_cp" placeholder="Enter CP" name="cp" required>
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <label for="Add_warranty" class="form-label">Warranty</label>
                                            <input type="number" min="0" class="form-control" id="Add_warranty" placeholder="In Days" name="warranty">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card mx-5 mt-4">
                                <div class="card-header">
                                    <h6 class="m-0">Extra Details</h6>
                                </div>
                                <div class="card-body pb-4">
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <label for="add_color" class="form-label">Color</label>
                                            <div class="input-group">
                                                <select class="form-select py-1 SelectColor" id="select_color" name="AddProductColor">
                                                </select>
                                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#color_modal"><i class="ri-add-line"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="Add_hsn" class="form-label">HSN code</label>
                                            <input type="text" class="form-control" id="Add_hsn" placeholder="HSN code" name="hsn">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="Add_code" class="form-label">Product Code</label>
                                            <input type="text" class="form-control" id="Add_code" placeholder="Code" name="code">
                                        </div>
                                        <div class="col-12 mt-2 col-md-4">
                                            <label for="more_image" class="form-label">More Images</label>
                                            <input type="file" class="form-control" id="more_image" name="multi_image[]" accept=".png ,.jpg" multiple>
                                        </div>

                                        <div class="col-12 mt-2 col-md-6">
                                            <label for="Add_barcode" class="form-label">Barcode</label>
                                            <input type="text" class="form-control" id="Add_barcode" placeholder="Barcode" name="barcode">
                                        </div>
                                        <div class="col-12 mt-md-5 col-md-2">
                                            <input class="form-check-input" type="checkbox" name="Isimei" value="YES" id="imeicheck">
                                            <label class="form-check-label" for="imeicheck">
                                                Is IMEI
                                            </label>
                                        </div>
                                        <div class="col-12 mt-md-4">
                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="bg-light rounded-3 border border-2 py-3 px-3">
                                                        <div>
                                                            <input class="form-check-input" type="checkbox" name="IsSalesItem" value="YES" id="sales_item_check">
                                                            <label class="form-check-label" for="sales_item_check">
                                                                Check if this is a Sales Item
                                                            </label>
                                                        </div>

                                                        <hr>

                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div>
                                                                    <input class="form-check-input" type="checkbox" name="IsInshopSalesItem" value="YES" id="inshop_sales_item_check">
                                                                    <label class="form-check-label" for="inshop_sales_item_check">
                                                                        Inshop Sales
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 text-end">
                                                                <div>
                                                                    <input class="form-check-input" type="checkbox" name="OnlineSalesItem" value="YES" id="online_sales_item_check">
                                                                    <label class="form-check-label" for="online_sales_item_check">
                                                                        Online Sales
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12 ">
                                                    <div class="bg-light rounded-3 border border-2 py-3 px-3">
                                                        <div>
                                                            <input class="form-check-input" type="checkbox" name="IsServiceItem" value="YES" id="service_item_check">
                                                            <label class="form-check-label" for="service_item_check">
                                                                Check if this is a Service Item
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3 col-md-12">
                                            <label for="Add_desc" class="form-label">Enter Description</label>
                                            <textarea class="form-control TinyEditor" id="Add_desc" cols="10" rows="10" placeholder="Enter Description of the Product" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card mx-5 mt-4">
                                <div class="card-header">
                                    <h6 class="m-0">Accessories Only</h6>
                                </div>
                                <div class="card-body pb-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="select_product_for" class="form-label">For Product</label>
                                            <!-- <select id="select_product_for" class="SelectPlugin" name="tax">
                                                <option hidden value="0">Choose a product to make this an accessory of that product</option>

                                            </select> -->

                                            <select class="mb-3 form-select ShowProducts" id="select_product_for" name="ProductFor">
                                                <option hidden value="0">Choose a product to make this an accessory of that product</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="mx-5 mt-4 mb-5">
                                <div class="col-12 mt-3 text-center">
                                    <button class="btn btn_submit rounded-pill py-2 px-4" type="submit">Add Product</button>
                                </div>
                            </div>

                        </form>

                    </div>

                <?php

                }

                ?>


            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>

    <script src="../JS/product.js"></script>

    <script src="../JS/AddMasters.js"></script>



    <script>
        RefreshProducts();


        tinymce.init({
            selector: '.TinyEditor',
            plugins: 'charmap emoticons link lists searchreplace table wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link table | addcomment showcomments | spellcheckdialog | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            // tinycomments_mode: 'embedded',
            //tinycomments_author: 'Author name',
        });


        function RefreshProducts() {
            var ListAllProducts = 'fetch_data';
            $.ajax({
                method: "POST",
                url: "ProductExtras.php",
                data: {
                    ListAllProducts: ListAllProducts
                },
                success: function(data) {
                    $('.ShowProducts').html(data);
                }
            });
        }



        var UpdateProductId = '<?= $UpdateProductId ?>';

        function SetOptionValue(ElementID, Value) {
            $(ElementID).val(Value).change();
        }

        if (UpdateProductId != 0) {

            var CategoryId = '<?= $CategoryId ?>';
            var BrandId = '<?= $BrandId ?>';
            var TypeId = '<?= $TypeId ?>';
            var SeriesId = '<?= $SeriesId ?>';
            var ColorId = '<?= $ColorId ?>';

            UpdateShowBrands(BrandId, SeriesId);

            ShowItemsInDropdown('UpdateShowTypes', 'ProductExtras', 'productTypeId', 'productTypeName', 'Type', 'producttype', 'NO', TypeId);

            ShowItemsInDropdown('UpdateShowCategories', 'ProductExtras', 'ty_id', 'type_name', 'Category', 'types', 'NO', CategoryId);

            ShowItemsInDropdown('UpdateShowColors', 'ProductExtras', 'colorId', 'colorName', 'Color', 'color', 'NO', ColorId);

            function UpdateShowBrands(SelectedValue, SeriesValue) {
                var ShowBrandsData = 'fetch_data';
                $.ajax({
                    method: "POST",
                    url: "ProductExtras.php",
                    data: {
                        ShowBrands: ShowBrandsData
                    },
                    success: function(data) {
                        //console.log(data);
                        $('.ShowAllBrands').html(data);
                        SetOptionValue("#update_product_branch", SelectedValue);
                        $.ajax({
                            method: "POST",
                            url: "ProductExtras.php",
                            data: {
                                ShowSeriesByBrand: SelectedValue
                            },
                            success: function(data) {
                                console.log(data);
                                $('.ShowAllSeries').html(data);
                                SetOptionValue("#update_series", SeriesValue);
                            }
                        });
                    }
                });
            }

            $(document).on('click', '.ShowAllBrands', function() {
                $(document).on('change', '.ShowAllBrands', function() {
                    var SelectedValue = $(this).val();
                    $.ajax({
                        method: "POST",
                        url: "ProductExtras.php",
                        data: {
                            ShowSeriesByBrand: SelectedValue
                        },
                        success: function(data) {
                            //console.log(data);
                            $('.ShowAllSeries').html(data);
                        }
                    });
                });
            });

        } else {
            //Show all Category
            ShowItemsInDropdown('SelectCategory', 'ProductExtras', 'ty_id', 'type_name', 'Category', 'types', 'NO');

            //Show all Brand
            ShowItemsInDropdown('SelectBrand', 'ProductExtras', 'br_id', 'brand_name', 'Brand', 'brands', 'NO');

            //Show all Color
            ShowItemsInDropdown('SelectColor', 'ProductExtras', 'colorId', 'colorName', 'Color', 'color', 'NO');

            //Show all Product Type
            ShowItemsInDropdown('SelectProductType', 'ProductExtras', 'productTypeId', 'productTypeName', 'Type', 'producttype', 'NO');


            //Show series on brand select
            $('#SelectBrand').change(function() {
                var BrandId = $(this).val();
                $.ajax({
                    method: "POST",
                    url: "ProductExtras.php",
                    data: {
                        ShowSeriesOnBrand: BrandId
                    },
                    success: function(data) {
                        console.log(data);
                        $('#SelectSeries').html(data);
                    }
                });
            });


            //Update Show series on brand select
            $('#update_product_brand').change(function() {
                var BrandId = $(this).val();
                $.ajax({
                    method: "POST",
                    url: "ProductExtras.php",
                    data: {
                        ShowSeriesOnBrand: BrandId
                    },
                    success: function(data) {
                        console.log(data);
                        $('#update_series').html(data);
                    }
                });
            });

        }

        //////////////////////////////  PRODUCT MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


        //Update  Product
        $(function() {

            let validator = $('#UpdateProduct').jbvalidator({
                //language: 'dist/lang/en.json',
                successClass: false,
                html5BrowserDefault: true
            });

            validator.validator.custom = function(el, event) {
                if ($(el).is('#update_Name,#update_mrp,#update_amount') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#UpdateProduct', (function(a) {
                a.preventDefault();
                var UpdateProductData = new FormData(this);
                //console.log(ProductData);
                $.ajax({
                    type: "POST",
                    url: "ProductMasterOperations.php",
                    data: UpdateProductData,
                    success: function(data) {
                        console.log(data);
                        var UpdateProductResponse = JSON.parse(data);
                        if (UpdateProductResponse.UpdateProduct == "1") {
                            toastr.success("Success Updating  Product");
                            $('#UpdateProduct')[0].reset();
                            RefreshProducts();
                            location.replace('./ProductView.php');
                        } else if (UpdateProductResponse.UpdateProduct == "0") {
                            toastr.warning("Cannot Add a Product That is Already Present");
                        } else if (UpdateProductResponse.UpdateProduct == "2") {
                            toastr.error("Error While Updating Product");
                        } else if (UpdateProductResponse.UpdateProduct == "5") {
                            toastr.warning("Barcode Already in use");
                        } else {
                            toastr.error("Error While Updating Product");
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }));

        });


        //add  product
        $(function() {

            let validator = $('#Add_Product').jbvalidator({
                //language: 'dist/lang/en.json',
                successClass: false,
                html5BrowserDefault: true
            });

            validator.validator.custom = function(el, event) {
                if ($(el).is('#Add_Name,#Add_mrp,#Add_amount') && $(el).val().trim().length == 0) {
                    return 'Cannot be empty';
                }
            }

            $(document).on('submit', '#Add_Product', (function(a) {
                a.preventDefault();
                var ProductData = new FormData(this);
                //console.log(ProductData);
                $.ajax({
                    type: "POST",
                    url: "ProductMasterOperations.php",
                    data: ProductData,
                    success: function(data) {
                        console.log(data);
                        var ProductResponse = JSON.parse(data);
                        if (ProductResponse.addProduct == "1") {
                            toastr.success("Success Adding a New Product");
                            $('#Add_Product')[0].reset();
                            RefreshProducts();
                        } else if (ProductResponse.addProduct == "0") {
                            toastr.warning("Cannot Add a Product That is Already Present");
                        } else if (ProductResponse.addProduct == "2") {
                            toastr.error("Error While Adding New Product");
                        } else if (ProductResponse.addProduct == "5") {
                            toastr.warning("Barcode already is in use");
                        } else {
                            toastr.error("Error While Adding New Product");
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }));

        });



        //////////////////////////////  PRODUCT MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\




        const SeriesModal = document.getElementById('series_modal')
        SeriesModal.addEventListener('shown.bs.modal', event => {
            ShowItemsInDropdown('SelectBrandPopup', 'ProductExtras', 'br_id', 'brand_name', 'Brand', 'brands', 'NO');
        });
    </script>






    <?php
    include "../MAIN/Footer.php";
    ?>



</body>

</html>