


<?php

require 'Dbconn.php';

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/5914a243cf.js" crossorigin="anonymous"></script>

    <title>Sign up</title>

    <style>
        body {
            background-color: #FF6464;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }
        
        #main_box {
            height: 500px;
            max-width: 800px;
            width: 100%;
            background: white;
            border: none;
            border-radius: 0px;
        }
        
        #first_box {
            align-items: center;
            display: flex;
            height: 500px;
        }
        
        #second_box {
            height: 500px;
            background-color: #EEEEEE;
            justify-content: center;
        }
        
        #second_box form {
            margin-top: 75px;
        }
        
        input {
            border: none !important;
            background-color: #EEEEEE !important;
            border-bottom: 2px solid #FF6464 !important;
            border-radius: 0px !important;
        }
        
        .input-group i {
            color: #FF6464;
        }
        
        #second_box p a {
            text-decoration: none;
            color: #FF6464;
        }
        
        #second_box button {
            background-color: #FF6464;
            color: white;
        }
        
        #login {
            background-color: #FF6464;
            color: white;
        }
    </style>
</head>

<body>
    <div id="main_box" class="card card-body shadow p-0">
        <div class="row g-0">
            <div id="first_box" class="col-7 d-none  d-md-flex">
                <img src="./Tiny technicians repairing smartphone.jpg" class="img-fluid" alt="">
            </div>
            <div id="second_box" class="col-md-5 col-12">
                <form action="" id="signupform" class="px-3">
                    <h3 class="mb-4">Sign up</h3>
                    <div class="input-group mb-3">
                        <span style="position:absolute; margin-left: 10px; margin-top:6px; z-index: 99;">
                            <i class="fas fa-at fa-sm"></i>
                        </span>
                        <input type="text" name="username" class="form-control shadow-none" placeholder="Enter Username" style="padding-left: 35px;" required>
                    </div>
                    <div class="input-group mb-3">
                        <span style="position:absolute; margin-left: 10px; margin-top:6px; z-index: 99;">
                            <i class="fas fa-key fa-sm"></i>
                        </span>
                        <input type="password" name="password" class="form-control shadow-none" placeholder="Enter Password" style="padding-left: 35px;" required>
                    </div>
                    
                    <div id="message">

                    </div>
                    <button id="signup" class="btn mt-3" type="submit" style="width:100%">Create Account</button>

                    <p class="mt-3">Already have an account? <a href="login.php">Login</a></p>
                </form>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function(){
            $('#signupform').submit(function(e){
                e.preventDefault();
                var form = $(this).serializeArray();
                //console.log(form);
                $.post(
                    "signup_verify.php",
                    form,
                    function(form){
                        $('#message').show();
                       // $('#btn_submit').hide();
                        $('#message').html(form);
                    }
                );
            });


            //Validation signup
            $("#signupform").validate({
                normalizer:function(value){
                    return $.trim(value);
                },
                errorClass: "error fail-alert",
                rules:{
                    username:{
                        required:true,
                        minlength:5,
                        maxlength:13,
                    },
                    password:{
                        required:true,
                        minlength:5,
                        maxlength:10
                    }
                },
                messages:{
                    username:{
                        required:"Please enter an username",
                        minlength:"Must contain atleast 5 letters",
                        maxlength:"Not more than 13 letters"
                    },
                    password:{
                        required:"Please Enter the password",
                        minlength:"Must contain atleast 5 letters",
                        maxlength:"Not more than 10 letters"
                    }
                }
            });

        });

    </script>

























    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js " integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM " crossorigin="anonymous "></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js " integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p " crossorigin="anonymous "></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js " integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF " crossorigin="anonymous "></script>
    -->
</body>


















</html>