<?php

require "../MAIN/Dbconn.php";
include_once "./OrderOperations.php";

if (!isset($_COOKIE['custnamecookie']) && !isset($_COOKIE['custidcookie'])) {

    header("location:login.php");
} else {

    $cart_table = $_COOKIE['custidcookie'] . $_COOKIE['custnamecookie'] . '_cart';
    $find_cart_empty = mysqli_query($con, "SELECT * FROM $cart_table");
    if (mysqli_num_rows($find_cart_empty) == 0) {
        header("location:Ecommerce.php");
    }
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
                <a href="Shipping.php" class="btn shadow-none" type="button" onclick="document.location='Shopping Cart.html'"><i class="material-icons">west</i></a>
                    <img class="img-fluid py-2" src="../assets/img/techstop.webp" width="100px" height="30px">
                </div>
                <a class="navbar-text me-auto">
                    <h5>Checkout</h5>
                </a>

                <div class=" d-flex">
                    <a class="btn text-white shadow-none d-none" href="ShoppingCart.php">
                        <i class="material-icons">shopping_cart</i>
                    </a>
                    <a class="btn text-white shadow-none" href="../profile.php">
                        <i class="material-icons">account_circle</i>
                    </a>
                </div>
            </div>
        </nav>



        <!--CONTENT-->
        <div id="Content" class="mb-5 checkout">


            <div class="container-fluid">

                <form action="OrderOperations.php" method="POST" id="Details">

                    <div class="row">

                        <div class="col-lg-7 col-12  order-lg-1 order-1">
                            <div class="card card-body shadow-sm">

                                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="./Ecommerce.php">Products</a></li>
                                        <li class="breadcrumb-item"><a href="./ShoppingCart.php">Shopping Cart</a></li>
                                        <li class="breadcrumb-item"><a href="./Shipping.php">Information</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Payment</li>
                                    </ol>
                                </nav>

                                <h5>Payment details</h5>


                                <div class="mt-2 px-3 ">
                                    <div class="card card-body small-box">
                                        <div class="d-lg-flex d-md-block ">
                                            <h6 class="">Ship to</h6>
                                            <p class="ms-4 m-0"><?php echo $_SESSION['f_name'] . '&nbsp;' . $_SESSION['l_name'] . ',' . $_SESSION['address'] . ',' . $_SESSION['city'] . ',' . $_SESSION['state'] . ',' . $_SESSION['pincode']; ?> </p>
                                        </div>
                                    </div>

                                    <div class="card card-body mt-4 p-0 small-box">

                                        <?php

                                        $search_type_query = mysqli_query($con, "SELECT type FROM user_details");
                                        foreach ($search_type_query as $search_type) {
                                            $type = $search_type['type'];
                                        }

                                        if ($type == 'admin') {
                                        ?>
                                            <div class="form-check-inline px-3 pt-3">
                                                <input type="radio" name="mode" id="shop" value="shop sales" class="form-check-input" checked>
                                                <label for="shop" class="form-check-label ps-4">Shop Sales</label>
                                                <span>( Pay at shop)</span>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="form-check-inline px-3 pt-3">
                                                <input type="radio" name="mode" id="Cod" value="5" class="form-check-input" checked>
                                                <label for="Cod" class="form-check-label ps-4">Cash On Delivery</label>
                                                <span>( Pay using cash upon delivery)</span>
                                            </div>
                                            <div class="form-check-inline px-3 pt-3">
                                                <input type="radio" name="mode" id="gate" value="6" class="form-check-input">
                                                <label for="gate" class="form-check-label ps-4">Choose Payment Gateway</label>
                                                <span>( Razor pay)</span>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <hr>
                                        <p class="px-3">Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="">privacy policy</a>.</p>
                                    </div>

                                    <div class="d-flex justify-content-between mt-3 mb-3">
                                        <a href="Shipping.php" class="btn shadow-none rounded-pill back_btn " type="button" >Back to Shipping</a>
                                        <button class="btn shadow-none rounded-pill btn_cart" type="submit" value="<?php echo $total; ?>" name="Pay_button">Make Payment</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 col-12 order-lg-2 order-2 mt-4 mt-lg-0">

                            <div class="card card-body shadow-sm">
                                <h5 class="border-bottom pb-2">Items in Cart</h5>
                                <ul class="list-unstyled">
                                    <?php
                                    $cart_id = mysqli_query($con, "SELECT * FROM $cart_table");
                                    while ($id_result = mysqli_fetch_array($cart_id)) {

                                        $pro_id = $id_result['pr_id'];
                                        $cart_items = mysqli_query($con, "SELECT * FROM products p INNER JOIN brands b ON p.brand = b.br_id WHERE p.pr_id = $pro_id");
                                        while ($cart_result = mysqli_fetch_array($cart_items)) {
                                    ?>

                                            <li class="border-bottom pb-2">
                                                <div class="d-flex">
                                                    <div>
                                                        <img src="../assets/img/PRODUCTS/<?php echo $cart_result['img']; ?>" alt="">
                                                    </div>
                                                    <div class="w-100 pe-3 ps-2">
                                                        <div class="d-lg-flex d-block justify-content-between mt-lg- mt-1 ">
                                                            <h6 class="" style="max-width: 300px;"> <?php echo $cart_result['brand_name'] . '&nbsp;' . $cart_result['name']; ?> </h6>
                                                            <h6 class=""> &#8377; <?php echo number_format($cart_result['price']); ?></h6>
                                                        </div>
                                                        <div class=" d-flex ">
                                                            <select name="" id="" class="form-select shadow-none" style="width: 100px;" disabled>
                                                                <option selected hidden value=""> <?php echo $id_result['quantity'] ?> </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>

                                <?php
                                $price_fetch = mysqli_query($con, "SELECT SUM(price * quantity) FROM products INNER JOIN $cart_table USING (pr_id)");
                                while ($total_row = mysqli_fetch_assoc($price_fetch)) {
                                    $total = $total_row['SUM(price * quantity)'];
                                }
                                ?>
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

                </form>


            </div>
        </div>


    </div>


    <?php
    include "../MAIN/Footer.php";
    ?>
</body>

</html>