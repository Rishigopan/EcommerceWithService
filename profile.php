<!doctype html>




<?php 

    include "Dbconn.php";
    include "login_verify.php";

    if(isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])){

        $userid = $_COOKIE['custidcookie'];
    }
    else{

        header("location:login.php");
    } 

    
?>





<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Profile</title>


    <style>
        body {
            /* background-color: #eeeeee; */
            background-image: url("assets/img/profileBg.jpg");
            background-size: cover;
            background-repeat: no-repeat;
        }
        
        #Content {
            margin-top: 4rem;
        }
        
       
        .navbar button i,
        .navbar a {
            color: white;
        }
        
        .navbar input {
            width: 20rem;
        }
        #main_container{
            max-width: 1000px;
            width: 100%;
        }
        .card{
            border-radius: 10px;
        }
        .card-header{
            border-radius: 10px 10px 0 0;
        }
        #backg {
            /* background-image: url("data:image/svg+xml,<svg id='patternId' width='150%' height='150%' xmlns='http://www.w3.org/2000/svg'><defs><pattern id='a' patternUnits='userSpaceOnUse' width='69.141' height='40' patternTransform='scale(1) rotate(0)'><rect x='0' y='0' width='100%' height='100%' fill='hsla(356, 97%, 49%, 1)'/><path d='M69.212 40H46.118L34.57 20 46.118 0h23.094l11.547 20zM57.665 60H34.57L23.023 40 34.57 20h23.095l11.547 20zm0-40H34.57L23.023 0 34.57-20h23.095L69.212 0zM34.57 60H11.476L-.07 40l11.547-20h23.095l11.547 20zm0-40H11.476L-.07 0l11.547-20h23.095L46.118 0zM23.023 40H-.07l-11.547-20L-.07 0h23.094L34.57 20z'  stroke-width='1' stroke='hsla(356, 100%, 80%, 1)' fill='none'/></pattern></defs><rect width='800%' height='800%' transform='translate(0,0)' fill='url(%23a)'/></svg>"); */
            min-height: 10rem;
            border-radius: 10px 10px 0 0;
        }
        
        #avt img {
            max-width: 10rem;
            max-height: 10rem;
            border-radius: 50%;
            background-color: green;
            border: 0.3rem solid white;
            box-shadow: 1px 1px 5px grey;
            margin-top: -6.8rem;
        }
        
        .Contact_details{
            position: relative;
        }
        .Contact_details button{
            position: absolute;
            border: 1px solid lightgray;
            background-color: white;
            color: #F50414;
            margin-top: -3px;
            box-shadow: 0px 3spx 5px lightgray !important;
        }
        .Contact_details button:hover{
           background-color: #F50414;
           color: white;
        }
        .Contact_details button i{
           vertical-align: top;
          
        }
        .order_info h6 i {
            vertical-align: middle;
            line-height: 1.8rem;
            color: #F50414;
        }
        
        .order_info h6 span {
            padding-left: 10px;
        }
        
        .order_info h6 {
            margin: 5px 0px;
        }
       .contactImage{
            width: 300px;
            height: 250px;
            margin: auto;
            border-radius:10px;
       }
       .profileImg{
            border-radius:50%;
       }
       .iconCircle{
            width: 80px;
            height: 80px;
            border-radius: 50%;
            font-size: 50px;
            background-color: #FF8C00;
       }
       .contactDetail{
            border-radius:10px;
       }
    </style>

</head>

