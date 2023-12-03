

    <?php 
        require "../MAIN/Dbconn.php"; 

        if(isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])){

            if($_COOKIE['custtypecookie'] == 'executive' || $_COOKIE['custtypecookie'] == 'admin'){
                echo "";
            }
            else{
                header("location:../login.php");
            } 

        }
        else{
            header("location:../login.php");
        }
        $PageTitle = 'SalesOrders';
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
            <div class="container-fluid">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5>Sales Orders</h5>
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


        <!--FILTERS-->
        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Filters</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-0">
                <div class="container-fluid filter_all">

                    <div class="mt-3 mb-4">
                        <h6>Delivery Status</h6>
                        <div class="d-block d-md-flex mt-3">
                            <div class="d-flex">
                                <div class=" me-3">
                                    <input type="checkbox" class="btn-check comm_select status" id="btncheck3" value="Not Delivered" autocomplete="off">
                                    <label class="btn shadow-none rounded-pill py-1" for="btncheck3">Not Delivered</label>
                                </div>
                                <div class="me-3">
                                    <input type="checkbox" class="btn-check comm_select status" id="btncheck4" value="In Transit" autocomplete="off">
                                    <label class="btn shadow-none rounded-pill py-1" for="btncheck4">In Transit</label>
                                </div>
                            </div>
                            <div class="d-flex mt-md-0 mt-2">
                            </div>
                        </div>
                    </div>

                    

                    <h5>Sort By</h5>

                    <div class="d-block d-md-flex mt-3">
                        <div class=" d-flex">
                            <div class="me-3">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                                <label class="btn shadow-none rounded-pill py-1" for="btnradio3">Recent</label>
                            </div>
                            <div class="me-3">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
                                <label class="btn shadow-none rounded-pill py-1" for="btnradio4">Oldest</label>
                            </div>
                            <div class="me-3">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off">
                                <label class="btn shadow-none rounded-pill py-1" for="btnradio5">Price : Low to High</label>
                            </div>
                        </div>
                        <div class="d-flex mt-md-0 mt-2">
                            <div class="me-3">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio6" autocomplete="off">
                                <label class="btn shadow-none rounded-pill py-1" for="btnradio6">Price : High to Low</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-center py-3 mt-3 canvas_foot">
                        <button class="btn clear_all rounded-pill btn_cart shadow-none me-5">Clear all</button>
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
                                <input type="text" class="search form-control py-1" id="searchbox" placeholder="Type to search...">
                                <button class="btn btn_fill rounded-circle shadow-none py-1 ms-4 mx-sm-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom"><i class='material-icons'>filter_list</i></button>
                            </div>
                        </div>
                    </div>


                        <div id="results" class="row my-2 service_cards">

                        </div>
                </div>
        </div>

    </div>



    <script src="../JS/Filter.js"></script>
    <script>

        $(document).ready(function(){

            $('.clear_all').click(function(){
                location.reload();
            });

            filter_data();

            $('#searchbox').keyup(function(){
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

            var refreshId = setInterval(function() {
                filter_data();
            }, 10000);
            
        });

    </script>

    <?php 
        include "../MAIN/Footer.php";
    ?>
        
</body>

</html>