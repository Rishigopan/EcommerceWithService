<?php


require "../MAIN/Dbconn.php"; 


if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

    if ($_COOKIE['custtypecookie'] == 'executive' || $_COOKIE['custtypecookie'] == 'admin') {

        $cart_table = $_COOKIE['custidcookie'] . $_COOKIE['custnamecookie'] . '_cart';
        $cust_id = $_COOKIE['custidcookie'];
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

    <style>




    </style>

</head>

<body>

    <div class="wrapper">

        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid ">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text mx-auto">
                    <h5>Checkout</h5>
                </a>

                <div class=" d-flex">
                    <a class="btn text-white shadow-none " href="AdminShoppingcart.php">
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
        <div id="Content" class="mb-5 checkout">

            <div class="container-fluid">



                <div class="row">

                    <div class="col-lg-7 col-12  order-lg-1 order-1">
                        <div class="card card-body shadow-sm">

                            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./AdminEcommerce.php">Products</a></li>
                                    <li class="breadcrumb-item"><a href="./AdminShoppingcart.php">Shopping Cart</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Information</li>
                                </ol>
                            </nav>

                            <h5>Shipping Details</h5>
                            <form action="AdminSalesOperations.php" method="POST" id="Details" class="mt-2 px-3">

                                <div class="row">

                                    <input type="text" id="billed_person" name="biller" class="form-control" value=" <?php echo $_COOKIE['custidcookie']; ?>" required hidden>
                                    <div class="col-6">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" id="first_name" name="first" class="form-control" placeholder="Enter First Name" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" id="last_name" name="last" class="form-control" placeholder="Enter Last Name" required>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="mobile" class="form-label">Phone Number</label>
                                        <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Enter Phone Number" required>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="email" class="form-label">Email Id</label>
                                        <input type="email" id="email" name="email_id" class="form-control" placeholder="Enter Email Id" required>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="address" class="form-label">Your Address</label>
                                        <input type="text" id="address" name="adddresses" class="form-control" placeholder="Enter Address" required>
                                    </div>
                                    <div class="col-12 col-md-4 mt-2">
                                        <label for="city" class="form-label">City</label>
                                        <select name="city" id="city" class="form-select">
                                            <option value="Trivandrum">Trivandrum</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4 mt-2">
                                        <label for="center" class="form-label">State</label>
                                        <select name="state" id="center" class="form-select">
                                            <option value="kerala">Kerala</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4 mt-2">
                                        <label for="pincode" class="form-label">Pincode</label>
                                        <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Enter Pincode" required>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="details" class="form-label">Order Details</label>
                                        <textarea name="ord_details" id="details" cols="3" rows="3" class="form-control shadow-none" placeholder="Additional notes about your order e.g:- delivery notes"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-center mt-3 mb-3">
                                        <button class="btn shadow-none px-4 rounded-pill btn_cart " type="submit" name="place_order">Place Order</button>
                                    </div>
                                </div>

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
                                                    <img src="../PRODUCTS/<?php echo $cart_result['img']; ?>" alt="">
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

            </div>
        </div>

    </div>


    <?php
    include "../MAIN/Footer.php";
    ?>



</body>

</html>