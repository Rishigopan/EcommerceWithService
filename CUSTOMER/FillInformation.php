<!doctype html>
<html lang="en">


<?php

include '../MAIN/Dbconn.php';
include './ServiceSession.php';

// if(!isset($_COOKIE['custnamecookie']) && !isset($_COOKIE['custidcookie'])){

// header("location:../login.php");

// }
// else{

// $cust_id = $_COOKIE['custidcookie'];
// }


?>

<head>
    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- ICONS -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!-- JQUERY SCRIPT -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


    <!-- JB VALIDATOR SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>




    <title>Checkout</title>


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

        @media only screen and (max-width: 600px) {
            .navbar input {
                width: 10rem;
            }
        }

        #main_box {
            height: 500px;
            max-width: 800px;
            width: 100%;
            background: white;
            border: none;
            border-radius: 0px;
        }

        #first_box {
            align-items: center;
            display: flex;
            height: 500px;
        }

        #second_box {
            height: 500px;
            background-color: #EEEEEE;
            justify-content: center;
        }

        #second_box form {
            margin-top: 75px;
        }

        #main_box input {
            border: none !important;
            background-color: #EEEEEE !important;
            border-bottom: 2px solid #FF6464 !important;
            border-radius: 0px !important;
        }

        .input-group i {
            color: #FF6464;
        }

        #second_box p a {
            text-decoration: none;
            color: #FF6464;
        }

        #second_box button {
            background-color: #FF6464;
            color: white;
        }

        #login {
            background-color: #FF6464;
            color: white;
        }
    </style>

