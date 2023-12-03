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
    <title>Services</title>


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

        .brands {
            background-color: white;
            border: 2px solid #e9e9e9;
            border-radius: 10px;
            background-image: linear-gradient(315deg, #f6f6f6 0%, #e9e9e9 74%);
        }

        #main_card {
            border-radius: 10px;
            border: none;
            background-color: white;
        }

        #main_list {
            height: 450px;
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

        #main_list {
            height: 70vh;
            overflow-y: scroll;
        }

        .brand_list p {
            color: #f50414;
            font-weight: 500;
        }

        .brand_list li a {
            text-decoration: none;
            color: black
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

        .right_col a {
            text-decoration: none;
            color: black;
        }

        #services input[type=checkbox] {
            display: none;
        }

        #services input[type=checkbox]:checked+.service_check {
            border: 2px solid #f50414;
            background-color: #f5041448;
            border-radius: 10px;
            background-image: none;
        }

        .service_check {
            border: 2px solid #e9e9e9;
            padding: 10px 0px;
            border-radius: 10px;
            cursor: pointer;
            background-color: white;
            background-image: linear-gradient(315deg, #f6f6f6 0%, #e9e9e9 74%);
        }

        .service_check img {
            height: 2.5rem;
            width: 4rem;
            object-fit: contain;
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
                    <a class="btn shadow-none" href="./ModelSelection.php"><i class="material-icons">west</i></a>
                    <img class="img-fluid py-2" src="../assets/img/techstop.webp" width="100px" height="30px">
                </div>
                <a class="navbar-text text-decoration-none d-md-flex d-none me-auto">
                    <h5>TECHSTOP</h5>
                </a>

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
                                                <p class="circle present"><span>3</span></p>
                                                <p class="ps-2 d-none d-md-block"><span class="d-none d-xl-inline">Choose</span><span>Service</span></p>
                                            </div>
                                            <div class="d-flex ps-3 ps-md-0">
                                                <p class="circle "><span>4</span></p>
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
                                            <h5 class="border-bottom pb-2">Choose Services</h5>
                                        </div>
                                        <div id="main_list">
                                            <ul id="services" class=" brand_list list-unstyled pt-1">
                                                <?php $Model = $_SESSION['model_name'];

                                                $fetch_model_name = mysqli_query($con, "SELECT name FROM products WHERE pr_id = '$Model'");
                                                foreach ($fetch_model_name as $model_name) {
                                                    echo '<p class="ps-1">' . $model_name['name'] . '</p>';
                                                }
                                                ?>
                                                <?php
                                                $service_query = mysqli_query($con, "SELECT * FROM service_main sm INNER JOIN services sr ON sm.sr_id = sr.sr_id INNER JOIN products P ON sm.mo_id = P.pr_id WHERE sm.mo_id ='$Model'");
                                                if (mysqli_num_rows($service_query) > 0) {
                                                    while ($result = mysqli_fetch_array($service_query)) {
                                                        $sr_id = $result['sr_id'];
                                                ?>
                                                        <li class="mb-2 mx-1">
                                                            <input type="checkbox" id="<?php echo $result['sr_id']; ?>" name="services[]" value="<?php echo $result['main_id']; ?>">
                                                            <label class="service_check" for="<?php echo $result['sr_id']; ?>" style="width: 100%;">
                                                                <div class="d-flex justify-content-between">
                                                                    <div class="d-flex">
                                                                        <?php
                                                                        ?>
                                                                        <img src="../assets/img/SERVICE/<?php echo $result['service_img']; ?>" alt="Brand">
                                                                        <?php
                                                                        ?>
                                                                        <h6 class="ps-3 my-auto" style="max-width: 130px;"><?php echo $result['service_name']; ?></h6>
                                                                    </div>
                                                                    <h6 class="my-auto pe-3">&#x20b9 <?php echo number_format($result['cost']); ?></h6>
                                                                </div>
                                                            </label>
                                                        </li>
                                                <?php
                                                    }
                                                } else {
                                                    echo '<li><h6>No Services Found</h6></li>';
                                                }
                                                ?>


                                                <li class="mb-2 mx-1 mt-3 service_check">
                                                    <a href="tel:+917594858777" class="bg-info" >
                                                        <div class="text-center">
                                                            <h6 class="mb-3"> Worried Your Service Is Not Listed ? Our Service Executives Are Always Ready To Help You. </h6>
                                                            <a class="btn next rounded-pill text-white" href="tel:+917594858777"> Make A Call Now</a>
                                                        </div>
                                                    </a>
                                                </li>


                                            </ul>


                                        </div>
                                    </div>

                                    <div id="Page_nav " class="d-flex justify-content-between pt-3 px-4 ">
                                        <a class="btn shadow-none rounded-pill  back px-md-4 " href='ModelSelection.php'>
                                            <i class="d-md-none material-icons">arrow_back_ios</i>
                                            <span class="d-none d-md-inline-block">BACK</span>
                                        </a>
                                        <button class="btn shadow-none rounded-pill next px-md-4 " type="submit" name="Service_btn">
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
                        </a>
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