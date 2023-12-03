<?php


require "../MAIN/Dbconn.php";

if (!isset($_COOKIE['custnamecookie']) && !isset($_COOKIE['custidcookie'])) {

    header("location:../login.php");
} else {

    $cart_table = $_COOKIE['custidcookie'] . $_COOKIE['custnamecookie'] . '_cart';
    $cust_id = $_COOKIE['custidcookie'];
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
                    <a href="ShoppingCart.php" class="btn shadow-none"><i class="material-icons">west</i></a>
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

                <div class="row">

                    <div class="col-lg-7 col-12  order-lg-1 order-1">
                        <div class="card card-body shadow-sm">

                            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./Ecommerce.php">Products</a></li>
                                    <li class="breadcrumb-item"><a href="./ShoppingCart.php">Shopping Cart</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Information</li>
                                </ol>
                            </nav>

                            <h5>Shipping Details</h5>
                            <form action="OrderOperations.php" method="POST" id="Details" class="mt-2 px-3">
                                <?php
                                $fetch_details_query = mysqli_query($con, "SELECT first_name,last_name,phone_number,email_id,address_detailed,city,state,pincode FROM user_details WHERE user_id = '$cust_id'");
                                foreach ($fetch_details_query as $details) {
                                ?>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" id="first_name" name="first" class="form-control" placeholder="Enter First Name" value="<?php echo $details['first_name']; ?>" required>
                                        </div>
                                        <div class="col-6">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" id="last_name" name="last" class="form-control" placeholder="Enter Last Name" value="<?php echo $details['last_name']; ?>" required>
                                        </div>
                                        <div class="col-12 col-md-6 mt-2">
                                            <label for="mobile" class="form-label">Phone Number</label>
                                            <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Enter Phone Number" value="<?php echo $details['phone_number']; ?>" readonly required>
                                        </div>
                                        <div class="col-12 col-md-6 mt-2">
                                            <label for="email" class="form-label">Email Id</label>
                                            <input type="email" id="email" name="email_id" class="form-control" placeholder="Enter Email Id" value="<?php echo $details['email_id']; ?>" readonly required>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label for="address" class="form-label">Your Address</label>
                                            <input type="text" id="address" name="adddresses" class="form-control" placeholder="Enter Address" value="<?php echo $details['address_detailed']; ?>" required>
                                        </div>
                                        <div class="col-12 col-md-4 mt-2">
                                            <label for="center" class="form-label">State</label>
                                            <select name="state" id="center" class="form-select">
                                                <option value="kerala">Kerala</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4 mt-2">
                                            <label for="city" class="form-label">City</label>
                                            <select name="city" id="city" class="form-select">
                                                <option value="Trivandrum">Trivandrum</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4 mt-2">
                                            <label for="nearby_taluk" class="form-label">Nearby Taluk</label>
                                            <select name="NearbyTaluk" id="nearby_taluk" class="form-select">
                                                <?php
                                                    $ListNearbyTaluks =  mysqli_query($con, "SELECT * FROM nearby_master");
                                                    foreach($ListNearbyTaluks as $ListNearbyTaluks){
                                                        echo '<option value="'.$ListNearbyTaluks['nearbyId'].'">'.$ListNearbyTaluks['nearbyTaluk'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4 mt-2">
                                            <label for="pincode" class="form-label">Pincode</label>
                                            <input type="text" name="pincode" id="pincode" class="form-control" value="<?php echo $details['pincode']; ?>" placeholder="Enter Pincode" required>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <label for="details" class="form-label">Order Details</label>
                                            <textarea name="ord_details" id="details" cols="3" rows="3" class="form-control shadow-none" placeholder="Additional notes about your order e.g:- delivery notes"></textarea>
                                        </div>
                                        <div class="d-flex justify-content-between mt-3 mb-3">
                                            <a href="ShoppingCart.php" class="btn shadow-none rounded-pill back_btn px-md-4"> <span class="d-none d-md-inline-flex">Back to</span> Shopping</a>
                                            <button class="btn shadow-none rounded-pill btn_cart " type="submit" name="save_ship"> <span class="d-none d-md-inline-flex">Continue to </span> Payment</button>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-5 col-12 order-lg-2 order-2 mt-3 mt-lg-0">

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
                                                        <h6 class=""> &#8377; <?php echo number_format($cart_result['price'] * $id_result['quantity']); ?></h6>
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
                            $price_fetch = mysqli_query($con, "SELECT SUM(rate * quantity) FROM products INNER JOIN $cart_table USING (pr_id)");
                            while ($total_row = mysqli_fetch_assoc($price_fetch)) {
                                $total = $total_row['SUM(rate * quantity)'];
                            }
                            ?>
                            <div class="d-flex justify-content-between px-3">
                                <h6>Subtotal</h6>
                                <h6>&#8377; <?php echo number_format($total); ?></h6>
                            </div>
                            <div class="d-flex justify-content-between px-3">
                                <h6>Delivery</h6>
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


    <?php
    include "../MAIN/Footer.php";
    ?>


</body>

</html>