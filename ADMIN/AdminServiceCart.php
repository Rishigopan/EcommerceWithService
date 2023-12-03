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

$cart_table = 'salestabletemp';


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
                                        <h4 class="ServiceTotals"> &#8377; <span id="service_subtotal">5000</span></h4>
                                    </div>

                                    <div class="col-md-4 col-12 d-flex">
                                        <h4>Total Tax :&nbsp;</h4>
                                        <h4 class="ServiceTotals"> &#8377; <span id="service_tax">6000</span></h4>
                                    </div>

                                    <div class="col-md-4 col-12 d-flex justify-content-lg-end">
                                        <h4 class="">Estimated Total :&nbsp;</h4>
                                        <h4 class="ServiceTotals ServiceMainTotal"> &#8377; <span id="service_total">7000</span></h4>
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
                                    <input type="number" id="actual_amount" name="ActualAmount" class="form-control" hidden>
                                    <div class="col-12">
                                        <label for="cust_name" class="form-label">Customer Name <span>*</span> </label>
                                        <input type="text" id="cust_name" name="CustomerName" class="form-control" placeholder="Enter Customer Name" required>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <label for="cust_mobile" class="form-label">Phone Number <span>*</span> </label>
                                        <input type="text" id="cust_mobile" name="CustomerMobile" class="form-control" placeholder="Enter Phone Number" required>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <label for="advance_amount" class="form-label">Advance</label>
                                        <input type="number" id="advance_amount" name="AdvanceAmount" class="form-control" placeholder="Enter Advanced Amount" >
                                    </div>

                                    <div class="col-12 mt-2">
                                        <label for="mobile" class="form-label">Mode Of Pay</label>
                                        <select class="form-select" name="ServiceMOP" id="service_mop">
                                            <option selected value="0">CASH</option>
                                            <option value="1">CHEQUE</option>
                                            <option value="2">BANK</option>
                                            <option value="3">UPI</option>
                                            <option value="4">RTGS</option>
                                        </select>
                                    </div>


                                    <div class="col-12 mt-2">
                                        <label for="address" class="form-label">Billing Address</label>
                                        <textarea col="3" row="3" id="address" name="CustomerAddress" class="form-control" placeholder="Enter Address"></textarea>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button class="btn rounded-pill btn_cart" type="submit">Take Service</button>
                                    </div>

                                </form>
                            </div>

                        </div>

                    </div>

                </div>




            </div>


        </div>




        <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>


        <script>
            DeleteAll('ADD');


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
                    console.log(value);
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
                            console.log(data);
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
                            console.log(data);
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
                                $('#actual_amount').val(TotalResult.TotalNet);
                                // $('#ShowTotal').text((TotalResult.TotalNetNoRound).toLocaleString('en-IN'));

                            } else {}
                        }
                    });
                }


                //Delete all Items
                function DeleteAll(Action) {
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
                                ShowServiceCart('ADD');
                                ShowTotal('ADD');
                                ShowServiceList(0);
                                $('input[type=checkbox]').prop('checked', false);
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
                        AddServiceToCartAction:'ADD'
                    },
                    success: function(data) {
                        console.log(data);
                        var Response = JSON.parse(data);
                        if (Response.Status == true) {
                            notyf.success(Response.Message);
                            ShowServiceCart('ADD');
                            ShowTotal('ADD');
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
                        DeleteFromCartAction:'ADD'
                    },
                    success: function(data) {
                        console.log(data);
                        var Response = JSON.parse(data);
                        if (Response.Status == true) {
                            notyf.success(Response.Message);
                            ShowServiceCart('ADD');
                            ShowTotal('ADD');
                        } else if (Response.Status == false) {
                            notyf.error(Response.Message);
                        }
                    }
                });
            });
            


            //////////////////////////////    Add Service Form    /////////////////////
                const SaveValidator = new window.JustValidate('#ServiceEntryForm', {
                    validateBeforeSubmitting: true,
                });

                SaveValidator
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
                    FormSubmitData.append('CollectedItems', CollectedItemsArray.join());
                    console.log(CollectedItemsArray.join());
                    $.ajax({
                        url: "AdminServiceOperations.php",
                        type: "POST",
                        data: FormSubmitData,
                        beforeSend: function() {
                            //$('#SalesScreen').addClass('disable');
                        },
                        success: function(data) {
                            console.log(data);
                            //$('#SalesScreen').removeClass('disable');
                            var Response = JSON.parse(data);
                            if (Response.Status == true) {
                                $('#ServiceEntryForm')[0].reset();
                                SelectDeviceControl.clear();
                                DeleteAll('ADD');
                                CollectedItemsArray.length = 0;
                                // swal("Success", Response.Message, "success").then(() => {
                                //     window.open(
                                //         'ServicePrint.php?SOID=' + Response.ServicePrintId,
                                //         '_blank'
                                //     );
                                // });
                                swal("Do you want to take a print?", {
                                    icon: "success",
                                    title: "Service Added Successfully",
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
                                            window.open(
                                                'ServicePrint.php?SOID=' + Response.ServicePrintId,
                                                '_blank'
                                            );
                                            break;

                                        case "cancel":
                                            //swal("Gotcha!", "Pikachu was caught!", "success");
                                            break;

                                        default:
                                            //swal("Got away safely!");
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

            //////////////////////////////    Add Service Form    /////////////////////


                
        </script>


        <?php
        include "../MAIN/Footer.php";
        ?>

</body>

</html>