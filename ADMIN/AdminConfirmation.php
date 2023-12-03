<!doctype html>
<html lang="en">

    <?php
       require "../MAIN/Dbconn.php"; 

                
        if(!isset($_COOKIE['custnamecookie']) && !isset($_COOKIE['custidcookie'])){

            header("location:login.php");

        }
        else{

            $user_id = $_COOKIE['custidcookie'];

        }
    ?>

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
                <button class="btn shadow-none"></button>
                <a class="navbar-text">
                    <h5>Confirmation</h5>
                </a>
                <button class="btn shadow-none">
            
                </button>
            </div>
        </nav>



        <!--CONTENT-->
        <div id="Content" class="confirmation">
            <div class="container-fluid" id="main_container">

                <div style="margin-top:120px;">
                    <div class="text-center ">
                        <img src="./payment_successful.gif" alt="" style="height: 100px;">
                    </div>

                    <div class="text-center mt-3">
                        <h2>Your Order has been placed</h2>
                        <h6 class="mt-4"> <a href="AdminEcommerce.php">Click Here</a> to Go back to Shopping</h6>
                    </div>


                    <?php 

                        $find =  mysqli_query($con,"SELECT order_id,pay_status,cancel_status FROM order_details WHERE biller_id = '$user_id' ORDER BY order_id  DESC LIMIT 1");
                        foreach ($find as $order_D){
                            $OrderId =  $order_D['order_id'];
                            $pay_status = $order_D['pay_status'];
                            $cancel_status = $order_D['cancel_status'];
                        }
                       
                    ?>

                    <div class="text-center action_btns">
                        <a href="../Order_invoice.php?order_id=<?php echo $OrderId; ?>" target="_blank" class="btn btn_cart btn_same rounded-pill shadow-none mx-4" >View Invoice</a>
                        <button class="btn btn_cart btn_same rounded-pill shadow-none mx-4" id="btn_cancel" value="<?php echo $OrderId;?>"  <?php if($cancel_status == '1'){ echo "disabled"; } else{ echo ""; }?> >Cancel Order</button>
                        <button class="btn btn_cart btn_same rounded-pill shadow-none mx-4" id="btn_pay" value="<?php echo $OrderId; ?>" <?php if($pay_status == 'Paid'|| $cancel_status == '1'){ echo "disabled"; } else{ echo ""; }?> >Payment Recieved</button>
                    </div>
                </div>

            </div>
        </div>

    </div>



    <script>


        $('#btn_cancel').click(function(){
            var cancel_id = $(this).val();
            $.ajax({
                url:"AdminSalesOperations.php",
                type:"POST",
                data:{cancel_id:cancel_id},
                success:function(data){
                    toastr.success(data);
                    $('#btn_cancel').prop("disabled",true);
                    $('#btn_pay').prop("disabled",true);
                }
            });
        });


        $('#btn_pay').click(function(){
            var pay_id = $(this).val();
            $.ajax({
                url:"AdminSalesOperations.php",
                type:"POST",
                data:{pay_id:pay_id},
                success:function(data){
                    toastr.success(data);
                    $('#btn_pay').prop("disabled",true);
                }
            });
        });
    </script>
    

    <?php 
        include "../MAIN/Footer.php";
    ?>
</body>

</html>