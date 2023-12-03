<?php

require "../MAIN/Dbconn.php";


if (isset($_COOKIE['custnamecookie']) && isset($_COOKIE['custidcookie'])) {

    if ($_COOKIE['custtypecookie'] == 'executive' || $_COOKIE['custtypecookie'] == 'admin') {
    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}

$cart_table = 'servicetabletemp';
$userId = $_COOKIE['custidcookie'];

$PageTitle = 'ServiceBilling';


?>

<!doctype html>
<html lang="en">

<head>


    <!-- SELECTIZE  CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/css/selectize.bootstrap5.css" integrity="sha512-QomP/COM7vFCHcVHpDh/dW9oDyg44VWNzgrg9cG8T2cYSXPtqkQK54WRpbqttfo0MYlwlLUz3EUR+78/aSbEIw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <?php

    require "../MAIN/Header.php";

    ?>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/js/selectize.min.js" integrity="sha512-VReIIr1tJEzBye8Elk8Dw/B2dAUZFRfxnV2wbpJ0qOvk57xupH+bZRVHVngdV04WVrjaMeR1HfYlMLCiFENoKw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <style>
        .disable {
            opacity: 0.5;
            pointer-events: none;

        }

        .selectize-dropdown-content {
            max-height: 60vh !important;
        }

        .ServiceSelectionCard .ListServices .ServiceImage {
            height: 70px;
            width: 70px;
        }

        .ServiceSelectionCard .ListServices .ServiceTitle {
            font-weight: 700;
            font-size: 17px;
            margin-top: 25px;
        }

        .ServiceSelectionCard .ListItems {
            border-radius: 10px;
            border: 2px solid gray;
            padding: 0px !important;
            margin-bottom: 10px;
            cursor: pointer;
            color: rgb(50, 50, 50);
        }

        .ServiceSelectionCard .ListItems:hover {
            border: 2px solid #f50414;
            color: #f50414;
        }

        .CollectedItemsCard .CollectedItems {
            border-radius: 10px;
            border: 2px solid grey;
            background-color: white;
            height: 120px;
            width: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .CollectedItemsCard .CollectedItemDiv {
            position: relative;
            width: 120px;
        }

        .CollectedItemsCard .CollectedItemCheckIcon {
            position: absolute;
            right: 10px;
            bottom: 5px;
            color: green;
        }

        .CollectedItemsCard .CollectedItemCheckbox {
            display: none;
        }

        .CollectedItemsCard .CollectedItemImage {
            height: 80px;
            width: 80px;
        }

        .CollectedItemsCard .CollectedItemImage img {
            height: 80px;
            width: 80px;
        }

        .CollectedItemsCard .CollectedItemCheckbox:checked+label {
            border: 2px solid #f50414;
        }

        .CollectedItemsCard .CollectedItemCheckbox:checked+label .CollectedItemCheckIcon {
            display: block;
        }

        .CollectedItemsCard .CollectedItemCheckIcon {
            display: none;
        }

        .ServiceCart .ServiceCartItems img {
            height: 90px !important;
            width: 80px !important;
        }

        .ServiceCart .ServiceCartItems .ServiceCartName {
            color: black;
            font-size: 17px;
        }

        .ServiceCart .ServiceCartItems .ServiceCartModel {
            color: rgb(80, 80, 80);
        }

        .ServiceCart .ServiceCartItems .ServiceCartAmount {
            color: rgb(242, 7, 7);
            font-weight: 700;
        }

        .FormDetails label {
            color: #474747;
            font-weight: 500;
        }

        .FormDetails label span {
            color: red;
            font-weight: 700;
        }

        .FormDetails input:focus,
        .FormDetails select:focus,
        .FormDetails textarea:focus {
            border: 1px solid #474747 !important;
        }

        .PaymentCard .ServiceTotals {
            font-weight: 700;
        }

        .PaymentCard .ServiceMainTotal {
            color: red;
        }
    </style>



</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h3>
                </div>
                <div class="modal-body ">
                    <h4 class="text-center">Successfully Saved Service Entry</h4>
                    <div class="d-flex justify-content-around mt-3">
                        <a id="ServicePrintButton" href="ServicePrint.php?OID=" target="_blank" class="btn btn_cart rounded-pill px-5">Print</a>
                        <a href="" data-bs-dismiss="modal" class="btn  btn-secondary rounded-pill px-5">Close</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="wrapper">

        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid ">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text mx-auto">
                    <h5>Service Billing</h5>
                </a>

                <div class=" d-flex">
                    <a class="btn text-white shadow-none d-none" href="AdminShoppingcart.php">
                        <i class="material-icons">shopping_cart</i>
                    </a>
                    <a class="btn text-white shadow-none" href="../profile.php">
                        <i class="material-icons">account_circle</i>
                    </a>
                </div>
            </div>
        </nav>


        <!--SIDEBAR-->
        <?php

        include '../MAIN/Sidebar.php';

        ?>



        <!--CONTENT-->
        <div id="Content" class="mb-5 shopping_cart">

            <?php
            if (isset($_GET['SOID'])) {
                $ServiceOrderId = $_GET['SOID'];
                $FetchOrderDetails =  mysqli_query($con, "SELECT * FROM servicebill WHERE serviceBillId = '$ServiceOrderId'");
                if (mysqli_num_rows($FetchOrderDetails) > 0) {
                    foreach ($FetchOrderDetails as $FetchOrderDetailsResults) {
                    }

                    $CollectedItemsArray = array();
                    $FindCollectedItems =  mysqli_query($con, "SELECT collectedItems FROM serviceothers WHERE serviceBillId = '$ServiceOrderId'");
                    if (mysqli_num_rows($FindCollectedItems) > 0) {
                        foreach ($FindCollectedItems as $FindCollectedItemsResults) {
                            array_push($CollectedItemsArray, $FindCollectedItemsResults['collectedItems']);
                        }
                        $CollectedItemsUpdateString = implode(",", $CollectedItemsArray);
                    }else{
                        $CollectedItemsUpdateString = '';
                    }

                    $ClearCart =  mysqli_query($con, "DELETE FROM $cart_table WHERE userId = '$userId' AND cartAction = 'EDIT'");
                    if($ClearCart){
                        $FindServiceDetailedItems =  mysqli_query($con, "SELECT * FROM servicedetailed WHERE serviceBillId = '$ServiceOrderId'");
                        if(mysqli_num_rows($FindServiceDetailedItems) > 0){
                            foreach($FindServiceDetailedItems as $FindServiceDetailedItemsResults){
    
                                $ServiceId = $FindServiceDetailedItemsResults['serviceId'];
                                $quantity = $FindServiceDetailedItemsResults['qty'];
                                $ItemInclusive = $FindServiceDetailedItemsResults['inclusive'];
                                $itembarcode = 0;
                                $itemimei = 0;
                                $inddiscountpercentage = 0;
                                $inddiscountamount = 0;
                                $rate = $FindServiceDetailedItemsResults['rate'];
                                $sp = $FindServiceDetailedItemsResults['sp'];
                                $mrp = $FindServiceDetailedItemsResults['mrp'];
                                $producttotalamount = $FindServiceDetailedItemsResults['gross'];
                                $ServiceTax = $FindServiceDetailedItemsResults['salestax'];
                                $taxamount = $FindServiceDetailedItemsResults['tax'];
                                $amount = $FindServiceDetailedItemsResults['amount'];
                                $lc = 0;
                                $CGSTPercentage = $FindServiceDetailedItemsResults['cgstpercentage'];
                                $CGSTAmt = $FindServiceDetailedItemsResults['cgstamt'];
                                $SGSTPercentage = $FindServiceDetailedItemsResults['sgstpercentage'];
                                $SGSTAmt = $FindServiceDetailedItemsResults['sgstamt'];
                                $IGSTPercentage = $FindServiceDetailedItemsResults['igstpercentage'];
                                $IGSTAmt = $FindServiceDetailedItemsResults['igstamt'];
                                $cesspercentage = $FindServiceDetailedItemsResults['cesspercentage'];
                                $cessamount = $FindServiceDetailedItemsResults['cessamount'];
                                $hsn = $FindServiceDetailedItemsResults['hsn'];
                                $addcesspercentage = $FindServiceDetailedItemsResults['addcesspercentage'];
                                $addcessamount = $FindServiceDetailedItemsResults['addcessamount'];
                                $cartAction = 'EDIT';
    
                                $FindMaxTempCart = mysqli_query($con, "SELECT MAX(cart_id) FROM $cart_table");
                                foreach ($FindMaxTempCart as $FindMaxTempCartResult) {
                                    $MaxTempCart = $FindMaxTempCartResult['MAX(cart_id)'] + 1;
                                }
    
    
                                $InsertIntoTempCartQuery = "INSERT INTO $cart_table(`cart_id`,`sr_id`,`quantity`,`inclusive`,`itembarcode`,`itemimei`,`inddiscountpercentage`,`inddiscountamount`,`rate`,`sp`,`mrp`,`producttotalamount`,`salestax`,`taxamount`,`amount`,`lc`,`CGSTPercentage`,`CGSTAmt`,`SGSTPercentage`,`SGSTAmt`,`IGSTPercentage`,`IGSTAmt`,`cesspercentage`,`cessamount`,`hsn`,`addcesspercentage`,`addcessamount`,`userId`,`cartAction`)VALUES('$MaxTempCart','$ServiceId','$quantity','$ItemInclusive','0','0','0','0','$rate','$sp','$mrp','$producttotalamount','$ServiceTax','$taxamount','$amount','$lc','$CGSTPercentage','$CGSTAmt','$SGSTPercentage','$SGSTAmt','$IGSTPercentage','$IGSTAmt','$cesspercentage','$cessamount','$hsn','$addcesspercentage','$addcessamount','$userId','$cartAction');
                                ";
    
    
                                $InsertIntoTempCart = mysqli_query($con,$InsertIntoTempCartQuery);
    
                                if($InsertIntoTempCart){
    
                                }
    
    
    
    
                            }
                        }else{
                        }
                    }

                    ?>
                    <div class="container-fluid" id="SalesScreen">

                        <div class="row mb-3">

                            <div class="col-lg-8 col-12 order-lg-1 order-1 mb-3">

                                <!-- SEARCH BOX FOR DEVICES -->
                                <div class="row">

                                    <div class="col-12">
                                        <select class="SelectPlugin mb-3" id="service_device">
                                            <option hidden value="">Search Device by Brand / Name / Model</option>
                                            <!-- <option value="">Iphone 13 Pro</option> -->
                                        </select>
                                    </div>

                                </div>


                                <!-- SHOW SERVICE LIST -->
                                <div class="card mt-2 shadow-sm ServiceSelectionCard">
                                    <div class="card-header">
                                        <h5 class="mb-0">Select Services</h5>
                                    </div>


                                    <div id="" class="card-body ">

                                        <div class="row" id="ShowServiceList">

                                            <div class="col-12 text-center">
                                                <img src="../assets/img/result_not_found.png" height="200px" width="200px" class="img-fluid">
                                                <h4 class="mt-3">No Records Found</h4>
                                                <p class="mt-3 text-muted">Search for a device to show the available services</p>
                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <!-- ITEMS COLLECTED -->
                                <div class="card mt-4 shadow-sm CollectedItemsCard">
                                    <div class="card-header">
                                        <h5 class="mb-0">Items Collected</h5>
                                    </div>

                                    <div id="" class="card-body">

                                        <div class="row">

                                            <div class="col-2">
                                                <div class="CollectedItemDiv">
                                                    <input type="checkbox" id="item_sim" name="CollectedItems[]" value="SimCard" class="CollectedItemCheckbox">
                                                    <label for="item_sim" class="CollectedItems">
                                                        <div class="CollectedItemImage">
                                                            <img src="../assets/img/CollectedItems/sim_1.png" class="img-fluid">
                                                        </div>
                                                        <i class="material-icons CollectedItemCheckIcon"> check_circle</i>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="CollectedItemDiv">
                                                    <input type="checkbox" id="item_sim_tray" name="CollectedItems[]" value="SimTray" class="CollectedItemCheckbox">
                                                    <label for="item_sim_tray" class="CollectedItems">
                                                        <div class="CollectedItemImage">
                                                            <img src="../assets/img/CollectedItems/sim_tray_new.png" class="img-fluid">
                                                        </div>
                                                        <i class="material-icons CollectedItemCheckIcon"> check_circle</i>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="CollectedItemDiv">
                                                    <input type="checkbox" id="item_mmc" name="CollectedItems[]" value="SdCard" class="CollectedItemCheckbox">
                                                    <label for="item_mmc" class="CollectedItems">
                                                        <div class="CollectedItemImage">
                                                            <img src="../assets/img/CollectedItems/micro-sd-card.png" class="img-fluid">
                                                        </div>
                                                        <i class="material-icons CollectedItemCheckIcon"> check_circle</i>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="CollectedItemDiv">
                                                    <input type="checkbox" id="item_pouch" name="CollectedItems[]" value="Pouch" class="CollectedItemCheckbox">
                                                    <label for="item_pouch" class="CollectedItems">
                                                        <div class="CollectedItemImage">
                                                            <img src="../assets/img/CollectedItems/phone-case.png" class="img-fluid">
                                                        </div>
                                                        <i class="material-icons CollectedItemCheckIcon"> check_circle</i>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="CollectedItemDiv">
                                                    <input type="checkbox" id="item_charger" name="CollectedItems[]" value="Charger" class="CollectedItemCheckbox">
                                                    <label for="item_charger" class="CollectedItems">
                                                        <div class="CollectedItemImage">
                                                            <img src="../assets/img/CollectedItems/charger.png" class="img-fluid">
                                                        </div>
                                                        <i class="material-icons CollectedItemCheckIcon"> check_circle</i>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <!-- AMOUNT TOTALS -->
                                <div class="card mt-4 shadow-sm PaymentCard">
                                    <div class="card-header">
                                        <h5 class="mb-0">Payment Details</h5>
                                    </div>


                                    <div id="" class="card-body">

                                        <div class="row">

                                            <div class="col-md-4 col-12 d-flex">
                                                <h4>Subtotal :&nbsp;</h4>
                                                <h4 class="ServiceTotals"> &#8377; <span id="service_subtotal">0</span></h4>
                                            </div>

                                            <div class="col-md-4 col-12 d-flex">
                                                <h4>Total Tax :&nbsp;</h4>
                                                <h4 class="ServiceTotals"> &#8377; <span id="service_tax">0</span></h4>
                                            </div>

                                            <div class="col-md-4 col-12 d-flex justify-content-lg-end">
                                                <h4 class="">Estimated Total :&nbsp;</h4>
                                                <h4 class="ServiceTotals ServiceMainTotal"> &#8377; <span id="service_total">0</span></h4>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>


                            <div class="col-lg-4 order-lg-2 order-2 mb-3">

                                <!-- SERVICE CART -->
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h5 class="mb-0">Service Cart</h5>
                                    </div>

                                    <div class="card card-body shadow-sm ServiceCart">
                                        <ul class="list-unstyled" id="ShowServiceCartItems">

                                            <li class="text-center">
                                                <img src="../assets/img/25648039_empty_cart.png" class="img-fluid">
                                                <h4 class="mt-3">Cart is Empty</h4>
                                                <p class="mt-3 text-muted">Try adding something</p>
                                            </li>

                                        </ul>
                                    </div>
                                </div>


                                <!-- BILLING ADDRESS -->
                                <div class="card shadow-sm mt-3">

                                    <div class="card-header">
                                        <h5 class="mb-0">Billing Address</h5>
                                    </div>

                                    <div class="card-body">
                                        <form id="ServiceEntryForm" class="FormDetails">

                                            <div class="col-12">
                                                <input class="form-control" type="number" id="update_service_id" name="UpdateServiceBillId" value="<?=  $ServiceOrderId ?>" hidden>
                                                <input class="form-control" type="number" id="update_actual_amount" name="UpdateActualAmount" value="" hidden>
                                                <label for="cust_name" class="form-label">Customer Name <span>*</span> </label>
                                                <input type="text" id="cust_name" name="UpdateCustomerName" class="form-control" value="<?= $FetchOrderDetailsResults['custName'] ?>" placeholder="Enter Customer Name" required>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <label for="cust_mobile" class="form-label">Phone Number <span>*</span> </label>
                                                <input type="text" id="cust_mobile" name="UpdateCustomerMobile" class="form-control" value="<?= $FetchOrderDetailsResults['custPhone'] ?>" placeholder="Enter Phone Number" required>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <label for="advance_amount" class="form-label">Advance</label>
                                                <input type="number" id="advance_amount" name="UpdateAdvanceAmount" class="form-control" value="<?= $FetchOrderDetailsResults['paidAmount'] ?>" placeholder="Enter Advanced Amount">
                                            </div>

                                            <div class="col-12 mt-2">
                                                <label for="mobile" class="form-label">Mode Of Pay</label>
                                                <select class="form-select" name="UpdateServiceMOP" id="service_mop">
                                                    <option selected value="0">CASH</option>
                                                    <option value="1">CHEQUE</option>
                                                    <option value="2">BANK</option>
                                                    <option value="3">UPI</option>
                                                    <option value="4">RTGS</option>
                                                </select>
                                            </div>


                                            <div class="col-12 mt-2">
                                                <label for="address" class="form-label">Billing Address</label>
                                                <textarea col="3" row="3" id="address" name="UpdateCustomerAddress" class="form-control" placeholder="Enter Address"><?= $FetchOrderDetailsResults['custAddress'] ?></textarea>
                                            </div>

                                            <div class="text-center mt-3">
                                                <button class="btn rounded-pill btn_cart" type="submit">Update Service</button>
                                            </div>

                                        </form>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                    <?php
                } else {
                    $ServiceOrderId = 0;
                    echo '<h1>Page Not Found</h1>';
                }
            } else {
                $ServiceOrderId = 0;
                echo '<h1>Page Not Found</h1>';
            }
            ?>

        </div>




        <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>


        <script>
            let ServiceOrderUpdateId = '<?= $ServiceOrderId ?>';

            if (ServiceOrderUpdateId != 0) {

                // Check for collected items and make it selected
                let CollectedItems = '<?= $CollectedItemsUpdateString ?>';
                if(CollectedItems != ''){
                    const CollectedItemsUpdateArray = CollectedItems.split(",");
                    for (CollectedItemsUpdateArraykeys of CollectedItemsUpdateArray) {
                        console.log(CollectedItemsUpdateArraykeys);
                        $('.CollectedItemCheckbox').each(function() {
                            if($(this).val() === CollectedItemsUpdateArraykeys){
                                $(this).prop('checked','checked');
                            }
                        });
                    }
                }else{

                }
                

                ShowServiceCart('EDIT');
                ShowTotal('EDIT');
                
            }



            // Create an instance of Notyf
            const notyf = new Notyf({
                duration: 1000,
                position: {
                    x: 'center',
                    y: 'bottom',
                },
                // types: [{
                //         type: 'warning',
                //         background: 'orange',
                //         icon: {
                //             className: 'material-icons',
                //             tagName: 'i',
                //             text: 'warning'
                //         }
                //     },
                //     {
                //         type: 'error',
                //         background: 'indianred',
                //         duration: 2000,
                //         dismissible: true
                //     }
                // ]
            });


            //Add Service List by name, brand or series
            var SelectDevice = $('#service_device').selectize({
                maxItems: 1,
                valueField: 'pr_id',
                labelField: 'name',
                searchField: ['name', 'brand_name', 'series_name'],
                create: false,
                load: (query, callback) => {
                    // if (query.length < 3) {
                    //     return callback();
                    // }
                    $.ajax({
                        url: 'AdminServiceOperations.php',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            SearchServiceDevices: query
                        },
                        error: () => callback(),
                        success: (res) => callback(res),
                    });
                },

                render: {
                    option: (item, escape) => {
                        return '<div class="card-body border-2 border-bottom py-0 px-3"><h5>' + escape(item.name) + '</h5><div class="row"><div class="col-6">Brand : ' + escape(item.brand_name) + '</div><div class="col-6 text-end">Series : ' + escape(item.series_name) + '</div></div></div>';
                    }
                },
                onChange: function(value) {
                    //console.log(value);
                    // if(value == ''){
                    //     console.log("nulll");
                    //     ShowServiceList(0);
                    // }
                    ShowServiceList(value);
                }
            });

            // Create an instance of selectize
            var SelectDeviceControl = SelectDevice[0].selectize;

            //Disable enter key on disable field
            // const ProductOptions = document.querySelector('.disable');
            // ProductOptions.addEventListener('keydown',function(event){
            // if(event.keyCode == 13) {
            //     event.preventDefault();
            //     return false;
            //     }
            // });


            ///////////////////////////   Basic Functions   //////////////////////

            //Function to List the services for a device
            function ShowServiceList(ProductId) {
                $.ajax({
                    url: "AdminServiceOperations.php",
                    type: "POST",
                    data: {
                        ShowServiceList: ProductId
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#ShowServiceList').html(data);
                    }
                });
            }


            //Show  Service cart 
            function ShowServiceCart(Action) {
                var ShowCartItems = 'FetchServiceItems';
                $.ajax({
                    url: "AdminServiceOperations.php",
                    type: "POST",
                    data: {
                        ShowCartItems: ShowCartItems,
                        ShowCartAction:Action
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#ShowServiceCartItems').html(data);
                    }
                });
            }


            //Show all service total
            function ShowTotal(Action) {
                var ShowServiceTotal = 'FetchServiceTotal';
                $.ajax({
                    url: "AdminServiceOperations.php",
                    type: "POST",
                    data: {
                        ShowServiceTotal: ShowServiceTotal,
                        ShowTotalAction:Action
                    },
                    success: function(data) {
                        //console.log(data);
                        var TotalResult = JSON.parse(data);
                        if (TotalResult.FindTotalStatus == 1) {
                            // $('#ShowSubTotal').text((TotalResult.TotalGross).toLocaleString('en-IN'));
                            $('#service_subtotal').text((TotalResult.TotalGross).toLocaleString('en-IN'));
                            // $('#ShowSGST').text((TotalResult.TotalSgst).toLocaleString('en-IN'));
                            //$('#ShowCGST').text((TotalResult.TotalCgst).toLocaleString('en-IN'));
                            //$('#ShowDiscount').text((TotalResult.TotalIndDiscount).toLocaleString('en-IN'));
                            $('#service_tax').text((TotalResult.TotalTax).toLocaleString('en-IN'));
                            $('#service_total').text((TotalResult.TotalNet).toLocaleString('en-IN'));
                            $('#update_actual_amount').val(TotalResult.TotalNet);
                            // $('#ShowTotal').text((TotalResult.TotalNetNoRound).toLocaleString('en-IN'));

                        } else {}
                    }
                });
            }


            
            //Delete all Items
            function DeleteAll(Action,Type = null) {
                var DeleteAll = 'DelAll';
                $.ajax({
                    url: "AdminServiceOperations.php",
                    type: "POST",
                    data: {
                        ClearServiceCart: DeleteAll,
                        ClearAllAction:Action
                    },
                    success: function(data) {
                        //console.log(data);
                        var Response = JSON.parse(data);
                        if (Response.Status == true) {
                            ShowServiceCart();
                            ShowTotal();
                            ShowServiceList(0);
                            if(Type == 'All'){
                                $('input[type=checkbox]').prop('checked', false);
                            }
                        } else {

                        }
                    }
                });
            }

            ///////////////////////////   Basic Functions   //////////////////////



            //Click to add service to the cart
            $(document).on('click', '.ListItems', function() {
                var ServiceId = $(this).data('service');
                console.log(ServiceId);
                $.ajax({
                    url: "AdminServiceOperations.php",
                    type: "POST",
                    data: {
                        AddServiceToCart: ServiceId,
                        AddServiceToCartAction:'EDIT'
                    },
                    success: function(data) {
                        //console.log(data);
                        var Response = JSON.parse(data);
                        if (Response.Status == true) {
                            notyf.success(Response.Message);
                            ShowServiceCart('EDIT');
                            ShowTotal('EDIT');
                        } else if (Response.Status == false) {
                            notyf.error(Response.Message);
                        }
                    }
                });
            });


            //Delete Service Item from cart
            $(document).on('click', '.DeleteServiceCart', function() {
                var DeleteServiceCartId = $(this).val();
                //console.log(DeleteCartId);
                $.ajax({
                    url: "AdminServiceOperations.php",
                    type: "POST",
                    data: {
                        DeleteServiceCartId: DeleteServiceCartId,
                        DeleteFromCartAction:'EDIT'
                    },
                    success: function(data) {
                        //console.log(data);
                        var Response = JSON.parse(data);
                        if (Response.Status == true) {
                            notyf.success(Response.Message);
                            ShowServiceCart('EDIT');
                            ShowTotal('EDIT');
                        } else if (Response.Status == false) {
                            notyf.error(Response.Message);
                        }
                    }
                });
            });



            ////////////////////////////    Add Service Form    /////////////////////
            const UpdateValidator = new window.JustValidate('#ServiceEntryForm', {
                validateBeforeSubmitting: true,
            });

            UpdateValidator
                .addField('#cust_name', [{
                        rule: 'required',
                    },
                    {
                        rule: 'minLength',
                        value: 3,
                    },
                    {
                        rule: 'maxLength',
                        value: 15,
                    },
                ]).addField('#cust_mobile', [{
                        rule: 'required',
                    },
                    {
                        rule: 'number',
                    },
                    {
                        rule: 'minLength',
                        value: 10,
                    },
                    {
                        rule: 'maxLength',
                        value: 10,
                    },
                ]).onSuccess((event) => {
                    const FormSubmitData = new FormData(document.getElementById('ServiceEntryForm'));
                    let CollectedItemsArray = [];
                    $('.CollectedItemCheckbox').each(function() {
                        if ($(this).is(':checked')) {
                            CollectedItemsArray.push($(this).val());
                            // console.log($(this).val());
                        }
                    })
                    FormSubmitData.append('UpdateCollectedItems', CollectedItemsArray.join());
                    console.log(CollectedItemsArray.join());
                    $.ajax({
                        url: "AdminServiceOperations.php",
                        type: "POST",
                        data: FormSubmitData,
                        beforeSend: function() {
                            //$('#SalesScreen').addClass('disable');
                        },
                        success: function(data) {
                            //console.log(data);
                            //$('#SalesScreen').removeClass('disable');
                            var Response = JSON.parse(data);
                            if (Response.Status == true) {
                                $('#ServiceEntryForm')[0].reset();
                                SelectDeviceControl.clear();
                                DeleteAll();
                                CollectedItemsArray.length = 0;
                                // swal("Success", Response.Message, "success").then(() => {
                                //     window.open(
                                //         'ServicePrint.php?SOID=' + Response.ServicePrintId,
                                //         '_blank'
                                //     );
                                // });
                                swal("Do you want to take a print?", {
                                        icon: "success",
                                        title: "Service Updated Successfully",
                                        buttons: {
                                            cancel: true,
                                            // catch: {
                                            //     text: "Throw Pokéball!",
                                            //     value: "catch",
                                            // },
                                            Print: true,
                                        },
                                    })
                                    .then((value) => {
                                        switch (value) {

                                            case "Print":
                                                //location.replace('NewServiceOrders.php');
                                                window.open(
                                                    'ServicePrint.php?SOID=' + Response.UpdateServicePrintId,
                                                    '_blank'
                                                );
                                                location.replace('NewServiceOrders.php');
                                                break;

                                            // case "cancel":
                                            //     //swal("Gotcha!", "Pikachu was caught!", "success");
                                            //     break;

                                            default:
                                                location.replace('NewServiceOrders.php');
                                        }
                                    });
                            } else if (Response.Status == false) {
                                swal("Error", Response.Message, "error");
                            } else {
                                swal("Potential Error", "Some Error Occured ! Please Refresh The Page To Continue", "error");
                                console.log([response.status, response.statusText]);
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                });

            ////////////////////////////    Add Service Form    /////////////////////
        </script>


        <?php
        include "../MAIN/Footer.php";
        ?>

</body>

</html>