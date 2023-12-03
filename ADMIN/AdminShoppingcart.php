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
$PageTitle = 'Sale';
?>

<!doctype html>
<html lang="en">

<head>

    <?php

    require "../MAIN/Header.php";

    ?>

    <!-- SELECTIZE  CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/css/selectize.bootstrap5.css" integrity="sha512-QomP/COM7vFCHcVHpDh/dW9oDyg44VWNzgrg9cG8T2cYSXPtqkQK54WRpbqttfo0MYlwlLUz3EUR+78/aSbEIw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/js/selectize.min.js" integrity="sha512-VReIIr1tJEzBye8Elk8Dw/B2dAUZFRfxnV2wbpJ0qOvk57xupH+bZRVHVngdV04WVrjaMeR1HfYlMLCiFENoKw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <style>
        .disable {
            opacity: 0.5;
            pointer-events: none;

        }

        .selectize-dropdown-content {
            max-height: 60vh !important;
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
                    <h4 class="text-center">Successfully Saved Sale Entry</h4>
                    <div class="d-flex justify-content-around mt-3">
                        <a id="SalesPrintButton" href="SalesPrint.php?OID=" target="_blank" class="btn btn_cart rounded-pill px-5">Print</a>
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
                    <h5>Shopping Cart</h5>
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

                <!-- <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="ms-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./AdminEcommerce.php">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                    </ol>
                </nav> -->





                <div class="row mb-3">

                    <div class="col-lg-8 col-12 order-lg-1 order-2">

                        <div class="row">

                            <div class="col-6">
                                <select class="SelectPlugin mb-3" id="product_add">
                                    <option hidden value="">Choose Product</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <input class="form-control" type="number" name="BarcodeSearch" value="" placeholder="Choose Barcode" id="barcode_search">
                            </div>
                            <div class="col-3 text-end">
                                <input class="form-control" type="number" name="ImeiSearch" value="" placeholder="Choose IMEI" id="imei_search">
                            </div>


                            <!-- <div class="col-6">
                                <div class="row">
                                    <div class="col-8"> -->
                            <!-- <select  class="SelectPlugin" id="product_add">
                                            <option value="">Choose Product</option>
                                            <?php
                                            $FindItems = mysqli_query($con, "SELECT pr_id,name,barcode FROM products");
                                            foreach ($FindItems as $FindItemsResult) {
                                                echo '<option value="' . $FindItemsResult["pr_id"] . '">' . $FindItemsResult["name"] . ' - ' . $FindItemsResult["barcode"] . '</option>';
                                            }
                                            ?>
                                        </select> -->
                            <!-- <input class="form-control" type="number" name="BarcodeSearch" value="" id="barcode_search"> -->
                            <!-- </div> -->
                            <!-- <div class="col-4 text-start">
                                        <label class="form-label"> <strong class="fs-5">Enter Barcode</strong> </label>
                                    </div> -->

                            <!-- </div>
                            </div> -->
                            <!-- <div class="col-6">
                                <div class="row">
                                    <div class="col-6 text-end">
                                        <input class="form-control" type="number" name="ImeiSearch" value="" placeholder="IMEI" id="imei_search">
                                    </div>
                                    <div class="col-6">
                                        <input class="form-control" type="number" name="BarcodeSearch" value="" placeholder="Barcode" id="barcode_search">
                                    </div>
                                </div>
                            </div> -->

                        </div>

                        <div class="card mt-2 shadow-sm">

                            <div class="card-header">
                                <h5 class="mb-0">Shopping Cart</h5>
                            </div>
                            <!-- <h4 class="border-bottom pb-2">Shopping Cart</h4> -->

                            <div class="card-body">
                                <div id="">

                                    <ul class="list-unstyled" id="ShowCartItems">
                                        <h5 class=" me-2 text-end">Subtotal : <span> &#8377; </span></h5>
                                    </ul>

                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-4 order-lg-2 order-1 mb-3">

                        <div class="card shadow-sm">

                            <div class="card-header">
                                <h5 class="mb-0">Payable Amount</h5>
                            </div>

                            <div class="card-body">
                                <div class="px-5 pb-3">
                                    <!-- <div class="mb-2">
                                    <h4 class="text-center text-decoration-underline"> Payable Amount</h4>
                                </div> -->
                                    <div class="row">
                                        <div class="col-6 fs-5"> <strong>Subtotal</strong> </div>
                                        <div class="col-1 fs-5"> <strong>:</strong> </div>
                                        <div class="col-5 fs-5 text-end"> <strong> &#8377;</strong> <strong id="ShowSubTotal"> </strong> </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6 fs-5"> <strong>SGST</strong> </div>
                                        <div class="col-1 fs-5"> <strong>:</strong> </div>
                                        <div class="col-5 fs-5 text-end"> <strong> &#8377; </strong> <strong id="ShowSGST"> </strong> </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6 fs-5"> <strong>CGST</strong> </div>
                                        <div class="col-1 fs-5"> <strong>:</strong> </div>
                                        <div class="col-5 fs-5 text-end"> <strong> &#8377; </strong> <strong id="ShowCGST"> </strong> </div>
                                    </div>
                                    <!-- <div class="row">
                                    <div class="col-6 fs-5"> <strong>Discount</strong> </div>
                                    <div class="col-1 fs-5"> <strong>:</strong> </div>
                                    <div class="col-5 fs-5 text-end"> <strong> - &#8377; </strong> <strong id="ShowDiscount"> </strong> </div>
                                </div> -->
                                    <hr>
                                    <div class="row">
                                        <div class="col-6 fs-4"> <strong>Total</strong> </div>
                                        <div class="col-1 fs-4"> <strong>:</strong> </div>
                                        <div class="col-5 fs-4 text-end text-danger"> <strong> &#8377; </strong> <strong id="ShowTotal"> </strong> </div>
                                    </div>
                                </div>
                            </div>



                            <!-- <div class="text-center mt-3">
                                <?php
                                $fetch_cart_empty = mysqli_query($con, "SELECT * FROM  $cart_table ");
                                if (mysqli_num_rows($fetch_cart_empty) == 0) {
                                    echo '<a href="" class="btn rounded-pill btn_cart" type="button" style="opacity:0.5;pointer-events:none">Proceed to Buy</a>';
                                } else {
                                    echo '<a href="AdminCheckout.php" class="btn rounded-pill btn_cart" type="button" >Proceed to Buy</a>';
                                }
                                ?>

                            </div> -->
                        </div>

                        <div class="card card-body shadow-sm mt-3">

                            <div class="row px-5">
                                <div class="col-6 fs-5"> <strong>Your Discount</strong> </div>
                                <div class="col-1 fs-5"> <strong>:</strong> </div>
                                <div class="col-5 fs-5 text-end"> <strong> &#8377; </strong> <strong id="ShowDiscount"> </strong> </div>
                            </div>

                        </div>

                        <div class="card shadow-sm mt-3">
                            <div class="card-header">
                                <h5 class="mb-0">Billing Address</h5>
                            </div>

                            <div class="card-body">
                                <!-- <h4 class="text-center text-decoration-underline">Billing Address</h4> -->

                                <form id="SalesForm">

                                    <div class="col-12">
                                        <label for="first_name" class="form-label">Customer Name</label>
                                        <input type="text" id="cust_name" name="CustomerName" class="form-control" placeholder="Enter Customer Name" required>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <label for="mobile" class="form-label">Phone Number</label>
                                        <input type="text" id="cust_mobile" name="CustomerMobile" class="form-control" placeholder="Enter Phone Number" required>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <label for="mobile" class="form-label">Mode Of Pay</label>
                                        <select class="form-select" name="CustomerMOP" id="customer_mop" required>
                                            <option selected value="0">CASH</option>
                                            <option value="1">CHEQUE</option>
                                            <option value="2">BANK</option>
                                            <option value="3">UPI</option>
                                            <option value="4">RTGS</option>
                                        </select>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <label for="address" class="form-label">Your Address</label>
                                        <textarea col="3" row="3" id="address" name="CustomerAddress" class="form-control" placeholder="Enter Address"></textarea>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button class="btn rounded-pill btn_cart" type="submit">Proceed to Buy</button>
                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>



                <!-- <div>

                    <h4>Related Products</h4>

                    <div id="Related_container" class="d-flex">

                        <div class="">
                            <button id="left-button" class="btn btn-danger shadow-none rounded-circle "> <i class="material-icons">arrow_back_ios</i> </button>
                        </div>

                        <div id="Related">

                            <?php
                            $related_results = mysqli_query($con, "SELECT pr_id FROM products");
                            while ($newrow = mysqli_fetch_assoc($related_results)) {
                                foreach ($newrow as $val) {
                                    $new_var = mysqli_query($con, "SELECT * FROM products p INNER JOIN brands b ON p.brand = b.br_id WHERE pr_id = $val");
                                    while ($tp_row = mysqli_fetch_array($new_var)) {
                            ?>
                                        <a href="AdminProductdetail.php?product_id=<?php echo $tp_row['pr_id']; ?>">
                                            <div class="card card-body shadow-sm">
                                                <img src="../assets/img/PRODUCTS/<?php echo $tp_row['img']; ?>" class="mx-auto" alt="">
                                                <div class=" mt-auto">
                                                    <div class="d-block">
                                                        <h6 class="text-muted"> <span class="d-block"><?php echo $tp_row['brand_name']; ?></span> <span class="d-inline-block text-truncate" style="max-width: 120px;"><?php echo $tp_row['name']; ?></span></h6>
                                                        <p>&#8377; <?php echo number_format($tp_row['price']); ?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                            <?php
                                    }
                                }
                            }
                            ?>

                        </div>

                        <div class="">
                            <button id="right-button" class="btn btn-danger shadow-none rounded-circle "> <i class="material-icons">arrow_forward_ios</i> </button>
                        </div>

                    </div>

                </div> -->

            </div>


        </div>


        <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>



        <script>





        </script>


        <script>
            ShowShoppingItems('ADD');
            ShowTotal('ADD');
            DeleteAll('ADD');



            //Add Products by name barcode or imei
            var SelectProducts = $('#product_add').selectize({
                maxItems: 1,
                valueField: 'pr_id',
                labelField: 'ProductName',
                searchField: ['ProductName', 'barcode', 'imei'],
                create: false,
                load: (query, callback) => {
                    if (query.length < 3) {
                        return callback();
                    }
                    $.ajax({
                        url: 'AdminSalesOperations.php',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            SearchProducts: query
                        },
                        error: () => callback(),
                        success: (res) => callback(res),
                    });
                },

                render: {
                    option: (item, escape) => {
                        if (item.current_stock <= 0) {
                            return '<div class="card-body border-2 border-bottom py-0 px-3 disable"><h6>' + escape(item.ProductName) + '</h6><div class="row"><div class="col-6">IMEI : ' + escape(item.imei) + '</div><div class="col-6 text-end">Barcode : ' + escape(item.barcode) + '</div></div><h6 class="mt-2">Quantity : ' + escape(item.current_stock) + '</h6></div>';
                        }
                        //return '<div class="card w-100"><div class="card-body"><h6 class="card-title">'+ escape(item.name) +'</h6></div></div>';
                        return '<div class="card-body border-2 border-bottom py-0 px-3"><h6>' + escape(item.ProductName) + '</h6><div class="row"><div class="col-6">IMEI : ' + escape(item.imei) + '</div><div class="col-6 text-end">Barcode : ' + escape(item.barcode) + '</div></div><h6 class="mt-2">Quantity : ' + escape(item.current_stock) + '</h6></div>';
                    }
                }
            });

            var SelectProductsControl = SelectProducts[0].selectize;

            //Disable enter key on disable field
            // const ProductOptions = document.querySelector('.disable');
            // ProductOptions.addEventListener('keydown',function(event){
            // if(event.keyCode == 13) {
            //     event.preventDefault();
            //     return false;
            //     }
            // });


            //Show cart 
            function ShowShoppingItems(Action) {
                var ShowItems = 'FetchShopItems';
                $.ajax({
                    url: "SalesExtras.php",
                    type: "POST",
                    data: {
                        ShowItems: ShowItems,
                        ShowItemsAction: Action
                    },
                    success: function(data) {
                        $('#ShowCartItems').html(data);
                    }
                });
            }

            //Show all total
            function ShowTotal(Action) {
                var ShowTotal = 'FetchShopTotal';
                $.ajax({
                    url: "AdminSalesOperations.php",
                    type: "POST",
                    data: {
                        ShowTotal: ShowTotal,
                        ShowTotalAction: Action
                    },
                    success: function(data) {
                        //console.log(data);
                        var TotalResult = JSON.parse(data);
                        if (TotalResult.FindTotalStatus == 1) {
                            // $('#ShowSubTotal').text((TotalResult.TotalGross).toLocaleString('en-IN'));
                            $('#ShowSubTotal').text((TotalResult.TotalGross).toLocaleString('en-IN'));
                            $('#ShowSGST').text((TotalResult.TotalSgst).toLocaleString('en-IN'));
                            $('#ShowCGST').text((TotalResult.TotalCgst).toLocaleString('en-IN'));
                            $('#ShowDiscount').text((TotalResult.TotalIndDiscount).toLocaleString('en-IN'));
                            $('#ShowTotal').text((TotalResult.TotalNet).toLocaleString('en-IN'));
                            // $('#ShowTotal').text((TotalResult.TotalNetNoRound).toLocaleString('en-IN'));

                        } else {}
                    }
                });
            }

            //Delete all Items
            function DeleteAll(Action) {
                var DeleteAll = 'DelAll';
                $.ajax({
                    url: "AdminSalesOperations.php",
                    type: "POST",
                    data: {
                        DeleteAll: DeleteAll,
                        DeleteAllAction: Action
                    },
                    success: function(data) {
                        //console.log(data);
                        var DeleteAllResult = JSON.parse(data);
                        if (DeleteAllResult.DelAll == 1) {
                            ShowShoppingItems('ADD');
                            ShowTotal('ADD');
                        } else {

                        }
                    }
                });
            }


            //Add Item By Barcode
            $(document).on('change', '#barcode_search', function() {
                var FindItem = $(this).val();
                //console.log(FindItem);
                $.ajax({
                    url: "AdminSalesOperations.php",
                    type: "POST",
                    data: {
                        FindItem: FindItem,
                        AddItemBarcodeAction: 'ADD'
                    },
                    success: function(data) {
                        console.log(data);
                        var ItemAddResult = JSON.parse(data);
                        if (ItemAddResult.AddItem == 1) {
                            ShowShoppingItems('ADD');
                            ShowTotal('ADD');
                            $('#barcode_search').val('');
                        } else if (ItemAddResult.AddItem == 0) {
                            toastr.error('No item exists for this barcode');
                            $('#barcode_search').val('');
                        } else {}
                    }
                });
            });



            //Add Item By IMEI
            $(document).on('change', '#imei_search', function() {
                var FindItemIMEI = $(this).val();
                $.ajax({
                    url: "AdminSalesOperations.php",
                    type: "POST",
                    data: {
                        FindItemIMEI: FindItemIMEI,
                        AddItemIMEIAction:'ADD'
                    },
                    success: function(data) {
                        console.log(data);
                        $('#imei_search').val('');
                        var ItemAddIMEIResult = JSON.parse(data);
                        if (ItemAddIMEIResult.AddItemIMEI == 1) {
                            ShowShoppingItems('ADD');
                            ShowTotal('ADD');
                        } else if (ItemAddIMEIResult.AddItemIMEI == 0) {
                            toastr.error('No item exists for this imei');
                            $('#imei_search').val('');
                        } else if (ItemAddIMEIResult.AddItemIMEI == 3) {
                            toastr.warning('There is no stock remaining for this product');
                        }else if (ItemAddIMEIResult.AddItemIMEI == 4) {
                            toastr.warning('Item is already in cart');
                        }else {}
                    }
                });
            });



            //Add Item By ProductId
            $(document).on('change', '#product_add', function() {
                var FindProductById = $(this).val();
                //console.log(FindProductById);
                if (FindProductById != '') {
                    $.ajax({
                        url: "AdminSalesOperations.php",
                        type: "POST",
                        data: {
                            FindProductById: FindProductById,
                            AddItemAction: 'ADD'
                        },
                        success: function(data) {
                            SelectProductsControl.clear();
                            SelectProductsControl.clearOptions();
                            console.log(data);
                            var ItemAddResult = JSON.parse(data);
                            if (ItemAddResult.AddItemById == 1) {
                                ShowShoppingItems('ADD');
                                ShowTotal('ADD');
                                //$('#product_add').change().val('');
                            } else if (ItemAddResult.AddItemById == 0) {
                                //toastr.error('Cannot Add This Item');
                            } else if (ItemAddResult.AddItemById == 3) {
                                toastr.warning('There is no stock remaining for this product');
                            }
                        }
                    });
                } else {
                    return false;
                }
            });


            //Change Qty of Item 
            $(document).on('change', '.qtyselect', function() {
                var cartchange_id = $(this).attr('id');
                //console.log(cartchange_id);
                var change_qty = $(this).val();
                var CurrentQty = parseInt($(this).data('currentqty'));
                //console.log(change_qty);
                var MaxStock = parseInt($(this).data('maxstock'));
                //console.log(MaxStock);
                if (change_qty > MaxStock) {
                    $(this).val(CurrentQty);
                    toastr.warning('Quantity exceeds the remaining stock');
                    return false;
                }

                $.ajax({
                    url: "AdminSalesOperations.php",
                    type: "POST",
                    data: {
                        cartchange_id: cartchange_id,
                        change_qty: change_qty,
                        ChangeQtyAction: 'ADD'
                    },
                    success: function(data) {
                        console.log(data);
                        var QtyChangeResult = JSON.parse(data);
                        if (QtyChangeResult.CartQty == 1) {
                            ShowShoppingItems('ADD');
                            ShowTotal('ADD');
                        } else if (QtyChangeResult.CartQty == 0) {
                            toastr.error('Change Qty Failed');
                        } else {}
                    }
                });

            });


            //Change Discount of item
            $(document).on('change', '.ChangeDiscount', function() {
                var DiscountChangeId = $(this).attr('id');
                //console.log(cartchange_id);
                var DiscountChangeValue = $(this).val();
                console.log(DiscountChangeValue);
                $.ajax({
                    url: "AdminSalesOperations.php",
                    type: "POST",
                    data: {
                        DiscountChangeId: DiscountChangeId,
                        DiscountChangeValue: DiscountChangeValue,
                        DiscountAction: 'ADD',
                    },
                    success: function(data) {
                        console.log(data);
                        var DiscountChangeResult = JSON.parse(data);
                        if (DiscountChangeResult.DiscountChange == 1) {
                            ShowShoppingItems('ADD');
                            ShowTotal('ADD');
                        } else if (DiscountChangeResult.DiscountChange == 0) {
                            toastr.error('Change Discount Failed');
                        } else {}
                    }
                });
            });


            //Delete Item from cart
            $(document).on('click', '.btn_delete', function() {
                var DeleteCartId = $(this).val();
                //console.log(DeleteCartId);
                $.ajax({
                    url: "AdminSalesOperations.php",
                    type: "POST",
                    data: {
                        DeleteCartId: DeleteCartId,
                        DeleteCartAction: 'ADD'
                    },
                    success: function(data) {
                        //console.log(data);
                        var DeleteCartIdResult = JSON.parse(data);
                        if (DeleteCartIdResult.DeleteCart == 1) {
                            ShowShoppingItems('ADD');
                            ShowTotal('ADD');
                        } else if (DeleteCartIdResult.DeleteCart == 0) {
                            toastr.error('Delete Failed');
                        } else {}
                    }
                });
            });


            //Add Sales Form
            $(function() {

                let validator = $('#SalesForm').jbvalidator({
                    successClass: false,
                    html5BrowserDefault: true
                });


                validator.validator.custom = function(el, event) {
                    if ($(el).is('#first_name,#cust_mobile') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#SalesForm', function(e) {
                    e.preventDefault();
                    var SalesData = new FormData(this);
                    SalesData.append('SalesAction', 'ADD');
                    console.log(SalesData);
                    $.ajax({
                        url: "AdminSalesOperations.php",
                        type: "POST",
                        data: SalesData,
                        beforeSend: function() {
                            $('#SalesScreen').addClass('disable');
                        },
                        success: function(data) {
                            console.log(data);
                            $('#SalesScreen').removeClass('disable');
                            var SaleResult = JSON.parse(data);
                            if (SaleResult.SalesSuccess == "0") {
                                toastr.warning('Cart is Empty');
                            } else if (SaleResult.SalesSuccess == "1") {
                                $('#SalesForm')[0].reset();
                                DeleteAll();
                                ShowTotal('ADD');
                                $('#confirmModal').modal('show');
                                $('#SalesPrintButton').attr('href', 'SalesPrint.php?OID=' + (SaleResult.SalesPrintId));
                            } else if (SaleResult.SalesSuccess == "2") {
                                toastr.error('Some Error Occured, Please Refresh The Page To Continue');
                            } else {

                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                    return false;
                });

            });
        </script>


        <?php
        include "../MAIN/Footer.php";
        ?>

</body>

</html>