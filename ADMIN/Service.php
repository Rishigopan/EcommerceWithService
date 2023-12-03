    <?php
    require "../MAIN/Dbconn.php"; 

    $update = false;

    if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

        if ($_COOKIE['custtypecookie'] == 'executive' || $_COOKIE['custtypecookie'] == 'admin') {
            echo "";
        } else {
            header("location:../login.php");
        }
    } else {
        header("location:../login.php");
    }
    $PageTitle = 'Service';

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
                        <h5> Add Service</h5>
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
                            <button class="nav-link " id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Service Type</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Service</button>
                        </li>

                    </ul>
                    <div class="tab-content" id="pills-tabContent">

                    
                        <!--service type -->
                        <div class="tab-pane fade show " id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                            <div class="container-fluid px-5 masters">
                                <div class="row gx-5">
                                    <div class="col-lg-5">
                                        <div class="card card-body px-5 py-4">
                                            <form id="add_service_type" action="" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-12 mt-3">
                                                        <label for="add_service_type_name" class="form-label">Service Name</label>
                                                        <input type="text" class="form-control" id="service_type_name" name="serviceTypeName" placeholder="Enter a Service Name" required>
                                                    </div>
                                                    <div class="col-12 mt-3">
                                                        <label for="add_service_image" class="form-label">Add Service image</label>
                                                        <input type="file" class="form-control" id="add_service_image" name="serviceImage" >
                                                    </div>
                                                    <div class="col-12 mt-3 text-center">
                                                        <button class="btn btn_submit shadow-none rounded-pill" type="submit">Add Service Type</button>
                                                    </div>
                                                </div>
                                            </form>

                                            <form id="edit_service_type" action="" method="POST" enctype="multipart/form-data" style="display: none;">
                                                <div class="row">
                                                    <div class="col-12 mt-3">
                                                        <input type="text" class="form-control" id="edit_service_type_id" name="editServiceTypeid" hidden>
                                                        <label for="edit_service_type_name" class="form-label">Service Name</label>
                                                        <input type="text" class="form-control" id="edit_service_type_name" name="editServiceTypeName" placeholder="Enter a Service Name">
                                                    </div>
                                                    <div class="col-12 mt-3">
                                                        <label for="edit_service_image" class="form-label">Add Service image</label>
                                                        <input type="file" class="form-control" id="edit_service_image" name="editServiceImage">
                                                    </div>
                                                    <div class="col-12 mt-3 text-center">
                                                        <button class="btn btn_submit shadow-none rounded-pill" type="submit" name="services">Update Service Type</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="card card-body px-0">
                                            <div class="table-responsive">
                                                <table class="table table-borderless text-nowrap" id="ServiceTypeTable" style="width:100%;">
                                                    <thead class="text-nowrap">
                                                        <tr class="text-nowrap">
                                                            <th class="text-center">Id</th>
                                                            <th class="text-center">Image</th>
                                                            <th class="text-center">Service Name</th>
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

                        <!--Servcie list-->
                        <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                            <div class="container-fluid px-5 masters">
                                <div class="row gx-5">
                                    <div class="col-lg-5">
                                        <div class="card card-body px-5 py-4">
                                            <form id="add_service" action="" method="" novalidate>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="select_brand_service" class="form-label">Select Brand</label>
                                                        <select class="form-select brand_service_options ShowBrand" id="select_brand_service" name="SelectBrandService" required>
                                                            <option value="">Select Brand</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="select_series_service" class="form-label">Select Series</label>
                                                        <select class="form-select ShowSeries" id="select_series_service" name="SelectSeriesService" required>
                                                            <option value=""> Select a Series </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 mt-2">
                                                        <label for="select_model_service" class="form-label">Select Product</label>
                                                        <select class="form-select ShowModel" id="select_model_service" name="SelectModelService" required>
                                                            <option value="">Select a Product</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 mt-2 ">
                                                        <label for="select_service" class="form-label">Select Service</label>
                                                        <select class="form-select ShowService" id="select_service" name="SelectService" required>
                                                            <option value="">Select a Service</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 mt-2 ">
                                                        <label for="service_amount" class="form-label"> Service Cost</label>
                                                        <input type="number" class="form-control py-1" id="service_amount" name="ServiceAmount" value="" placeholder="Enter Amount" required>
                                                    </div>
                                                    <div class="mt-2 col-6">
                                                        <label for="select_tax" class="form-label">Service Tax %</label>
                                                        <select id="select_tax" class="form-select py-1" name="ServiceTax" >
                                                            <option hidden value="">Choose a Tax %</option>
                                                            <option value="10">10 %</option>
                                                            <option value="12">12 %</option>
                                                            <option value="18">18 %</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 mt-2">
                                                        <label for="Add_commission" class="form-label">Commission</label>
                                                        <input type="number" class="form-control py-1" id="Add_commission" name="ServiceCommission" value="" placeholder="Enter Amount" >
                                                    </div>
                                                    <div class="col-12 mt-3 text-center">
                                                        <button class="btn btn_submit rounded-pill py-1" type="submit">Add Service</button>
                                                    </div>
                                                </div>
                                            </form>


                                            <form id="edit_service" action="" method="" style="display: none;">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <input type="text" name="UpdateServiceId" id="UpdateServiceID" hidden>
                                                        <label for="edit_select_brand_service" class="form-label">Select Brand</label>
                                                        <select class="form-select brand_service_options ShowBrand" id="edit_select_brand_service" name="EditSelectBrandService">
                                                            <option value="">Select Brand</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="edit_select_series_services" class="form-label">Select Series</label>
                                                        <select class="form-select ShowSeries" id="edit_select_series_services" name="EditSelectSeriesService">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 mt-2">
                                                        <label for="edit_select_model_service" class="form-label">Select Product</label>
                                                        <select class="form-select ShowModel" id="edit_select_model_service" name="EditSelectModelService">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 mt-2 ">
                                                        <label for="edit_select_service" class="form-label">Select Service</label>
                                                        <select class="form-select ShowService" id="edit_select_service" name="EditSelectService">
                                                            <option value="">Select a Service</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 mt-2 ">
                                                        <label for="edit_service_amount" class="form-label"> Service Cost</label>
                                                        <input type="number" class="form-control py-1" id="edit_service_amount" name="EditServiceAmount" value="" placeholder="Enter Amount">
                                                    </div>
                                                    <div class="mt-2 col-6">
                                                        <label for="edit_select_tax" class="form-label">Service Tax %</label>
                                                        <select id="edit_select_tax" class="form-select py-1" name="EditServiceTax">
                                                            <option hidden value="">Choose a Tax %</option>
                                                            <option value="10">10 %</option>
                                                            <option value="12">12 %</option>
                                                            <option value="18">18 %</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 mt-2">
                                                        <label for="edit_Add_commission" class="form-label">Commission</label>
                                                        <input type="number" class="form-control py-1" id="edit_Add_commission" name="EditServiceCommission" value="" placeholder="Enter Amount">
                                                    </div>
                                                    <div class="col-12 mt-3 text-center">
                                                        <button class="btn btn_submit rounded-pill py-1" type="submit">Update Service</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-lg-7">
                                        <div class="card card-body px-0">
                                            <table class="table table-borderless text-nowrap" id="ServiceTable" style="width:100%;">
                                                <thead class="text-nowrap">
                                                    <tr class="text-nowrap">
                                                        <th class="text-center">Id</th>
                                                        <th class="text-center">Brand</th>
                                                        <th class="text-center">Series</th>
                                                        <th class="text-center">Model</th>
                                                        <th class="text-center">Service</th>
                                                        <th class="text-center">Amount</th>
                                                        <th class="text-center">Tax %</th>
                                                        <th class="text-center">Commission</th>
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

        <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>

        <script src="../JS/masters.js?ver=1.8"></script>

        <script>

            $(document).ready(function() {

                //Reload Table on HomeTab click
                var tabHome = document.getElementById('pills-home-tab');
                tabHome.addEventListener('shown.bs.tab', function(event) {
                    serviceTypeTable.ajax.reload();
                });

                //Reload Table on ProfileTab click
                var tabProfile = document.getElementById('pills-profile-tab');
                tabProfile.addEventListener('shown.bs.tab', function(event) {
                    serviceTable.ajax.reload();
                });


                //////////////////////////////  SERVICE TYPE MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
                    var serviceTypeTable = $('#ServiceTypeTable').DataTable({
                        "processing": true,
                        "ajax": "ServiceTypeData.php",
                        "scrollX": true,
                        "scrollY": "500px",
                        //"serverSide": true,
                        //"serverMethod": 'post',
                        //"responsive": true,
                        "fixedHeader": true,
                        "dom": '<"top"fl>rt<"bottom"ip>',
                        //"select":true,
                        "fixedColumns": {
                            left: 1,
                            right: 2
                        },
                        "columns": [{
                                data: 'sr_id',
                            },
                            {
                                data: 'service_img',
                                render: function(data, type, row, meta) {
                                    if (type == 'display') {
                                        data = '<img class="img-fluid brand_img"  src="../assets/img/SERVICE/' + data + '">  </img>';
                                    }
                                    return data;
                                }
                            },
                            {
                                data: 'service_name',
                            },
                            {
                                data: 'sr_id',
                                render: function(data, type, row, meta) {
                                    if (type == 'display') {
                                        data = '<button class="edit_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                                    }
                                    return data;
                                }
                            },
                            {
                                data: 'sr_id',
                                render: function(data, type, row, meta) {
                                    if (type == 'display') {
                                        data = '<button class="delete_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">delete</i> </button>';
                                    }
                                    return data;
                                }
                            }

                        ]


                    });


                    //add  service types
                    $(function() {

                        let validator = $('#add_service_type').jbvalidator({
                            //language: 'dist/lang/en.json',
                            successClass: false,
                            html5BrowserDefault: true
                        });

                        validator.validator.custom = function(el, event) {
                            if ($(el).is('#service_type_name') && $(el).val().trim().length == 0) {
                                return 'Cannot be empty';
                            }
                        }

                        $(document).on('submit', '#add_service_type', (function(a) {
                            a.preventDefault();
                            var ServiceTypedata = new FormData(this);
                            //console.log(ServiceTypedata);
                            $.ajax({
                                type: "POST",
                                url: "ServiceMasterOperations.php",
                                data: ServiceTypedata,
                                success: function(data) {
                                    console.log(data);
                                    var response = JSON.parse(data);
                                    if (response.addServiceType == "1") {
                                        toastr.success("Success Adding a New Service Type");
                                        $('#add_service_type')[0].reset();
                                        serviceTypeTable.ajax.reload(null,false);
                                        GetServiceSelectService();
                                    } else if (response.addServiceType == "0") {
                                        toastr.warning("Cannot Add a Service Type That is Already Present");
                                    } else if (response.addServiceType == "2") {
                                        toastr.error("Error While Adding New Service Type");
                                    } else {
                                        toastr.error("Error While Adding New Service Type");
                                    }
                                },
                                cache: false,
                                contentType: false,
                                processData: false
                            });
                        }));

                    });


                    //Update service types
                    $(function() {

                        let validator = $('#edit_service_type').jbvalidator({
                            //language: 'dist/lang/en.json',
                            successClass: false,
                            html5BrowserDefault: true
                        });

                        validator.validator.custom = function(el, event) {
                            if ($(el).is('#edit_service_type_name') && $(el).val().trim().length == 0) {
                                return 'Cannot be empty';
                            }
                        }

                        $(document).on('submit', '#edit_service_type', (function(a) {
                            a.preventDefault();
                            var updateServiceTypeData = new FormData(this);
                            //console.log(updateServiceTypeData);
                            $.ajax({
                                type: "POST",
                                url: "ServiceMasterOperations.php",
                                data: updateServiceTypeData,
                                success: function(data) {
                                    console.log(data);
                                    var updateServiceTypeResponse = JSON.parse(data);
                                    console.log(updateServiceTypeResponse);
                                    if (updateServiceTypeResponse.updateServiceType == "1") {
                                        toastr.success("Successfully Updated Type");
                                        $('#edit_service_type')[0].reset();
                                        $('#add_service_type').show();
                                        $('#edit_service_type').hide();
                                        serviceTypeTable.ajax.reload(null,false);
                                        GetServiceSelectService();
                                    } else if (updateServiceTypeResponse.updateServiceType == "0") {
                                        toastr.warning("Service Type Name Already Exists");
                                    } else if (updateServiceTypeResponse.updateServiceType == "2") {
                                        toastr.error("Error While Updating Service Type");
                                    } else {
                                        toastr.error("Error While Updating Service Type");
                                    }
                                },
                                cache: false,
                                contentType: false,
                                processData: false
                            });
                        }));

                    });


                    //Edit service types
                    $('#ServiceTypeTable tbody').on('click', '.edit_btn', (function() {
                        var editServiceTypeId = $(this).val();
                        console.log(editServiceTypeId);

                        $.ajax({
                            method: "POST",
                            url: "ServiceMasterOperations.php",
                            data: {
                                editServiceTypeId: editServiceTypeId
                            },
                            beforeSend: function() {
                                $('#addCategoryForm').addClass("disable");
                            },
                            success: function(data) {
                                //console.log(data);
                                var editServiceType = JSON.parse(data);
                                if (editServiceType.EditServiceType == 'error') {
                                    toastr.error("Some Error Occured");
                                } else {
                                    $('#add_service_type').hide();
                                    $('#edit_service_type').show();
                                    $('#edit_service_type_name').val(editServiceType.EditServiceTypeName);
                                    $('#edit_service_type_id').val(editServiceTypeId);
                                }
                            },
                            error: function() {
                                alert("Error");
                            }
                        })
                    }));


                    //delete service types
                    $('#ServiceTypeTable tbody').on('click', '.delete_btn', (function() {
                        var deleteServiceTypeId = $(this).val();
                        //console.log(deleteServiceTypeId);
                        var ConfirmServiceTypeDelete = confirm("Are you sure, you want to delete this service type?");
                        if (ConfirmServiceTypeDelete == true) {
                            $.ajax({
                                method: "POST",
                                url: "ServiceMasterOperations.php",
                                data: {
                                    deleteServiceTypeId: deleteServiceTypeId
                                },
                                beforeSend: function() {
                                    $('#addCategoryForm').addClass("disable");
                                },
                                success: function(data) {
                                    console.log(data);
                                    var DeleteServiceTypeResponse = JSON.parse(data);
                                    if (DeleteServiceTypeResponse.DelServiceType == "1") {
                                        toastr.success("Successfully Deleted Service Type");
                                        serviceTypeTable.ajax.reload(null,false);
                                    } else if (DeleteServiceTypeResponse.DelServiceType == "0") {
                                        toastr.warning("Cannot Delete a Service Type That is Already in Use");
                                    } else if (DeleteServiceTypeResponse.DelServiceType == "2") {
                                        toastr.error("Error While Deleting");
                                    } else {
                                        toastr.error("Error While Deleting");
                                    }
                                },
                                error: function() {
                                    alert("Error");
                                }
                            });
                        } else {
                            toastr.info("Cancelled");
                        }

                    }));
                //////////////////////////////  SERVICE TYPE MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\



                //////////////////////////////  SERVICE MAIN MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

                    //load all brands
                    GetServiceSelectBrand();

                    //load all services
                    GetServiceSelectService();

                    //Change series For brand - selection
                    $('.ShowBrand').click(function() {
                        var S_brand = $(this).val();
                        GetSeriesSelectBrand(S_brand);
                        GetModelSelectSeries('0');
                    });

                    //Change Model  For series - selection
                    $('.ShowSeries').click(function() {
                        var S_series = $(this).val();
                        GetModelSelectSeries(S_series);
                    });

                    //service table
                    var serviceTable = $('#ServiceTable').DataTable({
                        "processing": true,
                        "ajax": "ServiceData.php",
                        "scrollY": "500px",
                        "scrollX": true,
                        //"serverSide": true,
                        //"serverMethod": 'post',
                        //"responsive": true,
                        "fixedHeader": true,
                        "dom": '<"top"fl>rt<"bottom"ip>',
                        //"select":true,
                        "fixedColumns": {
                            left: 2,
                            right: 2
                        },
                        "columns": [{
                                data: 'main_id',
                            },
                            {
                                data: 'brand_name',
                            },
                            {
                                data: 'series_name',
                            },
                            {
                                data: 'name',
                            },
                            {
                                data: 'service_name',
                            },
                            {
                                data: 'cost',
                            },
                            {
                                data: 'tax',
                            },
                            {
                                data: 'commission',
                            },
                            {
                                data: 'main_id',
                                render: function(data, type, row, meta) {
                                    if (type == 'display') {
                                        data = '<button class="edit_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                                    }
                                    return data;
                                }
                            },
                            {
                                data: 'main_id',
                                render: function(data, type, row, meta) {
                                    if (type == 'display') {
                                        data = '<button class="delete_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">delete</i> </button>';
                                    }
                                    return data;
                                }
                            }

                        ]
                    });


                    //add  services
                    $(function() {

                        let validator = $('#add_service').jbvalidator({
                            //language: 'dist/lang/en.json',
                            successClass: false,
                            html5BrowserDefault: true
                        });

                        validator.validator.custom = function(el, event) {
                            if ($(el).is('#service_amount') && $(el).val().trim().length == 0) {
                                return 'Cannot be empty';
                            }
                        }

                        $(document).on('submit', '#add_service', (function(a) {
                            a.preventDefault();
                            var Servicedata = new FormData(this);
                            //console.log(Servicedata);
                            $.ajax({
                                type: "POST",
                                url: "ServiceMasterOperations.php",
                                data: Servicedata,
                                success: function(data) {
                                    console.log(data);
                                    var ServiceResponse = JSON.parse(data);
                                    if (ServiceResponse.addService == "1") {
                                        toastr.success("Success Adding a New Service");
                                        $('#add_service')[0].reset();
                                        serviceTable.ajax.reload();
                                        GetModelSelectSeries('0');
                                        GetSeriesSelectBrand('0');
                                    } else if (ServiceResponse.addService == "0") {
                                        toastr.warning("Cannot Add a Service That is Already Present");
                                    } else if (ServiceResponse.addService == "2") {
                                        toastr.error("Error While Adding New Service");
                                    } else {
                                        toastr.error("Error While Adding New Service");
                                    }
                                },
                                cache: false,
                                contentType: false,
                                processData: false
                            });
                        }));

                    });


                    //Update service 
                    $(function() {

                        let validator = $('#edit_service').jbvalidator({
                            //language: 'dist/lang/en.json',
                            successClass: false,
                            html5BrowserDefault: true
                        });

                        validator.validator.custom = function(el, event) {
                            if ($(el).is('#edit_service_amount') && $(el).val().trim().length == 0) {
                                return 'Cannot be empty';
                            }
                        }

                        $(document).on('submit', '#edit_service', (function(a) {
                            a.preventDefault();
                            var updateServiceData = new FormData(this);
                            //console.log(updateServiceData);
                            $.ajax({
                                type: "POST",
                                url: "ServiceMasterOperations.php",
                                data: updateServiceData,
                                success: function(data) {
                                    console.log(data);
                                    var updateServiceResponse = JSON.parse(data);
                                    console.log(updateServiceResponse);
                                    if (updateServiceResponse.updateService == "1") {
                                        toastr.success("Successfully Updated Service");
                                        $('#edit_service')[0].reset();
                                        $('#add_service').show();
                                        $('#edit_service').hide();
                                        serviceTable.ajax.reload();
                                    } else if (updateServiceResponse.updateService == "0") {
                                        toastr.warning("Service Name Already Exists");
                                    } else if (updateServiceResponse.updateService == "2") {
                                        toastr.error("Error While Updating Service");
                                    } else {
                                        toastr.error("Error While Updating Service");
                                    }
                                },
                                cache: false,
                                contentType: false,
                                processData: false
                            });
                        }));

                    });


                    //Edit services
                    $('#ServiceTable tbody').on('click', '.edit_btn', (function() {
                        var editServiceId = $(this).val();
                        //console.log(editServiceId);
                        GetEditSeriesService();
                        GetEditModelService();
                        $.ajax({
                            method: "POST",
                            url: "ServiceMasterOperations.php",
                            data: {
                                editServiceId: editServiceId
                            },
                            beforeSend: function() {
                                //$('#addCategoryForm').addClass("disable");
                            },
                            success: function(data) {
                                //console.log(data);
                                var editServiceResponse = JSON.parse(data);
                                console.log(editServiceResponse);
                                if (editServiceResponse.EditService == 'error') {
                                    toastr.error("Some Error Occured");
                                } else {
                                    $('#add_service').hide();
                                    $('#edit_service').show();
                                    $('#edit_select_tax').val(editServiceResponse.tax).change();
                                    $('#edit_select_service').val(editServiceResponse.sr_id);
                                    $('#edit_select_model_service').val(editServiceResponse.mo_id);
                                    $('#edit_select_series_services').val(editServiceResponse.se_id);
                                    $('#edit_select_brand_service').val(editServiceResponse.br_id);
                                    $('#edit_service_amount').val(editServiceResponse.cost);
                                    $('#edit_Add_commission').val(editServiceResponse.commission);
                                    $('#UpdateServiceID').val(editServiceId);
                                }
                            },
                            error: function() {
                                alert("Error");
                            }
                        })
                    }));


                    //delete service 
                    $('#ServiceTable tbody').on('click', '.delete_btn', (function() {
                        var deleteServiceId = $(this).val();
                        //console.log(deleteServiceId);
                        var ConfirmServiceDelete = confirm("Are you sure, you want to delete this service?");
                        if (ConfirmServiceDelete == true) {
                            $.ajax({
                                method: "POST",
                                url: "ServiceMasterOperations.php",
                                data: {
                                    deleteServiceId: deleteServiceId
                                },
                                beforeSend: function() {
                                    $('#addCategoryForm').addClass("disable");
                                },
                                success: function(data) {
                                    console.log(data);
                                    var DeleteServiceResponse = JSON.parse(data);
                                    if (DeleteServiceResponse.DelService == "1") {
                                        toastr.success("Successfully Deleted Service");
                                        serviceTable.ajax.reload();
                                    } else if (DeleteServiceResponse.DelService == "0") {
                                        toastr.warning("Cannot Delete a Service That is Already in Use");
                                    } else if (DeleteServiceResponse.DelService == "2") {
                                        toastr.error("Error While Deleting");
                                    } else {
                                        toastr.error("Error While Deleting");
                                    }
                                },
                                error: function() {
                                    alert("Error");
                                }
                            });
                        } else {
                            toastr.info("Cancelled");
                        }

                    }));

                //////////////////////////////  SERVICE MAIN MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


            });

        </script>


        <?php
        include "../MAIN/Footer.php";
        ?>


    </body>

    </html>