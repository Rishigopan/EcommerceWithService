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
$PageTitle = 'ColorMaster';

?>

<!doctype html>
<html lang="en">

<head>



    <?php

    require "../MAIN/Header.php";

    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css" integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>






</head>

<body>

    <div class="wrapper">
        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top ">
            <div class="container-fluid">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5> Color Master</h5>
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
                <div class="container-fluid px-5 masters">
                    <div class="row gx-5">
                        <div class="col-lg-5">
                            <div class="card card-body px-5 py-4">
                                <form id="SaveColorMaster" class="form needs-validation" novalidate>
                                    <div class="row">
                                        <div class="col-12 mt-3">
                                            <label for="add_color" class="form-label">Color Name</label>
                                            <input type="text" class="form-control" id="add_color" name="ColorName" placeholder="Enter a Color Name" required>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="add_color_image" class="form-label">Color Image</label>
                                            <input type="file" class="form-control" id="add_color_image" name="ColorImage">
                                        </div>
                                        <div class="col-12 mt-3 text-center">
                                            <button class="btn btn_submit shadow-none rounded-pill" type="submit">Add Color</button>
                                        </div>
                                    </div>
                                </form>

                                <!-- <form id="UpdateColorMaster" action="" method="POST" enctype="multipart/form-data" style="display: none;"> -->
                                <form id="UpdateColorMaster">
                                    <div class="row">
                                        <div class="col-12 mt-3">
                                            <input type="text" class="form-control" id="update_color_id" name="UpdateColorId">
                                            <label for="update_color" class="form-label">Color Name</label>
                                            <input type="text" class="form-control" id="update_color" name="UpdateColorName" placeholder="Enter a Color Name">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="update_color_image" class="form-label">Color Image</label>
                                            <input type="file" class="form-control" id="update_color_image" name="UpdateColorImage">
                                        </div>
                                        <div class="col-12 mt-3 text-center">
                                            <button class="btn btn_submit shadow-none rounded-pill" type="submit">Update Color</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="card card-body px-0">
                                <div class="table-responsive">
                                    <table class="table table-borderless text-nowrap" id="MasterTable" style="width:100%;">
                                        <thead class="text-nowrap">
                                            <tr class="text-nowrap">
                                                <th class="text-center">Sl No.</th>
                                                <th class="text-center">Image</th>
                                                <th class="text-center">Color</th>
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

    <!-- <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script> -->

    <script src="../JS/masters.js?ver=1.8"></script>

    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>

    <script>
        //////////////////////////////  COLOR MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

        //Data table
        var MasterTable = $('#MasterTable').DataTable({
            "processing": true,
            "ajax": "MasterData.php?Color",
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
                    data: 'colorId',
                },
                {
                    data: 'colorImage',
                    render: function(data, type, row, meta) {
                        if (type == 'display') {
                            data = '<img class="img-fluid brand_img"  src="../assets/img/COLOR/' + data + '">  </img>';
                        }
                        return data;
                    }
                },
                {
                    data: 'colorName',
                },
                {
                    data: 'colorId',
                    render: function(data, type, row, meta) {
                        if (type == 'display') {
                            data = '<button class="edit_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                        }
                        return data;
                    }
                },
                {
                    data: 'colorId',
                    render: function(data, type, row, meta) {
                        if (type == 'display') {
                            data = '<button class="delete_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">delete</i> </button>';
                        }
                        return data;
                    }
                }
            ]
        });




        const SaveForm = document.getElementById("SaveColorMaster");
        //SaveForm.addEventListener('submit', FormSubmitFunction);






        // var $select = $('#select-tools').selectize({
        //     maxItems: null,
        //     valueField: 'id',
        //     labelField: 'title',
        //     searchField: 'title',
        //     options: [{
        //             id: 1,
        //             title: 'Spectrometer',
        //             url: 'http://en.wikipedia.org/wiki/Spectrometers'
        //         },
        //         {
        //             id: 2,
        //             title: 'Star Chart',
        //             url: 'http://en.wikipedia.org/wiki/Star_chart'
        //         },
        //         {
        //             id: 3,
        //             title: 'Electrical Tape',
        //             url: 'http://en.wikipedia.org/wiki/Electrical_tape'
        //         }
        //     ],
        //     create: false
        // });












        // (() => {

        //     let validator = $('#SaveColorMaster').jbvalidator({
        //         //language: 'dist/lang/en.json',
        //         successClass: false,
        //         html5BrowserDefault: true
        //     });

        //     validator.validator.custom = function(el, event) {
        //         if ($(el).is('#add_color') && $(el).val().trim().length == 0) {
        //             return 'Cannot be empty';
        //         }
        //     }


        //     $(document).on('submit', '#SaveColorMaster', FormSubmitFunction);

        // })();










        const SaveValidator = new window.JustValidate('#SaveColorMaster', {
            validateBeforeSubmitting: true,
        });

        SaveValidator
            .addField('#add_color', [{
                    rule: 'required',
                },
                {
                    rule: 'minLength',
                    value: 3,
                },
                {
                    rule: 'maxLength',
                    value: 15,
                },
            ]).addField('#add_color_image', [
                {
                    rule: 'files',
                    value: {
                        files: {
                            extensions: ['jpeg', 'jpg', 'png'],
                            maxSize: 20000,
                            //minSize: 10000,
                            types: ['image/jpeg', 'image/jpg', 'image/png'],
                        },
                    },
                    errorMessage: 'Image size must be less than 100Kb and only support .jpg,.png',
                },
            ]).onSuccess((event) => {
                //console.log('Validation passes and form submitted', event);
                FormSubmitFunction('SaveColorMaster');
            });









        const UpdateForm = document.getElementById("UpdateColorMaster");
        UpdateForm.addEventListener('submit', FormSubmitFunction);


        function FormSubmitFunction(FormId) {
            //e.preventDefault();
            //console.log("Hello");
            const FormSubmitData = new FormData(document.getElementById(FormId));
            fetch('MasterOperations.php', {
                method: "POST",
                body: FormSubmitData,
            }).then((response) => {
                console.log(response);
                if (response.status === 200) {
                    swal("Success", response.statusText, "success");
                    return response.json();
                } else if (response.status === 431 || response.status === 432) {
                    swal("Warning", response.statusText, "warning"); // Record Already exists or In use
                } else if (response.status === 401 || response.status === 404 || response.status === 405) {
                    swal("Error", response.statusText, "error"); // Basic Errors
                } else if (response.status === 500) {
                    swal("Server Error", response.statusText, "error"); // Server Error
                } else if (response.status === 433) {
                    swal("Data Error", response.statusText, "error"); // Record Not Found
                } else if (response.status === 434) {
                    swal("Data Error", response.statusText, "error"); // Failed Adding Record
                } else {
                    swal("Potential Error", "Some Error Occured ! Please Refresh The Page To Continue", "error");
                    console.log([response.status, response.statusText]);
                }
            }).then((data) => {
                console.log(data);
            }).catch((error) => {
                swal("Potential Error", "Some Error Occured ! Please Refresh The Page To Continue", "error");
            });
        }

        // SaveForm.addEventListener('submit',function(e) {
        //     e.preventDefault();
        //     //console.log("Hello");
        //     const FormData = new FormData(this);
        //     fetch('MasterOperations.php',{
        //         method:"POST",
        //         body:FormData,
        //     }).then((response) => {
        //         console.log(response);
        //         if(response.status === 200){
        //             swal("Success", response.statusText, "success");
        //             return response.json();
        //         }else if(response.status === 431 || response.status === 432){
        //             swal("Warning", response.statusText, "warning"); // Record Already exists or In use
        //         }else if(response.status === 401 || response.status === 404 || response.status === 405){
        //             swal("Error", response.statusText, "error"); // Basic Errors
        //         }else if(response.status === 500){
        //             swal("Server Error", response.statusText, "error"); // Server Error
        //         }else if(response.status === 433){
        //             swal("Data Error", response.statusText, "error"); // Record Not Found
        //         }else if(response.status === 434){
        //             swal("Data Error", response.statusText, "error"); // Failed Adding Record
        //         }else{
        //             swal("Potential Error", "Some Error Occured ! Please Refresh The Page To Continue", "error");
        //             console.log([response.status,response.statusText]);
        //         }
        //     }).then((data) => {
        //         console.log(data);
        //     }).catch((error) => {
        //         swal("Potential Error", "Some Error Occured ! Please Refresh The Page To Continue", "error");
        //     });

        // })























        // //Add Master
        // $(function() {

        //     let validator = $('#AddColorMaster').jbvalidator({
        //         //language: 'dist/lang/en.json',
        //         successClass: false,
        //         html5BrowserDefault: true
        //     });

        //     validator.validator.custom = function(el, event) {
        //         if ($(el).is('#add_color') && $(el).val().trim().length == 0) {
        //             return 'Cannot be empty';
        //         }
        //     }
        //     $(document).on('submit', '#AddColorMaster', (function(a) {
        //         a.preventDefault();
        //         var ColorData = new FormData(this);
        //         //console.log(ProductTypedata);
        //         $.ajax({
        //             type: "POST",
        //             url: "MasterOperations.php",
        //             data: ColorData,
        //             beforeSend: function() {
        //                 //NProgress.start();
        //             },
        //             success: function(data) {
        //                 console.log(data);
        //                 //NProgress.done();
        //                 var response = JSON.parse(data);
        //                 if (response.Status == "1") {
        //                     $('#AddColorMaster')[0].reset();
        //                     swal("Success", response.Message, "success");
        //                     MasterTable.ajax.reload(null, false);
        //                 } else if (response.Status == "0") {
        //                     swal("Warning", response.Message, "warning");
        //                 } else if (response.Status == "2") {
        //                     swal("Error", response.Message, "error");
        //                 } else {
        //                     swal("Some Error Occured!!!", "Please Try Again", "error");
        //                 }
        //             },
        //             error: function() {
        //                 swal("Some Error Occured!!!", "Please Refresh The Page...", "error");
        //             },
        //             cache: false,
        //             contentType: false,
        //             processData: false
        //         });
        //     }));

        // });


        // //Update Master
        // $(function() {

        //     let validator = $('#UpdateColorMaster').jbvalidator({
        //         //language: 'dist/lang/en.json',
        //         successClass: false,
        //         html5BrowserDefault: true
        //     });

        //     validator.validator.custom = function(el, event) {
        //         if ($(el).is('#update_product_type') && $(el).val().trim().length == 0) {
        //             return 'Cannot be empty';
        //         }
        //     }

        //     $(document).on('submit', '#UpdateColorMaster', (function(a) {
        //         a.preventDefault();
        //         var UpdateColorData = new FormData(this);
        //         //console.log(UpdateColorData);
        //         $.ajax({
        //             type: "POST",
        //             url: "MasterOperations.php",
        //             data: UpdateColorData,
        //             beforeSend: function() {

        //             },
        //             success: function(data) {
        //                 console.log(data);
        //                 var UpdateResponse = JSON.parse(data);
        //                 if (UpdateResponse.Status == "1") {
        //                     swal("Success", UpdateResponse.Message, "success");
        //                     $('#UpdateColorMaster')[0].reset();
        //                     $('#AddColorMaster').show();
        //                     $('#UpdateColorMaster').hide();
        //                     MasterTable.ajax.reload(null, false);
        //                 } else if (UpdateResponse.Status == "0") {
        //                     swal("Warning", UpdateResponse.Message, "warning");
        //                 } else if (UpdateResponse.Status == "2") {
        //                     swal("Error", UpdateResponse.Message, "error");
        //                 } else {
        //                     swal("Some Error Occured!!!", "Please Try Again", "error");
        //                 }
        //             },
        //             error: function() {
        //                 swal("Some Error Occured!!!", "Please Refresh The Page...", "error");
        //             },
        //             cache: false,
        //             contentType: false,
        //             processData: false
        //         });
        //     }));

        // });


        // //Edit Master
        // $('#MasterTable tbody').on('click', '.edit_btn', (function() {
        //     var EditColorId = $(this).val();
        //     //console.log(EditColorId);
        //     $.ajax({
        //         method: "POST",
        //         url: "MasterOperations.php",
        //         data: {
        //             EditColorId: EditColorId
        //         },
        //         beforeSend: function() {
        //             $('#UpdateColor').addClass("disable");
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             var EditResponse = JSON.parse(data);
        //             if (EditResponse.Status == '1') {
        //                 $('#AddColorMaster').hide();
        //                 $('#UpdateColorMaster').show();
        //                 $('#update_color').val(EditResponse.ColorName);
        //                 $('#update_color_id').val(EditColorId);
        //             } else {
        //                 swal("Warning", EditResponse.Message, "warning");
        //             }
        //         },
        //         error: function() {
        //             swal("Some Error Occured!!!", "Please Refresh The Page...", "error");
        //         }
        //     })
        // }));


        // //Delete Master
        // $('#MasterTable tbody').on('click', '.delete_btn', (function() {
        //     var DeleteColorId = $(this).val();
        //     swal({
        //             title: "Are you sure?",
        //             text: "Once deleted, you will not be able to recover this.",
        //             icon: "warning",
        //             buttons: true,
        //             dangerMode: true,
        //         })
        //         .then((willDelete) => {
        //             if (willDelete) {
        //                 $.ajax({
        //                     method: "POST",
        //                     url: "MasterOperations.php",
        //                     data: {
        //                         DeleteColorId: DeleteColorId
        //                     },
        //                     beforeSend: function() {
        //                         $('#AddColor').addClass("disable");
        //                     },
        //                     success: function(data) {
        //                         console.log(data);
        //                         var DeleteResponse = JSON.parse(data);
        //                         if (DeleteResponse.Status == "1") {
        //                             swal("Success", DeleteResponse.Message, "success");
        //                             MasterTable.ajax.reload(null, false);
        //                         } else if (DeleteResponse.Status == "0") {
        //                             swal("Warning", DeleteResponse.Message, "warning");
        //                             toastr.warning(DeleteResponse.Message);
        //                         } else if (DeleteResponse.Status == "2") {
        //                             swal("Error", DeleteResponse.Message, "error");
        //                         } else {
        //                             swal("Some Error Occured!!!", "Please Try Again", "error");
        //                         }
        //                     },
        //                     error: function() {
        //                         swal("Some Error Occured!!!", "Please Refresh The Page...", "error");
        //                     }
        //                 });
        //             } else {
        //                 //swal("Cancelled");
        //             }
        //         });
        // }));


        //////////////////////////////  COLOR MASTER   \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    </script>


    <?php
    include "../MAIN/Footer.php";
    ?>


</body>

</html>