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
$PageTitle = 'ServiceOrders';
?>

<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <?php

    require "../MAIN/Header.php";

    ?>

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>


    <style>
        .TableCard {
            border: none;
            border-radius: 10px;
        }

        .TableCard table thead th {
            border-bottom: 1px solid rgb(240, 240, 240);
            font-weight: 700;
            font-size: 15px;
            position: sticky !important;
            top: 0 !important;
            z-index: 1000;
        }

        .TableCard table {
            border: none !important;
        }

        .TableCard table tbody td {
            font-weight: 500;
            color: rgb(90, 90, 90);
            font-size: 14px;
            border-bottom: 1px solid rgb(240, 240, 240);
            padding: 8px 0px 8px 0px;

        }

        .TableCard table tbody td button,
        .TableCard table tbody td a {
            /* margin: 0px ; */
            padding: 3px 10px;
            font-size: 12px;
            border-radius: 20px;
            font-weight: 700;
        }

        .TableCard table tbody td button i,
        .TableCard table tbody td a i {
            font-size: 18px;
        }


        .TableCard table tbody td .ExpandButton,
        .TableCard table thead th .ExpandButton {
            color: #007FFF;
            font-size: 20px;
            cursor: pointer;
        }

        .TableCard table tbody .ChildTableContainer {
            margin: 0px 0px 0px 20px;
        }

        .TableCard table tbody .ChildTable {
            background-color: rgb(255, 255, 255) !important;
            border-bottom: 1px solid rgb(180, 180, 180);
        }

        .TableCard table tbody .ChildTable td,
        .TableCard table tbody .ChildTable th {
            padding: 5px 15px;
            /* border-bottom: 1px solid rgb(180, 180, 180); */
        }

        .TableCard table tbody .loading {
            height: 200px !important;
            display: flex;
            justify-content: center;
        }

        .TableCard table tbody .loading img {
            height: 200px !important;
            width: 200px !important;
        }

        .Searchbox {
            background-color: rgb(250, 250, 250);
            border: 1px solid rgb(230, 230, 230);
            color: #313638;
            font-weight: 500;
        }

        .Searchbox:focus,
        .FilterBox:focus {
            background-color: rgb(250, 250, 250);
            border: 1px solid rgb(150, 150, 150) !important;
        }

        .Searchbox::-webkit-input-placeholder {
            /* Edge */
            color: #7f7f7f;
            font-weight: 500;
        }

        .Searchbox:-ms-input-placeholder {
            /* Internet Explorer 10-11 */
            color: #7f7f7f;
            font-weight: 500;
        }

        .Searchbox::placeholder {
            color: #7f7f7f;
            font-weight: 500;
        }

        .FilterBox {
            background-color: rgb(250, 250, 250);
            border: 1px solid rgb(230, 230, 230);
            color: #7f7f7f;
            font-weight: 500;
        }

        .FilterBox option {
            color: #313638;
            font-weight: 500;
        }

        .RefreshButton {
            border-radius: 50%;
            background-color: rgb(210, 210, 210);
            color: black;
            border: none;
        }

        .RefreshButton:focus {
            background-color: rgb(210, 210, 210) !important;
            border: none;
        }

        .RefreshButton:hover {
            background-color: rgb(160, 160, 160);
        }
    </style>


    <style>
        #Head {
            background-color: white;
            height: 130px;
            border-bottom: 3px solid #f50414;
        }

        #Head img {
            height: 100px;
            width: 100px;
            object-fit: contain;
        }

        #Head h1 {
            color: #f50414;
            font-weight: 700;
        }

        #Head .Address {
            font-size: 13px;
        }

        #Head .gstin {
            margin-top: 90px;
        }

        #Invoice_details {
            border-bottom: 3px solid #f50414;
        }

        #Invoice_details p {
            font-weight: 500;
            font-size: 0.8rem;
        }

        #Table_main {
            border-bottom: 3px solid #f50414;
        }

        .table {
            border-collapse: collapse;
        }

        .table thead th {
            padding: 10px 0px;
            border-bottom: 1px solid black;
        }

        .table tbody td {
            padding: 10px 0px;
        }
    </style>


    <style>
        .tw-toggle {
            /* background: #95A5A6; */
            margin-top: 3px;
            display: inline-block;
            padding: 2px 3px;
            border-radius: 20px;
            position: relative;
            border: 2px solid #95A5A6;
            height: 35px;
            /* width: 100px; */
        }

        .tw-toggle label {
            text-align: center;
            font-family: sans-serif;
            display: inline-block;
            color: #95A5A6;
            position: relative;
            z-index: 3;
            margin: 0;
            text-align: center;
            padding: 0px 0px;
            /* font-size: 12px; */
            cursor: pointer;
            /* background-color: white; */
            width: 30px;
            height: 21px;
        }

        .tw-toggle label i {
            vertical-align: middle;
            font-size: 18px;
            font-weight: 100;
            /* margin-top: 10px !important; */
        }

        .tw-toggle input {
            display: none;
            position: absolute;
            z-index: 1;
            opacity: 1;
            cursor: pointer;
        }

        .tw-toggle span {
            height: 27px;
            width: 30px;
            line-height: 25px;
            border-radius: 50%;
            background: #fff;
            display: block;
            position: absolute;
            left: 22px;
            top: 2px;
            transition: all 0.3s ease-in-out;
        }

        .tw-toggle input[value="Inshop"]:checked~span {
            background: #e74c3c;
            left: 3px;
            color: #fff;
        }

        .tw-toggle input[value="Online"]:checked~span {
            background: #27ae60;
            left: 71px;
        }

        .tw-toggle input[value="All"]:checked~span {
            background: #95A5A6;
            left: 37px;
        }

        .tw-toggle input[value="Inshop"]:checked+label,
        .tw-toggle input[value="Online"]:checked+label {
            color: #fff;
        }

        .tw-toggle input[value="All"]:checked+label {
            color: #fff;
        }
    </style>

