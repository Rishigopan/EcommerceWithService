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
    <link rel="stylesheet" href="Sidebar.css">

    <title>Shipping</title>

    <style>
        body {
            background-color: #eeeeee;
        }

        #Content {
            margin-top: 4rem;
        }

        .navbar button i,
        .navbar a {
            color: white;
        }

        .navbar input {
            width: 20rem;
        }

        .card {
            border-radius: 10px;
            background-color: white !important;
        }

        .card ul li img {
            margin: 5px 0px;
            height: 60px;
            width: 100px;
            object-fit: contain;
        }

        .btn_cart {
            color: white;
            background-color: #F50414;
            font-weight: 500;
            transition: all 0.3s ease-out;
        }

        .btn_cart:hover {
            transform: translateY(-2px);
            color: white;
            box-shadow: 0px 3px 5px #FF6464 !important;
        }

        .back_btn {
            color: black;
            background-color: lightgrey;
            font-weight: 500;
            transition: all 0.3s ease-out;
        }

        .back_btn:hover {
            transform: translateY(-2px);
            box-shadow: 0px 3px 5px rgb(160, 159, 159) !important;
        }

        form .row input,
        form .row select,
        form .row textarea {
            border-radius: 10px !important;
            box-shadow: none !important;
        }

        form .row input:focus,
        form .row select:focus,
        form .row textarea:focus {
            border: 1px solid #F50414;
        }

        form .row label {
            color: #F50414;
        }

        @media only screen and (max-width: 480px) {
            .navbar input {
                width: 10rem;
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
                    <a class="btn shadow-none" href="./FillInformation.php"><i class="material-icons">west</i></a>
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
        <div id="Content" class="mb-5">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-lg-7 col-12  order-lg-1 order-1">
                        <div class="card card-body shadow-sm">

                            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="DateSelection.php">Service</a></li>
                                    <li class="breadcrumb-item"><a href="FillInformation.php">Information</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Payment</li>
                                </ol>
                            </nav>

                            <h5>Payment details</h5>
                            <form action="ServiceSession.php" id="Details" method="POST" class="mt-2 px-3">
                                <div class="card card-body">
                                    <div class="d-lg-flex d-md-block ">
                                        <h6 class="">Ship to</h6>
                                        <p class="ms-4 m-0"><?php echo $_SESSION['Cname']; ?> , <?php echo $_SESSION['Caddress']; ?> , <?php echo $_SESSION['Ccity']; ?> , <?php echo $_SESSION['Cstate']; ?> , <?php echo $_SESSION['Cpincode']; ?></p>
                                    </div>
                                </div>
                                <div class="card card-body mt-4 p-0">
                                    <div class="form-check-inline px-3 pt-3">
                                        <input type="radio" name="mode" id="Cod" class="form-check-input" value="COD" checked>
                                        <label for="Cod" class="form-check-label ps-4">Cash On Delivery</label>
                                        <span>( Pay using cash upon delivery)</span>
                                    </div>
                                    <div class="form-check-inline px-3 pt-3">
                                        <input type="radio" name="mode" id="gate" class="form-check-input" value="RAZOR">
                                        <label for="gate" class="form-check-label ps-4">Choose Payment Gateway</label>
                                        <span>( Razor pay)</span>
                                    </div>
                                    <hr>
                                    <p class="px-3">Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="">privacy policy</a>.</p>
                                </div>
                                <div class="d-flex justify-content-between mt-3 mb-3">
                                    <a href="FillInformation.php" class="btn shadow-none rounded-pill back_btn"><span class="d-none d-md-inline-flex">Back to</span> Information</a>
                                    <button class="btn shadow-none rounded-pill btn_cart" name="Pay_btn" type="submit"> <span class="d-none d-md-inline-flex">Continue to </span> Payment</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-5 col-12 order-lg-2 order-2 mt-4 mt-lg-0">

                        <div class="card card-body shadow-sm">
                            <?php
                            $brand = $_SESSION['brand_name'];
                            $model = $_SESSION['model_name'];

                            $fetch_model_name = mysqli_query($con, "SELECT model_name FROM models WHERE mo_id = '$model'");
                            foreach ($fetch_model_name as $model_name) {
                                echo '<h5 class="border-bottom pb-2">' . $model_name['model_name'] . '</h5>';
                            }
                            ?>
                            <ul class="list-unstyled">
                                <?php
                                foreach ($_SESSION['service_check'] as $ids) {
                                    $newquery = mysqli_query($con, "SELECT service_name,service_img,cost FROM service_main sm INNER JOIN services sr ON sm.sr_id = sr.sr_id WHERE sm.main_id = '$ids'");
                                    while ($result = mysqli_fetch_array($newquery)) {
                                ?>
                                        <li class="border-bottom pb-2">
                                            <div class="d-flex">
                                                <img src="../assets/img/SERVICE/<?php echo $result["service_img"]; ?>" alt="<?php echo  $result['service_name']; ?>">
                                                <div class="w-100 pe-3">
                                                    <div class="d-md-flex d-block justify-content-between mt-md-3 mt-2">
                                                        <h6 class=""><?php echo $result['service_name']; ?></h6>
                                                        <h6 class=""> &#8377; <?php echo number_format($result['cost']); ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                <?php
                                    }
                                }
                                $serviceID = implode("','", $_SESSION['service_check']);
                                // echo $serviceID;
                                $sumquery = mysqli_query($con, "SELECT SUM(cost) FROM service_main WHERE main_id IN('" . $serviceID . "')");
                                while ($sumresult = mysqli_fetch_array($sumquery)) {
                                    $total =  $sumresult['SUM(cost)'];
                                }
                                ?>
                            </ul>

                            <div class="d-flex justify-content-between px-3">
                                <h6>Subtotal</h6>
                                <h6>&#8377; <?php echo number_format($total); ?></h6>
                            </div>
                            <div class="d-flex justify-content-between px-3">
                                <h6>Tax</h6>
                                <h6>&#8377; 0</h6>
                            </div>
                            <div class="d-flex justify-content-between px-3">
                                <h5>Total</h5>
                                <h5>&#8377; <?php echo number_format($total); ?></h5>
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