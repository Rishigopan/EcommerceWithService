<?php

require "../MAIN/Dbconn.php";


if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

    if ($_COOKIE['custtypecookie'] == 'executive' || $_COOKIE['custtypecookie'] == 'admin') {
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

    <!-- SELECTIZE  CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/css/selectize.bootstrap5.css" integrity="sha512-QomP/COM7vFCHcVHpDh/dW9oDyg44VWNzgrg9cG8T2cYSXPtqkQK54WRpbqttfo0MYlwlLUz3EUR+78/aSbEIw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/js/selectize.min.js" integrity="sha512-VReIIr1tJEzBye8Elk8Dw/B2dAUZFRfxnV2wbpJ0qOvk57xupH+bZRVHVngdV04WVrjaMeR1HfYlMLCiFENoKw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <style>
        .disable {
            opacity: 0.5;
            pointer-events: none;

        }
    </style>



</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h3>
                </div>
                <div class="modal-body ">
                    <h4 class="text-center">Successfully Saved Sale Entry</h4>
                    <div class="d-flex justify-content-around mt-3">
                        <a id="SalesPrintButton" href="SalesPrint.php?OID=" target="_blank" class="btn btn_cart rounded-pill px-5">Print</a>
                        <a href="" data-bs-dismiss="modal" class="btn  btn-secondary rounded-pill px-5">Close</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="wrapper">

        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid ">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text mx-auto">
                    <h5>Shopping Cart</h5>
                </a>

                <div class=" d-flex">
                    <a class="btn text-white shadow-none d-none" href="AdminShoppingcart.php">
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
        <div id="Content" class="mb-5 shopping_cart">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-7 col-12  order-lg-1 order-1">
                        <div class="card card-body shadow-sm">

                            <!-- <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="DateSelection.php">Service</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Information</li>
                                </ol>
                            </nav> -->

                            <h5 class="text-decoration-underline">Personal Details</h5>


                            <form action="" method="" id="Details" class=" px-3">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <label for="first_name" class="form-label">Name</label>
                                        <input type="text" id="first_name" name="cust_name" class="form-control" placeholder="Enter Name"  required>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 mt-md-0">
                                        <label for="mobile" class="form-label">Phone Number</label>
                                        <input type="text" id="mobile" name="cust_phone" class="form-control" placeholder="Enter Phone Number"  required>
                                    </div>
                                  
                                    <!-- <div class="col-12 mt-2">
                                        <label for="address" class="form-label">Your Address</label>
                                        <input type="text" id="address" name="cust_address" class="form-control" placeholder="Enter Address"  required>
                                    </div> -->
                                    
                                    <div class="col-12 mt-2">
                                        <label for="details" class="form-label">Address</label>
                                        <textarea name="add_details" id="details" cols="3" rows="3" class="form-control shadow-none" ></textarea>
                                    </div>
                                    <!-- <div class="d-flex justify-content-between mt-3 mb-3">
                                        <a href="DateSelection.php" class="btn shadow-none rounded-pill back_btn px-md-4"> <span class="d-none d-md-inline-flex">Back to</span> Service</a>
                                        <button class="btn shadow-none rounded-pill btn_cart " name="Info_btn" type="submit"> <span class="d-none d-md-inline-flex">Continue to </span> Payment</button>
                                    </div> -->
                                </div>
                            </form>

                        </div>
                    </div>


                    <div class="col-lg-5 col-12 order-lg-2 order-2 mt-3 mt-lg-0">

                        <div class="card card-body shadow-sm">
                            <?php

                            $fetch_model_name = mysqli_query($con, "SELECT model_name FROM models WHERE mo_id = '$model'");
                            foreach ($fetch_model_name as $model_name) {
                                echo '<h5 class="border-bottom pb-2">' . $model_name['model_name'] . '</h5>';
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


        <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>




        <?php
        include "../MAIN/Footer.php";
        ?>

</body>

</html>