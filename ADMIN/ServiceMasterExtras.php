
<?php

require "../MAIN/Dbconn.php"; 

    //Select Brands For Service
    if(isset($_POST["FindServiceBrand"])){
            
        $fetch_selectBrand = mysqli_query($con, "SELECT br_id,brand_name FROM brands");

        echo '<option value="" hidden>Select a Brand</option>';
        if(mysqli_num_rows($fetch_selectBrand) > 0){
            foreach($fetch_selectBrand as $selectBrand){
        ?> 
            <option value="<?php echo $selectBrand['br_id']; ?>"> <?php echo $selectBrand['brand_name'];?>  </option>

        <?php

            }
        }
        else{
            echo 'No Brands Found!';
        }
    }

    //Select Service
    if(isset($_POST["FindService"])){
            
        $fetch_selectService = mysqli_query($con, "SELECT sr_id,service_name FROM services");

        echo '<option value="" hidden>Select a Service</option>';
        if(mysqli_num_rows($fetch_selectService) > 0){
            foreach($fetch_selectService as $selectService){
        ?> 
            <option value="<?php echo $selectService['sr_id']; ?>"> <?php echo $selectService['service_name'];?>  </option>

        <?php

            }
        }
        else{
            echo 'No Services Found!';
        }
    }



    //Choose Series With Brands For Service
    if(isset($_POST["FindServiceSeries"])){

        $givenBrandId = $_POST["FindServiceSeries"];

        $fetch_selectSeries = mysqli_query($con, "SELECT se_id,series_name FROM series WHERE br_id = '$givenBrandId'");

        //echo '<option value="" hidden>Select a Brand</option>';
        if(mysqli_num_rows($fetch_selectSeries) > 0){
            foreach($fetch_selectSeries as $selectSeries){
        ?> 
            <option value="<?php echo $selectSeries['se_id']; ?>"> <?php echo $selectSeries['series_name'];?>  </option>

        <?php

            }
        }
        else{
            echo '<option value="" hidden>No Series Found</option>';
        }
    }


    //Choose Model With Series For Service
    if(isset($_POST["FindServiceModel"])){

        $givenSeriesId = $_POST["FindServiceModel"];

        $fetch_selectModel = mysqli_query($con, "SELECT pr_id,name FROM products WHERE series = '$givenSeriesId' AND isServiceItem = 1");

        //echo '<option value="" hidden>Select a Brand</option>';
        if(mysqli_num_rows($fetch_selectModel) > 0){
            foreach($fetch_selectModel as $selectModels){
        ?> 
            <option value="<?php echo $selectModels['pr_id']; ?>"> <?php echo $selectModels['name'];?>  </option>

        <?php

            }
        }
        else{
            echo '<option value="" hidden>No Product Found</option>';
        }
    }



    //Select Series For Edit Service
    if(isset($_POST["FindSeriesEdit"])){

        //$FindSeriesEdit = $_POST['FindSeriesEdit'];
            
        $fetch_EditSeries = mysqli_query($con, "SELECT se_id,series_name FROM series");

        //echo '<option value="" hidden>Select a Series</option>';
        if(mysqli_num_rows($fetch_EditSeries) > 0){
            foreach($fetch_EditSeries as $EditSeries){
        ?> 
            <option value="<?php echo $EditSeries['se_id']; ?>"> <?php echo $EditSeries['series_name'];?>  </option>

        <?php

            }
        }
        else{
            echo 'No Series Found!';
        }
    }

    //Select Model For Edit Service
    if(isset($_POST["FindModelEdit"])){

        //$FindSeriesEdit = $_POST['FindSeriesEdit'];
            
        $fetch_EditModel = mysqli_query($con, "SELECT mo_id,model_name FROM models");

        //echo '<option value="" hidden>Select a Series</option>';
        if(mysqli_num_rows($fetch_EditModel) > 0){
            foreach($fetch_EditModel as $EditModel){
        ?> 
            <option value="<?php echo $EditModel['mo_id']; ?>"> <?php echo $EditModel['model_name'];?>  </option>

        <?php

            }
        }
        else{
            echo 'No Series Found!';
        }
    }
?>