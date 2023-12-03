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
            <div class="container-fluid">
                <div>
                    <a class="btn shadow-none" href="../index.php"><i class="material-icons">west</i></a>
                    <img class="img-fluid py-2" src="../assets/img/techstop.webp" width="100px" height="30px">
                </div>
                <!-- <a class="navbar-text">
                    <h5>CONNECT MY MOBILE</h5>
                </a> -->
                <button class="btn shadow-none">

                </button>
            </div>
        </nav>



        <!--CONTENT-->
        <div id="Content">
            <div class="container-fluid" id="main_container">

                <div style="margin-top: 120px;">
                    <div class="text-center ">
                        <img src="/IMAGES/payment_successful.gif" alt="" style="height: 100px;">
                    </div>

                    <div class="text-center mt-3">
                        <h2>Your Order has been placed</h2>
                        <h6 class="mt-2"> <a href="Ecommerce.php">Click Here</a> to Go back to Shopping</h6>
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