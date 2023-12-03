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
$PageTitle = 'Sale';
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
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <form class=" ms-auto me-3 d-none d-sm-block ">
                    <input id="searchbox" class="form-control py-2 px-5 text-center rounded-pill shadow-none border-0" type="text" placeholder="Search..." aria-label="Search">
                </form>
                <div class=" ">
                    <a href="AdminShoppingcart.php" class="btn text-white shadow-none">
                        <i class="material-icons">shopping_cart</i>
                    </a>
                    <a class="btn text-white shadow-none" href="profile.php">
                        <i class="material-icons">account_circle</i>
                    </a>
                </div>
            </div>
        </nav>




        <!--FILTERS-->
        <div class="offcanvas offcanvas-bottom d-sm-none" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Filters</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="container-fluid filter_all">
                    <div class="">
                        <h6>Types</h6>
                        <?php
                        $type_check_query = mysqli_query($con, "SELECT * FROM types");
                        foreach ($type_check_query as $type_checks) {
                        ?>
                            <div class=" form-check-inline me-3 mb-2">
                                <input type="checkbox" class="btn-check comm_select type" id="<?php echo $type_checks['ty_id']; ?>" value="<?php echo $type_checks['type_name']; ?>">
                                <label class="btn shadow-none rounded-pill py-0" for="<?php echo $type_checks['ty_id']; ?>"><?php echo $type_checks['type_name']; ?></label>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="mt-3 mb-4">
                        <h6>Brands</h6>
                        <?php
                        $brand_check_query = mysqli_query($con, "SELECT * FROM brands");
                        foreach ($brand_check_query as $brand_checks) {
                        ?>
                            <div class=" form-check-inline me-3 mb-2">
                                <input type="checkbox" class="btn-check comm_select brand" id="<?php echo $brand_checks['br_id']; ?>" value="<?php echo $brand_checks['brand_name']; ?>">
                                <label class="btn shadow-none rounded-pill py-0" for="<?php echo $brand_checks['br_id']; ?>"> <?php echo $brand_checks['brand_name']; ?></label>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <h5>Sort By</h5>

                    <div class="mt-3">
                        <div class=" form-check-inline me-3 mb-2">
                            <input type="radio" class="btn-check comm_select asc " name="btnradio" id="btnradio1" value="ASC" checked>
                            <label class="btn shadow-none rounded-pill py-0" for="btnradio1">A - Z</label>
                        </div>
                        <div class="me-3 form-check-inline mb-2">
                            <input type="radio" class="btn-check comm_select desc " name="btnradio" id="btnradio2" value="DESC">
                            <label class="btn shadow-none rounded-pill py-0" for="btnradio2">Z - A</label>
                        </div>
                        <div class="me-3 form-check-inline mb-2">
                            <input type="radio" class="btn-check comm_select L2H" name="btnradio" value="" id="btnradio3">
                            <label class="btn shadow-none rounded-pill py-0" for="btnradio3">Price:Low to High</label>
                        </div>
                        <div class="me-3 form-check-inline mb-2">
                            <input type="radio" class="btn-check comm_select H2L " name="btnradio" id="btnradio4">
                            <label class="btn shadow-none rounded-pill py-0" for="btnradio4">Price: High to Low</label>
                        </div>
                    </div>

                    <div class="text-center mt-3 canvas_foot">
                        <button class="btn rounded-pill btn_cart shadow-none ">Clear all</button>
                    </div>
                </div>
            </div>

        </div>


        <!--SIDEBAR-->
        <?php

        include '../MAIN/Sidebar.php';

        ?>


        <!--CONTENT-->
        <div id="Content" class="mb-5">


            <div class="container-fluid">

                <div id="mobile_search" class="d-flex justify-content-between mb-2 d-sm-none">
                    <input type="text" id="searchbar_mobile" class="form-control py-2 me-4" placeholder="Start typing...">
                    <button class="btn btn_cart py-0 " type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom"> <i class="material-icons" style="vertical-align: middle;">filter_alt</i></button>
                </div>

                <div class="row">

                    <div id="left_col" class="col-3 d-none d-md-block">

                        <div class="accordion accordion-flush shadow" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h6 class="accordion-header py-2  d-flex justify-content-between">
                                    <span class="ms-3 my-auto"> <i class="material-icons" style="vertical-align: middle;">filter_alt</i> Filters</span>
                                    <button class="btn btn_cart clear_all rounded-pill p-0 px-2 me-3 shadow-none" type="submit"> Clear all</button>
                                </h6>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button shadow-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                        Types
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <?php
                                        $type_check_query = mysqli_query($con, "SELECT * FROM types ORDER BY type_name ASC");
                                        foreach ($type_check_query as $type_checks) {
                                        ?>
                                            <div class="form-check">
                                                <label class="form-check-label"><?php echo $type_checks['type_name']; ?>
                                                    <input class="form-check-input comm_select type shadow-none" type="checkbox" value="<?php echo $type_checks['ty_id']; ?>">
                                                </label>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item ">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Brands
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <?php
                                        $brand_check_query = mysqli_query($con, "SELECT * FROM brands ORDER BY brand_name ASC");
                                        foreach ($brand_check_query as $brand_checks) {
                                        ?>
                                            <div class="form-check">
                                                <label class="form-check-label"><?php echo $brand_checks['brand_name']; ?>
                                                    <input class="form-check-input comm_select brand shadow-none" type="checkbox" value="<?php echo $brand_checks['br_id']; ?>">
                                                </label>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-body shadow mt-4">
                            <h6>
                                <i class="material-icons" style="vertical-align: middle;">sort</i>
                                <span>Sort By</span>
                            </h6>
                            <div class="filter_all">
                                <div class="d-flex">
                                    <div class="mt-2 me-3">
                                        <input type="radio" class="btn-check comm_select asc " name="btnradio" id="btnradio7" value="ASC" checked>
                                        <label class="btn shadow-none rounded-pill px-4 " for="btnradio7">A - Z</label>
                                    </div>
                                    <div class="mt-2 ">
                                        <input type="radio" class="btn-check comm_select L2H" name="btnradio" value="" id="btnradio9">
                                        <label class="btn shadow-none rounded-pill px-3" for="btnradio9">Price:Low to High</label>
                                    </div>

                                </div>
                                <div class="d-lg-flex">
                                    <div class="mt-2 me-3">
                                        <input type="radio" class="btn-check comm_select desc " name="btnradio" id="btnradio8" value="DESC">
                                        <label class="btn shadow-none rounded-pill px-4" for="btnradio8">Z - A</label>
                                    </div>
                                    <div class="mt-2">
                                        <input type="radio" class="btn-check comm_select H2L " name="btnradio" id="btnradio6">
                                        <label class="btn shadow-none rounded-pill px-3" for="btnradio6">Price: High to Low</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="right_col" class="col-md-12 col-12 col-lg-9 offset-md-4 offset-lg-3 ">

                        <!--Products-->
                        <div class="row g-2 products">


                        </div>

                    </div>
                </div>
            </div>

            
        </div>

    </div>

    <script>
        $(document).ready(function() {

            $('.clear_all').click(function() {
                location.reload();
            });

            filter_data();

            function filter_data(searchdata) {
                var brand = get_filter('brand');
                var type = get_filter('type');
                var action = 'fetch_data';
                var ndesc = get_filter('desc');
                var nasc = get_filter('asc');
                var L2H = get_filter('L2H');
                var H2L = get_filter('H2L');
                $.ajax({
                    method: "POST",
                    url: "AdminFilterdata.php",
                    data: {
                        action: action,
                        brand: brand,
                        type: type,
                        ndesc: ndesc,
                        nasc: nasc,
                        L2H: L2H,
                        H2L: H2L,
                        searchdata: searchdata
                    },
                    success: function(data) {

                        $('.products').html(data);

                    }
                });
            }

            function get_filter(class_name) {
                var filter = [];
                $("." + class_name + ":checked").each(function() {
                    filter.push($(this).val())
                });
                return filter;
            }

            $('#searchbar_mobile,#searchbox').keyup(function() {
                var search = $(this).val();
                console.log(search);
                if (search != '') {
                    filter_data(search);
                } else {
                    filter_data();
                }
            });

            $('.comm_select').click(function() {
                filter_data();
            });


        });
    </script>


    <?php
    include "../MAIN/Footer.php";
    ?>

</body>


</html>