</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="LoginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="main_box" class="card card-body shadow p-0">
                    <div class="row g-0">
                        <div id="second_box" class="col-md-12 col-12">


                            <form action="" id="loginform" class="px-3">
                                <h3 class="mb-4">Login</h3>
                                <div class="input-group mb-3">
                                    <span style="position:absolute; margin-left: 10px; margin-top:6px; z-index: 99;">
                                        <i class="fas fa-at fa-sm"></i>
                                    </span>
                                    <input type="text" name="username" class="form-control shadow-none" placeholder="Enter Email/Phone  " style="padding-left: 35px;" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span style="position:absolute; margin-left: 10px; margin-top:6px; z-index: 99;">
                                        <i class="fas fa-key fa-sm"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control shadow-none" placeholder="Enter Password" style="padding-left: 35px;" required>
                                </div>

                                <div id="message">

                                </div>
                                <button id="login" class="btn mt-3" type="submit" style="width:100%">Login</button>

                                <p class="mt-3">Don't have an account? <a href="signup.php" id="SignupLink">Sign up</a></p>
                            </form>


                            <form action="" id="signupform" class="px-3" style="display:none;">
                                <h3 class="mb-4">Sign up</h3>
                                <div class="input-group mb-3">
                                    <span style="position:absolute; margin-left: 10px; margin-top:6px; z-index: 99;">
                                        <i class="fas fa-at fa-sm"></i>
                                    </span>
                                    <input type="text" name="SignupUsername" class="form-control shadow-none" placeholder="Enter Username" style="padding-left: 35px;" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span style="position:absolute; margin-left: 10px; margin-top:6px; z-index: 99;">
                                        <i class="fas fa-key fa-sm"></i>
                                    </span>
                                    <input type="password" name="SignupPassword" class="form-control shadow-none" placeholder="Enter Password" style="padding-left: 35px;" required>
                                </div>

                                <div id="signup_message">

                                </div>
                                <button id="signup" class="btn mt-3" type="submit" style="width:100%">Create Account</button>

                                <p class="mt-3">Already have an account? <a href="login.php" id="LoginLink">Login</a></p>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper">

        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top py-0" style="background-color:#F50414;">
            <div class="container-fluid ">

                <div>
                    <a class="btn shadow-none" href="./DateSelection.php"><i class="material-icons">west</i></a>
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
        <div id="Content" class="mb-5" style="margin-top: 100px;">
            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-7 col-12  order-lg-1 order-1">
                        <div class="card card-body shadow-sm">

                            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="DateSelection.php">Service</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Information</li>
                                </ol>
                            </nav>

                            <h5>Personal Details</h5>
                            <?php
                            if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {
                                $custid = $_COOKIE['custidcookie'];
                                $fetch_details_query = mysqli_query($con, "SELECT first_name,last_name,phone_number,email_id,address_detailed,city,state,pincode FROM user_details WHERE user_id = '$custid'");
                                foreach ($fetch_details_query as $details) {
                            ?>
                                    <form action="ServiceSession.php" method="POST" id="Details" class=" px-3">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <label for="first_name" class="form-label">Name</label>
                                                <input type="text" id="first_name" name="cust_name" class="form-control" placeholder="Enter Name" value="<?php echo $details['first_name']; ?>" required>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2 mt-md-0">
                                                <label for="mobile" class="form-label">Phone Number</label>
                                                <input type="text" id="mobile" name="cust_phone" class="form-control" placeholder="Enter Phone Number" value="<?php echo $details['phone_number']; ?>"  required>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <label for="email" class="form-label">Email Id</label>
                                                <input type="email" id="email" name="cust_email" class="form-control" placeholder="Enter Email Id" value="<?php echo $details['email_id']; ?>"  required>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <label for="Nearby_center" class="form-label">Nearby Service Center</label>
                                                <select name="service_center" id="Nearby_center" class="form-select">
                                                    <option value="kazhakootam">kazhakootam</option>
                                                </select>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="address" class="form-label">Your Address</label>
                                                <input type="text" id="address" name="cust_address" class="form-control" placeholder="Enter Address" value="<?php echo $details['address_detailed']; ?>" required>
                                            </div>
                                            <div class="col-12 col-md-4 mt-2">
                                                <label for="city" class="form-label">City</label>
                                                <select name="cust_city" id="city" class="form-select">
                                                    <option value="Trivandrum">Trivandrum</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-4 mt-2">
                                                <label for="center" class="form-label">State</label>
                                                <select name="cust_state" id="center" class="form-select">
                                                    <option value="Kerala">Kerala</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-4 mt-2">
                                                <label for="pincode" class="form-label">Pincode</label>
                                                <input type="text" name="cust_pincode" id="pincode" class="form-control" placeholder="Enter Pincode" value="<?php echo $details['pincode']; ?>" placeholder="Enter Pincode" required>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="details" class="form-label">Order Details</label>
                                                <textarea name="add_details" id="details" cols="3" rows="3" class="form-control shadow-none" placeholder="Additional notes about your order e.g:- delivery notes"></textarea>
                                            </div>
                                            <div class="d-flex justify-content-between mt-3 mb-3">
                                                <a href="DateSelection.php" class="btn shadow-none rounded-pill back_btn px-md-4"> <span class="d-none d-md-inline-flex">Back to</span> Service</a>
                                                <button class="btn shadow-none rounded-pill btn_cart " name="Info_btn" type="submit"> <span class="d-none d-md-inline-flex">Continue to </span> Payment</button>
                                            </div>
                                        </div>
                                    </form>
                            <?php
                                }
                            }

                            ?>
                        </div>
                    </div>
                    

                    <div class="col-lg-5 col-12 order-lg-2 order-2 mt-3 mt-lg-0">

                        <div class="card card-body shadow-sm">
                            <?php
                            $brand = $_SESSION['brand_name'];
                            $model = $_SESSION['model_name'];

                            $fetch_model_name = mysqli_query($con, "SELECT name FROM products WHERE pr_id = '$model'");
                            foreach ($fetch_model_name as $model_name) {
                                echo '<h5 class="border-bottom pb-2">' . $model_name['name'] . '</h5>';
                            }
                            ?>
                            <ul class="list-unstyled">
                                <?php
                                foreach ($_SESSION['service_check'] as $ids) {
                                    $newquery = mysqli_query($con, "SELECT * FROM service_main sm INNER JOIN services sr ON sm.sr_id = sr.sr_id WHERE sm.main_id = '$ids' ");
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
                                <h6>Delivery Charge</h6>
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


    </div>






    <script>

        $('#SignupLink').click(function(e){
            e.preventDefault();
            $('#loginform').hide();
            $('#signupform').show();
        });

        $('#LoginLink').click(function(e){
            e.preventDefault();
            $('#signupform').hide();
            $('#loginform').show();
        });



        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }


        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }


        $(document).ready(function() {
            TestAuth();

            function TestAuth() {
                let CustNameCookie = getCookie("custnamecookie");
                let CustTypeCookie = getCookie("custtypecookie");
                if (CustNameCookie == '' && CustTypeCookie == '') {
                    //console.log('Not authenticated');
                    $('#LoginModal').modal('show');
                } else {
                    //console.log('Authenticated');
                }
            }


            $('#loginform').submit(function(e) {
                e.preventDefault();
                var form = $(this).serializeArray();
                console.log(form);
                $.post(
                    "../login_verify.php",
                    form,
                    function(form) {
                        $('#message').show();
                        $('#message').html(form);
                        //console.log("hello");
                        var response = JSON.parse(form);
                        if (response.success == "1") {
                            $('#message').hide();
                            //alert("admin");
                            //location.href = "./ADMIN/Service.php"; 
                            location.reload();
                        } else if (response.success == "2") {
                            $('#message').hide();
                            //alert("customer");
                            //location.href = "./CUSTOMER/Ecommerce.php";
                            //history.go(-1);
                            //location.reload();
                            location.reload();
                        } else if (response.success == "3") {
                            $('#message').hide();
                            //alert("delivery");
                            //location.href = "./DELIVERY/Delivery Screen.php";
                        } else if (response.success == "4") {
                            $('#message').hide();
                            //alert("technician");
                            //location.href = "./TECH/technician_allservices.php";
                        } else if (response.success == "5") {
                            $('#message').hide();
                            //alert("executive");
                            //location.href = "./ADMIN/Service.php";
                        } else {

                        }

                    }
                );
            });


            $('#signupform').submit(function(e){
                e.preventDefault();
                var form = $(this).serializeArray();
                console.log(form);
                $.post(
                    "../signup_verify.php",
                    form,
                    function(form){

                        $('#signup_message').show();
                       // $('#btn_submit').hide();
                        $('#signup_message').html(form);
                    }
                );
            });



        });
    </script>





</body>

</html>