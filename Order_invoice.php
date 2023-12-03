<!doctype html>
<html lang="en">
<?php require 'Dbconn.php';?>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Invoice</title>


    <style>
        body {
            width: 21cm;
            height: 29.7cm;
            box-sizing: border-box;
        }
        
        #Head {
            background-color: white;
            height: 100px;
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
            padding: 20px 20px;
        }
        
        .table tbody td {
            padding: 20px 20px;
        }
    </style>
</head>

<body>


    <div class="container-fluid">

        <div id="Head" class="d-flex justify-content-between px-3">
            <div class="my-auto">
                <img src="/IMAGES/logo-png.png" alt="">
            </div>
            <div class="my-auto">
                <h1>INVOICE</h1>
            </div>
        </div>

        <?php
        
        if(isset($_GET['order_id'])){

            $ordId = $_GET['order_id'];

            $invoice_query = mysqli_query($con, "SELECT * FROM order_details WHERE order_id = '$ordId'");
            while($row = mysqli_fetch_array($invoice_query)){
                $dt = $row['purchase_date'];
                $newDate = date("d-M-Y H:i A", strtotime($dt)); 
            ?>


                <div id="Invoice_details" class="d-flex justify-content-between px-3">

                    <div class="d-block py-3 my-auto">
                        <h5>Invoice to:</h5>
                        <p class="mb-1">
                            <?php echo $row['first_name'].'&nbsp;'.$row['last_name'] ;?> , <br> <?php echo $row['phone'];?> , <br> <?php echo $row['location'];?> , <br><?php echo $row['city'];?> <?php echo $row['pincode'];?>
                        </p>
                    </div>

                    <div class="d-block text-end py-3 my-auto">
                        <h5>Invoice No: </h5>
                        <h6 style="font-size: 0.9rem;"># <?php echo $row['order_id'];?></h6>
                        <h5>Date: </h5>
                        <h6 style="font-size: 0.9rem;"><?php echo $newDate;?></h6>
                    </div>

                </div>



                <div id="Table_main">
                    <table class="table table-striped table-borderless">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Item Name</th>
                                <th class="text-end">Quantity</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                                $item_query = mysqli_query($con, "SELECT * FROM order_items WHERE order_id = '$ordId'");
                                while($items = mysqli_fetch_array($item_query)){
                                    $prID = $items['pr_id'];
                                    $name_query =  mysqli_query($con, "SELECT * FROM products WHERE pr_id = $prID");
                                    while($item_name = mysqli_fetch_array($name_query)){
                                ?>
                                    <tr>
                                        <td>1</td>
                                        <td><?php echo $item_name['brand'].'&nbsp;'. $item_name['name'];?></td>
                                        <td class="text-end"><?php echo $items['quantity'];?></td>
                                        <td class="text-end"><?php echo number_format($items['price'])  ; ?></td>
                                    </tr>
                                <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                        

                <div class="d-flex justify-content-between px-3">

                    <div class="d-block pt-3">

                        <div>
                            <h6 class="text-muted"><i>Thank You for your business</i></h6>
                        </div>
                        <div class="pt-2">
                            <h6>Payment Details:</h6>
                            <h6 style="font-size: 0.8rem;"><?php echo $row['payment_mode'];?></h6>
                        </div>


                        <div class="pt-3">
                            <h6>Terms and Conditions</h6>
                            <p style="font-size: 0.8rem; max-width: 300px;">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            </p>
                        </div>


                    </div>

                    <div class="d-block pt-3">
                        <table>
                            <thead>
                                <tr>
                                    <th>Subtotal : </th>
                                    <th class="text-end"><?php echo number_format($row['total']);?></th>
                                </tr>
                                <tr style=" border-bottom: 2px solid #f50414;">
                                    <th>Tax : </th>
                                    <th class="text-end">0</th>
                                </tr>
                                <tr>
                                    <th style="font-size: 1.3rem;">Total : </th>
                                    <th style="font-size: 1.3rem;" class="text-end"><?php echo number_format($row['total']);?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>



            <?php
            }

        }
        
        
        ?>



        

        




        


    </div>



















    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>