<?php 



require '../MAIN/Dbconn.php';



session_start();

// Get Service type
if(isset($_GET['SLID'])){
    $_SESSION['SelectionId'] = $_GET['SLID'];
    header('location:BrandSelection.php');
}


// Get Brand
if(isset($_GET['Brand'])){
    $_SESSION['brand_name'] = $_GET['Brand'];
    //$_SESSION['ServiceSelected'] = $_GET['ServiceType'];
    header('location:ModelSelection.php');
}


//Get Model
if(isset($_GET['Model'])){
    $_SESSION['model_name'] = $_GET['Model'];
    header('location:TypeSelection.php');
}


//Get Products
if(isset($_GET['ProductType'])){
    $_SESSION['ProductType'] = $_GET['ProductType'];
    if(isset($_GET['HasColor'])){
        if($_GET['HasColor'] == 'YES'){
            header('location:ColorSelection.php');
        }else{
            header('location:Products.php');
        }
    }else{
        header('location:Products.php');
    }
}



//Get Color
if(isset($_GET['ProductColor'])){
    $_SESSION['ProductColor'] = $_GET['ProductColor'];
    header('location:ProductsWithColor.php');
}




//Get Service
if(isset($_POST['Service_btn'])){
    $_SESSION['service_check'] = $_POST['services'];
   /* foreach($_SESSION['service_check'] as $mx){
        $new_query = mysqli_query($con, "SELECT * FROM services WHERE sr_id = '$mx'");
        foreach($new_query as $results){
            echo $results['service_name'];
        }
        //echo $mx;
    }*/
    header('location:LocationSelection.php');
}


//Get Location
if(isset($_GET['location'])){
    $_SESSION['Service_location'] = $_GET['location'];
   // echo $_SESSION['Service_location'];
    header('location:DateSelection.php');
}


//Get Date & Time
if(isset($_POST['Date_btn'])){
    $_SESSION['selectDate'] = $_POST['Date_pick'];
    $_SESSION['time'] = $_POST['time_radio'];
    //echo $_SESSION['time'].$_SESSION['selectDate'];
    header('location:FillInformation.php');
}



//Get Customer Details
if(isset($_POST['Info_btn'])){
    $_SESSION['Cname'] = $_POST['cust_name'];
    $_SESSION['Cphone'] = $_POST['cust_phone'];
    $_SESSION['Cemail'] = $_POST['cust_email'];
    $_SESSION['Ccenter'] = $_POST['service_center'];
    $_SESSION['Caddress'] = $_POST['cust_address'];
    $_SESSION['Ccity'] = $_POST['cust_city'];
    $_SESSION['Cstate'] = $_POST['cust_state'];
    $_SESSION['Cpincode'] = $_POST['cust_pincode'];
    $_SESSION['Cdetails'] = $_POST['add_details'];

  //  echo $_SESSION['Cname'].$_SESSION['Cphone'].$_SESSION['Cemail'].$_SESSION['Ccenter'].$_SESSION['Caddress'].$_SESSION['Ccity'].$_SESSION['Cstate'].$_SESSION['Cpincode'].$_SESSION['Cdetails'];

    Header('location:ServicePayment.php');
}


if(isset($_POST['Pay_btn'])){

    $_SESSION['mode'] = $_POST['mode'];
    
    $brand = $_SESSION['brand_name'];
    $model = $_SESSION['model_name'];
    $mode = $_SESSION['mode'];
    $location = $_SESSION['Service_location'];
    $date = $_SESSION['selectDate'];
    $time = $_SESSION['time'];
    $name = $_SESSION['Cname'];
    $phone = $_SESSION['Cphone'];
    $email = $_SESSION['Cemail'];
    $nearby = $_SESSION['Ccenter'];
    $address = $_SESSION['Caddress'];
    $city = $_SESSION['Ccity'];
    $state = $_SESSION['Cstate'];
    $pincode = $_SESSION['Cpincode'];
    $add_details = $_SESSION['Cdetails'];


    $serviceID = implode("','", $_SESSION['service_check']);
    $sumquery = mysqli_query($con, "SELECT SUM(cost) FROM service_main WHERE mo_id = '$model' AND br_id = '$brand' AND sr_id IN('".$serviceID."')");
        while($sumresult = mysqli_fetch_array($sumquery)){
        $total =  $sumresult['SUM(cost)'];
        }

        if($location == 'Doorstep'){
            $Service_order = mysqli_query($con , "INSERT INTO service_order (cust_name,cust_phone,cust_email,service_center,cust_address,cust_city,cust_state,cust_pincode,cust_details,brand,model,pickup_date,pickup_time,pickup_mode,mode_of_pay,total,tracker) VALUES 
                                    
                                    ('$name','$phone','$email','$nearby','$address','$city','$state','$pincode','$add_details','$brand','$model','$date','$time','$location','$mode','$total','null')");
        }
        else{
            $Service_order = mysqli_query($con , "INSERT INTO service_order (cust_name,cust_phone,cust_email,service_center,cust_address,cust_city,cust_state,cust_pincode,cust_details,brand,model,pickup_date,pickup_time,pickup_mode,mode_of_pay,total,tracker) VALUES 
                                    
                                    ('$name','$phone','$email','$nearby','$address','$city','$state','$pincode','$add_details','$brand','$model','$date','$time','$location','$mode','$total','shop')");
        }
    
    if($Service_order){
        foreach($_SESSION['service_check'] as $mx){
              
            $service_items = mysqli_query($con, "INSERT INTO service_items (so_id,main_sr_id) VALUES ((SELECT so_id FROM service_order WHERE cust_phone = '$phone' ORDER BY so_id DESC LIMIT 1),'$mx')");
           
        }
        /*foreach($_SESSION['service_check'] as $mx){
            $query = mysqli_query($con, "SELECT * FROM service_main WHERE sr_id = '$mx' AND mo_id = '$model' AND br_id = '$brand'");
            while($result = mysqli_fetch_array($query)){
                $s_name = $result['service'];
                $s_price = $result['cost'];
                $service_items = mysqli_query($con, "INSERT INTO service_items (so_id,sr_id,service,price) VALUES ((SELECT so_id FROM service_order WHERE cust_phone = '$phone' ORDER BY so_id DESC LIMIT 1),'$mx','$s_name','$s_price')");
            }
        }*/
    }
    else{
        echo "Transaction Query error";
    }
    if($Service_order && $service_items){
        header('location:ServiceConfirmation.php');
    }
    else{
        echo "Transaction Failed";
    }
}














?>