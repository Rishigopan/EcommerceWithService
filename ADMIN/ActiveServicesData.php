

    <?php  

        require "../MAIN/Dbconn.php"; 
    
    ?>



<?php


   //Handover to customer
    if(isset($_POST['handoverid']))
    {
        $handover_se_id =  $_POST['handoverid'];

        //echo $handover_se_id ;
        date_default_timezone_set("Asia/kolkata");
        $handoverDate =  date("Y-m-d h:i:s");

        mysqli_autocommit($con,FALSE);

        mysqli_query($con, "UPDATE service_order SET stat = '3', in_service = '0', tracker = 'Delivered', payment_status = 'Paid', delivered_date = '$handoverDate' WHERE so_id = '$handover_se_id'");

        if(!mysqli_commit($con)){
            echo "Failed";
            mysqli_close($con);
        }
        else{
            echo "Success";
        }
    }




    //Assign Delivery Agent
    if(isset($_POST['service_id']) && !empty($_POST['agent_select'])){

        $SERVICE_id =  $_POST['service_id'];
        $agent_id =$_POST['agent_select'];
        //echo $agent_id .$SERVICE_id;

        $find_name = mysqli_query($con, "SELECT first_name,last_name FROM user_details WHERE user_id = '$agent_id'");
        foreach($find_name as $name){
            $agent_name = $name['first_name'].' '.$name['last_name'];
        }

        mysqli_autocommit($con,FALSE);

        mysqli_query($con, "UPDATE service_order SET delivery_agentid = '$agent_id', delivery_agentname = '$agent_name', tracker = 'delivery',in_transit = '1', in_service = '0' WHERE so_id = '$SERVICE_id'");

        if(!mysqli_commit($con)){
            echo "Failed";
            exit();
        }
        else{
            echo "Success";
        } 
    }


 /*
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
*/


    if(isset($_POST["active_service"])){

        $query_service = "SELECT * FROM service_order so INNER JOIN brands b ON so.brand = b.br_id INNER JOIN models m ON so.model = m.mo_id WHERE stat NOT IN(0,3) AND in_service  IN (0,1)";

        if(isset($_POST["mode"]))
        {
            $mode_filter = implode("','", $_POST["mode"]);
            $query_service .= "AND pickup_mode IN('".$mode_filter."')";
        }
                
        if(isset($_POST["query"]))
        {
            $search = $_POST["query"];
            $query_service .= "AND cust_name LIKE '%".$search."%' OR so_id LIKE '%".$search."%'";
        }
        

        $result = mysqli_query($con, $query_service);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach($row as $Rorder)
            {
               
                $track = $Rorder['tracker'];
                $mode = $Rorder['pickup_mode'];
                $s_id = $Rorder['so_id'];
                $tech_status = $Rorder['tech_status'];
                $tech_start = $Rorder['tech_start']; 
                $exp_date = $Rorder['expected_time'];
    ?>
        
       

            <div class="col-12 col-md-6 col-sm-12 col-xl-4 my-3 my-md-2">
                <div class="card card-body shadow p-0 ">
                    <div class=" heading text-center d-flex justify-content-between px-2 py-2">
                        <h6 class="my-auto "><?php echo $Rorder['cust_name']; ?></h6>
                        <h6 class="my-auto ">#<?php echo $Rorder['so_id']; ?></h6>
                    </div>
                    <div class="row g-0 pt-2 ">
                        <div class="col-6 order_info border-end border-2">
                            <div class="mx-2 px-2 ">
                                <p class="">
                                    <i class="material-icons">engineering</i>
                                    <span><?php echo $Rorder['tech_agentname']; ?></span>
                                </p>
                                <p>
                                    <i class="material-icons">hourglass_top</i>
                                    <span>
                                        <?php if ($tech_status == 'Completed' ){
                                            echo "Completed";}
                                            else{
                                                echo "Pending";
                                            } 
                                        ?>
                                    </span>
                                </p>
                                <p>
                                    <i class="material-icons">assignment</i>
                                    <span><?php echo $Rorder['tech_status']; ?></span>
                                </p>
                                <p class="">
                                    <i class="material-icons">access_time_filled</i>
                                    <span>
                                        <?php if( $tech_start == null){
                                            echo "";
                                        }else{
                                            echo date("d/m  h:i A", strtotime($tech_start));
                                        }
                                        ?>
                                    </span>
                                </p>
                                <p>
                                    <i class="material-icons">alarm</i>
                                    <span>
                                        <?php if( $exp_date == null){
                                            echo "";
                                        }else{
                                            echo date("d/m  h:i A", strtotime($exp_date));
                                        }
                                        ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-6 my-auto text-muted ">
                            <div class="order_info">
                                <p class="text-muted ms-2">
                                    <i class="material-icons">smartphone</i>
                                    <span><?php echo $Rorder['brand_name'].'&nbsp;'.$Rorder['model_name'];?></span>
                                </p>
                            </div>
                            <ul>
                            <?php 
                                $service_list = mysqli_query($con, "SELECT * FROM service_items si LEFT JOIN service_main sm ON si.main_sr_id = sm.main_id LEFT JOIN services s ON sm.sr_id = s.sr_id WHERE si.so_id = '$s_id'");
                                if(mysqli_num_rows($service_list) > 0){
                                    foreach($service_list as $services){
                                    ?>
                                        <li> <?php
                                            if ($services['service'] == null){
                                                echo $services['service_name'];
                                            }
                                            else{
                                                echo $services['service'];
                                            }
                                        
                                        ?> </li>
                                    <?php
                                    } 
                                }
                            ?>
                            </ul>
                        </div>
                    </div>
                    <div class=" btn_grp d-flex justify-content-between pt-2 ">
                        <a href="tel:+91<?php echo $Rorder['cust_phone']; ?>" class="btn btn_fill py-0 shadow-none" ><i  class='material-icons'>call</i></a>
                        <?php   
                            if($mode == 'Doorstep'){
                        ?> 
                            <form action="" class="agent_form <?php if($track == 'delivery'){echo "noaction";} ?>" method="POST" >
                                <div class="d-flex <?php echo $track ;?>">
                                        <select name="agent_select" class="form-select shadow-none py-1" style="width: 8rem;"  <?php if($tech_status != 'Completed'){echo "disabled";} ?> >
                                            <option hidden value="">Delivery Agent</option>
                                            <?php 
                                                $agent_query = mysqli_query($con, "SELECT user_id,first_name,last_name FROM user_details WHERE type = 'delivery'");
                                                if(mysqli_num_rows($agent_query) > 0){
                                                    foreach($agent_query as $agents){
                                            ?>
                                                    <option value="<?php echo $agents['user_id']; ?>"><?php echo $agents['first_name'].' '.$agents['last_name']; ?></option>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <input type="text" value="<?php echo $Rorder['so_id']; ?>"  name="service_id" hidden>
                                    <button class="btn btn_wish btn_cart  px-2 shadow-none py-0 mx-2"  type="submit" <?php if($tech_status <> 'Completed'){echo "disabled";} ?>> <i class="material-icons" style="vertical-align:middle;"  >delivery_dining</i>   </button>
                                    <a class="btn py-0 btn_fill shadow-none" href="" ><i class='material-icons'>receipt</i></a>
                                </div>
                            </form>
                        <?php       
                            }
                            else{
                        ?>
                                <div class="d-flex ">
                                    <input type="text" value="<?php echo $Rorder['so_id']; ?>"  name="handover_se_id" hidden>
                                    <button class="btn btn_cart  rounded-pill handoverBtn shadow-none py-1 me-3" value="<?php echo $Rorder['so_id']; ?>" type="button" <?php if($tech_status <> 'Completed'){echo "disabled";} ?>>Handover</button>
                                    <a class="btn py-0 btn_fill shadow-none" href="" ><i class='material-icons'>receipt</i></a>
                                </div>
                        <?php
                            }
                        ?>
                        <button class="btn py-0 btn_cancel shadow-none ms-2" ><i class='material-icons'>close</i></button>
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

<script src="../JS/active_services_fil.js"></script>
<script>

    $(document).ready(function(){
            
        //handover device 
        $('.handoverBtn').click(function(){
            var handoverid = $(this).val();
            $('#handover_modal').modal("show");
            $('.confirmHandover').click(function(){
                //console.log(handoverid);
                $.ajax({
                    method: "POST",
                    url:"ActiveServicesData.php",
                    data: {handoverid:handoverid},
                    success:function(data) {
                        console.log(data);
                        handoverid = undefined;
                        delete window.handoverid;
                        active_services();
                        $('#handover_modal').modal("hide");
                        toastr.success('Handover successfull');
                    }
                });
            });
            $('.closeBtn').click(function(){
                handoverid = undefined;
                delete window.handoverid;
            });
        });
            
       
       //Assign delivery 
        $('.agent_form').submit(function(m){
            m.preventDefault();
            var agentdata = $(this).serializeArray();
            console.log(agentdata);
                $.post(
                    "ActiveServicesData.php",
                    agentdata,
                    function(agentdata) {
                        //alert(agentdata);
                        active_services();
                        toastr.success('Assigned delivery agent');
                    }
                );
        });


        /*
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
        });*/

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







            