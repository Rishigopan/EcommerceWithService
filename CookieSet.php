<!DOCTYPE html>
<html lang="en">

<head>
    
    <?php  
    
        include './MAIN/Header.php';  
        include './MAIN/Dbconn.php';
    
    ?>


</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="LoginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div id="main_box" class="card card-body shadow p-0">
                    <div class="row g-0">
                        <div id="first_box" class="col-7 d-none  d-md-flex">
                            <img src="./Tiny technicians repairing smartphone.jpg" class="img-fluid" alt="">
                        </div>
                        <div id="second_box" class="col-md-5 col-12">
                            <form action="" id="loginform" class="px-3">
                                <h3 class="mb-4">Login</h3>
                                <div class="input-group mb-3">
                                    <span style="position:absolute; margin-left: 10px; margin-top:6px; z-index: 99;">
                                        <i class="fas fa-at fa-sm"></i>
                                    </span>
                                    <input type="text" name="username" class="form-control shadow-none" placeholder="Enter Email/Phone  " style="padding-left: 35px;" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span style="position:absolute; margin-left: 10px; margin-top:6px; z-index: 99;">
                                        <i class="fas fa-key fa-sm"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control shadow-none" placeholder="Enter Password" style="padding-left: 35px;" required>
                                </div>

                                <div id="message">

                                </div>
                                <button id="login" class="btn mt-3" type="submit" style="width:100%">Login</button>

                                <p class="mt-3">Don't have an account? <a href="signup.php">Sign up</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <h1>
        helooo
    </h1>




    <script>
        //setCookie("first", "hello", 20);

        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }


        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }



        TestAuth();


        function TestAuth() {
            let CustNameCookie = getCookie("custnamecookie");
            let CustTypeCookie = getCookie("custtypecookie");
            if (CustNameCookie == '' && CustTypeCookie == '') {
                console.log('Not authenticated');
                $('#LoginModal').modal('show');

            } else {
                console.log('Authenticated');
            }
        }


        $('#loginform').submit(function(e) {
            e.preventDefault();
            var form = $(this).serializeArray();
            console.log(form);
            $.post(
                "login_verify.php",
                form,
                function(form) {
                    $('#message').show();
                    $('#message').html(form);
                    //console.log("hello");
                    var response = JSON.parse(form);
                    if (response.success == "1") {
                        $('#message').hide();
                        //alert("admin");
                        location.href = "./ADMIN/Service.php";
                    } else if (response.success == "2") {
                        $('#message').hide();
                        //alert("customer");
                        //location.href = "./CUSTOMER/Ecommerce.php";
                        history.go(-1);
                        //location.reload();
                    } else if (response.success == "3") {
                        $('#message').hide();
                        //alert("delivery");
                        location.href = "./DELIVERY/Delivery Screen.php";
                    } else if (response.success == "4") {
                        $('#message').hide();
                        //alert("technician");
                        location.href = "./TECH/technician_allservices.php";
                    } else if (response.success == "5") {
                        $('#message').hide();
                        //alert("executive");
                        location.href = "./ADMIN/Service.php";
                    } else {

                    }

                }
            );
        });
        //console.log(CustNameCookie);
    </script>

</body>

</html>