<!doctype html>
<html lang="en">
<?php 
    include '../MAIN/Dbconn.php';
    include './ServiceSession.php';
?>


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Brands</title>


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

        .service {
            background-color: white;
        }

        .brands img {
            height: 5rem;
            width: 7rem;
            object-fit: contain;
        }

        .brands {
            background-color: white;
            border: 2px solid #e9e9e9;
        }

        .brands:active {
            border: 2px solid #f50414;
            background-image: none !important;
            background-color: #f5041448 !important;
        }

        #main_card {
            border-radius: 10px;
            border: none;
            background-color: white;
        }

        #brand_list {
            height: 70vh;
            overflow-y: scroll;
        }

        #brand_list::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */

        #brand_list::-webkit-scrollbar-track {
            background: #e9e9e9;
            border-radius: 30px;
        }

        /* Handle */

        #brand_list::-webkit-scrollbar-thumb {
            background: lightgray;
            border-radius: 30px;
        }

        /* Handle on hover */

        #brand_list .card {
            border-radius: 10px;
            background-color: white;
            /* background-image: linear-gradient(315deg, #f6f6f6 0%, #e9e9e9 74%); */
        }

        #brand_list a {
            text-decoration: none;
            color: black;
        }

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

            #brand_list {
                height: initial;
                overflow-y: auto;
            }

            .service .image {
                height: 100px;
                width: 100%;
                background-image: url('./phonenotfound.svg');
                background-position: center;
                background-size: contain;
            }

            .service .types {
                width: 40%;
            }
        }

        @media screen and (max-width:960px) {
            .service .image {
                height: 220px;
                width: 50%;
                background-image: url('./phonenotfound.svg');
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
        <nav class="navbar shadow-sm fixed-top p-0" style="background-color:#f50414;">
            <div class="container-fluid">
                <div>
                    <a class="btn shadow-none" href="../index.php"><i class="material-icons">west</i></a>
                    <img class="img-fluid py-2" src="../assets/img/techstop.webp" width="100px" height="30px">
                </div>

                <!-- <a class="navbar-text text-decoration-none d-md-flex d-none me-auto">
                    <h5>CONNECT MY MOBILE</h5>
                </a> -->
                <button class="btn shadow-none" type="">
                    <i class="material-icons">notifications</i>
                </button>
            </div>
        </nav>



        <!--CONTENT-->
        <div id="Content">
            <div class="container-fluid" id="main_container">
                <div class="row mb-3">

                    <div class="col-lg-9 col-12">
                        <div class="card card-body shadow-sm mb-5" id="main_card">
                            <div class="row">
                                <div class="col-12 col-md-3 col-lg-3">
                                    <div id="sidenav" class="d-flex d-md-block mb-md-0">
                                        <div class="d-flex  ">
                                            <p class="circle present"><span>1</span></p>
                                            <p class="ms-2 d-none d-md-block"><span class="d-none d-xl-inline-flex">Choose</span><span>Brand</span> </p>
                                        </div>
                                        <div class="d-flex ps-3 ps-md-0">
                                            <p class="circle"><span>2</span></p>
                                            <p class="ps-2 d-none d-md-block"><span class="d-none d-xl-inline">Choose</span><span>Model</span></p>
                                        </div>
                                        <div class="d-flex ps-3 ps-md-0">
                                            <p class="circle"><span>3</span></p>
                                            <p class="ps-2 d-none d-md-block"><span class="d-none d-xl-inline">Choose</span><span>Service</span></p>
                                        </div>
                                        <div class="d-flex ps-3 ps-md-0">
                                            <p class="circle"><span>4</span></p>
                                            <p class="ps-2 d-none d-md-block"><span class="d-none d-xl-inline">Service</span><span>Location</span></p>
                                        </div>
                                        <div class="d-flex ps-3 ps-md-0">
                                            <p class="circle"><span>5</span></p>
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
                                        <h5 class="border-bottom pb-2">Choose Brand</h5>
                                    </div>
                                    <div class=" row  mx-md-0 pt-3" id="brand_list">
                                        <?php

                                        // if($_GET['SRID']){
                                        //     $ServiceId = $_GET['SRID'];
                                        // }
                                        // else{
                                        //     $ServiceId = 0;
                                        // }
                                        if(($_SESSION['ServiceSelected']) != ''){
                                            $ServiceId = $_SESSION['ServiceSelected'];
                                        }
                                        else{
                                            $ServiceId = 0;
                                        }

                                        
                                        $brand_query = mysqli_query($con, "SELECT B.br_id,B.brand_img,B.brand_name FROM  brands B WHERE isService = 'YES' ORDER BY B.brand_name ASC");
                                        if (mysqli_num_rows($brand_query) > 0) {
                                            foreach ($brand_query as $brands) {
                                        ?>
                                                <div class="col-6 col-md-4 col-xl-3">
                                                    <a href="ServiceSession.php?Brand=<?= $brands['br_id']; ?>&ServiceType=<?= $ServiceId ?>">
                                                        <div class="card card-body brands mb-3 ">
                                                            <div class="d-block text-center ">
                                                                <img src="../assets/img/BRAND/<?php echo $brands['brand_img']; ?>" alt="Brand ">
                                                                <h6 class=" "><?php echo $brands['brand_name']; ?></h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                        <?php
                                            }
                                        } else {
                                            echo '<h4>No Records Found</h4>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div id="Page_nav " class="d-flex justify-content-between pt-3 px-4 ">
                                    <button class="btn shadow-none rounded-pill  back px-md-4 " type="submit">
                                        <i class="d-md-none material-icons">arrow_back_ios</i>
                                        <span class="d-none d-md-inline-block">BACK</span>
                                    </button>
                                    <button class="btn shadow-none rounded-pill next px-md-4 " type="submit">
                                        <i class="d-md-none material-icons">arrow_forward_ios</i>
                                        <span class="d-none d-md-inline-block">NEXT</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12 ">
                        <div class="card card-body shadow-sm service ">
                            <div class="d-flex d-lg-block">
                                <div class="my-auto types">
                                    <h5 class="text-center pt-3">Worried, Your Phone or Service is not listed?</h5>
                                    <h6 class="text-center">Click here</h6>
                                </div>
                                <div class="image">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>



    <script>
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