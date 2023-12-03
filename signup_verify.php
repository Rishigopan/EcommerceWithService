<?php     

require 'Dbconn.php';


    if(isset($_POST['SignupUsername'])){

        $username = $_POST['SignupUsername'];
        $password = $_POST['SignupPassword'];
        // echo $username echo $password;
        $cart = "_cart";
        $wishlist = "_wishlist";
        
        if(!empty($_POST['SignupUsername']) && !empty($_POST['SignupPassword'])){

            $exist_query = mysqli_query($con, "SELECT * FROM user_details WHERE username = '$username' AND password = '$password'");
            if(mysqli_num_rows($exist_query) > 0){
                echo "User already exists";
            }
            else{
    
                $fetch_id = mysqli_query($con, "SELECT MAX(user_id) FROM user_details");
                foreach($fetch_id as $ids){
                    $id = $ids['MAX(user_id)'];
                    $user_id = $id +1;
                    //echo $client_id;
                }
    
                if($fetch_id){

                    mysqli_autocommit($con,FALSE);

                    $signup_query = mysqli_query($con, "INSERT INTO user_details (user_id,username,password,type) VALUES ('$user_id','$username','$password','customer')");
                        //echo "signup Success";
                    $table_query = mysqli_query($con, "CREATE TABLE `$user_id$username$cart` (
                    `cart_id` int(11) NOT NULL,`pr_id` int(11) NOT NULL,`quantity` int(11) NOT NULL, PRIMARY KEY (cart_id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                    $wishlist_query = mysqli_query($con, "CREATE TABLE `$user_id$username$wishlist` (
                    `wish_id` int(11) NOT NULL,`pr_id` int(11) NOT NULL, PRIMARY KEY (wish_id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    
                    if( $signup_query && $table_query && $wishlist_query){
                        mysqli_commit($con);
                        if(mysqli_commit($con)){
                            echo "Account created successfully,Please try logging in";
                        }
                    }
                    else{
                        mysqli_rollback($con);
                        echo "Failed Creating Account";
                    }
                   
                }
                else{
                    echo "max failed";
                }
            }
        }
        else{
            echo "Fields are empty";
        }
    }


?>