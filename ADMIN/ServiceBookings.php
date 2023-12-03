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
$PageTitle = 'ServiceBookings';
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
            <div class="container-fluid">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5>Service Bookings</h5>
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


        <!--FILTERS-->
        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Filters</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="container-fluid filter_all">

                    <div class="mb-3">
                        <h6>Service Mode</h6>
                        <div class="d-flex mt-3">
                            <div class=" me-3">
                                <input type="checkbox" class="btn-check comm_select delmode" value="Doorstep" id="btncheck1" autocomplete="off">
                                <label class="btn shadow-none rounded-pill py-1" for="btncheck1">Door Delivery</label>
                            </div>
                            <div class="">
                                <input type="checkbox" class="btn-check comm_select delmode" value="Shop" id="btncheck2" autocomplete="off">
                                <label class="btn shadow-none rounded-pill py-1" for="btncheck2">Shop Visit</label>
                            </div>
                        </div>
                    </div>



                    <h6>Sort By</h6>

                    <div class="mt-3 d-flex">
                        <div class="me-3">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                            <label class="btn shadow-none rounded-pill py-1" for="btnradio3">Recent</label>
                        </div>
                        <div class="me-3">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
                            <label class="btn shadow-none rounded-pill py-1" for="btnradio4">Oldest</label>
                        </div>
                    </div>

                    <div class="text-center py-3 mt-3 canvas_foot">
                        <button class="btn rounded-pill clear_all  btn_cart shadow-none me-5">Clear all</button>
                    </div>
                </div>
            </div>
        </div>





        <!--CONTENT-->
        <div id="Content" class="mb-5">


            <div class="container-fluid">


                <div class="row">
                    <div class="col-md-6 offset-lg-3 offset-md-3">
                        <div class="d-flex mx-1 mx-sm-0 ">
                            <input type="text" id="searchbox" class="search form-control py-1" placeholder="Type to search...">
                            <button class="btn btn_fill shadow-none rounded-circle py-1 ms-4 mx-sm-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"><i class='material-icons'>filter_list</i></button>
                        </div>
                    </div>
                </div>


                <div id="door_delivery" class="row my-2 service_cards">


                </div>

            </div>
        </div>

    </div>





    <script src="../JS/service_filters.js"></script>
    <script>
        $(document).ready(function() {

            $('.clear_all').click(function() {
                location.reload();
            });

            service_bookings();


            $('#searchbox').keyup(function() {
                var search = $(this).val();
                console.log(search);
                if (search != '') {
                    service_bookings(search);
                } else {
                    service_bookings();
                }
            });

            setInterval(function() {
                service_bookings();
            }, 10000);

        });



        //Assign technician 
        $('#door_delivery').on('submit', '.tech_form', function(m) {
            m.preventDefault();
            var techdata = new FormData(this);
            console.log(techdata);
            $.ajax({
                url: "ServiceOperations.php",
                type: "POST",
                data: techdata,
                success: function(data) {
                    console.log(data)
                    service_bookings();
                    toastr.success('Assigned technician');
                },
                cache:false,
                contentType:false,
                processData:false
            });
        });

        

        //Assign delivery agent 
        $('#door_delivery').on('submit', '.agent_form', function(g){
            g.preventDefault();
            var agentdata = new FormData(this);   
                $.ajax({
                url: "ServiceOperations.php",
                type: "POST",
                data: agentdata,
                success: function(data) {
                    console.log(data)
                    service_bookings();
                    toastr.success('Assigned Delivery Agent');
                },
                cache:false,
                contentType:false,
                processData:false
            });
        });

        
     


    </script>

    <?php
    include "../MAIN/Footer.php";
    ?>

</body>

</html>