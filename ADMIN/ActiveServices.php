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
$PageTitle = 'ActiveServices';
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


    <script src="https://cdn.tiny.cloud/1/y49tcx2573i7rzcj4sk5or2yasus65k4w0wqfs0jvhzo6yew/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

</head>

<body>

    <div class="wrapper">
        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid">
                <div>
                    <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>

                </div>

                <a class="navbar-text">
                    <h5>Active Services</h5>

                </a>
                <a href="../profile.php">
                    <i class="material-icons">account_circle</i>
                </a>
            </div>
        </nav>





        <!--SIDEBAR-->
        <?php

        include '../MAIN/Sidebar.php';

        ?>



        <!-- DELETE MODAL -->
        <div class="modal fade" id="cancel_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-end">
                            <button type="button" class="btn-close bg-white shadow-none" data-bs-dismiss="modal" aria-label="Close" style="width: 50px;"></button>
                        </div>
                        <h4 class="mb-4 text-center">Do You want to cancel this service ?</h4>
                        <div class="text-center">
                            <button type="button" class="btn me-3">Yes</button>
                            <button type="button" class="btn ">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- HANDOVER  MODAL -->
        <div class="modal fade" id="handover_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-end">
                            <button type="button" class="btn-close closeBtn bg-white shadow-none" data-bs-dismiss="modal" aria-label="Close" style="width: 50px;"></button>
                        </div>
                        <h4 class="mb-4 text-center">Do You received the payment and handover to customer ?</h4>
                        <div class="text-center">
                            <button type="button" class="btn confirmHandover me-3">Yes</button>
                            <button type="button" data-bs-dismiss="modal" class="btn closeBtn">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--FILTERS-->
        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Filters</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="container-fluid filter_all">

                    <div class="">
                        <h6>Service Status</h6>
                        <div class="d-flex mt-3">
                            <div class=" me-3">
                                <input type="checkbox" class="btn-check comm_select delmode" value="Doorstep" id="btncheck1" autocomplete="off">
                                <label class="btn shadow-none rounded-pill py-1" for="btncheck1">Door Delivery</label>
                            </div>
                            <div class="">
                                <input type="checkbox" class="btn-check comm_select delmode" value="Shop" id="btncheck2" autocomplete="off">
                                <label class="btn shadow-none rounded-pill py-1" for="btncheck2">Shop Visit</label>
                            </div>
                        </div>
                    </div>


                    <div class="mt-3 mb-4">

                    </div>

                    <h5>Sort By</h5>

                    <div class="mt-3 d-flex">
                        <div class="me-3">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                            <label class="btn shadow-none rounded-pill py-1" for="btnradio3">Recent</label>
                        </div>
                        <div class="me-3">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
                            <label class="btn shadow-none rounded-pill py-1" for="btnradio4">Oldest</label>
                        </div>
                    </div>

                    <div class="text-center py-3 mt-3 canvas_foot">
                        <button class="btn rounded-pill clear_all btn_cart shadow-none me-5">Clear all</button>
                    </div>
                </div>
            </div>
        </div>


        <!--CONTENT-->
        <div id="Content" class="mb-5">


            <div class="container-fluid">


                <div class="row">

                    <div class="col-md-6 offset-lg-3 offset-md-3">
                        <div class="d-flex mx-1 mx-sm-0 ">
                            <input type="text" id="searchbox" class=" search form-control py-1" placeholder="Type to search...">
                            <button class="btn btn_fill rounded-circle shadow-none py-1 ms-4 mx-sm-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom"><i class='material-icons'>filter_list</i></button>
                        </div>
                    </div>
                </div>


                <select class="SelectPlugin mb-3" id="product_add">
                    <option hidden value="">Choose Product</option>
                </select>


                <div id="active_service" class="row my-2 service_cards">


                </div>

            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>

    <script src="../JS/product.js"></script>
    <script src="../JS/active_services_fil.js"></script>
    <script>
        var SelectProducts = $('#product_add').selectize({
            maxItems: 1,
            valueField: 'pr_id',
            labelField: 'ProductName',
            searchField: ['ProductName', 'barcode', 'imei'],
            create: false,
            load: (query, callback) => {
                console.log("hello");
                if (query.length < 3) {
                    console.log("hello");
                    return callback();

                }
                $.ajax({
                    url: 'Test.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        SearchProducts: query
                    },
                    error: () => callback(),
                    success: (res) => callback(res),
                });
            },

            render: {
                option: (item, escape) => {
                    if (item.current_stock <= 0) {
                        return '<div class="card-body border-2 border-bottom py-0 px-3 disable"><h6>' + escape(item.ProductName) + '</h6><div class="row"><div class="col-6">IMEI : ' + escape(item.imei) + '</div><div class="col-6 text-end">Barcode : ' + escape(item.barcode) + '</div></div><h6 class="mt-2">Quantity : ' + escape(item.current_stock) + '</h6></div>';
                    }
                    //return '<div class="card w-100"><div class="card-body"><h6 class="card-title">'+ escape(item.name) +'</h6></div></div>';
                    return '<div class="card-body border-2 border-bottom py-0 px-3"><h6>' + escape(item.ProductName) + '</h6><div class="row"><div class="col-6">IMEI : ' + escape(item.imei) + '</div><div class="col-6 text-end">Barcode : ' + escape(item.barcode) + '</div></div><h6 class="mt-2">Quantity : ' + escape(item.current_stock) + '</h6></div>';
                }
            }
        });



        $(document).ready(function() {


            $('.clear_all').click(function() {
                location.reload();
            });

            active_services();


            $('#searchbox').keyup(function() {
                var search = $(this).val();
                console.log(search);
                if (search != '') {
                    active_services(search);
                } else {
                    active_services();
                }
            });


            var activeServices = setInterval(function() {
                active_services();
            }, 10000);

        });
    </script>

    <?php
    include "../MAIN/Footer.php";
    ?>
</body>

</html>