<?php 
    
    require '../MAIN/Dbconn.php';


    $AID = $_COOKIE['custidcookie'];


    if(isset($_POST['pay_id']))
    {
        $pay_id =  $_POST['pay_id'];
        date_default_timezone_set("Asia/kolkata");
        $date = date("Y-m-d h:i:sa");
        mysqli_autocommit($con,FALSE);

        mysqli_query($con, "UPDATE order_details SET delivery_status = 'Delivered', pay_status = 'Paid', stat = '1', delivered_date = '$date' WHERE order_id = '$pay_id'");

        if(!mysqli_commit($con)){
            echo "Failed";
            mysqli_close($con);
        }
        else{
            echo "Success";
        }


    }


    if(isset($_POST["all"])){


        $query_home = "SELECT * FROM order_details WHERE agent_id = '$AID' AND delivery_status = 'In Transit' ";

        if(isset($_POST["query"]))
        {
            $search = $_POST["query"];
            $query_home .= "AND first_name LIKE '%".$search."%' OR order_id LIKE '%".$search."%'";
        }

        $result = mysqli_query($con, $query_home);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach($row as $Rdelivery)
            {
            
                $dt = $Rdelivery['expected_date'];
                $newDate = date("d-M-Y", strtotime($dt)); 
                $newTime = date("h:i A", strtotime($dt));
?>
            <div class="col-12 col-md-6 col-xl-4 my-3 my-md-2">
                <div class="card card-body shadow p-0 ">
                    <div class=" heading text-center d-flex justify-content-between px-2 py-2">
                        <h6 class="my-auto "><?php echo $newDate; ?></h6>
                        <h6 class="my-auto "><?php echo $newTime; ?></h6>
                    </div>
                    <div class="row g-0 pt-2 ">
                        <div class="col-6 order_info border-end border-2 my-auto">
                            <div class="mx-2 px-2">
                                <p class="">
                                    <i class="material-icons">face</i>
                                    <span><?php echo $Rdelivery['first_name'].'&nbsp;'.$Rdelivery['last_name']; ?></span>
                                </p>
                                <p>
                                    <i class="material-icons">call</i>
                                    <span><?php echo $Rdelivery['phone']; ?></span>
                                </p>
                                <p>
                                    <i class="material-icons">currency_rupee</i>
                                    <span> <?php echo number_format($Rdelivery['total']); ?></span>
                                </p>
                                <p>
                                    <i class="material-icons">info</i>
                                    <span> <?php echo $Rdelivery['add_details']; ?></span>
                                </p>
                            </div>
                        </div>
                        <div class="col-6 my-auto px-3">
                            <p><?php echo $Rdelivery['location']; ?> , <?php echo $Rdelivery['state']; ?> , <?php echo $Rdelivery['city']; ?> , <?php echo $Rdelivery['pincode']; ?></p>
                        </div>
                    </div>
                    <form action="" class="payform" method="POST">
                        <div class=" btn_grp d-flex justify-content-between pt-2 ">
                            <a href="tel:+91 <?php echo $Rdelivery['phone']; ?>" class="btn btn_fill  shadow-none py-0 me-3" style="border-radius: 50%; " ><i class='bx bxs-phone-call'></i></a>
                            <input type="text" value="<?php echo $Rdelivery['order_id']; ?>"  name="pay_id" hidden>
                            <button class="btn btn_cart paybutton rounded-pill shadow-none py-1 me-3 " type="submit" >Mark as Delivered</button>
                            <a href="../Order_invoice.php?order_id=<?php echo $Rdelivery['order_id'];?>" target="_blank" class="btn btn_fill py-0 shadow-none " style="border-radius: 50%; "><i class='bx bxs-receipt'></i></a>
                        </div>
                    </form>
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


<script src="../JS/Sales_delivery.js"></script>

<script>
        
    $('.payform').submit(function(g){
        g.preventDefault();
        var paydata = $(this).serializeArray();
        //console.log(paydata);
        $("#pay_modal").modal("show");

        $('.confirmBtn').click(function(){
           // console.log(paydata);
            $.post(
                "delivery_data.php",
                paydata,
                function(paydata) {
                    sales_delivery();
                    toastr.success('Successfully Delivered');
                }
            );
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























