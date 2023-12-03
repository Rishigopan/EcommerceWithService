<?php 



    require "../MAIN/Dbconn.php"; 

    $cart_table = $_COOKIE['custidcookie'].$_COOKIE['custnamecookie'].'_cart';
    $wish_table  = $_COOKIE['custidcookie'].$_COOKIE['custnamecookie'].'_wishlist';
    

    if(isset($_POST['remwish_id'])){
        $rem_id = $_POST['remwish_id']; 

        $remove_wishlist  = mysqli_query($con, "DELETE FROM $wish_table WHERE wish_id = '$rem_id'");
        if($remove_wishlist){
            echo "Product Removed From Wishlist";
        }
        else{
            echo "Couldn't Remove Product";  
        }
    }


    if(isset($_POST['addcart_id'])){
        $add_id = $_POST['addcart_id']; 

        $check_query = mysqli_query($con, "SELECT pr_id FROM $cart_table WHERE pr_id = '$add_id'");
        if(mysqli_num_rows($check_query) > 0){
            echo "Product Already Present in Cart";
        }
        else{
            $add_cart  = mysqli_query($con, "INSERT INTO  $cart_table (pr_id,quantity) VALUES ('$add_id','1')");
            if($add_cart){
                echo "Successfully Added to Cart";
            }
            else{
                echo "Failed to Add Product to Cart";  
            }
        }
        
    }













?>