</head>

<body>


   
    <!-- Assign Technician Modal -->
    <div class="modal fade" id="AssignTechModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="">Assign Technician</h3>
                </div>
                <div class="modal-body">
                    <form id="AssignTechnicianForm" class="Form">
                        <input id="assign_tech_orderid" name="AssignTechOrderId" type="number" hidden>
                        <select class="form-select" name="AssignTech" id="assign_tech_id">
                            <option value="0">Select Technician</option>
                            <?php

                            $FindTechnicians =  mysqli_query($con, "SELECT user_id,first_name,last_name FROM user_details WHERE type = 'technician'");
                            foreach ($FindTechnicians as $FindTechniciansResults) {
                                echo '<option data-agentname="Hii" value="' . $FindTechniciansResults["user_id"] . '">' . $FindTechniciansResults["first_name"] . ' ' . $FindTechniciansResults["last_name"] . '</option>';
                            }

                            ?>
                        </select>
                        <div class="d-flex justify-content-around mt-3">
                            <button type="submit" class="btn btn-success rounded-pill">Save</button>
                            <button data-bs-dismiss="modal" type="button" class="btn btn-secondary rounded-pill">Close</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>


    <!-- Assign Pickup Agent Modal -->
    <div class="modal fade" id="AssignPickupModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="">Assign Pickup Agent</h3>
                </div>
                <div class="modal-body">
                    <form id="AssignPickupForm" class="Form">
                        <input id="assign_pickup_orderid" name="AssignPickupOrderId" type="number" hidden>
                        <select class="form-select" name="AssignPickup" id="assign_pickup_id">
                            <option value="0">Select Pickup</option>
                            <?php

                            $FindPickupAgent =  mysqli_query($con, "SELECT user_id,first_name,last_name FROM user_details WHERE type = 'delivery'");
                            foreach ($FindPickupAgent as $FindPickupAgentResults) {
                                echo '<option value="' . $FindPickupAgentResults["user_id"] . '">' . $FindPickupAgentResults["first_name"] . ' ' . $FindTechniciansResults["last_name"] . '</option>';
                            }

                            ?>
                        </select>
                        <div class="d-flex justify-content-around mt-3">
                            <button type="submit" class="btn btn-success rounded-pill">Save</button>
                            <button data-bs-dismiss="modal" type="button" class="btn btn-secondary rounded-pill">Close</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>



    <!-- View Service Modal -->
    <div class="modal fade" id="ViewServiceModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="exampleModalLabel">Service Order Details</h3>
                </div>
                <div class="modal-body" id="ViewOrderInvoice">

                </div>
            </div>
        </div>
    </div>


    <!-- Handover Modal -->
    <div class="modal fade" id="HandoverModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="exampleModalLabel">Handover Device</h3>
                </div>
                <div class="modal-body">
                    <form id="HandoverDeviceForm" class="Form">
                        <input id="handover_order_id" name="HandoverOrderId" type="number" hidden>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="service_customer">Customer</label>
                                <input id="service_customer" name="ServiceCustomer" class="form-control" type="text" value="" disabled>
                            </div>
                            <div class="col-6">
                                <label for="service_amount">Service Amount</label>
                                <input id="service_amount" name="ServiceAmount" class="form-control" type="number" min="0" value="">
                                <input id="actual_amount" name="ActualAmount" class="form-control" type="number" min="0" value="" hidden>
                                <input id="paid_amount" name="PaidAmount" class="form-control" type="number" min="0" value="" hidden>
                            </div>

                            <div class="col-6">
                                <label for="service_mop">Mode Of Pay</label>
                                <select class="form-select" name="ServiceMOP" id="service_mop" required>
                                    <option selected value="0">CASH</option>
                                    <option value="1">CHEQUE</option>
                                    <option value="2">BANK</option>
                                    <option value="3">UPI</option>
                                    <option value="4">RTGS</option>
                                </select>
                            </div>
                        </div>


                        <div class="d-flex justify-content-around mt-3">
                            <button type="submit" class="btn btn-success rounded-pill">Confirm</button>
                            <button data-bs-dismiss="modal" type="button" class="btn btn-secondary rounded-pill">Close</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>


    <div class="wrapper">
        <!--NAVBAR-->
        <nav class="navbar shadow-sm fixed-top">
            <div class="container-fluid">
                <button class="btn shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="material-icons">menu</i></button>
                <a class="navbar-text">
                    <h5>Service Orders</h5>
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
        <div id="Content" class="mb-5 sales_report">

            <div class="container-fluid">


                <div class="toolbar">
                    <div class="card card-body shadow-sm py-2">
                        <div class="row">
                            <div class="col-lg-3 col-md-5 col-12 ">
                                <input type="text" class="form-control Searchbox" id="searchbox" placeholder="Search by Customer/Id/Technician">
                            </div>
                            <div class="col-lg-2 col-md-3 col-5 mt-2 mt-md-0">
                                <select class="form-select FilterBox" id="filter_status">
                                    <option selected value="">All</option>
                                    <option value="0">Pending</option>
                                    <option value="3">For Service</option>
                                    <option value="4">Diagnosis</option>
                                    <option value="5">In Service</option>
                                    <option value="6">Testing</option>
                                    <option value="8">Completed</option>
                                    <option value="10">Delivered</option>
                                    <option value="11">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-lg-5 col-md-1 col-2 mt-2 mt-md-0">

                            </div>
                            <div class="col-lg-2 col-md-3 col-5 text-end">
                                <div class="tw-toggle">
                                    <input id="inshop_switch" class="FilterOrderSwitch" type="radio" name="toggle" value="Inshop">
                                    <label for="inshop_switch" class="toggle toggle-yes"><i class="ri-store-2-line"></i> </label>
                                    <input id="all_switch" class="FilterOrderSwitch" checked type="radio" name="toggle" value="All">
                                    <label for="all_switch" class="toggle toggle-yes"><i class="ri-stack-line"></i></label>
                                    <input id="online_switch" class="FilterOrderSwitch" type="radio" name="toggle" value="Online">
                                    <label for="online_switch" class="toggle toggle-yes"><i class="ri-shopping-cart-2-line"></i></label>
                                    <span></span>
                                </div>
                            </div>

                            <!-- <div class="col-lg-1 col-md-2 col-2 mt-2 mt-md-0 text-end">
                                <button class="RefreshButton btn"> <i class="ri-loop-right-line"></i> </button>
                            </div> -->
                        </div>


                    </div>
                </div>



                <div class="card card-body text-nowrap TableCard px-3 mt-3">
                    <div class="row mb-2 justify-content-between">
                        <div class="col-lg-1 col-3">
                            <select class="form-control py-0" id="pagelength">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="-1">All</option>
                            </select>
                        </div>
                        <div class="col-lg-1 col-2 text-end">
                            <button class="RefreshButton btn m-0 py-0 px-1"> <i class="ri-loop-right-line"></i> </button>
                        </div>
                    </div>

                    <table class="table table-hover table-borderless" style="width:100%;" id="MasterTable">
                        <thead>
                            <tr>
                                <th><i class="ri-add-circle-line ExpandButton"></i></th>
                                <!-- <th>Sl No.</th> -->
                                <th>Order Id</th>
                                <th>Customer</th>
                                <th>Estimated Amt</th>
                                <th>Paid Amt</th>
                                <!-- <th>Device</th>
                                    <th>Pickup Time</th>
                                    <th>Pickup Mode</th> -->
                                <th>M.O.P</th>
                                <th>Payment</th>
                                <!-- <th>Pickup Agent</th>
                                    <th>Shop Deliver Time</th>  -->
                                <th>Technician</th>
                                <th>Service Status</th>
                                <th>Date</th>
                                <th>Action</th>
                                <!-- <th>Service Start</th>
                                    <th>Service Finish</th> -->

                                <!--<th>Delivery Agent</th>
                                    <th>Delivered Date</th>
                                    <th>Tracker</th> -->
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>



                <!-- <div class="btn-group">
                    <button type="button" class="btn btn-outline-danger">View</button>
                    <button type="button" class="btn btn-outline-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><button class="dropdown-item" href="#">Assign</button></li>
                        <li><button class="dropdown-item" href="#">Handover</button></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><button class="dropdown-item" href="#">Edit</button></li>
                        <li><button class="dropdown-item" href="#">Delete</button></li>
                    </ul>
                </div> -->





            </div>

        </div>

        <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>

        <script>

            // Change the data url 
            $('.FilterOrderSwitch').change(function() {
                MasterTable.ajax.url(FindUrl()).load();
            });


            // Function to find the url
            function FindUrl() {
                SelectedValue = $('.FilterOrderSwitch:checked').val();

                if (SelectedValue == 'Inshop') {
                    FetchUrl = 'ServiceDatas.php?InshopServiceOrders';
                } else if (SelectedValue == 'Online') {
                    FetchUrl = 'ServiceDatas.php?OnlineServiceOrders';
                } else {
                    FetchUrl = 'ServiceDatas.php?AllServiceOrders';
                }
                return FetchUrl;
                //MasterTable.ajax.reload();
            }


            // Create an instance of Notyf
            const notyf = new Notyf({
                duration: 1000,
                position: {
                    x: 'center',
                    y: 'bottom',
                },
                types: [{
                        type: 'warning',
                        background: 'orange',
                        icon: {
                            className: 'material-icons',
                            tagName: 'i',
                            text: 'warning'
                        }
                    },
                    {
                        type: 'info',
                        background: '#5bc0de',
                        // icon: {
                        //     className: 'ri-arrow-up-circle-fill',
                        //     tagName: 'i',
                        //     text: ''
                        // }
                        //duration: 2000,
                        //dismissible: true
                    }
                ]
            });




            //Master Table
            var MasterTable = $('#MasterTable').DataTable({
                "processing": true,
                "ajax": FindUrl(),
                // "scrollY": "500px",
                // "scrollX": true,
                //"serverSide": true,
                //"serverMethod": 'post',
                //"responsive": true,
                // "fixedHeader": true,
                "dom": 'rt<"bottom"ip>',
                //"select":true,
                // "fixedColumns": {
                //     left: 2,
                //     right: 2
                // },
                "order": [
                    [1, 'asc']
                ],
                "pageLength": 10,
                "pagingType": 'simple_numbers',
                "language": {
                    "paginate": {
                        "previous": "<i class='bi bi-caret-left-fill'></i>",
                        "next": "<i class='bi bi-caret-right-fill'></i>"
                    }
                },
                "initComplete": function() {
                    //console.log("helloo");
                    $("#MasterTable").wrap("<div style='overflow:auto; width:100%;height:65vh;position:relative;'></div>");
                },
                "columns": [{
                        className: 'details-control',
                        orderable: false,
                        data: null,
                        defaultContent: '<i class="ri-add-circle-line ExpandButton me-2"></i>'
                    },
                    // {
                    //     data: null,
                    //     render: function(data, type, row, meta) {
                    //         return meta.row + meta.settings._iDisplayStart + 1;
                    //     }
                    // },

                    {
                        data: 'serviceBillNo',
                    },
                    {
                        data: 'custName',
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            if (data.totalAmount != 0) {
                                data = '&#8377; ' + parseFloat(data.totalAmount).toLocaleString('en-IN');
                            } else {
                                data = '&#8377; 0';
                            }
                            return data;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            if (data.paidAmount != 0) {
                                data = '&#8377; ' + parseFloat(data.paidAmount).toLocaleString('en-IN');
                            } else {
                                data = '&#8377; 0';
                            }
                            return data;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            if (data.modeOfPay == 0) {
                                data = 'CASH'
                            } else if (data.modeOfPay == 1) {
                                data = 'CHEQUE'
                            } else if (data.modeOfPay == 2) {
                                data = 'BANK'
                            } else if (data.modeOfPay == 3) {
                                data = 'UPI'
                            } else if (data.modeOfPay == 4) {
                                data = 'RTGS'
                            }
                            return data;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            if (data.paymentStatus == 'Paid') {
                                data = '<span class="badge rounded-pill text-bg-success px-3 py-1">&nbsp;&nbsp;&nbsp;Paid&nbsp;&nbsp;&nbsp;</span>'
                            } else if (data.paymentStatus == 'Unpaid') {
                                data = '<span class="badge rounded-pill text-bg-light px-3 py-1">Un Paid</span>'
                            } else {
                                data = '';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'techAgentName',
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            if (data.stat == 0) {
                                data = '<span class="badge rounded-pill text-bg-secondary px-3 py-1">&nbsp;&nbsp;PENDING&nbsp;&nbsp;&nbsp;</span>'
                            } else if (data.stat == 1) {
                                data = '<span class="badge rounded-pill text-bg-warning px-3 py-1">FOR PICKUP</span>'
                            } else if (data.stat == 2) {
                                data = '<span class="badge rounded-pill text-bg-warning px-3 py-1">IN SHOP</span>'
                            } else if (data.stat == 3) {
                                data = '<span class="badge rounded-pill text-bg-warning px-3 py-1">FOR SERVICE</span>'
                            } else if (data.stat == 4) {
                                data = '<span class="badge rounded-pill text-bg-info text-white px-3 py-1">&nbsp;DIAGNOSIS&nbsp;</span>'
                            } else if (data.stat == 5) {
                                data = '<span class="badge rounded-pill text-bg-info text-white px-3 py-1">&nbsp;IN SERVICE&nbsp;</span>'
                            } else if (data.stat == 6) {
                                data = '<span class="badge rounded-pill text-bg-info text-white px-3 py-1">&nbsp;&nbsp;&nbsp;TESTING&nbsp;&nbsp;&nbsp;</span>'
                            } else if (data.stat == 8) {
                                data = '<span class="badge rounded-pill text-bg-info px-3 py-1">COMPLETED</span>'
                            } else if (data.stat == 9) {
                                data = '<span class="badge rounded-pill text-bg-info px-3 py-1">FOR DELIVERY</span>'
                            } else if (data.stat == 11) {
                                data = '<span class="badge rounded-pill text-bg-danger px-3 py-1">&nbsp;&nbsp;&nbsp;CANCELLED&nbsp;&nbsp;&nbsp;</span>'
                            } else {
                                data = '<span class="badge rounded-pill text-bg-secondary">No Status</span>'
                            }
                            return data;
                        }
                    },
                    {
                        data: 'createdDate',
                        render: function(data, type, row, meta) {
                            if (type === 'sort') {
                                return data;
                            }
                            return moment(data).format("MMM D , YYYY");
                        }
                    },
                    // {
                    //     data: 'serviceBillId',
                    //     render: function(data, type, row, meta) {
                    //         if (type == 'display') {
                    //             data = '<button class="delete_btn  btn shadow-none" type="button" value="' + data + '"> <i class="material-icons">delete</i> </button>';
                    //         }
                    //         return data;
                    //     }
                    // },
                    {
                        data: null,
                        render: function(data, type, row, meta) {

                            if (data.techId > 0) {
                                TechHeading = 'ReAssign Technician';
                            } else {
                                TechHeading = 'Assign Technician';
                            }

                            if (data.deliveryAgentId > 0) {
                                DeliveryHeading = 'ReAssign Delivery Agent';
                            } else {
                                DeliveryHeading = 'Assign Delivery Agent';
                            }

                            if (data.pickupAgentid > 0) {
                                PickupHeading = 'ReAssign Pickup Agent';
                            } else {
                                PickupHeading = 'Assign Pickup Agent';
                            }

                            if (data.billType == 'SR') {
                                if (data.stat < 3) {
                                    data = '<div class="btn-group"><button type="button" class="btn btn-outline-info ViewService" value="' + data.serviceBillId + '">View</button><button type="button" class="btn btn-outline-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"><span class="visually-hidden">Toggle Dropdown</span></button><ul class="dropdown-menu"> <li><button value="' + data.serviceBillId + '" class="dropdown-item AssignTech">Assign</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item CustomerHandOver" disabled>Handover</button></li> <li> <hr class="dropdown-divider"> </li> <li><a role="button" href="AdminServiceCartUpdate.php?SOID=' + data.serviceBillId + '" class="dropdown-item EditButton">Edit</a></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item CancelButton">Cancel</button></li></ul></div>';
                                } else if (data.stat >= 8) {
                                    data = '<div class="btn-group"><button type="button" class="btn btn-outline-info ViewService" value="' + data.serviceBillId + '">View</button><button type="button" class="btn btn-outline-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"><span class="visually-hidden">Toggle Dropdown</span></button><ul class="dropdown-menu"> <li><button value="' + data.serviceBillId + '" class="dropdown-item AssignTech" disabled>Assign</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item CustomerHandOver">Handover</button></li> <li> <hr class="dropdown-divider"> </li> <li><a role="button" href="AdminServiceCartUpdate.php?SOID=' + data.serviceBillId + '" class="dropdown-item EditButton">Edit</a></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item CancelButton">Cancel</button></li> </ul></div>';
                                } else if (data.stat >= 10) {
                                    data = '<div class="btn-group"><button type="button" class="btn btn-outline-info ViewService" value="' + data.serviceBillId + '">View</button><button type="button" class="btn btn-outline-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"><span class="visually-hidden">Toggle Dropdown</span></button><ul class="dropdown-menu"> <li><button value="' + data.serviceBillId + '" class="dropdown-item AssignTech" disabled>Assign</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item CustomerHandOver">Handover</button></li> <li> <hr class="dropdown-divider"> </li> <li><a role="button" href="AdminServiceCartUpdate.php?SOID=' + data.serviceBillId + '" class="dropdown-item EditButton" disabled>Edit</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item CancelButton">Cancel</button></li></ul></div>';
                                } else if (data.stat >= 3) {
                                    data = '<div class="btn-group"><button type="button" class="btn btn-outline-info ViewService" value="' + data.serviceBillId + '">View</button><button type="button" class="btn btn-outline-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"><span class="visually-hidden">Toggle Dropdown</span></button><ul class="dropdown-menu"> <li><button value="' + data.serviceBillId + '" class="dropdown-item AssignTech">Re Assign</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item CustomerHandOver" disabled>Handover</button></li> <li> <hr class="dropdown-divider"> </li> <li><a role="button" href="AdminServiceCartUpdate.php?SOID=' + data.serviceBillId + '" class="dropdown-item EditButton">Edit</a></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item CancelButton">Cancel</button></li></ul></div>';
                                }
                            } else {



                                if (data.stat < 2) {
                                    data = '<div class="btn-group"><button type="button" class="btn btn-outline-info ViewService" value="' + data.serviceBillId + '">View</button><button type="button" class="btn btn-outline-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"><span class="visually-hidden">Toggle Dropdown</span></button><ul class="dropdown-menu"> <li><button value="' + data.serviceBillId + '" class="dropdown-item AssignPickup">' + PickupHeading + '</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item AssignTech" disabled>' + TechHeading + '</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item AssignDelivery" disabled>' + DeliveryHeading + '</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item CustomerHandOver" disabled>Handover</button></li> <li> <hr class="dropdown-divider"> </li> <li><a role="button" href="AdminServiceCartUpdate.php?SOID=' + data.serviceBillId + '" class="dropdown-item EditButton">Edit</a></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item CancelButton">Cancel</button></li></ul></div>';
                                } else if (data.stat >= 2 && data.stat < 8) {
                                    data = '<div class="btn-group"><button type="button" class="btn btn-outline-info ViewService" value="' + data.serviceBillId + '">View</button><button type="button" class="btn btn-outline-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"><span class="visually-hidden">Toggle Dropdown</span></button><ul class="dropdown-menu"> <li><button value="' + data.serviceBillId + '" class="dropdown-item" disabled>' + PickupHeading + '</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item AssignTech">' + TechHeading + '</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item " disabled>' + DeliveryHeading + '</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item " disabled>Handover</button></li> <li> <hr class="dropdown-divider"> </li> <li><a role="button" href="AdminServiceCartUpdate.php?SOID=' + data.serviceBillId + '" class="dropdown-item EditButton">Edit</a></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item CancelButton">Cancel</button></li></ul></div>';
                                } else if (data.stat == 8) {
                                    data = '<div class="btn-group"><button type="button" class="btn btn-outline-info ViewService" value="' + data.serviceBillId + '">View</button><button type="button" class="btn btn-outline-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"><span class="visually-hidden">Toggle Dropdown</span></button><ul class="dropdown-menu"> <li><button value="' + data.serviceBillId + '" class="dropdown-item" disabled>' + PickupHeading + '</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item" disabled>' + TechHeading + '</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item " >' + DeliveryHeading + '</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item " >Handover</button></li> <li> <hr class="dropdown-divider"> </li> <li><a role="button" href="AdminServiceCartUpdate.php?SOID=' + data.serviceBillId + '" class="dropdown-item EditButton">Edit</a></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item CancelButton">Cancel</button></li></ul></div>';
                                } else if (data.stat >= 9) {
                                    data = '<div class="btn-group"><button type="button" class="btn btn-outline-info ViewService" value="' + data.serviceBillId + '">View</button><button type="button" class="btn btn-outline-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"><span class="visually-hidden">Toggle Dropdown</span></button><ul class="dropdown-menu"> <li><button value="' + data.serviceBillId + '" class="dropdown-item" disabled>' + PickupHeading + '</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item" disabled>' + TechHeading + '</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item " >' + DeliveryHeading + '</button></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item " disabled>Handover</button></li> <li> <hr class="dropdown-divider"> </li> <li><a role="button" href="AdminServiceCartUpdate.php?SOID=' + data.serviceBillId + '" class="dropdown-item EditButton">Edit</a></li> <li><button value="' + data.serviceBillId + '" class="dropdown-item CancelButton">Cancel</button></li></ul></div>';
                                }

                            }

                            return data;
                        }
                    },
                    {
                        data: 'stat',
                        visible: false,
                    },
                ]
            });




            // Search Function
            $('#searchbox').keyup(function() {
                MasterTable.search($(this).val()).draw();
            })


            // Change Pagelength Function
            $('#pagelength').on('change', function() {
                MasterTable.page.len($(this).val()).draw();
            });

            // Filter Service Status
            $('#filter_status').on('change', function() {
                regex = '\\b' + $(this).val() + '\\b';
                MasterTable.column(12).search(regex, true, false).draw();
                //MasterTable.column(14).search($(this).val(), true, false).draw();
            });

            // Refresh Table
            $('.RefreshButton').click(function() {
                MasterTable.ajax.reload(null, false);
            });

            // Child Row
            $('#MasterTable tbody').on('click', 'td.details-control', function() {
                var tr = $(this).closest('tr');
                var row = MasterTable.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });


            // Child Row View Function
            function format(rowData) {
                var div = $('<div/>')
                    .addClass('loading')
                    // .addClass('text-center')
                    //.text('Loading...')
                    .prepend('<img class="TableLoadingImage img-fluid" src="../assets/img/tableLoading.gif"/>');

                $.ajax({
                    url: 'AdminServiceOperations.php',
                    data: {
                        FetchServiceDetailedList: rowData.serviceBillId
                    },
                    type: "POST",
                    dataType: 'json',
                    success: function(Data) {
                        console.log(Data.Content);
                        div.html(Data.Content).removeClass('loading');
                    }
                });

                return div;
            }


            // Assign Technician 
            $(document).on('click', '.AssignTech', function() {
                const ServiceOrderId = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "AdminServiceOperations.php",
                    data: {
                        CheckServiceStatus: 'FetchServiceStatus',
                        CheckStatusBillId: ServiceOrderId
                    },
                    success: function(data) {
                        console.log(data);
                        var Response = JSON.parse(data);
                        if (Response.Status == true) {
                            if (parseInt(Response.ServiceStatus) >= 4) {
                                swal("Warning", "Service Has Started Already. Cannot Assign or Re Assign Technician Now", "warning");
                                //console.log("Service Has Started Already. Cannot Assign or Re Assign Technician Now");
                            } else if (parseInt(Response.ServiceStatus) <= 3) {
                                //console.log(Response.Technician);
                                $('#assign_tech_orderid').val(ServiceOrderId);
                                $('#AssignTechModal').modal('show');
                                if (parseInt(Response.ServiceStatus) === 3) {
                                    $("#assign_tech_id option[value='" + Response.Technician + "']").prop("disabled", true);
                                } else {
                                    $("#assign_tech_id option").prop("disabled", false);
                                }
                                $('#AssignTechnicianForm').submit(function(e) {
                                    e.preventDefault();
                                    const AssignAgentId = $('#assign_tech_id').val();
                                    const ServiceOrderId = $('#assign_tech_orderid').val();
                                    var AgentName = $('#assign_tech_id :selected').text();
                                    //console.log(AgentName); 
                                    if (AssignAgentId != 0 && ServiceOrderId != 0) {
                                        //console.log("AgentName"); 
                                        $.ajax({
                                            type: "POST",
                                            url: "AdminServiceOperations.php",
                                            data: {
                                                AssignAgentId: AssignAgentId,
                                                ServiceOrderId: ServiceOrderId,
                                                AssignAgentName: AgentName,
                                                AgentType:'TECH'
                                            },
                                            success: function(data) {
                                                //console.log(data);
                                                var Response = JSON.parse(data);
                                                if (Response.Status == true) {
                                                    swal("Success", Response.Message, "success");
                                                    $('#AssignTechnicianForm')[0].reset();
                                                    $('#AssignTechModal').modal('hide');
                                                    MasterTable.ajax.reload(null, false);
                                                } else if (Response.Status == false) {
                                                    swal("Warning", Response.Message, "warning");
                                                }
                                            }
                                        });
                                    } else {}
                                    $('#AssignTechnicianForm')[0].reset();
                                });
                            }
                        } else if (Response.Status == false) {
                            notyf.error(Response.Message);
                        }
                    }
                });


                //console.log(ServiceOrderId);
                // $('#assign_tech_orderid').val(ServiceOrderId);
                // $('#AssignTechModal').modal('show');
                // $('#AssignTechnicianForm').submit(function(e) {
                //     e.preventDefault();
                //     const AssignAgentId = $('#assign_tech_id').val();
                //     const ServiceOrderId = $('#assign_tech_orderid').val();
                //     var AgentName = $('#assign_tech_id :selected').text();
                //     //console.log(AgentName); 
                //     if (AssignAgentId != 0 && ServiceOrderId != 0) {
                //         //console.log("AgentName"); 
                //         $.ajax({
                //             type: "POST",
                //             url: "AdminServiceOperations.php",
                //             data: {
                //                 AssignAgentId: AssignAgentId,
                //                 ServiceOrderId: ServiceOrderId,
                //                 AssignAgentName: AgentName
                //             },
                //             success: function(data) {
                //                 //console.log(data);
                //                 var Response = JSON.parse(data);
                //                 if (Response.Status == true) {
                //                     swal("Success", Response.Message, "success");
                //                     $('#AssignTechnicianForm')[0].reset();
                //                     $('#AssignTechModal').modal('hide');
                //                     MasterTable.ajax.reload(null, false);
                //                 } else if (Response.Status == false) {
                //                     swal("Warning", Response.Message, "warning");
                //                 }
                //             }
                //         });
                //     } else {
                //     }
                //     $('#AssignTechnicianForm')[0].reset();
                // });

            });


            // Assign Pickup 
            $(document).on('click', '.AssignPickup', function() {
                const ServiceOrderId = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "AdminServiceOperations.php",
                    data: {
                        CheckServiceStatus: 'FetchServiceStatus',
                        CheckStatusBillId: ServiceOrderId
                    },
                    success: function(data) {
                        console.log(data);
                        var Response = JSON.parse(data);
                        if (Response.Status == true) {
                            if (parseInt(Response.ServiceStatus) >= 2) {
                                swal("Warning", "Service Device Has Arrived In Shop. Cannot Assign or Re Assign Pickup Agent Now", "warning");
                                //console.log("Service Has Started Already. Cannot Assign or Re Assign Technician Now");
                            } else if (parseInt(Response.ServiceStatus) <= 1) {
                                console.log(Response.Pickup);
                                $('#assign_pickup_orderid').val(ServiceOrderId);
                                $('#AssignPickupModal').modal('show');
                                if (parseInt(Response.ServiceStatus) === 1) {
                                    $("#assign_pickup_id option[value='" + Response.Pickup + "']").prop("disabled", true);
                                } else {
                                    $("#assign_tech_id option").prop("disabled", false);
                                }
                                $('#AssignPickupForm').submit(function(e) {
                                    e.preventDefault();
                                    const AssignPickupAgentId = $('#assign_pickup_id').val();
                                    const ServiceOrderId = $('#assign_pickup_orderid').val();
                                    var AgentName = $('#assign_pickup_id :selected').text();
                                    //console.log(AgentName); 
                                    if (AssignPickupAgentId != 0 && ServiceOrderId != 0) {
                                        //console.log("AgentName"); 
                                        $.ajax({
                                            type: "POST",
                                            url: "AdminServiceOperations.php",
                                            data: {
                                                AssignAgentId: AssignPickupAgentId,
                                                ServiceOrderId: ServiceOrderId,
                                                AssignAgentName: AgentName,
                                                AgentType:'PICKUP'
                                            },
                                            success: function(data) {
                                                //console.log(data);
                                                var Response = JSON.parse(data);
                                                if (Response.Status == true) {
                                                    swal("Success", Response.Message, "success");
                                                    $('#AssignPickupForm')[0].reset();
                                                    $('#AssignPickupModal').modal('hide');
                                                    MasterTable.ajax.reload(null, false);
                                                } else if (Response.Status == false) {
                                                    swal("Warning", Response.Message, "warning");
                                                }
                                            }
                                        });
                                    } else {}
                                    $('#AssignPickupForm')[0].reset();
                                });
                            }
                        } else if (Response.Status == false) {
                            notyf.error(Response.Message);
                        }
                    }
                });

            });





            // View Order Details
            $(document).on('click', '.ViewService', function() {

                let ViewServiceOrderId = $(this).val();
                //console.log(ViewServiceOrderId);
                // $('#AssignTechModal').modal('show');
                $.ajax({
                    type: "POST",
                    url: "AdminServiceOperations.php",
                    data: {
                        ViewServiceOrderId: ViewServiceOrderId
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#ViewOrderInvoice').html(data);
                        $('#ViewServiceModal').modal('show');
                        var Response = JSON.parse(data);
                        if (Response.Status == true) {

                        } else if (Response.Status == false) {
                            swal("Warning", Response.Message, "warning");
                        }
                    }
                });

            });



            // Fetch Order Details on Handover
            $(document).on('click', '.CustomerHandOver', function() {

                let MaxAmount = 0;

                const FetchServiceDetailsId = $(this).val();
                console.log(FetchServiceDetailsId);

                $.ajax({
                    type: "POST",
                    url: "AdminServiceOperations.php",
                    data: {
                        FetchServiceDetailsId: FetchServiceDetailsId,
                    },
                    success: function(data) {
                        console.log(data);
                        var Response = JSON.parse(data);
                        if (Response.Status == true) {
                            $('#handover_order_id').val(FetchServiceDetailsId);
                            $('#service_customer').val(Response.CustomerName);
                            $('#service_amount').val(Response.PendingAmount);
                            $('#actual_amount').val(Response.OrderAmount);
                            $('#paid_amount').val(Response.PaidAmount);
                            $('#HandoverModal').modal('show');
                            MaxAmount = parseInt(Response.PendingAmount);
                        } else if (Response.Status == false) {
                            swal("Warning", Response.Message, "warning");
                        }

                        //console.log(MaxAmount);
                    }
                });


            });



            // Cancel Service Order
            $(document).on('click', '.CancelButton', function() {
                let CancelServiceOrderId = $(this).val();
                swal("Before cancelling, make sure you have returned the device to the customer.", {
                        icon: "warning",
                        title: "Do you want to cancel this service?",
                        buttons: {
                            cancel: "cancel",
                            Confirm: true,
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Confirm":
                                $.ajax({
                                    url: "AdminServiceOperations.php",
                                    type: "POST",
                                    data: {
                                        CancelServiceOrderId: CancelServiceOrderId
                                    },
                                    beforeSend: function() {
                                        //$('#SalesScreen').addClass('disable');
                                    },
                                    success: function(data) {
                                        console.log(data);
                                        //$('#SalesScreen').removeClass('disable');
                                        var Response = JSON.parse(data);
                                        if (Response.Status == true) {
                                            swal("Success", Response.Message, "success");
                                            MasterTable.ajax.reload(null, false);
                                        } else if (Response.Status == false) {
                                            swal("Error", Response.Message, "error");
                                        } else {
                                            swal("Potential Error", "Some Error Occured ! Please Refresh The Page To Continue", "error");
                                            //console.log([response.status, response.statusText]);
                                        }
                                    }
                                });
                                break;
                            default:
                                notyf.open({
                                    type: 'info',
                                    message: 'Operation Cancelled!'
                                });
                        }
                    });
            });


            // Refresh Table
            $('.RefreshButton').click(function() {
                MasterTable.ajax.reload(null, false);
            });

            //////////////////////////////    Service Handover Form    /////////////////////

            const HandoverValidator = new window.JustValidate('#HandoverDeviceForm', {
                validateBeforeSubmitting: true,
            });

                HandoverValidator
                .addField('#service_mop', [{
                    rule: 'required',
                }, ]).addField('#service_amount', [{
                        rule: 'required',
                    },
                    {
                        rule: 'number',
                    },
                    {
                        rule: 'minNumber',
                        value: 1,
                        errorMessage: 'Amount cannot be zero',
                    },
                    {
                        rule: 'maxNumber',
                        value: 1000000,
                        errorMessage: 'Amount cannot be greater than 1000000',
                    },
                    // {
                    //     errorMessage: 'Amount cannot be zero or greater than 6 digits',
                    // },
                ]).onSuccess((event) => {

                    let HandoverServiceOrderId = $('#handover_order_id').val();
                    let ServiceActualAmount = ($('#actual_amount').val() == '') ? 0 : $('#actual_amount').val();
                    let ServicePaidAmount = ($('#paid_amount').val() == '') ? 0 : $('#paid_amount').val();
                    let ServiceCollectedAmount = ($('#service_amount').val() == '') ? 0 : $('#service_amount').val();
                    let ServiceModeOfPay = $('#service_mop').val();

                    $.ajax({
                        url: "AdminServiceOperations.php",
                        type: "POST",
                        data: {
                            HandoverServiceOrderId: HandoverServiceOrderId,
                            ServiceActualAmount: ServiceActualAmount,
                            ServiceCollectedAmount: ServiceCollectedAmount,
                            ServiceModeOfPay: ServiceModeOfPay,
                            ServicePaidAmount: ServicePaidAmount
                        },
                        beforeSend: function() {
                            //$('#SalesScreen').addClass('disable');
                        },
                        success: function(data) {
                            console.log(data);
                            //$('#SalesScreen').removeClass('disable');
                            var Response = JSON.parse(data);
                            if (Response.Status == true) {
                                $('#HandoverDeviceForm')[0].reset();
                                $('#HandoverModal').modal('hide');
                                MasterTable.ajax.reload(null, false);
                                swal("Do you want to take a print?", {
                                        icon: "success",
                                        title: "Service Completed And Delivered Successfully",
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
                                                    'ServicePrint.php?SOID=' + Response.ServiceOrderId,
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
                                //console.log([response.status, response.statusText]);
                            }
                        }
                    });
                });


            //////////////////////////////    Service Handover Form    /////////////////////
        </script>



        <?php
        include "../MAIN/Footer.php";
        ?>

</body>

</html>