<?php 

    require '../MAIN/Dbconn.php';

    $AID = $_COOKIE['custidcookie'];


   //deliver to customer
    if(isset($_POST['tocustomerid'])){
        $pay_id =  $_POST['tocustomerid'];
        date_default_timezone_set("Asia/kolkata");
        $date = date("Y-m-d h:i:sa");
        mysqli_autocommit($con,FALSE);

        mysqli_query($con, "UPDATE service_order SET tracker = 'Completed', payment_status = 'Paid', stat = '3', delivered_date = '$date', in_transit = '0' WHERE so_id = '$pay_id'");

        if(!mysqli_commit($con)){
            echo "Failed";
            mysqli_close($con);
        }
        else{
            echo "Success";
        }
    }

    //deliver to shop
    if(isset($_POST['toshopid'])){
        $toshop_id =  $_POST['toshopid'];
        date_default_timezone_set("Asia/kolkata");
        $shop_time =  date("Y-m-d h:i:sa");
        mysqli_autocommit($con,FALSE);

        mysqli_query($con, "UPDATE service_order SET tracker = 'shop' , shop_delivertime = '$shop_time', in_transit = '0' WHERE so_id = '$toshop_id'");

        if(!mysqli_commit($con)){
            echo "Failed";
            mysqli_close($con);
        }
        else{
            echo "Success";
        }
    }


    if(isset($_POST["all_service"])){


        $query_home = "SELECT * FROM service_order so INNER JOIN brands b ON so.brand = b.br_id INNER JOIN models m ON so.model = m.mo_id WHERE pickup_agentid = '$AID' AND in_transit = '1'"; 

        if(isset($_POST["type"]))
        {
            $type_filter = implode("','", $_POST["type"]);
            $query_home .= "AND tracker IN('".$type_filter."')";
        }


        if(isset($_POST["query"]))
        {
            $search = $_POST["query"];
            $query_home .= "AND cust_name LIKE '%".$search."%' OR so_id LIKE '%".$search."%'";
        }


        $result = mysqli_query($con, $query_home);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach($row as $Rdelivery)
            {
                $dt = $Rdelivery['pickup_date'];
                $track = $Rdelivery['tracker'];      
                $so_id = $Rdelivery['so_id']; 
?>
            <div class="col-12 col-md-6 col-xl-4 my-3 my-md-2">
                <div class="card card-body shadow p-0 ">
                    <div class=" heading text-center d-flex justify-content-between px-2 py-2">
                        <h6 class="my-auto "><?php echo $Rdelivery['brand_name'].'&nbsp;'.$Rdelivery['model_name'] ; ?></h6>
                        <h6 class="my-auto "><?php echo $Rdelivery['pickup_time']; ?></h6>
                    </div>
                    <div class="row g-0 pt-2 ">
                        <div class="col-6 order_info border-end border-2 my-auto">
                            <div class="mx-2 px-2 ">
                                <p class="">
                                    <i class="material-icons">face</i>
            
                                    <span><?php echo $Rdelivery['cust_name']; ?></span>
                                </p>
                                <p>
                                    <i class="material-icons">call</i>
                                    <span><?php echo $Rdelivery['cust_phone']; ?></span>
                                </p>
                                <p>
                                    <i class="material-icons">currency_rupee</i>
                                    <span> <?php 
                                    $fetch_total = mysqli_query($con, "SELECT SUM(price),SUM(cost) FROM service_items si LEFT JOIN service_main sm ON si.main_sr_id = sm.main_id LEFT JOIN services s ON sm.sr_id = s.sr_id WHERE si.so_id = '$so_id';");
                                    foreach($fetch_total as $total_row){
                                        $total_price = $total_row['SUM(price)'];
                                        $total_cost = $total_row['SUM(cost)'];
                                        echo number_format($total_price + $total_cost);
                                    }
                                     ?></span>
                                </p>
                                <p>
                                    <i class="material-icons">today</i>
                                    <span> <?php echo date("d-M-Y", strtotime($dt)) ; ?></span>
                                </p>
                            </div>
                        </div>
                        <div class="col-6 my-auto px-3">
                            <p><?php echo $Rdelivery['cust_address']; ?> , <?php echo $Rdelivery['cust_state']; ?> , <?php echo $Rdelivery['cust_city']; ?> , <?php echo $Rdelivery['cust_pincode']; ?></p>
                        </div>
                    </div>

                    <div class=" btn_grp d-flex justify-content-between pt-2 ">
                        <a href="tel:+91 <?php echo $Rdelivery['cust_phone']; ?>" class="btn btn_fill  shadow-none py-0 me-3" style="border-radius: 50%; " ><i class='bx bxs-phone-call'></i></a>
                            <?php
                                if($track == 'pickup'){
                            ?>  
                                    <button class="btn btn_cart toshopBtn rounded-pill shadow-none py-1 me-3" value="<?php echo $Rdelivery['so_id']; ?>" type="button" >To Shop</button>
                            <?php
                                }
                                else{
                            ?>  
                                    <button class="btn btn_cart tocustomerBtn rounded-pill shadow-none py-1 me-3" value="<?php echo $Rdelivery['so_id']; ?>" type="button" >Mark as Delivered</button>
                            <?php
                                }
                            ?>
                        <a class="btn btn_fill py-0 shadow-none" ><i class='bx bxs-receipt'></i></a>
                    </div>
                    
                </div>
            </div>


    <?php
                }
            }
        else{
            echo '<h3 class="text-center">No Delivery tasks Now!</h3>';
        }
    }
    ?>

<script>

        //deliver to customer 
        $('.tocustomerBtn').click(function(){
            var tocustomerid = $(this).val();
            $('#pay_modal').modal("show");
            $('.confirmBtn').click(function(){
                console.log(tocustomerid);
                $.ajax({
                    method: "POST",
                    url:"service_delivery_data.php",
                    data: {tocustomerid:tocustomerid},
                    success:function(data) {
                        tocustomerid = undefined;
                        delete window.tocustomerid;
                        service_delivery();
                        $('#pay_modal').modal("hide");
                        toastr.success('Customer Delivery successfull');
                    }
                });
            });
            $('.cancelBtn').click(function(){
                tocustomerid = undefined;
                delete window.tocustomerid;
            });
        });



        //deliver to shop 
        $('.toshopBtn').click(function(){
            var toshopid = $(this).val();
            $('#shop_modal').modal("show");
            $('.confirmshopBtn').click(function(){
                //console.log(toshopid);
                $.ajax({
                    method: "POST",
                    url:"service_delivery_data.php",
                    data: {toshopid:toshopid},
                    success:function(data) {
                        toshopid = undefined;
                        delete window.toshopid;
                        service_delivery();
                        $('#shop_modal').modal("hide");
                        toastr.success('Handover successfull');
                    }
                });
            });
            $('.shopcancelBtn').click(function(){
                toshopid = undefined;
                delete window.toshopid;
            });
        });
    

        toastr.options = {
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }



</script>






















