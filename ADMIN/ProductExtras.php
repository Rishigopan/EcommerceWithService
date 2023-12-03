<?php

require "../MAIN/Dbconn.php";

//Select Category
if (isset($_POST["selectType"])) {

    $fetch_selectType = mysqli_query($con, "SELECT ty_id,type_name FROM types");

    echo '<option value="0" hidden>Select a Category</option>';
    if (mysqli_num_rows($fetch_selectType) > 0) {
        foreach ($fetch_selectType as $selectType) {
?>
            <option value="<?php echo $selectType['ty_id']; ?>"> <?php echo  $selectType['type_name']; ?> </option>

        <?php

        }
    } else {
        echo '';
    }
}



//Select Brand
if (isset($_POST["selectBrand"])) {


    $fetch_selectBrand = mysqli_query($con, "SELECT br_id,brand_name FROM brands");

    echo '<option value="0" hidden>Select a Brand</option>';
    if (mysqli_num_rows($fetch_selectBrand) > 0) {
        foreach ($fetch_selectBrand as $selectBrand) {
        ?>
            <option value="<?php echo $selectBrand['br_id']; ?>"> <?php echo $selectBrand['brand_name']; ?> </option>

        <?php

        }
    } else {
        echo '<option value="0" hidden>Select a Brand</option>';
    }
}



//Select Product Type
if (isset($_POST["selectProductType"])) {


    $fetch_selectProductType = mysqli_query($con, "SELECT productTypeId,productTypeName FROM producttype");

    echo '<option value="0" hidden>Select a Type</option>';
    if (mysqli_num_rows($fetch_selectProductType) > 0) {
        foreach ($fetch_selectProductType as $selectProductType) {
        ?>
            <option value="<?php echo $selectProductType['productTypeId']; ?>"> <?php echo $selectProductType['productTypeName']; ?> </option>

        <?php

        }
    } else {
        echo '<option value="" hidden>Select a Type</option>';
    }
}


//Select Series on Brand Selection
if (isset($_POST["ShowSeriesOnBrand"])) {


    $BrandId = $_POST['ShowSeriesOnBrand'];

    $FetchSeries = mysqli_query($con, "SELECT se_id,series_name FROM series WHERE br_id = '$BrandId'");

    echo '<option value="0" hidden>Select a Series</option>';
    if (mysqli_num_rows($FetchSeries) > 0) {
        foreach ($FetchSeries as $FetchSeriesResult) {
        ?>
            <option value="<?php echo $FetchSeriesResult['se_id']; ?>"> <?php echo $FetchSeriesResult['series_name']; ?> </option>

        <?php

        }
    } else {
        echo '<option value="0">Select a Series</option>';
    }
}


//Select Model on Series Selection
if (isset($_POST["ShowModelOnSeries"])) {


    $SeriesId = $_POST['ShowModelOnSeries'];

    $FetchModel = mysqli_query($con, "SELECT mo_id,model_name FROM models WHERE se_id = '$SeriesId'");

    echo '<option value="0" hidden>Select a Model</option>';
    if (mysqli_num_rows($FetchModel) > 0) {
        foreach ($FetchModel as $FetchModelResult) {
        ?>
            <option value="<?php echo $FetchModelResult['mo_id']; ?>"> <?php echo $FetchModelResult['model_name']; ?> </option>

<?php

        }
    } else {
        echo '<option value="0">Select a Model</option>';
    }
}



//Show all Categories
if (isset($_POST['ShowCategories'])) {
    $fetch_selectCategories = mysqli_query($con, "SELECT ty_id,type_name FROM types");
    echo '<option value="0" hidden>Select a Category</option>';
    if (mysqli_num_rows($fetch_selectCategories) > 0) {
        foreach ($fetch_selectCategories as $selectCategories) {
            echo '<option value="' . $selectCategories['ty_id'] . '">' . $selectCategories['type_name'] . '</option>';
        }
    } else {
        echo '<option value="0" hidden>Select a Category</option>';
    }
}


//Show all Brands
if (isset($_POST['ShowBrands'])) {
    $fetch_selectBrands = mysqli_query($con, "SELECT br_id,brand_name FROM brands");
    echo '<option value="0" hidden>Select a Brand</option>';
    if (mysqli_num_rows($fetch_selectBrands) > 0) {
        foreach ($fetch_selectBrands as $selectBrands) {
            echo '<option value="' . $selectBrands['br_id'] . '">' . $selectBrands['brand_name'] . '</option>';
        }
    } else {
        echo '<option value="0" hidden>Select a Brand</option>';
    }
}


