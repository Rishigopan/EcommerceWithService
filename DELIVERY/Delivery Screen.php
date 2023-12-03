


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

    <div class="wrapper">
        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid">
            <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5>Sales Delivery</h5>
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
                        <a href="../assets/img/DELIVERY/Delivery Screen.php" class="active">
                            <i class="material-icons">currency_rupee</i>
                            <span>Sales Delivery</span>
                        </a>
                        <a href="../assets/img/DELIVERY/service_delivery.php">
                            <i class="material-icons">construction</i>
                            <span>Service Delivery</span>
                        </a>
                    </li>
                    
                
                </ul>

            </div>
        </div>



        <!-- DELETE MODAL -->
        <div class="modal fade" id="pay_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-end">
                            <button type="button" class="btn-close bg-white shadow-none" data-bs-dismiss="modal" aria-label="Close" style="width: 50px;"></button>
                        </div>
                        <h4 class="mb-4 text-center">Did you recieved the payment ?</h4>
                        <div class="text-center">
                            <button class="btn confirmBtn shadow-none me-3" type="button" data-bs-dismiss="modal" aria-label="Close" >Yes</button>
                            <button type="button" class="btn shadow-none " data-bs-dismiss="modal" aria-label="Close" >No</button>
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
                        <div class="d-flex mx-1 mx-sm-0 ">
                            <input type="text" id="searchbox"  class="search form-control py-1" placeholder="Type to search...">
                        </div>
                    </div>
                </div>

                

                <div id="home" class="row my-2 service_cards"></div>

            </div>
        </div>
    </div>




    <script src="../JS/Sales_delivery.js"></script>
    <script>

        $(document).ready(function(){

            sales_delivery();


            $('#searchbox').keyup(function(){
                var search = $(this).val();
                console.log(search);
                if(search != ''){
                    sales_delivery(search);
                }
                else
                {
                    sales_delivery();
                }
	        });

            var sales_delivery_data = setInterval(function() {
                sales_delivery();
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