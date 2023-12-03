<?php
require "../MAIN/Dbconn.php";

if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

    if ($_COOKIE['custtypecookie'] == 'executive' || $_COOKIE['custtypecookie'] == 'admin') {
        echo "";
    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}
$PageTitle = 'SalesOrders';
?>



<!doctype html>
<html lang="en">

<head>

    <?php

    require "../MAIN/Header.php";

    ?>

    <style>
        .mainContents .img-div {
            height: 100px;
            width: 100px;

        }

        .mainContents .img-div img {
            border-radius: 50%;
        }

        .mainContents .customerDetails i {
            vertical-align: middle;
            color: #1338be;
            margin-right: 10px;
        }

        .mainContents .customerDetails strong {
            color: grey;
        }

        .mainContents .CardHead {
            padding: 10px 10px;
            background-color: lightgray;
            border-radius: 8px 8px 0px 0px;
            font-weight: 600;
        }

        .mainContents .CardDiv {
            padding: 10px 15px;
        }

        .mainContents .HistoryCard {
            border: none;
            border-radius: 8px;
        }
    </style>

</head>

<body>

    <div class="wrapper">
        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5>Sales Orders</h5>
                </a>
                <a href="../profile.php">
                    <i class="material-icons">account_circle</i>
                </a>
            </div>
        </nav>

        <!--SIDEBAR-->
        <?php

        include '../MAIN/Sidebar.php';

        ?>








        <!--CONTENT-->
        <div id="Content" class="mb-5">

            <div class="container-fluid px-5">

                <?php

                $BillId = $_GET['OID'];
                $FindOrderDetails =  mysqli_query($con, "SELECT * FROM ebill WHERE billid = '$BillId'");
                if (mysqli_num_rows($FindOrderDetails) > 0) {
                    foreach ($FindOrderDetails as $FindOrderDetailsResults) {
                        $CustomerId = $FindOrderDetailsResults['customerid'];
                        $FindCgstSgstCount = mysqli_query($con, "SELECT SUM(cgstamt), SUM(sgstamt), COUNT(billdetailedid) FROM ebilldetailed WHERE billid = '$BillId'");
                        foreach ($FindCgstSgstCount as $FindCgstSgstCountResult) {
                            $TotalCgst = $FindCgstSgstCountResult['SUM(cgstamt)'];
                            $TotalSgst = $FindCgstSgstCountResult['SUM(sgstamt)'];
                            $TotalCount = $FindCgstSgstCountResult['COUNT(billdetailedid)'];
                        }
                ?>



                        <div id="InstallmentHistoryView" class="mainContents">

                            <div class="Adminheading mt-4 mb-3">
                                <h3>Order Details</h3>
                            </div>

                            <div class="row">

                                <div class="col-4">

                                    <?php

                                    $FindCustomerDetails = mysqli_query($con, "SELECT user_id,first_name,last_name,email_id,phone_number,address_detailed FROM user_details WHERE user_id = '$CustomerId'");
                                    foreach ($FindCustomerDetails as $FindCustomerDetailsResults) {
                                    }

                                    ?>

                                    <div class="card card-body HistoryCard shadow p-0">
                                        <h5 class="CardHead">Customer Details</h5>
                                        <div class="CardDiv">
                                            <div class="img-div mx-auto mb-2">
                                                <img src="../assets/img/team/team-1.jpg" alt="" class="img-fluid">
                                            </div>
                                            <h6 class="text-muted text-center"> # <?= $FindCustomerDetailsResults['user_id']  ?></h6>
                                            <h4 class="text-center mb-0"><?= $FindCustomerDetailsResults['first_name'] . ' ' . $FindCustomerDetailsResults['last_name'] ?></h4>

                                            <hr class="m-2">
                                            <div class="customerDetails">
                                                <h6> <i class="material-icons">phone_iphone</i> <strong> <?= $FindCustomerDetailsResults['phone_number']  ?> </strong> </h6>
                                                <h6> <i class="material-icons">alternate_email</i> <strong><?= $FindCustomerDetailsResults['email_id']  ?></strong> </h6>
                                                <!-- <h6> <i class="material-icons">cake</i> <strong> </strong> </h6> -->
                                                <h6> <i class="material-icons">home</i> <strong> <?= $FindCustomerDetailsResults['address_detailed']  ?> </strong> </h6>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-4">

                                    <div class="card card-body shadow HistoryCard p-0">
                                        <h5 class="CardHead">Shipping Details</h5>

                                        <div class="CardDiv">
                                            <div class="row mt-3">
                                                <div class="col-6 text-muted">
                                                    <h6>Name : </h6>
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h6> <?= $FindOrderDetailsResults['customername'] ?> </h6>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-6 text-muted">
                                                    <h6>Email :</h6>
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h6> <?= $FindOrderDetailsResults['customerEmail'] ?> </h6>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-6 text-muted">
                                                    <h6>Phone :</h6>
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h6><?= $FindOrderDetailsResults['contactno'] ?></h6>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-6 text-muted">
                                                    <h6>Address :</h6>
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h6><?= $FindOrderDetailsResults['address'] ?></h6>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-6 text-muted">
                                                    <h6>State :</h6>
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h6><?= $FindOrderDetailsResults['customerState'] ?></h6>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-6 text-muted">
                                                    <h6>City :</h6>
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h6><?= $FindOrderDetailsResults['customerCity'] ?></h6>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-6 text-muted">
                                                    <h6>Nearby Taluk :</h6>
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h6><?= $FindOrderDetailsResults['customername'] ?></h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-4">

                                    <div class="card card-body shadow HistoryCard p-0">
                                        <h5 class="CardHead">Payment Details</h5>

                                        <div class="CardDiv">
                                            <div class="row mt-2">
                                                <div class="col-6 text-muted">
                                                    <h6>Total Quantity:</h6>
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h6> <?= number_format($FindOrderDetailsResults['totalqty'])  ?> Nos. </h6>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-6 text-muted">
                                                    <h6>Total Items:</h6>
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h6><?= $TotalCount ?> Nos.</h6>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-6 text-muted">
                                                    <h6>Sub Total:</h6>
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h6> &#8377; <?= number_format($FindOrderDetailsResults['grossamount'], 2)  ?> </h6>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-6 text-muted">
                                                    <h6>Total SGST:</h6>
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h6> &#8377; <?= $TotalSgst ?></h6>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-6 text-muted">
                                                    <h6>Total CGST:</h6>
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h6> &#8377; <?= $TotalCgst ?></h6>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-6 text-muted">
                                                    <h6>Total Amount :</h6>
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h6> &#8377; <?= number_format($FindOrderDetailsResults['totalamount'], 2)  ?> </h6>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-body HistoryCard mt-2 p-0">
                                        <table class="table" id="MasterTable" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th> <input class="form-check-input" type="checkbox"> </th>
                                                    <th>Sl.NO</th>
                                                    <th>PRODUCT</th>
                                                    <th>QTY</th>
                                                    <th>STATUS</th>

                                                </tr>
                                            </thead>
                                            <tbody id="ShowItemDetails">
                                                <tr>
                                                    <td> <input class="form-check-input" type="checkbox"> </td>
                                                    <td>1</td>
                                                    <td>I Phone 13 Pro</td>
                                                    <td>2</td>
                                                    <td><span class="badge text-bg-success">Approved</span></td>
                                                </tr>
                                                <tr>
                                                    <td> <input class="form-check-input" type="checkbox"> </td>
                                                    <td>2</td>
                                                    <td>I Phone 11</td>
                                                    <td>1</td>
                                                    <td><span class="badge text-bg-warning">Pending</span></td>
                                                </tr>
                                                <tr>
                                                    <td> <input class="form-check-input" type="checkbox"> </td>
                                                    <td>3</td>
                                                    <td>Redmi Note 13</td>
                                                    <td>1</td>
                                                    <td><span class="badge text-bg-danger">Rejected</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-12 mt-3">

                                    <div class="text-end">
                                        <button class="btn btn-success me-5">APPROVE</button>
                                        <button class="btn btn-danger">REJECT&nbsp;</button>
                                    </div>

                                </div>

                            </div>

                        </div>

                <?php

                    }
                }

                ?>

            </div>


        </div>

    </div>






    <?php
    include "../MAIN/Footer.php";
    ?>


    <script>
        ShowAllItems();
        function ShowAllItems() {
            var ShowSalesOrderItems = '<?= $BillId ?>';
            $.ajax({
                url: "AdminSalesOperations.php",
                type: "POST",
                data: {ShowSalesOrderItems:ShowSalesOrderItems},
                success: function(data) {
                    console.log(data)
                    $('#ShowItemDetails').html(data);
                },
                
            });
        }
    </script>


</body>

</html>