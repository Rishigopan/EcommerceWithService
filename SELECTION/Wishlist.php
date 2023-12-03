<?php

require "../MAIN/Dbconn.php";


if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

    $wish_table  = $_COOKIE['custidcookie'] . $_COOKIE['custnamecookie'] . '_wishlist';
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
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid ">

                <div>
                    <a href="javascript:history.go(-1)" class="btn shadow-none"><i class="material-icons">west</i></a>
                    <img class="img-fluid py-2" src="../assets/img/techstop.webp" width="100px" height="30px">
                </div>
                <a class="navbar-text ms-auto me-auto">
                    <h5>My Wishlist</h5>
                </a>
                <div class=" ">
                    <a class="btn text-white shadow-none" href="Wishlist.php">
                        <i class="material-icons"> favorite_border</i>
                    </a>
                    <a href="ShoppingCart.php" class="btn text-white shadow-none">
                        <i class="material-icons">shopping_cart</i>
                    </a>
                    <a class="btn text-white shadow-none" type="submit" href="../profile.php">
                        <i class="material-icons">account_circle</i>
                    </a>
                </div>
            </div>
        </nav>




        <!--FILTERS
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
                                    <input type="checkbox" class="btn-check comm_select type" id="<?php echo $type_checks['ty_id']; ?>" value="<?php echo $type_checks['type_name']; ?>" >
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
                                <input type="checkbox" class="btn-check comm_select brand" id="<?php echo $brand_checks['br_id']; ?>" value="<?php echo $brand_checks['brand_name']; ?>" >
                                <label class="btn shadow-none rounded-pill py-0" for="<?php echo $brand_checks['br_id']; ?>"> <?php echo $brand_checks['brand_name']; ?></label>
                            </div>
                        <?php
                        }
                        ?>
                        </div>

                        <h5>Sort By</h5>

                        <div class="mt-3">
                            <div class=" form-check-inline me-3 mb-2">
                                <input type="radio" class="btn-check comm_select asc " name="btnradio" id="btnradio1"  value="ASC" checked>
                                <label class="btn shadow-none rounded-pill py-0" for="btnradio1">A - Z</label>
                            </div>
                            <div class="me-3 form-check-inline mb-2">
                                <input type="radio" class="btn-check comm_select desc " name="btnradio" id="btnradio2" value="DESC" >
                                <label class="btn shadow-none rounded-pill py-0" for="btnradio2">Z - A</label>
                            </div>
                            <div class="me-3 form-check-inline mb-2">
                                <input type="radio" class="btn-check comm_select L2H" name="btnradio" value="" id="btnradio3" >
                                <label class="btn shadow-none rounded-pill py-0" for="btnradio3">Price:Low to High</label>
                            </div>
                            <div class="me-3 form-check-inline mb-2">
                                <input type="radio" class="btn-check comm_select H2L " name="btnradio" id="btnradio4" >
                                <label class="btn shadow-none rounded-pill py-0" for="btnradio4">Price: High to Low</label>
                            </div>
                        </div>
                        
                        <div class="text-center mt-3 canvas_foot">
                            <button class="btn rounded-pill btn_cart shadow-none ">Clear all</button>
                        </div>
                    </div>
                </div>

            </div>-->




        <!--CONTENT-->
        <div id="Content" class="mb-5 wishlist">


            <div class="container-fluid">

                <div id="mobile_search" class="d-flex justify-content-between mb-2 d-sm-none">
                    <input type="text" id="searchbar_mobile" class="form-control py-2 me-4" placeholder="Start typing...">
                    <button class="btn btn_cart py-0 " type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom"> <i class="material-icons" style="vertical-align: middle;">filter_alt</i></button>
                </div>





                <div class="row g-2 products">

                    <?php

                    $wishlist_fetch_query = mysqli_query($con, "SELECT * FROM $wish_table");
                    if (mysqli_num_rows($wishlist_fetch_query) > 0) {
                        while ($wishlist_result = mysqli_fetch_array($wishlist_fetch_query)) {
                            $product_id = $wishlist_result['pr_id'];
                            $product_fetch_query = mysqli_query($con, "SELECT * FROM products p INNER JOIN brands b ON p.brand = b.br_id WHERE p.pr_id = '$product_id'");
                            while ($product_result = mysqli_fetch_array($product_fetch_query)) {


                    ?>
                                <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-2 my-2 ">
                                    <div class="card card-body shadow-sm ">
                                        <a href="ProductDetail.php?product_id=<?php echo $wishlist_result['pr_id']; ?>">
                                            <div class="d-sm-block d-flex">
                                                <div class="d-flex justify-content-sm-center">
                                                    <img src="../assets/img/PRODUCTS/<?php echo $product_result['img']; ?>" class=" " alt="">
                                                </div>
                                                <div class="mt-sm-2 ms-3 ms-sm-0">
                                                    <h6 class=""><span class="d-block"> <?php echo $product_result['brand_name'] ?></span> <span class=" text-muted"><?php echo $product_result['name'] ?></span></h6>
                                                    <div class="text-center mt-2 mt-sm-0 d-flex justify-content-between">
                                                        <p class=" mt-4 mt-sm-0 my-sm-0">&#8377; <?php echo number_format($product_result['price']); ?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="text-center d-flex justify-content-center">
                                            <button class="btn btn_cart btn_wish add_cart me-3" type="button" value="<?php echo $wishlist_result['pr_id']; ?>"><i class="material-icons">add_shopping_cart</i></button>
                                            <button class="btn btn_cart btn_wish rem_wish ms-3" type="button" value="<?php echo $wishlist_result['wish_id']; ?>"><i class="material-icons">heart_broken</i></button>
                                        </div>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    } else {
                        echo '<h1 class="text-center">Please add any product to your wishlist</h1>';
                    }
                    ?>
                </div>



            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            //Remove from wishlist
            $('.rem_wish').click(function() {
                var remwish_id = $(this).val();
                //console.log(remwish_id);
                $.ajax({
                    method: "POST",
                    url: "WishOperations.php",
                    data: {
                        remwish_id: remwish_id
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            });

            //Add to cart
            $('.add_cart').click(function() {
                var addcart_id = $(this).val();
                console.log(addcart_id);
                $.ajax({
                    method: "POST",
                    url: "WishOperations.php",
                    data: {
                        addcart_id: addcart_id
                    },
                    success: function(data) {
                        toastr.success(data);
                    }
                });
            });

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


            /*   $('.clear_all').click(function(){
                location.reload();
            });

            filter_data();

            function filter_data(searchdata)
            {
                var brand = get_filter('brand');
                var type = get_filter('type');
                var action = 'fetch_data';
                var ndesc = get_filter('desc');
                var nasc = get_filter('asc');
                var L2H = get_filter('L2H');
                var H2L = get_filter('H2L');
                $.ajax({
                    method:"POST",
                    url:"FilterData.php",
                    data:{action:action,brand:brand,type:type,ndesc:ndesc,nasc:nasc,L2H:L2H,H2L:H2L,searchdata:searchdata},
                    success:function(data){
                        
                        $('.products').html(data);
                        
                    }
                });
            }

            function get_filter(class_name)
            {
                var filter = [];
                $("."+class_name+":checked").each(function(){
                    filter.push($(this).val())
                });
                return filter;
            }

            $('#searchbar_mobile,#searchbox').keyup(function(){
                var search = $(this).val();
                console.log(search);
                    if(search != ''){
                        filter_data(search);
                    }
                    else
                    {
                        filter_data();
                    }
	        });
            
            $('.comm_select').click(function(){
                filter_data();
            });

            */


        });
    </script>






    <?php
    include "../MAIN/Footer.php";
    ?>

</body>


</html>