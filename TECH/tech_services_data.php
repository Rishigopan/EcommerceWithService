
<?php

    require "../MAIN/Dbconn.php"; 


    $tech_id = $_COOKIE['custidcookie'];
    

    if(isset($_POST["device_list"])){

    $query_service = "SELECT * FROM servicebill SB WHERE tracker = 'Tech' AND techId = '$tech_id'";

    if(isset($_POST["mode"]))
    {
        $mode_filter = implode("','", $_POST["mode"]);
        $query_service .= "AND pickup_mode IN('".$mode_filter."')";
    }

    if(isset($_POST["progress"]))
    {
        $progress_filter = implode("','", $_POST["progress"]);
        $query_service .= "AND tech_status IN('".$progress_filter."')";
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
                                <span><?php echo $Rorder['brand_name'].'&nbsp;'. $Rorder['model_name'];?></span>
                            </p>
                        </div>
                        <ul>
                        <?php 
                            $service_list = mysqli_query($con, "SELECT service_name FROM service_items si INNER JOIN service_main sm ON si.main_sr_id = sm.main_id INNER JOIN services s ON s.sr_id = sm.sr_id WHERE so_id = '$s_id'");
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
                    <a class="btn btn_fill py-1 shadow-none rounded-pill" href="techservice.php?service_id=<?php echo $Rorder['so_id']; ?>" >Take for Service</a>
                    <button class="btn py-0 btn_cancel shadow-none" data-bs-toggle="modal" data-bs-target="#cancel_modal" ><i class='material-icons'>close</i></button>
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