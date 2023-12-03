<?php
require "../MAIN/Dbconn.php"; 


if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

    if ($_COOKIE['custtypecookie'] == 'executive' || $_COOKIE['custtypecookie'] == 'admin') {
        echo "";
    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}
$PageTitle = 'Master';

?>

<!doctype html>
<html lang="en">

<head>

    <?php

    require "../MAIN/Header.php";

    ?>



</head>

<body>

    <div class="wrapper">
        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top ">
            <div class="container-fluid">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5> Add Masters</h5>
                </a>
                <a href="../profile.php">
                    <i class="material-icons">account_circle</i>
                </a>
            </div>
        </nav>


        <!--SIDEBAR-->
        <?php

        include '../MAIN/Sidebar.php';

        ?>


        <!--CONTENT-->
        <div id="Content">


            <div class="container-fluid">

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Category</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Brand</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Series</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-disabled-tab" data-bs-toggle="pill" data-bs-target="#pills-disabled" type="button" role="tab" aria-controls="pills-disabled" aria-selected="false">Model</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <!--category master -->
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                        <div class="container-fluid px-5 masters">
                            <div class="row gx-5">
                                <div class="col-lg-5">
                                    <div class="card card-body px-5 py-4">
                                        <form id="AddCategory" action="" method="">
                                            <div class="row">
                                                <div class="col-12 ">
                                                    <label for="type_name" class="form-label">Category Name</label>
                                                    <input type="text" class="form-control" id="category_name" name="CategoryName" placeholder="Enter Category Name">
                                                </div>
                                                <div class="col-12 mt-3 text-center">
                                                    <button class="btn btn_submit rounded-pill shadow-none" id="type_btn" type="submit" name="types">Add Category</button>
                                                </div>
                                            </div>
                                        </form>

                                        <form id="UpdateCategory" action="" method="" style="display: none;">
                                            <div class="row">
                                                <div class="col-12 ">
                                                    <label for="type_name" class="form-label">Category Name</label>
                                                    <input type="text" id="edit_type_id" name="updateTypeId" hidden>
                                                    <input type="text" class="form-control" id="edit_type_name" name="editTypeName" placeholder="Enter Type Name">
                                                </div>
                                                <div class="col-12 mt-3 text-center">
                                                    <button class="btn btn_submit rounded-pill shadow-none" id="type_btn" type="submit" name="types">Update Category</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="card card-body px-0">
                                        <div class="table-responsive">
                                            <table class="table table-borderless" id="typeTable" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Id</th>
                                                        <th class="text-center">Category Name</th>
                                                        <th class="text-center">Edit</th>
                                                        <th class="text-center">Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
 
                    <!--brand master-->
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                        <div class="container-fluid px-5 masters">
                            <div class="row gx-5">
                                <div class="col-lg-5">
                                    <div class="card card-body px-5 py-4">
                                        <form id="AddBrand" action="" method="">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="add_brand_name" class="form-label">Brand Name</label>
                                                    <input type="text" class="form-control" name="BrandName" id="add_brand_name" placeholder="Enter a Brand Name">
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label for="add_brand_image" class="form-label">Add a Brand Logo</label>
                                                    <input type="file" class="form-control" name="BrandImage" id="add_brand_image">
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <input type="checkbox" id="add_brand_sales" class="form-check-input" name="AddBrandSale" value="YES">
                                                    <label for="add_brand_sales" class="form-label">Sales</label>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <input type="checkbox" id="add_brand_service" class="form-check-input" name="AddBrandService" value="YES">
                                                    <label for="add_brand_service" class="form-label">Service</label>
                                                </div>
                                                <div class="col-12 mt-3 text-center">
                                                    <button class="btn btn_submit rounded-pill shadow-none" id="brand_btn" type="submit" name="brands">Add Brand</button>
                                                </div>

                                                
                                            </div>
                                        </form>
                                        <form id="edit_brand" action="" method="" style="display: none;">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="edit_brandName" class="form-label">Brand Name</label>
                                                    <input type="text" name="UpdateBrandId" id="UpdateBrandId" hidden>
                                                    <input type="text" class="form-control" name="editbrand_name" id="edit_brandName" placeholder="Enter a Brand Name">
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label for="edit_brand_image" class="form-label">Add a Brand Logo</label>
                                                    <input type="file" class="form-control" name="edit_brand_image" id="edit_brand_image">
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <input type="checkbox" id="update_brand_sales" class="form-check-input" name="UpdateBrandSale" value="YES">
                                                    <label for="update_brand_sales" class="form-label">Sales</label>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <input type="checkbox" id="update_brand_service" class="form-check-input" name="UpdateBrandService" value="YES">
                                                    <label for="update_brand_service" class="form-label">Service</label>
                                                </div>
                                                <div class="col-12 mt-3 text-center">
                                                    <button class="btn btn_submit rounded-pill shadow-none" id="brand_btn" type="submit" name="brands">Update Brand</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-lg-7">
                                    <div class="card card-body px-0">
                                        <div class="table-responsive">
                                            <table class="table table-borderless" id="brandTable" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Id</th>
                                                        <th class="text-center">Brand Logo</th>
                                                        <th class="text-center">Brand Name</th>
                                                        <th class="text-center">Is Sales</th>
                                                        <th class="text-center">Is Service</th>
                                                        <th class="text-center">Edit</th>
                                                        <th class="text-center">Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <!--series master -->
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">

                        <div class="container-fluid px-5 masters">
                            <div class="row gx-5">
                                <div class="col-lg-5">
                                    <div class="card card-body px-5 py-4">
                                        <form id="add_series" method="" novalidate>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="select_brand" class="form-label">Select Brand</label>
                                                    <select class="form-select brand_update_options" id="select_brand" name="brandSelect" required>

                                                    </select>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label for="series_name" class="form-label">Series Name</label>
                                                    <input type="text" class="form-control" id="series_name" name="seriesName" placeholder="Enter a Series Name">
                                                </div>
                                                <div class="col-12 mt-3 text-center">
                                                    <button class="btn btn_submit rounded-pill shadow-none" type="submit">Add Series</button>
                                                </div>
                                            </div>
                                        </form>

                                        <form id="edit_series" method="" style="display: none;" novalidate>
                                            <div class="row">
                                                <div class="col-12 ">
                                                    <label for="brandSelectSeries" class="form-label">Select Brand</label>
                                                    <input type="text" id="UpdateSeriesId" name="updateSeriesId" hidden>
                                                    <select class="form-select brand_update_options" id="brandSelectSeries" name="brandSelectSeries" required>

                                                    </select>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label for="editSeriesName" class="form-label">Series Name</label>
                                                    <input type="text" class="form-control" id="editSeriesName" name="editSeriesName" placeholder="Enter a Series Name">
                                                </div>
                                                <div class="col-12 mt-3 text-center">
                                                    <button class="btn btn_submit rounded-pill shadow-none" id="type_btn" type="submit" name="series">Update Series</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                                <div class="col-lg-7">
                                    <div class="card card-body px-0 ">
                                        <div class="table-responsive">
                                            <table class="table table-borderless" id="SeriesTable" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Sl No.</th>
                                                        <th class="text-center">Brand</th>
                                                        <th class="text-center">Series</th>
                                                        <th class="text-center">Edit</th>
                                                        <th class="text-center">Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>


                    <!--model master -->
                    <div class="tab-pane fade" id="pills-disabled" role="tabpanel" aria-labelledby="pills-disabled-tab" tabindex="0">

                        <div class="container-fluid px-5 masters">
                            <div class="row gx-5">
                                <div class="col-lg-5">
                                    <div class="card card-body px-5 py-4">
                                        <form id="add_model" action="" method="" enctype="" novalidate>
                                            <div class="row">
                                                <div class="col-12 ">
                                                    <label for="select_brand_m" class="form-label">Select Brand</label>
                                                    <select class="form-select brand_update_options select_ModelBrand" id="select_brand_m" name="brand_select_m" required>

                                                    </select>
                                                </div>
                                                <div class="col-12 ">
                                                    <label for="select_series_m" class="form-label">Select Series</label>
                                                    <select class="form-select series_update_options" id="select_series_m" name="series_select_m" required>
                                                        <option value="" hidden>Select a Series</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label for="add_model" class="form-label">Model Name</label>
                                                    <input type="text" class="form-control" id="add_model" name="model_name" placeholder="Enter a Model Name" required>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label for="add_model_image" class="form-label">Add Model image</label>
                                                    <input type="file" class="form-control" id="add_model_image" name="model_image">
                                                </div>
                                                <div class="col-12 mt-3 text-center">
                                                    <button class="btn btn_submit shadow-none rounded-pill" type="submit" name="models">Add Model</button>
                                                </div>
                                            </div>
                                        </form>

                                        <form id="edit_modelForm" action="" method="" enctype="" style="display:none;" novalidate>
                                            <div class="row">
                                                <div class="col-12 ">
                                                    <label for="update_brand_m" class="form-label">Select Brand</label>
                                                    <input type="text" id="EditModelId" name="edit_modelId" hidden>
                                                    <select class="form-select brand_update_options select_ModelBrand" id="update_brand_m" name="brand_update_m" required>

                                                    </select>
                                                </div>
                                                <div class="col-12 ">
                                                    <label for="update_series_m" class="form-label">Select Series</label>
                                                    <select class="form-select series_update_options" id="update_series_m" name="series_update_m" required>
                                                        <option hidden>Select a Series</option>

                                                    </select>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label for="edit_model_name" class="form-label">Model Name</label>
                                                    <input type="text" class="form-control" id="edit_model_name" name="edit_model_name" placeholder="Enter a Model Name" required>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label for="edit_model_image" class="form-label">Add Model image</label>
                                                    <input type="file" class="form-control" id="edit_model_image" name="edit_model_image">
                                                </div>
                                                <div class="col-12 mt-3 text-center">
                                                    <button class="btn btn_submit shadow-none rounded-pill" type="submit">Update Model</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-lg-7">
                                    <div class="card card-body px-0 ">
                                        <div class="table-responsive">
                                            <table class="table table-borderless" id="ModelTable" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Sl No.</th>
                                                        <th class="text-center">Image</th>
                                                        <th class="text-center">Brand</th>
                                                        <th class="text-center">Series</th>
                                                        <th class="text-center">Model</th>
                                                        <th class="text-center">Edit</th>
                                                        <th class="text-center">Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>

    <script src="../JS/masters.js?ver=1.0"></script>

    <script>
        $(document).ready(function() {


            get_brand_select();


            //Show series on brand select
            $('.select_ModelBrand').change(function() {
                var Brand_model_id = $(this).val();
                get_series_select(Brand_model_id);
            });


            //////////////////////////////   CATEGORY MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

                var itemTable = $('#typeTable').DataTable({
                    "processing": true,
                    "ajax": "TypeData.php",
                    //"responsive": true,
                    "fixedHeader": true,
                    "dom": '<"top"fl>rt<"bottom"ip>',
                    //"select":true,

                    "columns": [{
                            data: 'ty_id',
                        },
                        {
                            data: 'type_name',
                        },
                        {
                            data: 'ty_id',
                            render: function(data, type, row, meta) {
                                if (type == 'display') {
                                    data = '<button class="edit_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                                }
                                return data;
                            }
                        },
                        {
                            data: 'ty_id',
                            render: function(data, type, row, meta) {
                                if (type == 'display') {
                                    data = '<button class="delete_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">delete</i> </button>';
                                }
                                return data;
                            }
                        }

                    ]


                });

                //Add Category
                $(function() {

                    let validator = $('#AddCategory').jbvalidator({
                        language: 'dist/lang/en.json',
                        successClass: false,
                        html5BrowserDefault: true
                    });

                    validator.validator.custom = function(el, event) {
                        if ($(el).is('#category_name') && $(el).val().trim().length == 0) {
                            return 'Cannot be empty';
                        }
                    }

                    $(document).on('submit', '#AddCategory', (function(a) {
                        a.preventDefault();
                        var CategoryData = new FormData(this);
                        //console.log(CategoryData);
                        $.ajax({
                            type: "POST",
                            url: "MasterOperations.php",
                            data: CategoryData,
                            beforeSend: function () {

                            },
                            success: function(data) {
                                //console.log(data);
                                var response = JSON.parse(data);
                                if (response.Status == "1") {
                                    swal("Success", response.Message, "success");
                                    $('#AddCategory')[0].reset();
                                    itemTable.ajax.reload(null,false);
                                } else if (response.Status == "0") {
                                    swal("Warning", response.Message, "warning");
                                } else if (response.Status == "2") {
                                    swal("Error", response.Message, "error");
                                } else {
                                    swal("Some Error Occured!!!", "Please Try Again", "error");
                                }
                            },
                            error: function () {
                                swal(
                                    "Some Error Occured!!!",
                                    "Please Refresh The Page...",
                                    "error"
                                );
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }));

                });

                //Update Category
                $(function() {

                    let validator = $('#edit_type').jbvalidator({
                        language: 'dist/lang/en.json',
                        successClass: false,
                        html5BrowserDefault: true
                    });

                    validator.validator.custom = function(el, event) {
                        if ($(el).is('#edit_type_name') && $(el).val().trim().length == 0) {
                            return 'Cannot be empty';
                        }
                    }

                    $(document).on('submit', '#edit_type', (function(a) {
                        a.preventDefault();
                        var updateTypeData = new FormData(this);
                        //console.log(updateTypeData);
                        $.ajax({
                            type: "POST",
                            url: "MasterOperations.php",
                            data: updateTypeData,
                            success: function(data) {
                                //console.log(data);
                                var updateTypeResponse = JSON.parse(data);
                                //console.log(updateTypeResponse);
                                if (updateTypeResponse.updateType == "1") {
                                    toastr.success("Successfully Updated Type");
                                    $('#edit_type')[0].reset();
                                    $('#add_type').show();
                                    $('#edit_type').hide();
                                    itemTable.ajax.reload(null,false);
                                } else if (updateTypeResponse.updateType == "0") {
                                    toastr.warning("Type Name Already Exists");
                                } else if (updateTypeResponse.updateType == "2") {
                                    toastr.error("Error While Updating Type");
                                } else {
                                    toastr.error("Error While Updating Type");
                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }));

                });

                //Edit Category
                $('#typeTable tbody').on('click', '.edit_btn', (function() {
                    var editTypeId = $(this).val();
                    //console.log(editTypeId);

                    $.ajax({
                        method: "POST",
                        url: "MasterOperations.php",
                        data: {
                            editTypeId: editTypeId
                        },
                        beforeSend: function() {
                            $('#addCategoryForm').addClass("disable");
                        },
                        success: function(data) {
                            //console.log(data);
                            var edittype = JSON.parse(data);
                            if (edittype.Edittype == 'error') {
                                toastr.error("Some Error Occured");
                            } else {
                                $('#add_type').hide();
                                $('#edit_type').show();
                                $('#edit_type_name').val(edittype.Edittypename);
                                $('#edit_type_id').val(editTypeId);
                            }

                        },
                        error: function() {
                            alert("Error");
                        }
                    })
                }));

                //delete Category
                $('#typeTable tbody').on('click', '.delete_btn', (function() {
                    var deleteTypeId = $(this).val();
                    //console.log(deleteTypeId);
                    var ConfirmTypeDelete = confirm("Are you sure, you want to delete this type?");
                    if(ConfirmTypeDelete == true){
                        $.ajax({
                            method: "POST",
                            url: "MasterOperations.php",
                            data: {
                                deleteTypeId: deleteTypeId
                            },
                            beforeSend: function() {
                                $('#addCategoryForm').addClass("disable");
                            },
                            success: function(data) {
                                //console.log(data);
                                var response = JSON.parse(data);
                                if (response.Deltype == "1") {
                                    toastr.success("Successfully Deleted Type");
                                    itemTable.ajax.reload(null,false);
                                } else if (response.Deltype == "0") {
                                    toastr.warning("Cannot Delete a Type That is Already in Use");
                                } else if (response.Deltype == "2") {
                                    toastr.error("Error While Deleting");
                                } else {
                                    toastr.error("Error While Deleting");
                                }
                            },
                            error: function() {
                                alert("Error");
                            }
                        });
                    }else{

                    }
                   
                }));

            //////////////////////////////   CATEGORY MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


            //////////////////////////////   SERIES MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
                var SeriesTable = $('#SeriesTable').DataTable({
                    "processing": true,
                    "ajax": "SeriesData.php",
                    //"responsive": true,
                    "fixedHeader": true,
                    "dom": '<"top"fl>rt<"bottom"ip>',
                    //"select":true,

                    "columns": [{
                            "data": null,
                            "sortable": true,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'brand_name',
                        },
                        {
                            data: 'series_name',
                        },
                        {
                            data: 'se_id',
                            render: function(data, type, row, meta) {
                                if (type == 'display') {
                                    data = '<button class="edit_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                                }
                                return data;
                            }
                        },
                        {
                            data: 'se_id',
                            render: function(data, type, row, meta) {
                                if (type == 'display') {
                                    data = '<button class="delete_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">delete</i> </button>';
                                }
                                return data;
                            }
                        }

                    ]
                });

                //add series
                $(function() {

                    let validator = $('#add_series').jbvalidator({
                        language: 'dist/lang/en.json',
                        successClass: false,
                        html5BrowserDefault: true
                    });

                    validator.validator.custom = function(el, event) {
                        if ($(el).is('#seriesName') && $(el).val().trim().length == 0) {
                            return 'Cannot be empty';
                        }
                    }

                    $(document).on('submit', '#add_series', (function(a) {
                        a.preventDefault();
                        var SeriesData = new FormData(this);
                        //console.log(SeriesData);
                        $.ajax({
                            type: "POST",
                            url: "MasterOperations.php",
                            data: SeriesData,
                            success: function(data) {
                                //console.log(data);
                                var SeriesResponse = JSON.parse(data);
                                //console.log(SeriesResponse);
                                if (SeriesResponse.series == "1") {
                                    toastr.success("Success Adding a New Series");
                                    $('#add_series')[0].reset();
                                    SeriesTable.ajax.reload(null,false);
                                } else if (SeriesResponse.series == "0") {
                                    toastr.warning("Cannot Add a Series That is Already Present");
                                } else if (SeriesResponse.series == "2") {
                                    toastr.error("Error While Adding New Series");
                                } else {
                                    toastr.error("Error While Adding New Series");
                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }));

                });

                //Update series
                $(function() {

                    let validator = $('#edit_series').jbvalidator({
                        language: 'dist/lang/en.json',
                        successClass: false,
                        html5BrowserDefault: true
                    });

                    validator.validator.custom = function(el, event) {
                        if ($(el).is('#editSeriesName') && $(el).val().trim().length == 0) {
                            return 'Cannot be empty';
                        }
                    }

                    $(document).on('submit', '#edit_series', (function(a) {
                        a.preventDefault();
                        var updateSeriesData = new FormData(this);
                        //console.log(updateSeriesData);
                        $.ajax({
                            type: "POST",
                            url: "MasterOperations.php",
                            data: updateSeriesData,
                            success: function(data) {
                                //console.log(data);
                                var updateSeriesResponse = JSON.parse(data);
                                //console.log(updateSeriesResponse);
                                if (updateSeriesResponse.updateSeries == "1") {
                                    toastr.success("Successfully Updated Series");
                                    $('#edit_series')[0].reset();
                                    $('#add_series').show();
                                    $('#edit_series').hide();
                                    SeriesTable.ajax.reload(null,false);
                                } else if (updateSeriesResponse.updateSeries == "0") {
                                    toastr.warning("Series Name Already Exists");
                                } else if (updateSeriesResponse.updateSeries == "2") {
                                    toastr.error("Error While Updating Series");
                                } else {
                                    toastr.error("Error While Updating Series");
                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }));

                });

                //Edit series
                $('#SeriesTable tbody').on('click', '.edit_btn', (function() {
                    var editSeriesId = $(this).val();
                    //console.log(editSeriesId);
                    $.ajax({
                        method: "POST",
                        url: "MasterOperations.php",
                        data: {
                            editSeriesId: editSeriesId
                        },
                        beforeSend: function() {
                            $('#addCategoryForm').addClass("disable");
                        },
                        success: function(data) {
                            //console.log(data);
                            var editSeries = JSON.parse(data);
                            if (editSeries.EditSeries == 'error') {
                                toastr.error("Some Error Occured");
                            } else {
                                $('#add_series').hide();
                                $('#edit_series').show();
                                $('#brandSelectSeries').val(editSeries.EditSeriesBrand).change();
                                $('#editSeriesName').val(editSeries.EditSeriesName);
                                $('#UpdateSeriesId').val(editSeriesId);
                            }

                        },
                        error: function() {
                            alert("Error");
                        }
                    })
                }));

                //delete series
                $('#SeriesTable tbody').on('click', '.delete_btn', (function() {
                    var deleteSeriesId = $(this).val();
                    //console.log(deleteSeriesId);
                    var ConfirmSeriesDelete = confirm("Are you sure, you want to delete this series?");
                    if(ConfirmSeriesDelete == true){
                        $.ajax({
                            method: "POST",
                            url: "MasterOperations.php",
                            data: {
                                deleteSeriesId: deleteSeriesId
                            },
                            beforeSend: function() {
                                $('#addCategoryForm').addClass("disable");
                            },
                            success: function(data) {
                                //console.log(data);
                                var SeriesDeleteresponse = JSON.parse(data);
                                if (SeriesDeleteresponse.Delseries == "1") {
                                    toastr.success("Successfully Deleted Series");
                                    SeriesTable.ajax.reload(null,false);
                                } else if (SeriesDeleteresponse.Delseries == "0") {
                                    toastr.warning("Cannot Delete a Series That is Already in Use");
                                } else if (SeriesDeleteresponse.Delseries == "2") {
                                    toastr.error("Error While Deleting");
                                } else {
                                    toastr.error("Error While Deleting");
                                }
                            },
                            error: function() {
                                alert("Error");
                            }
                        })
                    }
                    else{

                    }
                }));
            //////////////////////////////  SERIES MASTER    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


            //////////////////////////////  BRAND MASTER    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
                var BrandTable = $('#brandTable').DataTable({
                    "processing": true,
                    "ajax": "BrandData.php",
                    //"responsive": true,
                    "fixedHeader": true,
                    "dom": '<"top"fl>rt<"bottom"ip>',
                    //"select":true,

                    "columns": [{
                            "data": null,
                            "sortable": true,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'brand_img',
                            render: function(data, type, row, meta) {
                                if (type == 'display') {
                                    data = '<img class="img-fluid brand_img"  src="../assets/img/BRAND/' + data + '">  </img>';
                                }
                                return data;
                            }
                        },
                        {
                            data: 'brand_name',
                        },
                        {
                            data: 'isSales',
                        },
                        {
                            data: 'isService',
                        },
                        {
                            data: 'br_id',
                            render: function(data, type, row, meta) {
                                if (type == 'display') {
                                    data = '<button class="edit_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                                }
                                return data;
                            }
                        },
                        {
                            data: 'br_id',
                            render: function(data, type, row, meta) {
                                if (type == 'display') {
                                    data = '<button class="delete_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">delete</i> </button>';
                                }
                                return data;
                            }
                        }

                    ]
                });


                //Add Brand
                $(function() {

                    let validator = $('#AddBrand').jbvalidator({
                        language: 'dist/lang/en.json',
                        successClass: false,
                        html5BrowserDefault: true
                    });

                    validator.validator.custom = function(el, event) {
                        if ($(el).is('#brand_name') && $(el).val().trim().length == 0) {
                            return 'Cannot be empty';
                        }
                    }

                    $(document).on('submit', '#AddBrand', (function(b) {
                        b.preventDefault();
                        var BrandData = new FormData(this);
                        console.log(BrandData);
                        $.ajax({
                            type: "POST",
                            url: "MasterOperations.php",
                            data: BrandData,
                            success: function(data) {
                                console.log(data);
                                var response = JSON.parse(data);
                                if (response.Status == "1") {
                                    $("#AddBrand")[0].reset();
                                    swal("Success", response.Message, "success");
                                    BrandTable.ajax.reload(null,false);
                                    get_brand_select();
                                } else if (response.Status == "0") {
                                    swal("Warning", response.Message, "warning");
                                } else if (response.Status == "2") {
                                    swal("Error", response.Message, "error");
                                } else {
                                    swal("Some Error Occured!!!", "Please Try Again", "error");
                                }
                            },
                            error: function () {
                                swal(
                                    "Some Error Occured!!!",
                                    "Please Refresh The Page...",
                                    "error"
                                );
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }));

                });


                //Update Brand
                $(function() {

                    let validator = $('#edit_brand').jbvalidator({
                        language: 'dist/lang/en.json',
                        successClass: false,
                        html5BrowserDefault: true
                    });

                    validator.validator.custom = function(el, event) {
                        if ($(el).is('#edit_brandName') && $(el).val().trim().length == 0) {
                            return 'Cannot be empty';
                        }
                    }

                    $(document).on('submit', '#edit_brand', (function(a) {
                        a.preventDefault();
                        var updateBrandData = new FormData(this);
                        console.log(updateBrandData);
                        $.ajax({
                            type: "POST",
                            url: "MasterOperations.php",
                            data: updateBrandData,
                            success: function(data) {
                                console.log(data);
                                var updateBrandResponse = JSON.parse(data);
                                console.log(updateBrandResponse);
                                if (updateBrandResponse.updateBrand == "1") {
                                    toastr.success("Successfully Updated Brand");
                                    $('#edit_brand')[0].reset();
                                    $('#AddBrand').show();
                                    $('#edit_brand').hide();
                                    BrandTable.ajax.reload(null,false);
                                    get_brand_select();
                                } else if (updateBrandResponse.updateBrand == "0") {
                                    toastr.warning("Brand Name Already Exists");
                                } else if (updateBrandResponse.updateBrand == "2") {
                                    toastr.error("Error While Updating Brand");
                                } else {
                                    toastr.error("Error While Updating Brand");
                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }));

                });


                //Edit Brand
                $('#brandTable tbody').on('click', '.edit_btn', (function() {
                    var editBrandId = $(this).val();
                    console.log(editBrandId);
                    $.ajax({
                        method: "POST",
                        url: "MasterOperations.php",
                        data: {
                            editBrandId: editBrandId
                        },
                        beforeSend: function() {
                            $('#addCategoryForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            var editBrand = JSON.parse(data);
                            if (editBrand.EditBrand == 'error') {
                                toastr.error("Some Error Occured");
                            } else {
                                $('#AddBrand').hide();
                                $('#edit_brand').show();
                                $('#edit_brandName').val(editBrand.EditBrandName);
                                $('#UpdateBrandId').val(editBrandId);
                                if(editBrand.IsSales == 'YES'){
                                    $('#update_brand_sales').prop('checked', true);
                                }else{
                                    $('#update_brand_sales').prop('checked', false);
                                }
                                if(editBrand.IsService == 'YES'){
                                    $('#update_brand_service').prop('checked', true);
                                }
                                else{
                                    $('#update_brand_service').prop('checked', false);
                                }
                            }

                        },
                        error: function() {
                            alert("Error");
                        }
                    })
                }));


                //Delete Brand
                $('#brandTable tbody').on('click', '.delete_btn', (function() {
                    var deleteBrandId = $(this).val();
                    //console.log(deleteBrandId);
                    var ConfirmBrandDelete = confirm("Are you sure, you want to delete this brand?");
                    if (ConfirmBrandDelete == true) {
                        $.ajax({
                            method: "POST",
                            url: "MasterOperations.php",
                            data: {
                                deleteBrandId: deleteBrandId
                            },
                            beforeSend: function() {
                                $('#addCategoryForm').addClass("disable");
                            },
                            success: function(data) {
                                console.log(data);
                                var BrandDeleteresponse = JSON.parse(data);
                                if (BrandDeleteresponse.Delbrand == "1") {
                                    toastr.success("Successfully Deleted Brand");
                                    BrandTable.ajax.reload(null,false);
                                } else if (BrandDeleteresponse.Delbrand == "0") {
                                    toastr.warning("Cannot Delete a Brand That is Already in Use");
                                } else if (BrandDeleteresponse.Delbrand == "2") {
                                    toastr.error("Error While Deleting");
                                } else {
                                    toastr.error("Error While Deleting");
                                }
                            },
                            error: function() {
                                alert("Error");
                            }
                        });
                    }else{

                    }
                }));

            //////////////////////////////  BRAND MASTER    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


            //////////////////////////////  MODEL MASTER    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


                var ModelTable = $('#ModelTable').DataTable({
                    "processing": true,
                    "ajax": "ModelData.php",
                    //"responsive": true,
                    "fixedHeader": true,
                    "dom": '<"top"fl>rt<"bottom"ip>',
                    //"select":true,

                    "columns": [{
                            "data": null,
                            "sortable": true,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'model_img',
                            render: function(data, type, row, meta) {
                                if (type == 'display') {
                                    data = '<img class="img-fluid brand_img"  src="../assets/img/MODEL/' + data + '">  </img>';
                                }
                                return data;
                            }
                        },
                        {
                            data: 'brand_name',
                        },
                        {
                            data: 'series_name',
                        },

                        {
                            data: 'model_name',
                        },
                        {
                            data: 'mo_id',
                            render: function(data, type, row, meta) {
                                if (type == 'display') {
                                    data = '<button class="edit_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                                }
                                return data;
                            }
                        },
                        {
                            data: 'mo_id',
                            render: function(data, type, row, meta) {
                                if (type == 'display') {
                                    data = '<button class="delete_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">delete</i> </button>';
                                }
                                return data;
                            }
                        }

                    ]
                });



                //add model
                $(function() {

                    let validator = $('#add_model').jbvalidator({
                        //language: 'dist/lang/en.json',
                        successClass: false,
                        html5BrowserDefault: true
                    });

                    validator.validator.custom = function(el, event) {
                        if ($(el).is('#model_name') && $(el).val().trim().length == 0) {
                            return 'Cannot be empty';
                        }
                    }

                    $(document).on('submit', '#add_model', (function(b) {
                        b.preventDefault();
                        var ModelData = new FormData(this);
                        console.log(ModelData);
                        $.ajax({
                            type: "POST",
                            url: "MasterOperations.php",
                            data: ModelData,
                            success: function(data) {
                                console.log(data);
                                var ModelResponse = JSON.parse(data);
                                console.log(ModelResponse);
                                if (ModelResponse.addModel == "1") {
                                    toastr.success("Success Adding a New Model");
                                    $('#add_model')[0].reset();
                                    get_series_select('0');
                                    ModelTable.ajax.reload(null,false);
                                } else if (ModelResponse.addModel == "0") {
                                    toastr.warning("Cannot Add a Model That is Already Present");
                                } else if (ModelResponse.addModel == "2") {
                                    toastr.error("Error While Adding New Model");
                                } else {
                                    toastr.error("Error While Adding New Model");
                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }));

                });



                //Update model
                $(function() {

                    let validator = $('#edit_modelForm').jbvalidator({
                        //language: 'dist/lang/en.json',
                        successClass: false,
                        html5BrowserDefault: true
                    });

                    validator.validator.custom = function(el, event) {
                        if ($(el).is('#edit_model_name') && $(el).val().trim().length == 0) {
                            return 'Cannot be empty';
                        }
                    }

                    $(document).on('submit', '#edit_modelForm', (function(a) {
                        a.preventDefault();
                        var updateModelData = new FormData(this);
                        console.log(updateModelData);
                        $.ajax({
                            type: "POST",
                            url: "MasterOperations.php",
                            data: updateModelData,
                            success: function(data) {
                                console.log(data);
                                var updateModelResponse = JSON.parse(data);
                                console.log(updateModelResponse);
                                if (updateModelResponse.updateModel == "1") {
                                    toastr.success("Successfully Updated Model");
                                    $('#edit_modelForm')[0].reset();
                                    get_series_select('0');
                                    $('#add_model').show();
                                    $('#edit_modelForm').hide();
                                    ModelTable.ajax.reload(null,false);

                                } else if (updateModelResponse.updateModel == "0") {
                                    toastr.warning("Model Name Already Exists");
                                } else if (updateModelResponse.updateModel == "2") {
                                    toastr.error("Error While Updating Model");
                                } else {
                                    toastr.error("Error While Updating Model");
                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }));
                });


                //Edit model
                $('#ModelTable tbody').on('click', '.edit_btn', (function() {
                    //get_series_select_edit();
                    var editModelId = $(this).val();
                    console.log(editModelId);
                    $.ajax({
                        method: "POST",
                        url: "MasterOperations.php",
                        data: {
                            editModelId: editModelId
                        },
                        beforeSend: function() {
                            $('#addCategoryForm').addClass("disable"); 
                        },
                        success: function(data) {
                            console.log(data);
                            var editModel = JSON.parse(data);
                            if (editModel.EditModel == 'error') {
                                toastr.error("Some Error Occured");
                            } else {
                                $('#add_model').hide();
                                $('#edit_modelForm').show();
                                $('#edit_model_name').val(editModel.EditModelName)
                                $('#EditModelId').val(editModelId);
                                $('#update_brand_m').val(editModel.EditModelBrand).change();
                                $('#update_series_m').val(editModel.EditModelSeries).change();
                            }

                        },
                        error: function() {
                            alert("Error");
                        }
                    })
                }));



                //delete model
                $('#ModelTable tbody').on('click', '.delete_btn', (function() {
                    var deleteModelId = $(this).val();
                    //console.log(deleteModelId);
                    var ConfirmModelDelete = confirm("Are you sure, you want to delete this model?");
                    if (ConfirmModelDelete == true) {
                        $.ajax({
                            method: "POST",
                            url: "MasterOperations.php",
                            data: {
                                deleteModelId: deleteModelId
                            },
                            beforeSend: function() {
                                $('#addCategoryForm').addClass("disable");
                            },
                            success: function(data) {
                                console.log(data);
                                var ModelDeleteresponse = JSON.parse(data);
                                if (ModelDeleteresponse.Delmodel == "1") {
                                    toastr.success("Successfully Deleted Model");
                                    ModelTable.ajax.reload(null,false);
                                } else if (ModelDeleteresponse.Delmodel == "0") {
                                    toastr.warning("Cannot Delete a Model That is Already in Use");
                                } else if (ModelDeleteresponse.Delmodel == "2") {
                                    toastr.error("Error While Deleting");
                                } else {
                                    toastr.error("Error While Deleting");
                                }
                            },
                            error: function() {
                                alert("Error");
                            }
                        });
                    }
                    else{

                    }
                }));

            //////////////////////////////  MODEL MASTER    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


        });
    </script>


    <?php
    include "../MAIN/Footer.php";
    ?>


</body>

</html>