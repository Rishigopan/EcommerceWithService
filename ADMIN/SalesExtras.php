<?php

require "../MAIN/Dbconn.php"; 


$cart_table = 'salestabletemp';
$userId = $_COOKIE['custidcookie'];

if (isset($_POST['ShowItems']) && !empty($_POST['ShowItemsAction'])) {
    $ShowItemsAction = $_POST['ShowItemsAction'];

    $FetchCartItems = mysqli_query($con, "SELECT P.pr_id,P.name,P.img,P.price,P.current_stock,ShopCart.quantity,B.brand_name,ShopCart.cart_id,ShopCart.inddiscountamount,ShopCart.IGSTPercentage,ShopCart.producttotalamount,ShopCart.amount,ShopCart.itembarcode,ShopCart.itemimei,ShopCart.rate FROM $cart_table ShopCart LEFT JOIN products P ON ShopCart.pr_id = P.pr_id LEFT JOIN brands B ON P.brand = B.br_id WHERE ShopCart.userId = '$userId' AND cartAction = '$ShowItemsAction'");
    if (mysqli_num_rows($FetchCartItems) > 0) {


        foreach ($FetchCartItems as $FetchCartItemsResult) {
        ?>

            <li class="border-bottom pb-4">
                <div class="d-flex">
                    <div>
                        <a href="ProductDetail.php?product_id=<?php echo $FetchCartItemsResult['pr_id']; ?>">
                            <img class="img-fluid" src="../assets/img/PRODUCTS/<?php echo $FetchCartItemsResult['img']; ?>" alt="">
                        </a>
                    </div>
                    <div class="w-100 pe-3 ps-4">
                        <div class="d-lg-flex d-block justify-content-between mt-lg-3 mt-1 ">
                            <div>
                                <h5 class=""><?php echo $FetchCartItemsResult['brand_name'] . '&nbsp' . $FetchCartItemsResult['name'] . ' (' . number_format($FetchCartItemsResult['price'], '2','.',',') .')'; ?></h5>
                                <h5 class="">Barcode : <?php echo $FetchCartItemsResult['itembarcode']; ?></h5>
                                <h5 class=""><?php echo  ($FetchCartItemsResult['itemimei'] > 0) ? "IMEI : ".$FetchCartItemsResult['itemimei'] : "" ?></h5>
                            </div>
                            
                            <div> 
                                <h5 class="prod_price text-end"> Amount : &#8377; <?php echo number_format($FetchCartItemsResult['quantity'] * $FetchCartItemsResult['rate']); ?></h5>
                                <h5 class="prod_price text-end"> Tax : <?php echo number_format($FetchCartItemsResult['IGSTPercentage']); ?> %</h5>
                                <h5 class="prod_price text-end"> Total : <?php echo number_format($FetchCartItemsResult['amount']); ?></h5>
                            </div>

                        </div>
                        <div class="d-flex mt-2 mb-2 mt-lg-4">
                            <select id="<?php echo $FetchCartItemsResult['cart_id']; ?>" data-currentqty="<?= $FetchCartItemsResult['quantity'] ?>" data-maxstock="<?= $FetchCartItemsResult['current_stock'] ?>" class="form-select px-2 shadow-none qtyselect" style="width: 6rem;">
                                <option selected hidden value=""> Qty &nbsp;: <?php echo $FetchCartItemsResult['quantity']; ?></option>
                                <option value="1">Qty : 1</option>
                                <option value="2">Qty : 2</option>
                                <option value="3">Qty : 3</option>
                                <option value="4">Qty : 4</option>
                                <option value="5">Qty : 5</option>
                                <option value="6">Qty : 6</option>
                                <option value="7">Qty : 7</option>
                                <option value="8">Qty : 8</option>
                                <option value="9">Qty : 9</option>
                                <option value="10">Qty : 10</option>
                            </select>
                            <input type="text" id="<?php echo $FetchCartItemsResult['cart_id']; ?>" class="ms-3 form-control ChangeDiscount" value="<?php echo $FetchCartItemsResult['inddiscountamount']; ?>" style="width: 6rem;">
                            <button class="btn btn-link mt-auto ms-3 btn_delete" value="<?php echo $FetchCartItemsResult['cart_id']; ?>">Remove</button>
                        </div>
                    </div>
                </div>
            </li>
        <?php
        }
    } else {
        echo '<li class="text-center">
                    <img src="../assets/img/25648039_empty_cart.png" class="img-fluid">
                    <h4 class="mt-3">Cart is Empty</h4>
                    <p class="mt-3 text-muted">Try adding something</p>
                </li>';
    }
}

























?>