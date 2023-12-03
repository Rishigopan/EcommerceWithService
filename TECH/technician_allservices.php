
    <?php 
        require "../MAIN/Dbconn.php"; 

        // if(isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])){

        //     if($_COOKIE['custtypecookie'] != 'technician' ){
        //         header("location:../login.php");
        //     }
        //     else{

        //     } 
        // }
        // else{
        //     header("location:../login.php");
        // }
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
                    <h5>Technician Window</h5>
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
                        <a href="technician_allservices.php" class="active"><i class="material-icons">construction</i>
                            <span>All Services</span>
                        </a>
                    </li>
                    
                </ul>

            </div>
        </div>


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
                        <h6>Service Types</h6>
                        <div class="d-block d-md-flex mt-3">
                            <div class="d-flex">
                                <div class=" me-3">
                                    <input type="checkbox" class="btn-check comm_select techprogress" value="Diagnosis" id="btncheck3" autocomplete="off">
                                    <label class="btn shadow-none rounded-pill py-1" for="btncheck3">Diagnosis</label>
                                </div>
                                <div class="me-3">
                                    <input type="checkbox" class="btn-check comm_select techprogress" value="Service" id="btncheck4" autocomplete="off">
                                    <label class="btn shadow-none rounded-pill py-1" for="btncheck4">Service</label>
                                </div>
                                <div class=" me-3">
                                    <input type="checkbox" class="btn-check comm_select techprogress" value="Testing" id="btncheck5" autocomplete="off">
                                    <label class="btn shadow-none rounded-pill py-1" for="btncheck5">Testing</label>
                                </div>
                            </div>
                            
                        </div>
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
                            <input type="text" id="searchbox" class="search form-control py-1" placeholder="Type to search...">
                            <button class="btn btn_fill rounded-circle shadow-none py-1 ms-4 mx-sm-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom"><i class='material-icons'>filter_list</i></button>
                        </div>
                    </div>
                </div>



                <div id="all_devices" class="row my-2 service_cards">


                </div>



            </div>
        </div>

    </div>




    <script src="../JS/techdata.js"></script>
    <script>




        $(document).ready(function(){

            $('.clear_all').click(function(){
                location.reload();
            });

            tech_services();

            $('#searchbox').keyup(function(){
                var search = $(this).val();
                console.log(search);
                if(search != ''){
                    tech_services(search);
                }
                else
                {
                    tech_services();
                }
	        });

            setInterval(function() {
                tech_services();
            }, 10000);
        });

    </script>

    <?php 
        include "../MAIN/Footer.php";
    ?>
   
</body>

</html>