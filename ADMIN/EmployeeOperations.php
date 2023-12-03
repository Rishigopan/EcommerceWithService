<?php


require "../MAIN/Dbconn.php"; 
    $cart = "_cart";

    //Add Operation
    if(isset($_POST['first_name']) && !empty($_POST['first_name'])){

        $firstname = $_POST['first_name'];
        $lastname = $_POST['last_name'];
        $employeid = $_POST['employee_id'];
        $username = $_POST['empl_user'];
        $password = $_POST['empl_pass'];
        $position = $_POST['empl_position'];
        $hub = $_POST['empl_branch'];
        $email = $_POST['empl_email'];
        $state = $_POST['empl_state'];
        $city = $_POST['empl_city'];
        $pincode = $_POST['empl_pincode'];
        $address = $_POST['empl_address'];
        $cart = "_cart";
        $wishlist = "_wishlist";

    
        $search_query = mysqli_query($con, "SELECT username FROM user_details WHERE username = '$username'");
        if(mysqli_num_rows($search_query) >0 ){
            echo json_encode(array('empl' => 0));

        }
        else{

            $max_query = mysqli_query($con,"SELECT MAX(user_id) FROM user_details");
            foreach($max_query as $max_result){
                $MAX = $max_result['MAX(user_id)'] + 1;
            }
            
            if($position == 'executive'){
                mysqli_autocommit($con,FALSE);
                $table_add = mysqli_query($con, "CREATE TABLE `$MAX$username$cart` (
                    `cart_id` int(11) NOT NULL,`pr_id` int(11) NOT NULL,`quantity` int(11) NOT NULL, PRIMARY KEY (cart_id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                if($table_add){
                    $add_query = mysqli_query($con, "INSERT INTO user_details (user_id,username,password,type,first_name,last_name,email_id,address_detailed,city,state,pincode,employee_id,branch) VALUES ('$MAX','$username','$password','$position','$firstname','$lastname','$email','$address','$city','$state','$pincode','$employeid','$hub')");
                    if($add_query){
                        mysqli_commit($con);
                        echo json_encode(array('empl' => 1));
                    }
                    else{
                        mysqli_rollback($con);
                        echo json_encode(array('empl' => 2));
                    }
                }
                else{
                    mysqli_rollback($con);
                    echo json_encode(array('empl' => 3));
                }
            }
            else{
                mysqli_autocommit($con,FALSE);

                $add_query = mysqli_query($con, "INSERT INTO user_details (user_id,username,password,type,first_name,last_name,email_id,address_detailed,city,state,pincode,employee_id,branch) VALUES ('$MAX','$username','$password','$position','$firstname','$lastname','$email','$address','$city','$state','$pincode','$employeid','$hub')");
                if($add_query){
                    mysqli_commit($con);
                    echo json_encode(array('empl' => 1));
                }
                else{
                    mysqli_rollback($con);
                    echo json_encode(array('empl' => 2));
                }
            }
        }  
          
    }
  
    
    
    //Edit Operation
    if(isset($_POST['editID'])){
        $edit_empl_code = $_POST['editID'];
        $edit_query = mysqli_query($con, "SELECT * FROM user_details WHERE user_id = '$edit_empl_code'");
        $edit_row = mysqli_fetch_assoc($edit_query);
        echo json_encode($edit_row,JSON_FORCE_OBJECT);
        mysqli_close($con);
    }

    

    //Update Operation
    if(isset($_POST['edit_id'])){

        $editId = $_POST['edit_id'];
        $editfirstname = $_POST['edit_firstname'];
        $editlastname = $_POST['edit_lastname'];
        $editemployeeid = $_POST['edit_employeeid'];
        $editusername = $_POST['edit_empluser'];
        $editpassword = $_POST['edit_emplpass'];
        $editposition = $_POST['edit_emplposition'];
        $edithub = $_POST['edit_emplbranch'];
        $editemail = $_POST['edit_emplemail'];
        $editstate = $_POST['edit_emplstate'];
        $editcity = $_POST['edit_emplcity'];
        $editpincode = $_POST['edit_emplpincode'];
        $editaddress = $_POST['edit_empladdress'];


        $search_query = mysqli_query($con, "SELECT username FROM user_details WHERE username = '$editusername' AND user_id <> '$editId'");
        if(mysqli_num_rows($search_query) >0 ){
            echo json_encode(array('updt' => 0));

        }
        else{
            
            $update_query = mysqli_query($con, "UPDATE user_details SET username = '$editusername', password = '$editpassword', type = '$editposition', first_name = '$editfirstname', last_name = '$editlastname', employee_id = '$editemployeeid', branch = '$edithub', email_id = '$editemail', state = '$editstate', city = '$editcity', address_detailed = '$editaddress', pincode = '$editpincode' WHERE user_id = '$editId'");
           
            if($update_query){
                echo json_encode(array('updt' => 1));
            }
            else{
                echo json_encode(array('updt' => 2));
            }
        } 
    }

    

    //Delete Operation
    if(isset($_POST['delID'])){

        $delID = $_POST['delID'];

        $search_used = mysqli_query($con,"SELECT * FROM user_details u LEFT JOIN order_details o ON u.user_id = o.agent_id LEFT JOIN service_order s ON u.user_id = s.pickup_agentid  WHERE  o.delivery_agent = '$delID' OR s.pickup_agentid = '$delID' OR s.tech_id = '$delID' OR s.delivery_agentid = '$delID'");
        if(mysqli_num_rows($search_used) > 0){
            echo json_encode(array('del' => 0));//Already in Use
        }
        else{


            $findUserType = mysqli_query($con, "SELECT type,username FROM user_details WHERE user_id = '$delID'");
            foreach($findUserType as $resultUserType){
                $userType = $resultUserType['type'];
                $deleteUserName = $resultUserType['username'];
            }

            if($userType == 'executive'){
                mysqli_autocommit($con,FALSE);

                $removeTable = mysqli_query($con, "DROP TABLE IF EXISTS $delID$deleteUserName$cart");
                if($removeTable){
                    $delete_query = mysqli_query($con, "DELETE FROM user_details WHERE user_id = '$delID'");
                    if($delete_query){
                        mysqli_commit($con);
                        echo json_encode(array('del' => 1));//Delete success
                    }
                    else{
                        mysqli_rollback($con);
                        echo json_encode(array('del' => 2));//Delete Failed
                    }
                }
                
            }
            else{
                mysqli_autocommit($con,FALSE);

                $delete_query = mysqli_query($con, "DELETE FROM user_details WHERE user_id = '$delID'");
                if($delete_query){
                    mysqli_commit($con);
                    echo json_encode(array('del' => 1));//Delete success
                }
                else{
                    mysqli_rollback($con);
                    echo json_encode(array('del' => 2));//Delete Failed
                }
            }
            
        }
    }






?>