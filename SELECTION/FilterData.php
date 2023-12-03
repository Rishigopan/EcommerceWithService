<?php


    require "../MAIN/Dbconn.php"; 
    if(isset($_POST["action"])){

        $sql_query = "SELECT * FROM products p INNER JOIN brands b ON p.brand = b.br_id INNER JOIN types t ON p.type = t.ty_id WHERE p.parent_item_id = p.pr_id AND b.isSales = 'YES' AND p.p_created != ''";

        if(isset($_POST["brand"]))
        {
        $brand_filter = implode("','", $_POST["brand"]);
        $sql_query .= "AND brand IN('".$brand_filter."')";
        }

        if(isset($_POST["searchdata"]))
        {
            $search = $_POST["searchdata"];
            $sql_query .= "AND name LIKE '%".$search."%' OR b.brand_name LIKE '%".$search."%' OR type_name LIKE '%".$search."%'";
        }

        if(isset($_POST['type'])){
            $type_filter = implode("','", $_POST["type"]);
            $sql_query .= "AND type IN ('".$type_filter."')";
        }

        if(isset($_POST['ndesc'])){
            $sql_query .= "ORDER BY brand_name DESC ";
        }
        if(isset($_POST['nasc'])){
            $sql_query .= "ORDER BY brand_name ASC ";
        }
        if(isset($_POST['L2H'])){
            $sql_query .= "ORDER BY price ASC ";
        }
        if(isset($_POST['H2L'])){
            $sql_query .= "ORDER BY price DESC ";
        }


        $result = mysqli_query($con, $sql_query);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach($row as $item)
            {
?>
            <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3 my-2 ">    
                <div class="card card-body shadow-sm ">
                    <a href="ProductDetail.php?product_id=<?php echo $item['pr_id'];?>">
                        <div class="d-sm-block d-flex">
                                <div class="d-flex justify-content-sm-center">
                                    <img src="../assets/img/PRODUCTS/<?php echo $item['img']; ?>" class=" " alt="">
                                </div>
                            <div class="mt-sm-2 ms-3 ms-sm-0">
                                <h6 class=""><span class="d-block"> <?php echo $item['brand_name'] ?></span> <span class=" text-muted" ><?php echo $item['name'] ?></span></h6>
                                <div class="text-center mt-2 mt-sm-0 d-flex justify-content-between">
                                <p class=" mt-4 mt-sm-0 my-sm-0">&#8377; <?php echo number_format($item['price']);?>   </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
<?php
    }
    }
    else{
        echo '<h3 class="text-center">No such Products Found!</h3>';
    }
    }
?>






