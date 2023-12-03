
    <?php  

        require "../MAIN/Dbconn.php";

        if(isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])){

            if($_COOKIE['custtypecookie'] != 'technician' ){
                header("location:../login.php");
            }
            else{

            } 
        }
        else{
            header("location:../login.php");
        }

        $service_id = $_GET['service_id'];
        
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
                <button class="btn shadow-none" type="button" onclick="document.location='technician_allservices.php'"><i class="material-icons">west</i></button>
                <a class="navbar-text me-auto">
                    <h5>Service Window</h5>
                </a>
                <a href="../profile.php">
                    <i class="material-icons">account_circle</i>
                </a>
            </div>
        </nav>

       <!-- FINISH MODAL -->
        <div class="modal fade" id="finish_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-end">
                            <button type="button" class="btn-close btnClose bg-white shadow-none" data-bs-dismiss="modal" aria-label="Close" style="width: 50px;"></button>
                        </div>
                        <h4 class="mb-4 text-center">Are you sure you have completed the Diagnosis,Service and Testing processes and ready to handover the device to the customer ?</h4>
                        <div class="text-center">
                            <button type="button" id="confirmBtn" class="btn shadow-none  rounded-pill px-4 me-3">Yes</button>
                            <button type="button" data-bs-dismiss="modal" class="btn shadow-none btnClose rounded-pill px-4 ">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!--CONTENT-->
        <div id="Content" class="mb-5 allservice">

            <div class="container-fluid">
                
                <div class="row">
                <?php 
                    $fetch_service_query = mysqli_query($con,"SELECT * FROM service_order se INNER JOIN brands b ON b.br_id = se.brand INNER JOIN models m ON m.mo_id = se.model WHERE so_id = '$service_id'");
                    while($service_details = mysqli_fetch_array($fetch_service_query)){
                    $so_id = $service_details['so_id'];
                    $status = $service_details['tech_status'];
                    $brand = $service_details['brand'];
                    $model = $service_details['model'];
                    ?>
                        <!--DIAGNOSIS-->
                        <div class="col-12 col-md-6 col-lg-4  <?php if($status == 'Diagnosis'){ echo "no"; } ?>">
                            <div id="main_card" class="card card-body shadow">
                                <div id="heading" class="heading">
                                    <h5 class="my-auto text-center">1. Diagnosis</h5>
                                </div>
                                    <div class="card card-body inside_card mx-3 mt-2 service_cards ">
                                        <div class="order_info ">
                                            <div class="">
                                                <div class="d-flex justify-content-between">
                                                    <h6 class="">
                                                        <i class="material-icons">tag</i>
                                                        <span class="text-muted">Order ID</span>
                                                    </h6>
                                                    <h6><?php  echo $service_details['so_id']; ?></h6>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <h6 class="">
                                                        <i class="material-icons">smartphone</i>
                                                        <span class="text-muted">Device</span>
                                                    </h6>
                                                    <h6><?php  echo $service_details['brand_name'].'&nbsp;'.$service_details['model_name']; ?></h6>
                                                </div>
                                            
                                                <div class="d-flex justify-content-between">
                                                    <h6>
                                                        <i class="material-icons">face</i>
                                                        <span class="text-muted">Customer</span>
                                                    </h6>
                                                    <h6> <?php echo ucfirst($service_details['cust_name']); ?>  </h6>
                                                </div>
                                                
                                                <div class="d-flex justify-content-between">
                                                    <h6>
                                                        <i class="material-icons">phone</i>
                                                        <span class="text-muted">Phone Number</span>
                                                    </h6>
                                                    <h6> <?php echo $service_details['cust_phone']; ?> </h6>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <h6>
                                                        <i class="material-icons">alarm</i>
                                                        <span class="text-muted">Expected Time</span>
                                                    </h6>
                                                    <h6> <?php if($service_details['expected_time'] == null){echo "";} else{ echo date("d-M h:i a", strtotime($service_details['expected_time'])); }  ?> </h6>
                                                </div>
            
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-body inside_card services mt-3 mx-3 p-2 ">
                                        <ul class="list-unstyled">
                                            <?php 
                                            

                                                $fetch_details_query = mysqli_query($con, "SELECT * FROM service_items si INNER JOIN service_main sm ON si.main_sr_id = sm.main_id INNER JOIN services s ON s.sr_id = sm.sr_id WHERE so_id = '$so_id' ");
                                                while($fetch_details = mysqli_fetch_assoc($fetch_details_query)){
                                            ?>
                                                <li class="border-bottom">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex mt-2">
                                                            <img src="../assets/img/SERVICE/<?php 
                                                                if ($fetch_details['service'] == null){
                                                                    echo $fetch_details['service_img'];
                                                                }else{
                                                                    echo 'common.jpg';
                                                                }
                                                            ?>" alt="">
                                                            <div class="w-100 ms-2">
                                                                <div class=" d-block justify-content-between">
                                                                    <h6 class=""><?php  if ($fetch_details['service'] == null){
                                                                        echo $fetch_details['service_name'];
                                                                    }else{
                                                                        echo $fetch_details['service'];
                                                                    }
                                                                     ?></h6>
                                                                    <h5 class=""> &#8377;  <?php echo number_format($fetch_details['cost']) ; ?>  </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php
                                               
                                            }
                                            ?>
                                            
                                        </ul>
                                    </div>
                                <div class="text-center mx-3 my-3">
                                    <button id="strtDiagnosis" value="<?php echo $so_id; ?>" class="btn btn_cart rounded-pill py-1">Start diagnosis</button>
                                </div>
                            </div>
                        </div>


                        <!--SERVICE-->
                        <div class="col-12 col-md-6 col-lg-4 mt-4 mt-md-0">
                            <div id="main_card" class="card card-body shadow">
                                <div id="heading" class="heading">
                                    <h5 class="my-auto text-center">2. Service</h5>
                                </div>

                                <div class="card card-body inside_card mx-3 mt-2 p-2">
                                    <h6>Add Service</h6>
                                    <form id="AddService" action="" method="">
                                        <input type="text" name="Add_id" value="<?php echo $so_id; ?>" hidden>
                                        <div class="mt-1">
                                            <select name="S_select" id="" class="form-select shadow-none py-1">
                                                <option hidden value="">Choose A Service</option>
                                                <?php
                                                    $brand = $service_details['brand']; 
                                                    $model = $service_details['model']; 
                                                    $find_service = mysqli_query($con,"SELECT * FROM service_main sm INNER JOIN services s ON sm.sr_id = s.sr_id WHERE sm.br_id = '$brand' AND sm.mo_id = '$model'");
                                                    foreach($find_service as $list_services){
                                                        echo '<option value="'.$list_services["main_id"].'">'.$list_services["service_name"].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <h6 class="text-center mt-1">Or</h6>
                                        <div class="d-flex justify-content-between">
                                            <input type="text" name="S_name" class="form-control shadow-none py-1 me-3" placeholder="Enter Service Name">
                                            <input type="text" name="S_amount" class="form-control shadow-none py-1 ms-3" placeholder="Enter Service Amount">
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn_cart rounded-pill py-1">Add Service</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="card card-body inside_card my-3 mx-3 p-2 ">
                                    <h6 class="py-2">Expected Delivery Time</h6>
                                    <form action="" class="p-0" id="StrtService">
                                        <div class="pb-2">
                                            <input class="form-control" type="text" value="<?php echo $so_id; ?>" name="sorder_id" hidden>
                                            <input class="form-control" type="datetime-local" name="exp_time">
                                        </div>
                                        <div class=" d-flex justify-content-between mx-2 mt-3">
                                            <a href="tel:+91 <?php echo $service_details['cust_phone']; ?>" class="btn btn_cart rounded-pill py-1 ">Call</a>
                                            <button type="submit" class="btn btn_cart rounded-pill py-1 ">Start Service</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                

                        <!--TESTING-->
                        <div class="col-12 col-md-6 col-lg-4 mt-4 mt-lg-0">
                            <div id="main_card" class="card card-body shadow">
                                <div id="heading" class="heading">
                                    <h5 class="my-auto text-center">3. Testing</h5>
                                </div>

                                <div class="d-flex px-3 my-2">
                                    <h6 class="my-auto"> Completed Service?</h6>
                                    <button id="strtTest" value="<?php echo $so_id; ?>" class="btn btn_cart rounded-pill py-1 ms-auto">Start Test</button>
                                </div>
                            

                                <div class="card card-body inside_card mt-3 services mx-3 p-2 ">
                                <ul class="list-unstyled">
                                    <?php
                                        $fetch_details_query = mysqli_query($con, "SELECT * FROM service_items si LEFT JOIN service_main sm ON si.main_sr_id = sm.main_id LEFT JOIN services s ON sm.sr_id = s.sr_id WHERE si.so_id = '$so_id'");
                                        while($fetch_details = mysqli_fetch_assoc($fetch_details_query)){
                                    ?>
                                        <li class="border-bottom">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex mt-2">
                                                    <img src="../assets/img/SERVICE/<?php
                                                        if ($fetch_details['service'] == null){
                                                            echo $fetch_details['service_img'];
                                                        }else{
                                                            echo 'common.jpg';
                                                        }
                                                    ?>" alt="">
                                                    <div class="w-100 ms-2">
                                                        <div class=" d-block justify-content-between">
                                                            <h6 class=""><?php  if ($fetch_details['service'] == null){
                                                                echo $fetch_details['service_name'];
                                                            }else{
                                                                echo $fetch_details['service'];
                                                            }
                                                             ?></h6>
                                                            <h5 class=""> &#8377; 
                                                            <?php  if ($fetch_details['service'] == null){
                                                                echo number_format($fetch_details['cost']);
                                                            }else{
                                                                echo number_format($fetch_details['price']);
                                                            }
                                                             ?> </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <button  class="btn delBtn shadow-none" value="<?php echo $fetch_details['id']; ?>" >  <i class="material-icons">remove_circle_outline</i> </button>
                                                </div>
                                            </div>
                                        </li>
                                    <?php
                                        }  
                                    
                                    ?>
                                </ul>
                                <div class="d-flex justify-content-between px-2">
                                    <h4>Total</h4>
                                    <h4>&#8377; 
                                            <?php
                                                $fetch_total = mysqli_query($con, "SELECT SUM(price),SUM(cost) FROM service_items si LEFT JOIN service_main sm ON si.main_sr_id = sm.main_id LEFT JOIN services s ON sm.sr_id = s.sr_id WHERE si.so_id = '$so_id';");
                                                foreach($fetch_total as $total_row){
                                                    $total_price = $total_row['SUM(price)'];
                                                    $total_cost = $total_row['SUM(cost)'];
                                                    echo number_format($total_price + $total_cost);
                                                }
                                            ?>
                                    </h4>
                                </div>
                                </div>
                                <div class=" d-flex justify-content-center mx-3 my-3">
                                    <button id="finishService" value="<?php echo $so_id; ?>" class="btn btn_cart rounded-pill py-1" >Hand over</button>
                                </div>

                            </div>
                        </div>


                    <?php
                    }
                ?>
                </div>

               
            </div>


        </div>

    </div>



    <script>

        $(document).ready(function(){

            //START DIAGNOSIS
            $('#strtDiagnosis').click(function(){
                var D_id = $(this).val();
                $.ajax({
                    method:"POST",
                    url:"techservice_data.php",
                    data:{D_id:D_id},
                    success:function(data){
                        alert(data);
                        location.reload();
                    }
                });
            });


            //ADD SERVICE
            $('#AddService').submit(function(e){
                e.preventDefault();
                var A_data = $(this).serializeArray();
                //console.log(A_data);
                $.post(
                    "techservice_data.php",
                    A_data,
                    function(A_data){
                        alert(A_data);
                        location.reload();
                    }
                );
            });
            

            //START SERVICE AND SET DATE
            $('#StrtService').submit(function(g){
                g.preventDefault();
                var E_data = $(this).serializeArray();
                console.log(E_data);
                $.post(
                    "techservice_data.php",
                    E_data,
                    function(E_data){
                        alert(E_data);
                        location.reload();
                    }
                );
            });

            
            //DELETE SERVICE
            $('.delBtn').click(function(){
                var Del_id = $(this).val();
                //console.log(Del_id);
                $.ajax({
                    method:"POST",
                    url:"techservice_data.php",
                    data:{Del_id:Del_id},
                    success:function(data){
                        alert(data);
                        location.reload();
                    }
                });
            });


            //START TESTING
            $('#strtTest').click(function(){
                var st_id = $(this).val();
                $.ajax({
                    method:"POST",
                    url:"techservice_data.php",
                    data:{st_id:st_id},
                    success:function(data){
                        alert(data);
                        location.reload();
                    }
                });
            });


            //FINISHED SERVICE
            $('#finishService').click(function(){
                var finish_id = $(this).val();
                $('#finish_modal').modal('show');
                $('#confirmBtn').click(function(){
                    $.ajax({
                        method:"POST",
                        url:"techservice_data.php",
                        data:{finish_id:finish_id},
                        success:function(data){
                            alert(data);
                            location.href = "technician_allservices.php";
                        }
                    });
                });
                $('.btnClose').click(function(){
                    location.reload();
                });
            });

        });

    </script>
    <?php 
        include "../MAIN/Footer.php";
    ?>
</body>

</html>