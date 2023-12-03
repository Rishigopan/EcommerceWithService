<?php     



include __DIR__.'/MAIN/Dbconn.php';



$user = 0;
$pass = 0;
    if(isset($_POST['username'])){

        $username = $_POST['username'];
        $password = $_POST['password'];
       // echo $username echo $password;
        if (!empty($_POST['username']) && !empty($_POST['password'])) {

            $search_user = mysqli_query($con, "SELECT username FROM user_details WHERE username = '$username'");

            foreach($search_user as $user_rows){
                if($username === $user_rows['username']){
                    $user = 1;
                }
                else{
                    $user = 0;
                }
            }
            if($user === 1){

                $search_pass = mysqli_query($con, "SELECT password FROM user_details WHERE username = '$username'");

                foreach($search_pass as $pass_rows){

                    if($password === $pass_rows['password']){
                        $pass = 1;
                    }
                    else{
                    // $pass = 0;
                    }
                        
                }
                if(($user === 1) & ($pass === 1)){

                    $id_query = mysqli_query($con, "SELECT user_id,type from user_details WHERE username = '$username' AND password = '$password' ");
                    foreach($id_query as $id_row){
                        $user_id = $id_row['user_id'];
                        $user_type = $id_row['type'];
                         setcookie('custnamecookie',$username,time()+(86400*2), "/");
                         setcookie('custidcookie',$user_id,time()+(86400*2), "/");
                         setcookie('custtypecookie',$user_type,time()+(86400*2), "/");
                    }

                    if($user_type == 'admin' ){
                        echo json_encode(array('success' => 1));
                    }
                    elseif($user_type == 'customer' ){
                        echo json_encode(array('success' => 2));
                    }
                    elseif($user_type == 'delivery' ){
                        echo json_encode(array('success' => 3));
                    }
                    elseif($user_type == 'technician' ){
                        echo json_encode(array('success' => 4));
                    }
                    elseif($user_type == 'executive' ){
                        echo json_encode(array('success' => 5));
                    }
                    
                }
                else{

                   // echo json_encode(array('success' => 0));
                    echo "Password In correct";
                }
            }
            else{
                echo "Username not found";
            }

        }
        else{
            echo "The feilds are empty";
        }
        

        


        

        

    
    }
















?>