<body>

    <div class="wrapper">
        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top py-0" style="background-color:#FF8C00;">
            <div class="container-fluid ">
                <a class="btn shadow-none" type="button" href="javascript:history.go(-1)" ><i class="material-icons">west</i></a>
                <a class="navbar-text me-auto" style="text-decoration: none;">
                    <h5>Profile</h5>
                </a>
                <h6 class="text-white">Sign Out</h6><a class="btn shadow-none" type="button" href="logout.php" ><i class="material-icons">logout</i></a>
                
            </div>
        </nav>

        <!--CONTENT-->
        <div id="Content" class="mb-5">


            <div id="main_container" class="container-fluid">

            <?php 
            
                $fetch_account_query = mysqli_query($con,"SELECT first_name,last_name,type,phone_number,email_id,address_detailed,city,state,pincode FROM user_details WHERE user_id ='$userid'");
                while($fetch_results = mysqli_fetch_assoc($fetch_account_query)){
                    $user_type = $fetch_results['type'];
                    $name = $fetch_results['first_name'].'&nbsp;'.$fetch_results['last_name'];
                    $phone = $fetch_results['phone_number'];
                    $email = $fetch_results['email_id'];
                    $address = $fetch_results['address_detailed'];
                    $city = $fetch_results['city'];
                    $state = $fetch_results['state'];
                    $pincode =  $fetch_results['pincode'];
                }
            
            ?>

                <!-- <div class="card shadow-lg mx-5 contactImage">
                    <div class="card-header" id="backg">
                         
                    </div>
                    <div class="card-body" id="avt">
                        <div class="text-center">
                            <img src="./EMPL/png-transparent-call-centre-customer-service-boy-avatar-white-child-face.png" alt="avatar">
                        </div>
                        <div class="text-center">
                            <h3 class="pt-3"><?php echo ucfirst($name) ;?></h3>
                        </div>
                    </div>
                </div> -->

                <div class="shadow-lg contactImage">
                    <div class="text-center">
                        <img src="assets/img/team/team-1.jpg" alt="avatar" style="width:120; height:120px;" class="mt-4 profileImg">
                        <!-- <h3 class="pt-3"><?php echo ucfirst($name) ;?></h3> -->
                        <h3 class="text-center border-3 pb-2 mt-4">Contact Details</h3>
                    </div>
                </div>
                

                <!-- <div  class=" Contact_details card card-body shadow-sm mt-3">
                    <h5 class="text-center border-bottom border-3 pb-2">Contact Details</h5>

                    <div class="col-12 order_info mb-3">
                        <div class="mx-2 px-2 text-muted">
                            <h6 class="">
                                <i class="material-icons">phone</i>
                                <span><?php echo $phone; ?></span>
                            </h6>
                            <h6>
                                <i class="material-icons">alternate_email</i>
                                <span><?php echo $email; ?></span>
                            </h6>
                            <h6>
                                <i class="material-icons">place</i>
                                <span><?php echo ''.$address.','.$city.','.$state.','.$pincode.''; ?></span>
                            </h6>
                        </div>
                        
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn shadow-none rounded-circle" type="button" onclick="document.location='Edit Profile.html'" >
                            <i class="material-icons">edit</i>
                        </button>
                    </div>
                </div> -->

                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-12 pe-0">
                        <div class="shadow-lg text-center mt-5 pt-4 bg-white contactDetail mx-4" style="height:17rem;">
                        <i class="material-icons iconCircle pt-3 mt-4">phone</i>
                            <h5 class="mt-5 mb-3"><?php echo $phone; ?></h5>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-12 px-0">
                        <div class="shadow-lg text-center mt-5 pt-4 bg-white pb-3 contactDetail mx-4" style="height:17rem;">
                            <i class="material-icons iconCircle pt-3 mt-4">alternate_email</i>
                            <h5 class="mt-5 mb-3"><?php echo $email; ?></h5>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-12 ps-0">
                    <div class="shadow-lg text-center mt-5 pt-4 bg-white contactDetail mx-4" style="height:17rem;">
                            <i class="material-icons iconCircle pt-3 mt-4">place</i>
                            <h5 class="mt-3 mb-3"><?php echo ''.$address.','.$city.',' ?><br><?php echo ''.$state.','.$pincode.''; ?></h5>
                        </div>
                    </div>
                </div>

                <?php 
                    if($user_type == 'customer' ){
                ?>
                
                    <div class=" Contact_details card card-body shadow-sm mt-5">
                        <h5 class="text-center border-bottom border-3 pb-2">Billing Details</h5>

                        <div class="col-12 order_info mb-3 ">
                            <div class="mx-2 px-2 text-muted">
                                <h6 class="">
                                    <i class="material-icons">face</i>
                                    <span><?php echo ucfirst($name) ;?></span>
                                </h6>
                                <h6 class="">
                                    <i class="material-icons">phone</i>
                                    <span><?php echo $phone; ?></span>
                                </h6>
                                <h6>
                                    <i class="material-icons">alternate_email</i>
                                    <span><?php echo $email; ?></span>
                                </h6>
                                <h6>
                                    <i class="material-icons">place</i>
                                    <span><?php echo ''.$address.','.$city.','.$state.','.$pincode.''; ?></span>
                                </h6>
                            </div>
                            
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn shadow-none rounded-circle" type="button" onclick="document.location='Edit Profile.html'">
                                <i class="material-icons">edit</i>
                            </button>
                        </div>
                    </div>


                    <div class=" Contact_details card card-body shadow-sm mt-5">
                    <div>
                            <h5 class="text-center border-bottom border-3 pb-2">My Orders</h5>
                            <ul class="list-unstyled text-muted">
                                <?php 
                                
                                    $fetch_order_query = mysqli_query($con, "SELECT * FROM order_details WHERE phone = '$phone' ORDER BY order_id DESC LIMIT 3");
                                    if(mysqli_num_rows($fetch_order_query) > 0){
                                        while($orders_result = mysqli_fetch_array($fetch_order_query)){
                                        
                                            $order_id = $orders_result['order_id'];
                                            $order_items_query = mysqli_query($con, "SELECT * FROM order_items WHERE order_id = '$order_id'");
                                            while($order_items_results = mysqli_fetch_array($order_items_query)){
        
                                    ?>
                                        <li class="border-bottom d-flex justify-content-between">
                                            <h6># <?php echo $order_items_results['order_id']; ?> <br> <span class="ps-2"  style="font-size: smaller;" >( &#8377; <?php echo number_format($order_items_results['price'] * $order_items_results['quantity']) ; ?>)</span></h6>
                                            <h6 class="my-auto"><?php echo $order_items_results['pr_name']; ?> </h6>
                                        </li>
        
                                    <?php
                                            } 
                                        }
                                    }
                                    else{
                                        echo '<li> <h6>No orders placed</h6>  </li>';
                                    }
                                    ?>
                                
                            </ul>
                    </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn shadow-none rounded-circle">
                                <i class="material-icons">expand_more</i>
                            </button>
                        </div>
                    </div>
                

                    <div class=" Contact_details card card-body shadow-sm mt-5">
                        <div>
                            <h5 class="text-center border-bottom border-3 pb-2">My Services</h5>
                            <ul class="list-unstyled text-muted">
                                <?php 
                                    $fetch_service_query = mysqli_query($con, "SELECT * FROM service_order WHERE cust_phone = '$phone' ORDER BY so_id DESC LIMIT 3");
                                    if(mysqli_num_rows($fetch_service_query) > 0){

                                        while($service_result = mysqli_fetch_array($fetch_service_query)){
                                        
                                            $service_id = $service_result['so_id'];
                                            $service_items_query = mysqli_query($con, "SELECT * FROM service_items WHERE so_id = '$service_id'");
                                            while($service_items_results = mysqli_fetch_array($service_items_query)){
                                                $service_list[] = $service_items_results['service'];
                                                $new_list = implode(",",  $service_list);
                                            }
                                    ?>
                                        <li class="border-bottom d-flex justify-content-between">
                                            <h6># <?php echo $service_result['so_id']; ?> <br> <span class="ps-2"  style="font-size: smaller;" >( <?php echo $new_list;  ?>)</span></h6>
                                            <h6 class=""><?php echo $service_result['brand'].'&nbsp;'.$service_result['model'] ; ?> </h6>
                                        </li>
                                    <?php
                                            } 
                                        }
                                        else{
                                            echo '<li> <h6>No service orders placed</h6>  </li>';
                                        }
                                    ?>
                            </ul>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn shadow-none rounded-circle" type="button" onclick="document.location='My services.html'" >
                                <i class="material-icons">expand_more</i>
                            </button>
                        </div>
                    </div>
                    <?php       
                        }
                    else{

                    }
                    ?>

            </div>
        </div>


    </div>





    <script>
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