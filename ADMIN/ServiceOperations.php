<?php

    include('../MAIN/Dbconn.php');

    //Assign technician
    if(isset($_POST['ServiceIdTech']) && !empty($_POST['tech_select']))
    {
        $ServiceId =  $_POST['ServiceIdTech'];
        $TechnicianId =$_POST['tech_select'];
        $StartDate =  date("Y-m-d h:i:s");

        mysqli_autocommit($con,FALSE);

        $AssignTechnician =  mysqli_query($con, "UPDATE service_order SET stat = 1, in_service = 1, tech_id = '$TechnicianId', tracker = 'tech', tech_start = '$StartDate' WHERE so_id = '$ServiceId'");
        if($AssignTechnician){
            mysqli_commit($con);
            echo json_encode(array('Status' => true, 'AssignTech' => 1));
        }else{
            mysqli_rollback($con);
            echo json_encode(array('Status' => false, 'AssignTech' => 2));
        }
    }


    //Assign Delivery Agent
    if(isset($_POST['ServiceIdDel']) && !empty($_POST['agent_select'])){

        $ServiceId =  $_POST['ServiceIdDel'];
        $AgentId = $_POST['agent_select'];
        
        mysqli_autocommit($con,FALSE);

        $AssignDelivery = mysqli_query($con, "UPDATE service_order SET in_transit = 1, pickup_agentid = '$AgentId', tracker = 'pickup' WHERE so_id = '$ServiceId'");
        if($AssignDelivery){
            mysqli_commit($con);
            echo json_encode(array('Status' => true, 'AssignDelivery' => 1));
        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('Status' => false, 'AssignDelivery' => 2));
        }

    }





















?>