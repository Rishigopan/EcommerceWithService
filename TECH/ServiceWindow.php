<?php

require "../MAIN/Dbconn.php";
include "../ADMIN/CommonFunctions.php";

// if(isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])){

//     if($_COOKIE['custtypecookie'] != 'technician' ){
//         header("location:../login.php");
//     }
//     else{

//     } 
// }
// else{
//     header("location:../login.php");
// }


if (isset($_GET['ServiceOrderId'])) {
    $ServiceOrderId = $_GET['ServiceOrderId'];
} else {
    $ServiceOrderId = 0;
}



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
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid ">
                <button class="btn shadow-none" type="button" onclick="history.back();"><i class="material-icons">west</i></button>
                <a class="navbar-text me-auto">
                    <h5>Service Window</h5>
                </a>
                <a href="../profile.php">
                    <i class="material-icons">account_circle</i>
                </a>
            </div>
        </nav>

      


        <!--CONTENT-->
        <div id="Content" class="mb-5 allservice">

            <div class="container-fluid" id="serice_window_section">





            </div>


        </div>

    </div>



    <script>
        function ShowServiceWindow(ServiceOrderId) {
            $.ajax({
                method: "POST",
                url: "ServiceWindowData.php",
                data: {
                    ShowServiceWindow: ServiceOrderId
                },
                success: function(data) {
                    $('#serice_window_section').html(data);
                }
            });
        }


        var ServiceOrderId = '<?= $ServiceOrderId ?>';
        if (ServiceOrderId != 0) {
            ShowServiceWindow(ServiceOrderId);
        } else {

        }


        //START DIAGNOSIS
        $(document).on('click', '#start_diagnosis', function() {
            var StartDiagnosis = $(this).val();
            swal({
                    title: "Start Diagnosis?",
                    text: "Once started, you will not be able to return to previous state.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: "POST",
                            url: "../ADMIN/AdminServiceOperations.php",
                            data: {
                                StartDiagnosis: StartDiagnosis
                            },
                            success: function(data) {
                                console.log(data);
                                var Response = JSON.parse(data);
                                if (Response.Status == true) {
                                    swal("Success", Response.Message, "success");
                                    ShowServiceWindow(ServiceOrderId);
                                } else if(Response.Status == false) {
                                    if(Response.Code == 431){
                                        swal("", {
                                            closeOnEsc: false,
                                            closeOnClickOutside: false,
                                            icon: "warning",
                                            title: Response.Message,
                                            buttons: {
                                                //cancel: "cancel",
                                                Confirm: true,
                                            },
                                        })
                                        .then((value) => {
                                            switch (value) {
                                                case "Confirm":
                                                    location.replace('TechnicianServices.php');
                                                    break;
                                                default:
                                            }
                                        });
                                    }else{
                                        swal("Error", Response.Message, "error");
                                    }
                                }else{
                                    swal("Some Error Occured!!!", "Please Refresh The Page...", "error");
                                }
                            }
                        });
                    } else {
                        //swal("Cancelled");
                    }
                });
        });




        //START SERVICE AND SET DATE
        $(document).on('submit', '#StartService', function(g) {
            g.preventDefault();
            var StartService = new FormData(this);
            swal({
                    title: "Start Service?",
                    text: "Once started, you will not be able to return to previous state.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: "POST",
                            url: "../ADMIN/AdminServiceOperations.php",
                            data: StartService,
                            success: function(data) {
                                console.log(data);
                                var Response = JSON.parse(data);
                                if (Response.Status == true) {
                                    swal("Success", Response.Message, "success");
                                    ShowServiceWindow(ServiceOrderId);
                                }else if(Response.Status == false){
                                    if(Response.Code == 431){
                                        swal("", {
                                            closeOnEsc: false,
                                            closeOnClickOutside: false,
                                            icon: "warning",
                                            title: Response.Message,
                                            buttons: {
                                                //cancel: "cancel",
                                                Confirm: true,
                                            },
                                        })
                                        .then((value) => {
                                            switch (value) {
                                                case "Confirm":
                                                    location.replace('TechnicianServices.php');
                                                    break;
                                                default:
                                            }
                                        });
                                    }else{
                                        swal("Error", Response.Message, "error");
                                    }
                                }else {
                                    swal("Some Error Occured!!!", "Please Refresh The Page...", "error");
                                }
                            },
                            cache: false,
                            processData: false,
                            contentType: false
                        });
                    } else {
                        //swal("Cancelled");
                    }
                });

        });




        //START TESTING
        $(document).on('click', '#StartTesting', function() {
            var StartTestingOrderId = $(this).val();
            swal({
                    title: "Start Testing?",
                    text: "Once started, you will not be able to return to previous state.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: "POST",
                            url: "../ADMIN/AdminServiceOperations.php",
                            data: {
                                StartTesting: StartTestingOrderId
                            },
                            success: function(data) {
                                console.log(data);
                                var Response = JSON.parse(data);
                                if (Response.Status == true) {
                                    swal("Success", Response.Message, "success");
                                    ShowServiceWindow(ServiceOrderId);
                                }else if(Response.Status == false){
                                    if(Response.Code == 431){
                                        swal("", {
                                            closeOnEsc: false,
                                            closeOnClickOutside: false,
                                            icon: "warning",
                                            title: Response.Message,
                                            buttons: {
                                                //cancel: "cancel",
                                                Confirm: true,
                                            },
                                        })
                                        .then((value) => {
                                            switch (value) {
                                                case "Confirm":
                                                    location.replace('TechnicianServices.php');
                                                    break;
                                                default:
                                            }
                                        });
                                    }else{
                                        swal("Error", Response.Message, "error");
                                    }
                                } else {
                                    swal("Some Error Occured!!!", "Please Refresh The Page...", "error");
                                }
                            }
                        });
                    } else {
                        //swal("Cancelled");
                    }
                });
        });




        //FINISH SERVICE
        $(document).on('click', '#FinishService', function() {
            var FinishServiceOrderId = $(this).val();
            swal({
                    title: "Finished Service?",
                    text: "Before confirming, make sure you have  completed the diagnosis, service and testing process and ready to handover the device to the executive.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: "POST",
                            url: "../ADMIN/AdminServiceOperations.php",
                            data: {
                                FinishService: FinishServiceOrderId
                            },
                            success: function(data) {
                                console.log(data);
                                var Response = JSON.parse(data);
                                if (Response.Status == true) {
                                    swal("Success", Response.Message, "success").then(() => {
                                        location.href = 'TechnicianServices.php';
                                    });
                                    //ShowServiceWindow(ServiceOrderId);
                                }else if(Response.Status == false){
                                    if(Response.Code == 431){
                                        swal("", {
                                            closeOnEsc: false,
                                            closeOnClickOutside: false,
                                            icon: "warning",
                                            title: Response.Message,
                                            buttons: {
                                                //cancel: "cancel",
                                                Confirm: true,
                                            },
                                        })
                                        .then((value) => {
                                            switch (value) {
                                                case "Confirm":
                                                    location.replace('TechnicianServices.php');
                                                    break;
                                                default:
                                            }
                                        });
                                    }else{
                                        swal("Error", Response.Message, "error");
                                    }
                                } else {
                                    swal("Some Error Occured!!!", "Please Refresh The Page...", "error");
                                }
                            }
                        });
                    } else {
                        //swal("Cancelled");
                    }
                });
        });




        // //ADD SERVICE
        // $('#AddService').submit(function(e) {
        //     e.preventDefault();
        //     var A_data = $(this).serializeArray();
        //     //console.log(A_data);
        //     $.post(
        //         "techservice_data.php",
        //         A_data,
        //         function(A_data) {
        //             alert(A_data);
        //             location.reload();
        //         }
        //     );
        // });




        // //DELETE SERVICE
        // $('.delBtn').click(function() {
        //     var Del_id = $(this).val();
        //     //console.log(Del_id);
        //     $.ajax({
        //         method: "POST",
        //         url: "techservice_data.php",
        //         data: {
        //             Del_id: Del_id
        //         },
        //         success: function(data) {
        //             alert(data);
        //             location.reload();
        //         }
        //     });
        // });
    </script>
    <?php
    include "../MAIN/Footer.php";
    ?>
</body>

</html>