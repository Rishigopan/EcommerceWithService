<?php  $CurrentDate = date('Y-m-d'); ?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Select Date</title>

    <style>
        body {
            background-color: #e9e9e9;
        }

        #Content {
            margin-top: 4rem;
        }

        .navbar button i,
        .navbar a {
            color: white;
        }

        .card {
            border-radius: 10px;
            background-color: white;
        }

        #main_card {
            border-radius: 10px;
            border: none;
            background-color: white;
        }

        #main_list {
            height: 70vh;
            overflow-y: scroll;
        }

        #main_list::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */

        #main_list::-webkit-scrollbar-track {
            background: #e9e9e9;
            border-radius: 30px;
        }

        /* Handle */

        #main_list::-webkit-scrollbar-thumb {
            background: lightgray;
            border-radius: 30px;
        }

        /* Handle on hover */

        #sidenav {
            margin-top: 30px;
            margin-left: 15px;
        }

        #sidenav div {
            margin-top: 15px;
        }

        #sidenav .circle {
            width: 25px;
            height: 25px;
            background-color: grey;
            color: white;
            border-radius: 50%;
        }

        #sidenav div p span {
            line-height: 2px;
            margin-left: 8px;
        }

        .back {
            background-color: lightgrey;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease-out;
        }

        .next {
            background-color: #f50414;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease-out;
        }

        .back:hover {
            transform: translateY(-2px);
            box-shadow: 0px 3px 5px lightgrey !important;
            color: white;
        }

        .next:hover {
            transform: translateY(-2px);
            box-shadow: 0px 3px 5px #FF6464 !important;
            color: white;
        }

        .back i,
        .next i {
            margin-left: 5px;
            vertical-align: top;
            color: white;
        }

        .done {
            background-color: #f50414 !important;
            color: white;
        }

        .present {
            background-color: #FF7800 !important;
        }

        .right_col a {
            text-decoration: none;
            color: black;
        }

        #Time_select {
            max-width: 500px;
        }

        #Time_select .row .col-4 {
            padding: 5px 5px;
        }

        #Time_row input[type=radio] {
            display: none;
        }

        #Time_row input[type=radio]:checked+.time_label {
            border: 2px solid #f50414;
            background-color: #f5041448;
        }

        #Time_select .DisabledTime{
            pointer-events: none;
            opacity: 0.5;
        }

        .time_label {
            padding: 20px 0px;
            background-color: #e9e9e9;
            border: 2px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #calendar {
            margin-top: -50px;
            padding: 0px 0px;
        }

        @media screen and (max-width:480px) {
            #main_card {
                border-radius: 10px;
                border: none;
                background-color: white;
            }

            #sidenav div {
                margin-top: 0px;
            }

            #sidenav {
                margin-top: 10px;
                margin-left: 0px;
            }

            #main_list {
                height: initial;
                overflow-y: auto;
            }

            .service .image {
                height: 100px;
                width: 100%;
                background-image: url('../phonenotfound.svg');
                background-position: center;
                background-size: contain;
            }

            .service .types {
                width: 40%;
            }

            .time_label h6 {
                font-size: smaller;
            }
        }

        @media screen and (max-width:960px) {
            .service .image {
                height: 220px;
                width: 50%;
                background-image: url('../phonenotfound.svg');
                background-position: center;
                background-repeat: no-repeat;
                background-size: contain;
            }

            .service .types {
                width: 70%;
            }
        }

        @media screen and (min-width:961px) {
            .service .image {
                height: 300px;
                width: 100%;
                background-image: url('../phonenotfound.svg');
                justify-content: center;
                background-repeat: no-repeat;
                background-size: contain;
            }
        }
    </style>

</head>

