<?php


    require "../MAIN/Dbconn.php";
    include "../ADMIN/CommonFunctions.php";



    if(isset($_POST['ShowServiceWindow'])){

        $ServiceOrderId = $_POST['ShowServiceWindow'];

        ?>

            <div class="row">
                <?php
                $fetch_service_query = mysqli_query($con, "SELECT * FROM servicebill WHERE serviceBillId = '$ServiceOrderId'");
                while ($service_details = mysqli_fetch_array($fetch_service_query)) {

                ?>
                    <!--DIAGNOSIS-->
                    <div class="col-12 col-md-6 col-lg-4 ">
                        <div id="main_card" class="card card-body shadow">
                            <div id="heading" class="heading">
                                <h5 class="my-auto text-center">1. Diagnosis</h5>
                            </div>

                            <!-- Show Order Details -->
                            <div class="card card-body inside_card mx-3 mt-2 service_cards ">
                                <div class="order_info ">
                                    <div class="">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="">
                                                <i class="material-icons">tag</i>
                                                <span class="text-muted">Order ID</span>
                                            </h6>
                                            <h6><?php echo $service_details['serviceBillNo']; ?></h6>
                                        </div>

                                        <!-- <div class="d-flex justify-content-between">
                                            <h6 class="">
                                                <i class="material-icons">smartphone</i>
                                                <span class="text-muted">Device</span>
                                            </h6>
                                            <h6><?php echo $service_details['brand_name'] . '&nbsp;' . $service_details['model_name']; ?></h6>
                                        </div> -->

                                        <div class="d-flex justify-content-between">
                                            <h6>
                                                <i class="material-icons">face</i>
                                                <span class="text-muted">Customer</span>
                                            </h6>
                                            <h6> <?php echo ucfirst($service_details['custName']); ?> </h6>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <h6>
                                                <i class="material-icons">phone</i>
                                                <span class="text-muted">Phone Number</span>
                                            </h6>
                                            <h6> <?php echo $service_details['custPhone']; ?> </h6>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <h6>
                                                <i class="material-icons">alarm</i>
                                                <span class="text-muted">Expected Time</span>
                                            </h6>
                                            <h6> <?php if ($service_details['expectedTime'] == null) {
                                                        echo "";
                                                    } else {
                                                        echo date("d-M h:i a", strtotime($service_details['expectedTime']));
                                                    }  ?> </h6>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Show Service Items -->
                            <div class="card card-body inside_card services mt-3 mx-3 p-2 ">
                                <ul class="list-unstyled">
                                    <?php

                                    $FetchItemsQuery = mysqli_query($con, "SELECT * FROM servicedetailed SD INNER JOIN brands B ON SD.brand = B.br_id INNER JOIN products P ON SD.model = P.pr_id INNER JOIN service_main SM ON SD.serviceId = SM.main_id INNER JOIN services S ON SM.sr_id = S.sr_id WHERE SD.serviceBillId = '$ServiceOrderId'");
                                    foreach ($FetchItemsQuery as $FetchItemsQueryResults) {

                                    ?>
                                        <li class="border-bottom">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex my-2">
                                                    <img src="../assets/img/SERVICE/<?= $FetchItemsQueryResults['service_img'] ?>" alt="">
                                                    <div class="w-100 ms-2">
                                                        <div class=" d-block justify-content-between">
                                                            <p class="m-0 p-0"> <strong class="text-muted"> <?= $FetchItemsQueryResults['brand_name'] . ' ' . $FetchItemsQueryResults['name'] ?> </strong> </p>
                                                            <h6 class=""><?= $FetchItemsQueryResults['service_name'] ?></h6>
                                                            <!-- <h5 class=""> &#8377; <?php echo number_format($FetchItemsQueryResults['amount']); ?> </h5> -->
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
                                <button id="start_diagnosis" value="<?= $ServiceOrderId ?>" class="btn btn_cart rounded-pill py-1" <?= ($service_details['stat'] >= 4) ? "disabled" : "" ?>  >Start diagnosis</button>
                            </div>

                        </div>
                    </div>


                    <!--SERVICE-->
                    <div class="col-12 col-md-6 col-lg-4 mt-4 mt-md-0">
                        <div id="main_card" class="card card-body shadow">
                            <div id="heading" class="heading">
                                <h5 class="my-auto text-center">2. Service</h5>
                            </div>

                            <!-- <div class="card card-body inside_card mx-3 mt-2 p-2">
                                <h6>Add Service</h6>
                                <form id="AddService" action="" method="">
                                    <input type="text" name="Add_id" value="<?php echo $so_id; ?>" hidden>
                                    <div class="mt-1">
                                        <select name="S_select" id="" class="form-select shadow-none py-1">
                                            <option hidden value="">Choose A Service</option>
                                            <?php
                                            $brand = $service_details['brand'];
                                            $model = $service_details['model'];
                                            $find_service = mysqli_query($con, "SELECT * FROM service_main sm INNER JOIN services s ON sm.sr_id = s.sr_id WHERE sm.br_id = '$brand' AND sm.mo_id = '$model'");
                                            foreach ($find_service as $list_services) {
                                                echo '<option value="' . $list_services["main_id"] . '">' . $list_services["service_name"] . '</option>';
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
                            </div> -->

                            <div class="card card-body inside_card my-3 mx-3 p-2 ">
                                <h6 class="py-2">Expected Delivery Time</h6>
                                <form action="" class="p-0" id="StartService">
                                    <div class="pb-2">
                                        <input class="form-control" type="text" value="<?= $ServiceOrderId; ?>" name="StartServiceOrderId" hidden>
                                        <input class="form-control" type="datetime-local" required value="<?= ($service_details["expectedTime"] != '') ? (substr($service_details["expectedTime"],0,10) .'T'.substr($service_details["expectedTime"],11,5)) : '' ?>" name="StartServiceExpectedTime" <?= ($service_details['stat'] >= 5) ? "disabled" : "" ?>>
                                    </div>
                                    <div class=" d-flex justify-content-between mx-2 mt-3">
                                        <a href="tel:+91 <?= $service_details['custPhone']; ?>" class="btn btn_cart rounded-pill py-1 ">Call</a>
                                        <button type="submit" class="btn btn_cart rounded-pill py-1" <?= ($service_details['stat'] >= 5) ? "disabled" : "" ?>>Start Service</button>
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
                                <button id="StartTesting" value="<?= $ServiceOrderId; ?>" class="btn btn_cart rounded-pill py-1 ms-auto" <?= ($service_details['stat'] >= 6) ? "disabled" : "" ?>>Start Test</button>
                            </div>


                            <div class="card card-body inside_card mt-3 services mx-3 p-2 ">
                                <ul class="list-unstyled">

                                    <?php

                                    $FetchItemsQuery = mysqli_query($con, "SELECT * FROM servicedetailed SD INNER JOIN brands B ON SD.brand = B.br_id INNER JOIN products P ON SD.model = P.pr_id INNER JOIN service_main SM ON SD.serviceId = SM.main_id INNER JOIN services S ON SM.sr_id = S.sr_id WHERE SD.serviceBillId = '$ServiceOrderId'");
                                    foreach ($FetchItemsQuery as $FetchItemsQueryResults) {

                                    ?>
                                        <li class="border-bottom">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex mt-2">
                                                    <img src="../assets/img/SERVICE/<?= $FetchItemsQueryResults['service_img'] ?>" alt="">
                                                    <div class="w-100 ms-2">
                                                        <div class=" d-block justify-content-between">
                                                            <p class="m-0 p-0"> <strong class="text-muted"> <?= $FetchItemsQueryResults['brand_name'] . ' ' . $FetchItemsQueryResults['name'] ?> </strong> </p>
                                                            <h6 class=""><?= $FetchItemsQueryResults['service_name'] ?></h6>
                                                            <h5 class=""> &#8377; <?php echo number_format($FetchItemsQueryResults['amount']); ?> </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                    <?php

                                    }

                                    ?>


                                    



                                </ul>
                                <div class="d-flex justify-content-between px-2">
                                    <h4>Total</h4>
                                    <h4> <?=  $service_details['totalAmount'] ?> </h4>
                                </div>
                            </div>
                            <div class=" d-flex justify-content-center mx-3 my-3">
                                <button id="FinishService" value="<?php echo $ServiceOrderId; ?>" class="btn btn_cart rounded-pill py-1">Finish Service</button>
                            </div>

                        </div>
                    </div>



                <?php
                }
                ?>
            </div>

        <?php

    }

















?>