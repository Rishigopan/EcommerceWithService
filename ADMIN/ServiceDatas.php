<?php

    require "../MAIN/Dbconn.php"; 

    // Only Show Inshop Service
    if(isset($_GET['InshopServiceOrders'])){

        $find_data = mysqli_query($con, "SELECT * FROM servicebill WHERE stat NOT IN(10,11) AND billType = 'SR'");
        if(mysqli_num_rows($find_data) > 0){
            while ($dataRow = mysqli_fetch_assoc($find_data)) {
                $rows[] = $dataRow;
            }
        }
        else{
            $rows = array();
        }
        
        $dataset = array(
            //"sEcho" => 1,
            //"iTotalRecords"=> "0",
            //"iTotalDisplayRecords"=> "0",
            "aaData" => $rows
        );
        
        echo json_encode($dataset);

    }


    // Only Show Online Service
    if(isset($_GET['OnlineServiceOrders'])){

        $find_data = mysqli_query($con, "SELECT * FROM servicebill WHERE stat NOT IN(10,11) AND billType = 'OSR'");
        if(mysqli_num_rows($find_data) > 0){
            while ($dataRow = mysqli_fetch_assoc($find_data)) {
                $rows[] = $dataRow;
            }
        }
        else{
            $rows = array();
        }
        
        $dataset = array(
            //"sEcho" => 1,
            //"iTotalRecords"=> "0",
            //"iTotalDisplayRecords"=> "0",
            "aaData" => $rows
        );
        
        echo json_encode($dataset);

    }


    // Show All Service Orders
    if(isset($_GET['AllServiceOrders'])){

        $find_data = mysqli_query($con, "SELECT * FROM servicebill WHERE stat NOT IN(10,11)");
        if(mysqli_num_rows($find_data) > 0){
            while ($dataRow = mysqli_fetch_assoc($find_data)) {
                $rows[] = $dataRow;
            }
        }
        else{
            $rows = array();
        }
        
        $dataset = array(
            //"sEcho" => 1,
            //"iTotalRecords"=> "0",
            //"iTotalDisplayRecords"=> "0",
            "aaData" => $rows
        );
        
        echo json_encode($dataset);

    }



    if(isset($_GET['TechAllServices'])){

        $find_data = mysqli_query($con, "SELECT * FROM servicebill WHERE tracker = 'Tech'");
        if(mysqli_num_rows($find_data) > 0){
            while ($dataRow = mysqli_fetch_assoc($find_data)) {
                $rows[] = $dataRow;
            }
        }
        else{
            $rows = array();
        }
        
        $dataset = array(
            //"sEcho" => 1,
            //"iTotalRecords"=> "0",
            //"iTotalDisplayRecords"=> "0",
            "aaData" => $rows
        );
        
        echo json_encode($dataset);

    }


    

    if(isset($_GET['ServiceReport'])){

        $find_data = mysqli_query($con, "SELECT * FROM servicebill");
        if(mysqli_num_rows($find_data) > 0){
            while ($dataRow = mysqli_fetch_assoc($find_data)) {
                $rows[] = $dataRow;
            }
        }
        else{
            $rows = array();
        }
        
        $dataset = array(
            //"sEcho" => 1,
            //"iTotalRecords"=> "0",
            //"iTotalDisplayRecords"=> "0",
            "aaData" => $rows
        );
        
        echo json_encode($dataset);

    }
















?>