<body>

    <div class="wrapper">
        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top py-0" style="background-color:#F50414;">
            <div class="container-fluid ">
                <div>
                    <a class="btn shadow-none" href="./LocationSelection.php"><i class="material-icons">west</i></a>
                    <img class="img-fluid py-2" src="../assets/img/techstop.webp" width="100px" height="30px">
                </div>
                <!-- <a class="navbar-text text-decoration-none d-md-flex d-none me-auto">
                    <h5>CONNECT MY MOBILE</h5>
                </a> -->
                <div class=" d-flex">
                    <button class="btn text-white shadow-none d-none d-sm-block" type="submit">
                        <i class="material-icons"> favorite_border</i>
                    </button>
                    <button class="btn text-white shadow-none" type="submit">
                        <i class="material-icons">account_circle</i>
                    </button>
                </div>
            </div>
        </nav>



        <!--CONTENT-->
        <div id="Content">
            <div class="container-fluid" id="main_container">
                <div class="row mb-3">

                    <div class="col-lg-9 col-12">
                        <div class="card card-body shadow-sm mb-5" id="main_card">
                            <form action="ServiceSession.php" method="POST">
                                <div class="row">
                                    <div class="col-12 col-md-3 col-lg-3">
                                        <div id="sidenav" class="d-flex d-md-block mb-md-0">
                                            <div class="d-flex  ">
                                                <p class="circle done"><span>1</span></p>
                                                <p class="ms-2 d-none d-md-block"><span class="d-none d-xl-inline-flex">Choose</span><span>Brand</span> </p>
                                            </div>
                                            <div class="d-flex ps-3 ps-md-0">
                                                <p class="circle done"><span>2</span></p>
                                                <p class="ps-2 d-none d-md-block"><span class="d-none d-xl-inline">Choose</span><span>Model</span></p>
                                            </div>
                                            <div class="d-flex ps-3 ps-md-0">
                                                <p class="circle done"><span>3</span></p>
                                                <p class="ps-2 d-none d-md-block"><span class="d-none d-xl-inline">Choose</span><span>Service</span></p>
                                            </div>
                                            <div class="d-flex ps-3 ps-md-0">
                                                <p class="circle done "><span>4</span></p>
                                                <p class="ps-2 d-none d-md-block"><span class="d-none d-xl-inline">Service</span><span>Location</span></p>
                                            </div>
                                            <div class="d-flex ps-3 ps-md-0">
                                                <p class="circle present"><span>5</span></p>
                                                <p class="ps-2 d-none d-md-block"><span class="d-none d-xl-inline">Schedule</span><span>Date</span></p>
                                            </div>
                                            <div class="d-flex ps-3 ps-md-0">
                                                <p class="circle"><span>6</span></p>
                                                <p class="ps-2 d-none d-md-block"><span class="d-none d-xl-inline">Personal</span><span>Information</span></p>
                                            </div>
                                            <div class="d-flex ps-3 ps-md-0">
                                                <p class="circle"><span>7</span></p>
                                                <p class="ps-2 d-none d-md-block"><span class="d-none d-xl-inline">Order</span><span>Confirm</span> </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-9 col-lg-9">
                                        <div>
                                            <h5 class="border-bottom pb-2">Schedule Date</h5>
                                        </div>

                                        <div id="main_list">

                                            <div class="row g-0 mt-3">
                                                <!-- <div class="col-12 col-md-6 pe-2 ps-3">
                                                    <input type="date" id="pick_date" name="Date_pick" class="form-control" required>
                                                </div> -->
                                                <div class="col-12 col-md-12 d-flex justify-content-center align-items-center ">
                                                    <div id="Time_select" class="card  mb-3">
                                                        <div class="card-header text-center" id="show_date">
                                                            <!-- 9-2-2022 -->
                                                            <input type="date" id="pick_date" name="Date_pick" placeholder="Choose A Day" class="form-control" required>
                                                        </div>
                                                        <div class="card-body">
                                                            <div id="Time_row" class="row">
                                                                <div class="col-6 mb-3">
                                                                    <input type="radio" id="time_1" name="time_radio" value="10AM - 12PM" required >
                                                                    <label for="time_1" class="w-100 text-center px-0 time_label <?=  (date('H') >= 12) ? "DisabledTime" : ""  ?>" >
                                                                        <h6 class="my-auto">10AM - 12PM </h6>
                                                                    </label>
                                                                </div>
                                                                
                                                                <div class="col-6 mb-3">
                                                                    <input type="radio" id="time_3" name="time_radio" value="12PM - 2PM">
                                                                    <label for="time_3" class="w-100 text-center px-0 time_label <?=  (date('H') >= 14) ? "DisabledTime" : ""  ?>">
                                                                        <h6 class="my-auto">12PM - 2PM</h6>
                                                                    </label>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <input type="radio" id="time_5" name="time_radio" value="2PM - 4PM">
                                                                    <label for="time_5" class="w-100 text-center px-0 time_label <?=  (date('H') >= 16) ? "DisabledTime" : ""  ?>">
                                                                        <h6 class="my-auto">2PM - 4PM</h6>
                                                                    </label>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <input type="radio" id="time_7" name="time_radio" value="4PM - 6PM">
                                                                    <label for="time_7" class="w-100 text-center px-0 time_label <?=  (date('H') >= 18) ? "DisabledTime" : ""  ?>">
                                                                        <h6 class="my-auto">4PM - 6PM</h6>
                                                                    </label>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <input type="radio" id="time_9" name="time_radio" value="6PM - 8PM">
                                                                    <label for="time_9" class="w-100 text-center px-0 time_label <?=  (date('H') >= 20) ? "DisabledTime" : ""  ?>">
                                                                        <h6 class="my-auto">6PM - 8PM</h6>
                                                                    </label>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <input type="radio" id="time_11" name="time_radio" value="8PM - 10PM">
                                                                    <label for="time_11" class="w-100 text-center px-0 time_label <?=  (date('H') >= 22) ? "DisabledTime" : ""  ?>">
                                                                        <h6 class="my-auto">8PM - 10PM</h6>
                                                                    </label>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="Page_nav " class="d-flex justify-content-between pt-3 px-4 ">
                                        <a class="btn shadow-none rounded-pill  back px-md-4 " href="LocationSelection.php">
                                            <i class="d-md-none material-icons">arrow_back_ios</i>
                                            <span class="d-none d-md-inline-block">BACK</span>
                                        </a>
                                        <button class="btn shadow-none rounded-pill next px-md-4 " type="submit" name="Date_btn">
                                            <i class="d-md-none material-icons">arrow_forward_ios</i>
                                            <span class="d-none d-md-inline-block">NEXT</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12 right_col">
                        <a href="">
                            <div class="card card-body shadow-sm service">
                                <div class="d-flex d-lg-block ">
                                    <div class="my-auto types">
                                        <h5 class="text-center pt-3">Worried, Your Phone or Service is not listed?</h5>
                                        <h6 class="text-center">Click here</h6>
                                    </div>
                                    <div class="image">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>




    <script>
        flatpickr("#pick_date", {
            // inline: true,
            minDate: "<?= $CurrentDate ?>",
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
        });
    </script>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js " integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM " crossorigin="anonymous "></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js " integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p " crossorigin="anonymous "></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js " integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF " crossorigin="anonymous "></script>
    -->
</body>

</html>