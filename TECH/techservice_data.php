<?php

    require "../MAIN/Dbconn.php"; 


    //START DIAGNOSIS
    if(isset($_POST['D_id'])){
        $D_id = $_POST['D_id'];
        $start_diagnosis = mysqli_query($con, "UPDATE service_order SET tech_status = 'Diagnosis' WHERE so_id = '$D_id'");
        if($start_diagnosis){
            echo "Successfully Started diagnosis";
        }
        else{
            echo "Failed Starting Diagnosis";
        }
    }

    //ADD SERVICE
    if(isset($_POST['Add_id'])){
        $so_id =  $_POST['Add_id'];
        $select_service = $_POST['S_select'];
        $service_name = $_POST['S_name'];
        $service_price = $_POST['S_amount'];

        $fetch_max_query = mysqli_query($con, "SELECT MAX(main_sr_id) FROM service_items WHERE so_id = '$so_id'");
        foreach($fetch_max_query as $fetch_max){
            $new_id = $fetch_max['MAX(main_sr_id)'] + 1;
        }

        if(!empty($service_name) && !empty($service_price) && empty($select_service)){
            $add_new_service_query = mysqli_query($con, "INSERT INTO service_items (so_id,main_sr_id,service,price) VALUES ('$so_id','$new_id','$service_name','$service_price')");
            if($add_new_service_query){
                echo "Success Adding New Service";
            }
            else{
                echo "Failed Adding New Service";
            }
        }
        elseif(empty($service_name) && !empty($service_price) && empty($select_service)){
            echo "Enter Service Name";

        }
        elseif(!empty($service_name) && empty($service_price) && empty($select_service)){
            echo "Enter Service Amount";
            
        }

        if(!empty($select_service) && empty($service_name) && empty($service_price)){
            $add_service_query = mysqli_query($con, "INSERT INTO service_items (so_id,main_sr_id) VALUES ('$so_id','$select_service')");
            if($add_service_query){
                echo "Success Adding New Service";
            }
            else{
                echo "Failed Adding New Service";
            }
        }


        if(!empty($service_name) && !empty($service_price) && !empty($select_service)){
            echo "Choose Only one";
        }

        if(empty($service_name) && empty($service_price) && empty($select_service)){
            echo "Choose atleast one";
        }
    }
    

    //START SERVICE AND SET DATE
    if(isset($_POST['exp_time'])){
        $sorder_id = $_POST['sorder_id'];
        $exptime = $_POST['exp_time'];

        if(!empty($exptime)){
            $set_exptime = mysqli_query($con, "UPDATE service_order SET expected_time = '$exptime', tech_status = 'Service' WHERE so_id = '$sorder_id'");
            if($set_exptime){
                echo "Expected Time of Completion is Set";
            }
            else{
                echo "Setting Time of Completion Failed";
            }
        }
        else{
            echo "Please Choose a Date and Time";
        }
    }

    //DELETE SERVICE
    if(isset($_POST['Del_id'])){

      $delId = $_POST['Del_id'];
      $delete_query = mysqli_query($con, "DELETE FROM service_items WHERE id = '$delId'");
      if($delete_query){
        echo "Successfully Removed From Service List";
      }
      else{
        echo "Failed Removing From Service List";
      }
    }

    //START TESTING
    if(isset($_POST['st_id'])){

        $TestId = $_POST['st_id'];
        $start_testing_query = mysqli_query($con, "UPDATE service_order SET tech_status = 'Testing' WHERE so_id = '$TestId'");
        if($start_testing_query){
          echo "Successfully Started Testing";
        }
        else{
          echo "Failed  Starting Testing";
        }
    }

    //FINISHED SERVICE
    if(isset($_POST['finish_id'])){
        
        date_default_timezone_set("Asia/kolkata");
        $endDate =  date("Y-m-d h:i:s");
        $FinishId = $_POST['finish_id'];
        $finish_query = mysqli_query($con, "UPDATE service_order SET tech_status = 'Completed', stat = '2', tech_end = '$endDate' WHERE so_id = '$FinishId'");
        if($finish_query){
          echo "Successfully Completed Service";
        }
        else{
          echo "Failed Completing Service";
        }
    }

    
?>