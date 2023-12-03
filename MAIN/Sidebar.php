 <!--SIDEBAR-->
 <div class="offcanvas  offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">


     <div class="offcanvas-body">

         <div class="profile">
             <img src="../employee.png" alt="">
             <h6>User Name</h6>
         </div>

         <ul id="menu" class="list-unstyled py-5">
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>" >
                 <a href="../ADMIN/Dashboard.php" class=" <?php echo ($PageTitle == 'Dashboard') ? 'active' : ''; ?> ">
                     <i class="material-icons">dashboard</i>
                     <span>Dashboard</span>
                 </a>
             </li>
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/Master.php" class=" <?php echo ($PageTitle == 'Master') ? 'active' : ''; ?> ">
                     <i class="material-icons">stars</i>
                     <span>Masters</span>
                 </a>
             </li>
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/ProductAdd.php" class=" <?php echo ($PageTitle == 'AddProduct') ? 'active' : ''; ?> ">
                     <i class="material-icons">smartphone</i>
                     <span>Add Product</span>
                 </a>
             </li>
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/ProductView.php" class=" <?php echo ($PageTitle == 'Product') ? 'active' : ''; ?> ">
                     <i class="material-icons">smartphone</i>
                     <span>Product</span>
                 </a>
             </li>

             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/ProductType.php" class=" <?php echo ($PageTitle == 'ProductType') ? 'active' : ''; ?> ">
                     <i class="material-icons">category</i>
                     <span>Type</span>
                 </a>
             </li>
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/ColorMaster.php" class=" <?php echo ($PageTitle == 'ColorMaster') ? 'active' : ''; ?> ">
                     <i class="material-icons">palette</i>
                     <span>Color</span>
                 </a>
             </li>
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/NearbyMaster.php" class=" <?php echo ($PageTitle == 'NearbyMaster') ? 'active' : ''; ?> ">
                     <i class="material-icons">share_location</i>
                     <span>Nearby</span>
                 </a>
             </li>
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/BarcodePrint.php" class=" <?php echo ($PageTitle == 'Barcode') ? 'active' : ''; ?> ">
                     <i class="material-icons">qr_code_2</i>
                     <span>Barcode</span>
                 </a>
             </li>
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/Service.php" class=" <?php echo ($PageTitle == 'Service') ? 'active' : ''; ?> ">
                     <i class="material-icons">construction</i>
                     <span>Service</span>
                 </a>
             </li>
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/AdminServiceCart.php" class=" <?php echo ($PageTitle == 'ServiceBilling') ? 'active' : ''; ?> ">
                     <i class="material-icons">construction</i>
                     <span>Service Billing</span>
                 </a>
             </li>
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/NewServiceOrders.php" class=" <?php echo ($PageTitle == 'ServiceOrders') ? 'active' : ''; ?> ">
                     <i class="material-icons">construction</i>
                     <span>Service Orders</span>
                 </a>
             </li>
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin'){}else{echo "d-none";}  ?> ">
                 <a href="../ADMIN/Employee.php" class=" <?php echo ($PageTitle == 'Employee') ? 'active' : ''; ?> ">
                     <i class="material-icons">badge</i>
                     <span>Employee</span>
                 </a>
             </li>

             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/ServiceBookings.php" class=" <?php echo ($PageTitle == 'ServiceBookings') ? 'active' : ''; ?> ">
                     <i class="material-icons">work</i>
                     <span>Service Bookings</span>
                 </a>
             </li>
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/ActiveServices.php" class=" <?php echo ($PageTitle == 'ActiveServices') ? 'active' : ''; ?> ">
                     <i class="material-icons">home_repair_service</i>
                     <span>Active Services</span>
                 </a>
             </li>
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/AdminShoppingcart.php" class=" <?php echo ($PageTitle == 'Sale') ? 'active' : ''; ?> ">
                     <i class="material-icons">currency_rupee</i>
                     <span>Sale</span>
                 </a>
             </li>
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/InitialStock.php" class=" <?php echo ($PageTitle == 'InitialStock') ? 'active' : ''; ?> ">
                     <i class="material-icons">add_shopping_cart</i>
                     <span>Initial Stock</span>
                 </a>
             </li>
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/CustomerOrders.php" class=" <?php echo ($PageTitle == 'SalesOrders') ? 'active' : ''; ?> ">
                     <i class="material-icons">local_shipping</i>
                     <span>Sales Orders</span>
                 </a>
             </li>
             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../ADMIN/PurchaseNew.php" class=" <?php echo ($PageTitle == 'Purchase') ? 'active' : ''; ?> ">
                     <i class="material-icons">local_shipping</i>
                     <span>Purchase</span>
                 </a>
             </li>

             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a data-bs-toggle="collapse" href="#reports" class=" <?php echo ($PageTitle == 'ServiceReport' or $PageTitle == 'SalesReport' or $PageTitle == 'PurchaseReport') ? 'active' : ''; ?> ">
                     <i class="material-icons">insights</i> Reports <span class="ms-5 dropdown-toggle"></span>
                 </a>
                 <ul class="list-unstyled mini-list collapse " id="reports">
                     <li>
                         <a href="../ADMIN/ServiceReport.php" class=" <?php echo ($PageTitle == 'ServiceReport') ? 'active' : ''; ?> ">
                             <span class="ps-5">Service Report</span>
                         </a>
                     </li>
                     <li>
                         <a href="../ADMIN/SalesReport.php" class=" <?php echo ($PageTitle == 'SalesReport') ? 'active' : ''; ?> ">
                             <span class="ps-5">Sales Report</span>
                         </a>
                     </li>
                     <!-- <li>
                         <a href="../ADMIN/InitialStockReport.php" class=" <?php echo ($PageTitle == 'PurchaseReport') ? 'active' : ''; ?> ">
                             <span class="ps-5">Purchase Report</span>
                         </a>
                     </li> -->
                 </ul>
             </li>


             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a data-bs-toggle="collapse" href="#stock" class=" <?php echo ($PageTitle == 'StockSummary' or $PageTitle == 'StockDetailed') ? 'active' : ''; ?> ">
                     <i class="material-icons">inventory_2</i> Stock <span class="ms-5 dropdown-toggle"></span>
                 </a>
                 <ul class="list-unstyled mini-list collapse " id="stock">
                     <li>
                         <a href="../ADMIN/StockSummary.php" class=" <?php echo ($PageTitle == 'StockSummary') ? 'active' : ''; ?> ">
                             <span class="ps-5">Stock Summary</span>
                         </a>
                     </li>
                     <li>
                         <a href="../ADMIN/StockDetailed.php" class=" <?php echo ($PageTitle == 'StockDetailed') ? 'active' : ''; ?> ">
                             <span class="ps-5">Stock Detailed</span>
                         </a>
                     </li>

                 </ul>
             </li>

             <li class="<?php if($_COOKIE['custtypecookie'] == 'admin' || $_COOKIE['custtypecookie'] == 'executive'){}else{echo "d-none";}  ?>">
                 <a href="../logout.php" class="">
                     <i class="material-icons">power_settings_new</i>
                     <span>Logout</span>
                 </a>
             </li>


         </ul>

     </div>



 </div>