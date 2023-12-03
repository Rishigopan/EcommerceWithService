<?php
// include "../MAIN/Dbconn.php";
// include "../login_verify.php";

include '../MAIN/Dbconn.php';

if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

    $cart_table = $_COOKIE['custidcookie'] . $_COOKIE['custnamecookie'] . '_cart';
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
                    <button class="btn shadow-none" onclick="document.location='Ecommerce.php'" type="button"><i class="material-icons">west</i></button>
                    <img class="img-fluid py-2" src="../assets/img/techstop.webp" width="100px" height="30px">
                </div>
                <a class="navbar-text d-md-flex d-none ms-auto me-auto">
                    <h5>Shopping Cart</h5>
                </a>

                <div class=" ">
                    <a class="btn text-white shadow-none" href="./Wishlist.php">
                        <i class="material-icons"> favorite_border</i>
                    </a>
                    <a href="Shopping_cart.php" class="btn text-white shadow-none">
                        <i class="material-icons">shopping_cart</i>
                    </a>
                    <a class="btn text-white shadow-none" href="profile.php">
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
        <div id="Content" class="mb-5 shopping_cart">


            <div class="container-fluid">

                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="ms-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./Ecommerce.php">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                    </ol>
                </nav>


                <div class="row mb-3">


                    <div class="col-lg-9 col-12 order-lg-1 order-2">
                        <div class="card card-body shadow-sm">
                            <h4 class="border-bottom pb-2">Shopping Cart</h4>

                            <form action="">
                                <ul class="list-unstyled">
                                    <?php $fetch_cart = mysqli_query($con, "SELECT * FROM $cart_table");
                                    if (mysqli_num_rows($fetch_cart) > 0) {

                                        while ($cart_row = mysqli_fetch_array($fetch_cart)) {
                                    ?>
                                            <li class="border-bottom pb-4">
                                                <div class="d-flex">

                                                    <?php
                                                    $prod_id = $cart_row['pr_id'];
                                                    $fetch_product = mysqli_query($con, "SELECT * FROM products p INNER JOIN brands b ON p.brand = b.br_id WHERE pr_id = $prod_id;");
                                                    while ($prod_row = mysqli_fetch_array($fetch_product)) {
                                                    ?>

                                                        <div>
                                                            <a href="ProductDetail.php?product_id=<?php echo $prod_row['pr_id']; ?>">
                                                                <img src="../assets/img/PRODUCTS/<?php echo $prod_row['img']; ?>" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="w-100 pe-3 ps-4">
                                                            <div class="d-lg-flex d-block justify-content-between mt-lg-3 mt-1 ">
                                                                <h5 class=""><?php echo $prod_row['brand_name'] . '&nbsp' . $prod_row['name']; ?></h5>
                                                                <h4 class="prod_price"> &#8377; <?php echo number_format($prod_row['price'] * $cart_row['quantity']); ?></h4>
                                                            </div>

                                                        <?php
                                                    }
                                                        ?>
                                                        <div class="d-flex mt-2 mb-2 mt-lg-4">
                                                            <select id="<?php echo $cart_row['cart_id']; ?>" class="form-select px-2 shadow-none qtyselect" style="width: 6rem;">
                                                                <option selected hidden value=""> Qty &nbsp;: <?php echo $cart_row['quantity']; ?></option>
                                                                <?php  
                                                                    for($I= 1 ; $I <= 100 ; $I++){
                                                                        echo '<option value="'.$I.'">'.$I.'</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                            <a class=" mt-auto ms-3" href="OrderOperations.php?del_id=<?php echo $cart_row['cart_id']; ?>">Remove</a>
                                                        </div>
                                                        </div>
                                                </div>
                                            </li>

                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <li class="text-center border-bottom pb-2">
                                            <h5>Your cart is empty! Try adding something.</h5>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    $cartitems_query = mysqli_query($con, "SELECT SUM(quantity) FROM $cart_table");
                                    while ($cart_items = mysqli_fetch_assoc($cartitems_query)) {
                                        $items =   $cart_items['SUM(quantity)'];
                                    }

                                    $price_query = mysqli_query($con, "SELECT SUM(rate * quantity) AS SubTotal FROM $cart_table");
                                    while ($total = mysqli_fetch_assoc($price_query)) {
                                    ?>
                                        <h5 class=" me-2 text-end">Subtotal : <span> &#8377; <?php echo number_format($total['SubTotal']); ?> </span></h5>
                                        
                                </ul>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-3 order-lg-2 order-1 mb-3">
                        <div class="card card-body shadow-sm">
                            <div class="d-flex justify-content-between"> 
                                <h5 class="">Subtotal (<?php echo $items; ?> Items): </h5>
                                <h5 class=""> &#8377; <?php echo number_format($total['SubTotal']); ?> </h5>
                            </div>
                            <div class="d-flex justify-content-between"> 
                                <h5 class="">Delivery : </h5>
                                <h5 class=""> &#8377; 0</h5>
                            </div>
                            <div class="d-flex justify-content-between"> 
                                <h4 class="">Total : </h4>
                                <h4 class=""> &#8377; <?php echo number_format($total['SubTotal']); ?></h4>
                            </div>
                            <!-- <h5 class="">Subtotal (<?php echo $items; ?> Items): <span> &#8377; <?php echo number_format($total['SubTotal']); ?> </span></h5>
                            <h5 class="">Delivery : <span> &#8377; 0 </span></h5>
                            <h5 class="">Total : <span> &#8377; <?php echo number_format($total['SubTotal']); ?> </span></h5> -->
                            <div class="text-center mt-3">
                                <?php

                                        $fetch_cart_empty = mysqli_query($con, "SELECT * FROM  $cart_table ");
                                        if (mysqli_num_rows($fetch_cart_empty) == 0) {
                                            echo '<a href="" class="btn rounded-pill btn_cart" type="button" style="opacity:0.5;pointer-events:none">Proceed to Buy</a>';
                                        } else {
                                            echo '<a href="Shipping.php" class="btn rounded-pill btn_cart" type="button" >Proceed to Buy</a>';
                                        }
                                ?>

                            </div>
                        </div>
                    </div>
                <?php
                                    }
                ?>

                </div>



                <div>

                    <h4>Related Products</h4>

                    <div id="Related_container" class="d-flex">

                        <div class="">
                            <button id="left-button" class="btn btn-danger shadow-none rounded-circle "> <i class="material-icons">arrow_back_ios</i> </button>
                        </div>

                        <div id="Related">

                            <?php
                            $related_results = mysqli_query($con, "SELECT pr_id FROM products");
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
                            <button id="right-button" class="btn btn-danger shadow-none rounded-circle "> <i class="material-icons">arrow_forward_ios</i> </button>
                        </div>

                    </div>

                </div>

            </div>


        </div>



        <script>
            $('.qtyselect').change(function() {
                var cartchange_id = $(this).attr('id');
                //console.log(cartchange_id);
                var change_qty = $(this).val();
                //console.log(change_qty);
                $.ajax({
                    url: "OrderOperations.php",
                    type: "POST",
                    data: {
                        cartchange_id: cartchange_id,
                        change_qty: change_qty
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            });


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