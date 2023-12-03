

    <?php 
        require "../MAIN/Dbconn.php"; 
        if(isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])){

            if($_COOKIE['custtypecookie'] != 'delivery' ){
                header("location:../login.php");
            }
            else{

            } 
        }
        else{
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

    <!--FILTERS-->
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasBottomLabel">Filters</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="container-fluid filter_all">

                <div class="mb-3">
                    <h6>Delivery Type</h6>
                    <div class="d-flex mt-3">
                        <div class=" me-3">
                            <input type="checkbox" class="btn-check comm_select deltype" value="pickup" id="btncheck1" autocomplete="off">
                            <label class="btn shadow-none rounded-pill py-1" for="btncheck1">To Shop</label>
                        </div>
                        <div class="">
                            <input type="checkbox" class="btn-check comm_select deltype" value="delivery" id="btncheck2" autocomplete="off">
                            <label class="btn shadow-none rounded-pill py-1" for="btncheck2">To Customer</label>
                        </div>
                    </div>
                </div>

                <h6>Sort By</h6>

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
                    <button class="btn rounded-pill clear_all  btn_cart shadow-none me-5">Clear all</button>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper">


        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid">
            <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5>Service Delivery</h5>
                </a>
                <a href="../profile.php">
                    <i class="material-icons">account_circle</i>
                </a>
            </div>
        </nav>

        <!--SIDEBAR-->
        <div class="offcanvas  offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">


            <div class="offcanvas-body">

                <div class="profile">
                    <img src="../employee.png" alt="">
                    <h6>User Name</h6>
                </div>

                <ul id="menu" class="list-unstyled">
                    <li>
                        <a href="../assets/img/DELIVERY/Delivery Screen.php">
                            <i class="material-icons">currency_rupee</i>
                            <span>Sales Delivery</span>
                        </a>
                        <a href="../assets/img/DELIVERY/service_delivery.php" class="active">
                            <i class="material-icons">construction</i>
                            <span>Service Delivery</span>
                        </a>
                    </li>
                </ul>

            </div>
        </div>



        <!-- PAY MODAL -->
        <div class="modal fade" id="pay_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-end">
                            <button type="button" class="btn-close cancelBtn bg-white shadow-none" data-bs-dismiss="modal" aria-label="Close" style="width: 50px;"></button>
                        </div>
                        <h4 class="mb-4 text-center">Did you recieved the payment ?</h4>
                        <div class="text-center">
                            <button class="btn confirmBtn shadow-none me-3" type="button" data-bs-dismiss="modal" aria-label="Close" >Yes</button>
                            <button type="button" class="btn cancelBtn shadow-none " data-bs-dismiss="modal" aria-label="Close" >No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- SHOP MODAL -->
        <div class="modal fade" id="shop_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-end">
                            <button type="button" class="btn-close shopcancelBtn bg-white shadow-none" data-bs-dismiss="modal" aria-label="Close" style="width: 50px;"></button>
                        </div>
                        <h4 class="mb-4 text-center">Have you handovered the device to technician ?</h4>
                        <div class="text-center">
                            <button class="btn confirmshopBtn shadow-none me-3" type="button" data-bs-dismiss="modal" aria-label="Close" >Yes</button>
                            <button type="button" class="btn shadow-none shopcancelBtn " data-bs-dismiss="modal" aria-label="Close" >No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        

        <!--CONTENT-->
        <div id="Content" class="mb-5">


            <div class="container-fluid">

                <div class="row">
                    <div  class="col-md-6 offset-lg-3 offset-md-3">
                        <div class="d-flex mx-1 mx-sm-0  ">
                            <input type="text" id="searchbox"  class="search form-control py-1" placeholder="Type to search...">
                            <button class="btn btn_fill shadow-none rounded-circle py-1 ms-4 mx-sm-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"><i class='material-icons'>filter_list</i></button>
                        </div>
                    </div>
                </div>

                
                <div id="service" class="row my-2 service_cards"></div>

            </div>
        </div>

    </div>




    <script src="../JS/service_delivery.js"></script>
    <script>

        $(document).ready(function(){

            service_delivery();

            $('.clear_all').click(function(){
                location.reload();
            });


            $('#searchbox').keyup(function(){
                var search = $(this).val();
                console.log(search);
                if(search != ''){
                    service_delivery(search);
                }
                else
                {
                    service_delivery();
                }
	        });


            setInterval(function() {
                service_delivery();
            }, 10000);



        });






    </script>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js " integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM " crossorigin="anonymous "></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js " integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p " crossorigin="anonymous "></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js " integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF " crossorigin="anonymous "></script>
    -->
</body>

</html>