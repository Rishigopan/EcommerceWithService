<?php
require "../MAIN/Dbconn.php"; 
$pro_id = $_GET['product_id'];

if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

    if ($_COOKIE['custtypecookie'] == 'executive' || $_COOKIE['custtypecookie'] == 'admin') {
        echo "";
    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
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
        <nav class="navbar shadow-sm fixed-top ">
            <div class="container-fluid ">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text mx-auto">
                    <h5>Product detail</h5>
                </a>

                <div class=" ">
                    <a href="AdminShoppingcart.php" class="btn text-white shadow-none">
                        <i class="material-icons">shopping_cart</i>
                    </a>
                    <a class="btn text-white shadow-none" href="../profile.php">
                        <i class="material-icons">account_circle</i>
                    </a>
                </div>
            </div>
        </nav>

        <!--SIDEBAR-->
        <?php

        include '../MAIN/Sidebar.php';

        ?>


        <!--CONTENT-->
        <div id="Content" class="mb-5 product-detail">


            <div class="container-fluid">

                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="ms-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./AdminEcommerce.php">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product details</li>
                    </ol>
                </nav>


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
                        </div>
                        <div class=" mt-3 text-center text-lg-start">
                            <?php
                            if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {
                            ?>
                                <form action="" id="Add_cart_form">
                                    <input type="text" name="product_id" id="id_input" value="<?php echo $main_row['pr_id']; ?>" hidden>
                                    <button name="Add2cart" type="submit" class="btn btn_cart rounded-pill px-3 me-3">Add to Cart</button>
                                    <a href="AdminSalesOperations.php?ad_id=<?php echo $main_row['pr_id']; ?>" class="btn btn_cart rounded-pill px-4">Buy Now</a>

                                </form>
                            <?php
                            } else {
                            ?>
                                <form action="" id="Add_cart_form_temp">
                                    <input type="text" name="product_id" value="<?php echo $main_row['pr_id']; ?>" hidden>
                                    <button name="Add2cartemp" type="button" onclick="document.location='../login.php'" class="btn btn_cart rounded-pill px-3 me-3">Add to Cart</button>
                                    <a href="../login.php" class="btn btn_cart rounded-pill px-4">Buy Now</a>
                                </form>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="details mt-4 mt-lg-4">
                            <h6 class="" style="font-weight: 600;">Product Details</h6>
                            <div class="ps-lg-3 pe-4">
                                <?php echo $main_row['description']; ?>
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
                                        <a href="AdminProductdetail.php?product_id=<?php echo $tp_row['pr_id']; ?>">
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
        $(document).ready(function() {
            $('#Add_cart_form').submit(function(e) {
                e.preventDefault();
                var product_id = $('#id_input').val();
                $.ajax({
                    method: "POST",
                    url: "AdminSalesOperations.php",
                    data: {
                        product_id: product_id
                    },
                    success: function(data) {
                        toastr.success('Successfully Added to Cart');
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