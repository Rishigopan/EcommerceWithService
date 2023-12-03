

    <?php 
        require "../MAIN/Dbconn.php"; 
    ?>



<?php


    if( isset($_REQUEST["ex_id"] )) {
        $id = $_REQUEST['ex_id'];
        $date = $_REQUEST['exp_date'];
        $time = date("Y-m-d h:i:sa", strtotime($date));
        //echo $id .$time;
        $exp_query = mysqli_query($con, "UPDATE order_details SET expected_date ='$time' WHERE order_id= '$id'");
        if ($exp_query){
            echo "success";
            mysqli_close($con);
        }
        else{
            echo "fatal error";
        }
    }


    if( isset($_POST['exp_id']) && !empty($_POST['exp_id']) ) {
        
        $newid = $_POST['exp_id'];
        $agent = $_POST['agent_select'];
        //echo $agent .$newid;

        $agent_query = mysqli_query($con, "UPDATE order_details SET agent_id ='$agent', delivery_agent = (SELECT empl_name FROM employees WHERE empl_id = '$agent'), delivery_status='In Transit' WHERE order_id= '$newid'");
        if ($agent_query){
            echo "success";
            mysqli_close($con);
        }
        else{
            echo "fatal error";
        }
    }



    if(isset($_POST["action"])){

        $query_orders = "SELECT * FROM order_details WHERE stat = '0'";

        if(isset($_POST["status"]))
        {
            $status_filter = implode("','", $_POST["status"]);
            $query_orders .= "AND delivery_status IN('".$status_filter."')";
        }

        if(isset($_POST["query"]))
        {
            $search = $_POST["query"];
            $query_orders .= "AND first_name LIKE '%".$search."%' OR order_id LIKE '%".$search."%'";
        }

        $result = mysqli_query($con, $query_orders);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach($row as $Rorder)
            {
            
                $dt = $Rorder['expected_date'];
                
    ?>
        <div class="col-12 col-md-6 col-xl-4 my-3 my-md-2">
            <div class="card card-body shadow p-0 ">
                <div class=" heading text-center d-flex justify-content-between px-2 py-2">
                    <h6 class="my-auto "><?php echo $Rorder['first_name'] . '&nbsp;'. $Rorder['last_name']; ?></h6>
                    <h6 class="my-auto exp_id">#<?php echo $Rorder['order_id']; ?></h6>
                </div>
                <div class="row g-0 pt-2 ">
                    <div class="col-6 order_info border-end border-2">
                        <div class="mx-2 px-2 ">
                            <p>
                                <i class="material-icons">currency_rupee</i>
                                <span><?php echo number_format($Rorder['total']); ?></span>
                            </p>
                            <p class="">
                                <i class="material-icons">payments</i>
                                <span><?php echo $Rorder['payment_mode']; ?></span>
                            </p>
                            <p>
                                <i class="material-icons">local_shipping</i>
                                <span><?php echo $Rorder['delivery_status']; ?></span>
                            </p>
                            <p>
                                <i class="material-icons">alarm</i>
                                <span class="expdel_date"><?php
                                    if($dt == ''){
                                        echo '';
                                    }
                                    else{
                                        echo $newDate = date("M-d H:i A", strtotime($dt)); 
                                    } ?></span>
                            </p>
                            <p class="">
                                <i class="material-icons">delivery_dining</i>
                                <span ><?php echo $Rorder['delivery_agent']; ?></span>
                            </p>
                    </div>
                </div>
                <div class="col-6 my-auto px-3">
                    <p><?php echo $Rorder['location']; ?>, <br> <?php echo $Rorder['city']; ?>,  <?php echo $Rorder['state']; ?>, <br> <?php echo $Rorder['pincode']; ?></p>
                </div>
            </div>
                    <div class=" btn_grp d-flex justify-content-between pt-2 ">
                        <div id="date_btn">
                            <form action="" method="POST" class="Date_form">
                                <label class=" <?php echo str_replace(' ', '',$Rorder['delivery_status']);?>  btn shadow-none rounded-pill py-1"> 
                                    <input type="text" name="ex_id" value="<?php echo $Rorder['order_id']; ?>" hidden>
                                    <span class=""> <input type="datetime-local" name="exp_date" class="  exp_date btn py-0 p-0" ></span>
                                </label>
                            </form>
                        </div>
                        <form action="" class="Newform" method="POST">
                            <div class="d-flex">
                            <?php
                                if($dt == ''){
                            ?>
                                <select name="" id="" class="form-select shadow-none py-1 " style="width: 8rem;" disabled>
                                    <option value="">Delivery Agent</option>
                                </select>
                                <button class="btn_set btn_cart btn shadow-none rounded-pill py-1 ms-2"  name="" type="button" disabled>Assign</button>
                            <?php
                                }
                                else{
                            ?>
                                <select name="agent_select" id="select_agent"  class=" <?php echo str_replace(' ', '',$Rorder['delivery_status']);?> form-select shadow-none py-1 "placeholder="Delivery agent" style="width: 8rem;" required>
                                    <option hidden value="">Delivery Agent</option>
                                    <?php 
                                        $agent_query = mysqli_query($con, "SELECT * FROM user_details WHERE type = 'delivery'");
                                        if(mysqli_num_rows($agent_query) > 0){
                                            foreach($agent_query as $agents){
                                    ?>
                                            <option value="<?php echo $agents['user_id']; ?>"><?php echo $agents['first_name'] .' '. $agents['last_name']; ?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <input type="text" name="exp_id" value="<?php echo $Rorder['order_id']; ?>" hidden>
                                <button class=" <?php echo str_replace(' ', '',$Rorder['delivery_status']);?> btn_set btn_cart btn shadow-none rounded-pill py-1 ms-2"  name="set_delivery" type="submit">Assign</button>
                            <?php
                                } 
                            ?>
                                <a href="../Order_invoice.php?order_id=<?php echo $Rorder['order_id'];?>" target="_blank" class="btn btn_fill py-0 shadow-none ms-2" ><i class='material-icons'>receipt</i></a>
                            </div>
                        </form>
                        <button class="btn btn_cancel py-0 <?php echo str_replace(' ', '',$Rorder['delivery_status']);?> shadow-none" data-bs-toggle="modal" data-bs-target="#cancel_modal"><i class='material-icons'>close</i></button>
                    </div>
            </div>
    </div>
<?php
    }
    }
    else{
        echo '<h3 class="text-center">No Orders Placed!</h3>';
    }
    }
?>



<script src="../JS/Filter.js"> </script>

<script>
    
    


    $(document).ready(function(){
            
        //Update expected delivery date
        $('.Date_form').change(function(){
            var data = $(this).serializeArray();
            $.post(
                "OrderHandling.php",
                data,
                function(data) {
                    filter_data();
                }
            );
        });

        //Assign delivery agent 
        $('.Newform').submit(function(f){
            f.preventDefault();
            var formdata = $(this).serializeArray();
            console.log(formdata);
            $.post(
                "OrderHandling.php",
                formdata,
                function(formdata) {
                    filter_data();
                }
            );
        });
            

        

        });
    
</script>







            