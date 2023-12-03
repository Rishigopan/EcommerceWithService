
    <?php 
        require "../MAIN/Dbconn.php"; 
    ?>


<?php


    if(isset($_POST['removeId']))
    {
        $remove_id =  $_POST['remove_order'];
        
        mysqli_autocommit($con,FALSE);

        mysqli_query($con, "DELETE FROM service_order WHERE so_id = '$remove_id'");

        if(!mysqli_commit($con)){
            echo "Failed";
            exit();
        }
        else{
            echo "Success";
        }
    }



    if(isset($_POST["services"])){

        $query_service = "SELECT * FROM service_order so INNER JOIN brands b ON b.br_id = so.brand INNER JOIN models m ON m.mo_id = so.model WHERE stat = '0'";

        if(isset($_POST["mode"]))
        {
            $mode_filter = implode("','", $_POST["mode"]);
            $query_service .= "AND pickup_mode IN('".$mode_filter."')";
        }
                
        if(isset($_POST["query"]))
        {
            $search = $_POST["query"];
            $query_service .= "AND cust_name LIKE '%".$search."%' OR so_id LIKE '%".$search."%' OR brand LIKE '%".$search."%'";
        }
        

        $result = mysqli_query($con, $query_service);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach($row as $Rorder)
            {
                $pickup_id = $Rorder['pickup_agentid'];
                $track = $Rorder['tracker'];
                $s_id = $Rorder['so_id'];
                $dt = $Rorder['pickup_date'];
                $newDate = date("d-M", strtotime($dt)); 
                
    ?>
        
        <div class="test col-12 col-md-6 col-xl-4 my-3 my-md-2">
            <div class="card card-body shadow p-0 ">
                <div class=" heading text-center d-flex justify-content-between px-2 py-2">
                    <h6 class="my-auto "><?php echo $Rorder['cust_name']; ?></h6>
                    <h6 class="my-auto "><?php echo $newDate.'&nbsp;'.$Rorder['pickup_time'] ; ?></h6>
                </div>
                <div class="row g-0 pt-2 ">
                    <div class="col-6 order_info border-end border-2">
                        <div class="mx-2 px-2 text-muted">
                            <p class="">
                                <i class="material-icons">smartphone</i>
                                <span><?php echo $Rorder['brand_name'].'&nbsp;'.$Rorder['model_name']; ?></span>
                            </p>
                            <p>
                                <i class="material-icons">call</i>
                                <span><?php echo $Rorder['cust_phone']; ?></span>
                            </p>
                            <p>
                                <i class="material-icons">place</i>
                                <span><?php echo $Rorder['cust_city']; ?>, <?php echo $Rorder['cust_state']; ?>,<?php echo $Rorder['cust_pincode']; ?></span>
                            </p>
                            <p>
                                <?Php
                                    if($track == 'pickup' || $track == 'null') {
                                        echo '<i class="material-icons">delivery_dining</i>';
                                        echo '<span>'.$Rorder["pickup_agentname"].'</span>'; 
                                    }
                                    elseif($track == 'shop') {                                
                                        echo '<i class="material-icons">engineering</i>';
                                        echo '<span>'.$Rorder["tech_agentname"].'</span>';
                                    }
                                ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-6 d-flex align-items-center">
                        <ul>
                            <?php 
                                $service_list = mysqli_query($con, "SELECT * FROM service_items si INNER JOIN service_main sm ON si.main_sr_id = sm.main_id INNER JOIN services s ON s.sr_id = sm.sr_id WHERE so_id = '$s_id'");
                                if(mysqli_num_rows($service_list) > 0){
                                    foreach($service_list as $services){
                                        echo  '<li>'.$services['service_name']. '</li>';
                                    } 
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class=" btn_grp d-flex justify-content-between pt-2 ">
                    <a href="tel:+91<?php echo $Rorder['cust_phone']; ?>" class="btn btn_fill py-0 shadow-none" ><i  class='material-icons'>call</i></a>
                    <?php   
                        if($track == 'pickup' || $track == 'null' ){
                    ?> 
                        <form action="" class="agent_form" method="POST">
                            <div class="d-flex <?php echo $track ;?>">
                                    <select name="agent_select" class="form-select shadow-none py-1 " style="width: 8rem;">
                                        <option hidden value="">Delivery Agent</option>
                                        <?php 
                                            $agent_query = mysqli_query($con, "SELECT user_id,first_name,last_name FROM user_details WHERE type = 'delivery'");
                                            if(mysqli_num_rows($agent_query) > 0){
                                                foreach($agent_query as $agents){
                                        ?>
                                                <option value="<?php echo $agents['user_id']; ?>"><?php echo $agents['first_name'].'&nbsp;'.$agents['last_name']; ?></option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                    <input type="text" value="<?php echo $Rorder['so_id']; ?>"  name="ServiceIdDel" hidden>
                                <button class="btn btn_cart  rounded-pill shadow-none py-1 ms-2" type="submit" >Assign</button>
                            </div>
                        </form>
                    <?php       
                        }
                        elseif($track == 'shop'){
                    ?>
                        <form action="" class="tech_form" method="POST">
                            <div class="d-flex">
                                <select name="tech_select" class="form-select shadow-none py-1 " style="width: 8rem;">
                                    <option hidden value="">Technician</option>
                                    <?php 
                                        $tech_query = mysqli_query($con, "SELECT user_id,first_name,last_name FROM user_details WHERE type = 'technician'");
                                        if(mysqli_num_rows($tech_query) > 0){
                                            foreach($tech_query as $techs){
                                    ?>
                                            <option value="<?php echo $techs['user_id']; ?>"><?php echo $techs['first_name'].'&nbsp;'.$techs['last_name']; ?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <input type="text" value="<?php echo $Rorder['so_id']; ?>"  name="ServiceIdTech" hidden>
                                <button class="btn btn_cart  rounded-pill shadow-none py-1 ms-1" type="submit" >Assign</button>
                            </div>
                        </form>
                    <?php
                        }
                    ?>

                    <?php
                        if($track == 'shop' || $track == 'null'){
                    ?>
                        <button class="btn btn_cancel  py-0  shadow-none remove_order" name="remove_order" value="<?php echo $Rorder['so_id']; ?>" ><i class='material-icons'>close</i></button>
                    <?php
                        }
                        elseif($track == 'pickup'){
                    ?>
                        <button class="btn btn_cancel  py-0  shadow-none revert_action" name="revert_order" value="<?php echo $Rorder['so_id']; ?>"><i class='material-icons'>close</i></button>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>

<?php
    }
    }
    else{
        echo '<h3 class="text-center">No service orders!</h3>';
    }
    }
?>


<script src="../JS/service_filters.js"></script>
<script>

    $(document).ready(function(){
            
        // //Assign delivery agent 
        // $('.agent_form').submit(function(g){
        //     g.preventDefault();
        //     var agentdata = $(this).serializeArray();
        //     //console.log(agentdata);
        //         $.post(
        //             "ServiceBookingsData.php",
        //             agentdata,
        //             function(agentdata) {
        //                 //alert(agentdata);
        //                 service_bookings();
        //                 toastr.success('Assigned delivery agent');
        //             }
        //         );
        // });
            


        // //Assign technician 
        // $('.tech_form').submit(function(m){
        //     m.preventDefault();
        //     var techdata = $(this).serializeArray();
        //     //console.log(techdata);
        //         $.post(
        //             "ServiceBookingsData.php",
        //             techdata,
        //             function(techdata) {
        //                 //alert(techdata);
        //                 service_bookings();
        //                 toastr.success('Assigned technician');
        //             }
        //         );
        // });

        $('.remove_order').click(function(){
            var removeId = $(this).val();
            console.log(removeId);
            $.post(
                "ServiceBookingsData.php",
                    removeId,
                    function(removeId) {
                        //alert(removeId);
                        //service_bookings();
                       // toastr.success('Assigned technician');
                    }
            );
        });
        
        $('.revert_action').click(function(){
            var revert_id = $(this).val();
            console.log(revert_id);
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

        

    });
    
    
</script>







            