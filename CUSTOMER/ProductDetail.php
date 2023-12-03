<?php

require "../MAIN/Dbconn.php";
$pro_id = $_GET['product_id'];

if (isset($_COOKIE['custidcookie']) && isset($_COOKIE['custnamecookie'])) {

    $wish_table  = $_COOKIE['custidcookie'] . $_COOKIE['custnamecookie'] . '_wishlist';
} else {
}

?>

<!doctype html>
<html lang="en">

<head>

    <?php

    require "../MAIN/Header.php";

    ?>

    <style>
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

                                <p class="mt-3">Don't have an account? <a href="signup.php">Sign up</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="wrapper">

        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid ">

                <div>
                    <button class="btn shadow-none" type="button" onclick="document.location='Ecommerce.php'"><i class="material-icons">west</i></button>
                    <img class="img-fluid py-2" src="../assets/img/techstop.webp" width="100px" height="30px">
                </div>
                <a class="navbar-text ms-auto me-auto">
                    <h5>Product detail</h5>
                </a>

                <div class=" ">
                    <a class="btn text-white shadow-none" href="./Wishlist.php">
                        <i class="material-icons"> favorite_border</i>
                    </a>
                    <a href="./ShoppingCart.php" class="btn text-white shadow-none">
                        <i class="material-icons">shopping_cart</i>
                    </a>
                    <a class="btn text-white shadow-none" href="../profile.php">
                        <i class="material-icons">account_circle</i>
                    </a>
                </div>
            </div>
        </nav>


        <!--CONTENT-->
        <div id="Content" class="mb-5 product-detail">


            <div class="container-fluid">

                <div class="row">

                    <div class="col-md-12 col-lg-7 col-12 ">


                        <?php

                        $pro_result = mysqli_query($con, "SELECT * FROM products p INNER JOIN brands b ON p.brand = b.br_id WHERE p.pr_id = $pro_id");
                        $pro_sub_result = mysqli_query($con, "SELECT * FROM product_image WHERE pr_id =$pro_id");
                        $main_row = mysqli_fetch_array($pro_result);

                        ?>
                        <div class="card card-body shadow">
                            <div id="carouselExampleControls" class="carousel carousel-dark slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="../assets/img/PRODUCTS/<?php echo $main_row['img'] ?>" class="d-block w-100" alt="...">
                                    </div>

                                    <?php
                                    while ($sub_row = mysqli_fetch_array($pro_sub_result)) {
                                    ?>
                                        <div class="carousel-item">
                                            <img src="../assets/img/ADD_IMAGE/<?php echo $sub_row['images'] ?>" class="d-block w-100" alt="...">
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-5 col-12 mt-4 mt-lg-0">
                        <div class="">
                            <h2 class=""><?php echo $main_row['brand_name']; ?> <span><?php echo $main_row['name']; ?></span></h2>
                            <h1 class="mt-lg-2 mt-3" style="color: #F50414;">&#8377; <?php echo number_format($main_row['price']); ?></h1>
                            <h5 class="mt-lg-2 mt-3 text-muted">Expected Delivery - With in 2 days (Inside Trivandrum)</h5>
                        </div>
                        <div class=" mt-3 text-center text-lg-start">
                            <?php
                            if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {
                            ?>
                                <form action="" id="Add_cart_form">
                                    <input type="text" name="product_id" id="id_input" value="<?php echo $main_row['pr_id']; ?>" hidden>
                                    <button name="Add2cart" type="submit" class="btn btn_cart rounded-pill px-3 me-3">Add to Cart</button>
                                    <a href="OrderOperations.php?ad_id=<?php echo $main_row['pr_id']; ?>" class="btn btn_cart rounded-pill px-4">Buy Now</a>

                                </form>
                                <?php
                                $wish_checkid = $main_row['pr_id'];
                                $check_wish = mysqli_query($con, "SELECT * FROM $wish_table WHERE pr_id = '$wish_checkid'");
                                if (mysqli_num_rows($check_wish) > 0) {
                                ?>
                                    <button id="removewish" value="<?php echo $main_row['pr_id']; ?>" class=" mt-3 btn shadow-none btn-link p-0" type="button">Remove from wishlist</button>
                                <?php
                                } else {
                                ?>
                                    <button id="add2wish" value="<?php echo $main_row['pr_id']; ?>" class=" mt-3 btn shadow-none btn-link p-0" type="button">Add to wishlist</button>
                                <?php
                                }
                                ?>

                            <?php
                            } else {
                            ?>
                                <form action="" id="Add_cart_form_temp">
                                    <input type="text" name="product_id" value="<?php echo $main_row['pr_id']; ?>" hidden>
                                    <button name="Add2cartemp" type="button" data-bs-toggle="modal" data-bs-target="#LoginModal" class="btn btn_cart rounded-pill px-3 me-3">Add to Cart</button>
                                    <a href="#LoginModal" data-bs-toggle="modal" class="btn btn_cart rounded-pill px-4">Buy Now</a>
                                </form>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="details mt-4 mt-lg-4">
                            <h6 class="" style="font-weight: 600;">Product Details</h6>
                            <div class="ps-lg-3 pe-4">
                                <?php  
                                    echo htmlspecialchars_decode(stripslashes($main_row['description']));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="mt-3">Related Products</h4>

                    <div id="Related_container" class="d-flex">

                        <div class="">
                            <button id="left-button" class="btn btn-danger d-none d-md-block shadow-none rounded-circle "> <i class="material-icons">arrow_back_ios</i> </button>
                        </div>

                        <div id="Related">

                            <?php
                            $related_results = mysqli_query($con, "SELECT pr_id FROM products WHERE pr_id <> '$pro_id'");
                            while ($newrow = mysqli_fetch_assoc($related_results)) {
                                foreach ($newrow as $val) {
                                    $new_var = mysqli_query($con, "SELECT * FROM products p INNER JOIN brands b ON p.brand = b.br_id WHERE pr_id = $val");
                                    while ($tp_row = mysqli_fetch_array($new_var)) {
                            ?>
                                        <a href="ProductDetail.php?product_id=<?php echo $tp_row['pr_id']; ?>">
                                            <div class="card card-body shadow-sm">
                                                <img src="../assets/img/PRODUCTS/<?php echo $tp_row['img']; ?>" class="mx-auto" alt="">
                                                <div class=" mt-auto">
                                                    <div class="d-block">
                                                        <h6 class="text-muted"> <span class="d-block"><?php echo $tp_row['brand_name']; ?></span> <span class="d-inline-block text-truncate" style="max-width: 120px;"><?php echo $tp_row['name']; ?></span></h6>
                                                        <p>&#8377; <?php echo number_format($tp_row['price']); ?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                            <?php
                                    }
                                }
                            }
                            ?>


                        </div>

                        <div class="">
                            <button id="right-button" class="btn btn-danger d-none d-md-block shadow-none rounded-circle "> <i class="material-icons">arrow_forward_ios</i> </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>


    <script>
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

        $(document).ready(function() {


            $('#Add_cart_form').submit(function(e) {
                e.preventDefault();
                var product_id = $('#id_input').val();
                console.log(product_id);
                $.ajax({
                    method: "POST",
                    url: "OrderOperations.php",
                    data: {
                        product_id: product_id
                    },
                    success: function(data) {
                        console.log(data);
                        toastr.success('Successfully Added to Cart');
                    }
                });
            });


            $('#add2wish').click(function() {
                var add2wish_id = $(this).val();
                //console.log(add2wish_id);
                $.ajax({
                    method: "POST",
                    url: "OrderOperations.php",
                    data: {
                        add2wish_id: add2wish_id
                    },
                    success: function(data) {
                        toastr.success(data);
                        $('#add2wish').hide();
                        //$('#removewish').show();
                    }
                });
            });



            $('#removewish').click(function() {
                var removewish_id = $(this).val();
                //console.log(removewish_id);
                $.ajax({
                    method: "POST",
                    url: "OrderOperations.php",
                    data: {
                        removewish_id: removewish_id
                    },
                    success: function(data) {
                        toastr.success(data);
                        $('#removewish').hide();
                        //$('#add2wish').show();
                    }
                });
            });





        });
    </script>



    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        $('#right-button').click(function() {
            event.preventDefault();
            $('#Related').animate({
                scrollLeft: "+=300px"
            }, "slow");
        });

        $('#left-button').click(function() {
            event.preventDefault();
            $('#Related').animate({
                scrollLeft: "-=300px"
            }, "slow");
        });
    </script>

    <?php
    include "../MAIN/Footer.php";
    ?>


</body>

</html>