//Show all Types
if (isset($_POST['ShowTypes'])) {
    $fetch_selectTypes = mysqli_query($con, "SELECT productTypeId,productTypeName FROM producttype");
    echo '<option value="0" hidden>Select a Type</option>';
    if (mysqli_num_rows($fetch_selectTypes) > 0) {
        foreach ($fetch_selectTypes as $selectTypes) {
            echo '<option value="' . $selectTypes['productTypeId'] . '">' . $selectTypes['productTypeName'] . '</option>';
        }
    } else {
        echo '<option value="0" hidden>Select a Type</option>';
    }
}






//Show all Series By Brand
if (isset($_POST['ShowSeriesByBrand'])) {
    $BrandId = $_POST['ShowSeriesByBrand'];
    $fetch_selectSeries = mysqli_query($con, "SELECT se_id,series_name FROM series WHERE br_id = '$BrandId'");
    echo '<option value="0" hidden>Select a Series</option>';
    if (mysqli_num_rows($fetch_selectSeries) > 0) {
        foreach ($fetch_selectSeries as $selectSeries) {
            echo '<option value="' . $selectSeries['se_id'] . '">' . $selectSeries['series_name'] . '</option>';
        }
    } else {
        echo '<option value="0" hidden>Select a Series</option>';
    }
}



//Show all Dropdowns
if (isset($_POST['ShowDataInDropDown'])) {
    $OptionValue = $_POST['OptionValue'];
    $OptionName = $_POST['OptionName'];
    $ColumnName = $_POST['ColumnName'];
    $DefaultName = $_POST['DefaultName'];
    $FetchItems = mysqli_query($con, "SELECT $OptionValue,$OptionName FROM $ColumnName");
    echo '<option value="0" hidden>Select a ' . $DefaultName . '</option>';
    if (mysqli_num_rows($FetchItems) > 0) {
        foreach ($FetchItems as $FetchItemsResult) {
            echo '<option value="' . $FetchItemsResult['' . $OptionValue . ''] . '">' . $FetchItemsResult['' . $OptionName . ''] . '</option>';
        }
    } else {
        echo '<option value="0" hidden>Select a ' . $DefaultName . '</option>';
    }
}


//Show Depended Dropdown
if (isset($_POST['DependedDropDownSingle'])) {
    $OptionValue = $_POST['OptionValue'];
    $OptionName = $_POST['OptionName'];
    $ColumnName = $_POST['ColumnName'];
    $DefaultName = $_POST['DefaultName'];
    $WhereColumn = $_POST['WhereColumn'];
    $WhereColumnValue = $_POST['WhereColumnValue'];
    $FetchItems = mysqli_query($con, "SELECT $OptionValue,$OptionName FROM $ColumnName WHERE $WhereColumn = '$WhereColumnValue'");
    echo '<option value="0" hidden>Select a ' . $DefaultName . '</option>';
    if (mysqli_num_rows($FetchItems) > 0) {
        foreach ($FetchItems as $FetchItemsResult) {
            echo '<option value="' . $FetchItemsResult['' . $OptionValue . ''] . '">' . $FetchItemsResult['' . $OptionName . ''] . '</option>';
        }
    } else {
        echo '<option value="0" hidden>Select a ' . $DefaultName . '</option>';
    }
}


if (isset($_POST['ListAllProducts'])) {

    echo '<option hidden value="0">Choose a product to make this an accessory of that product</option>';
    $FindAllProducts = mysqli_query($con, "SELECT P.pr_id,P.name,B.brand_name FROM products P INNER JOIN brands B ON P.brand = B.br_id WHERE P.pr_id = P.parent_item_id");
    if(mysqli_num_rows($FindAllProducts) > 0){
        foreach ($FindAllProducts as $FindAllProductsResults) {
            echo '<option value="' . $FindAllProductsResults["pr_id"] . '">' . $FindAllProductsResults["brand_name"] . ' ' . $FindAllProductsResults["name"] . '</option>';
        }
    }else{
        echo '<option hidden value="0">Choose a product to make this an accessory of that product</option>';
    }
    
}



?>