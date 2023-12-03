<?php



    if(isset($_POST['ProductId']) && !empty($_POST['ProductId']) && !empty($_POST['ProductName'])){

        $ProductName = $_POST['ProductName'];
        $ProductBarcode = $_POST['ProductBarcode'];
        $ProductMrp = $_POST['ProductMrp'];
        $ProductSP = $_POST['ProductSP'];
        $PrintQty = $_POST['PrintQty'];
        $ProductColor = $_POST['ProductColor'];
        $ProductMini = $_POST['ProductMini'];
        $ProductBrand = $_POST['ProductBrand'];

        $BarcodeWithTrail  = str_pad($ProductBarcode, 13, '0', STR_PAD_LEFT); //Add prefix zeros to barcode and make it 13 digits

        $BarcodeFirst = substr($BarcodeWithTrail, 0, 3);

        $BarcodeLast = substr($BarcodeWithTrail, 3, 10);

        $DivideValue = ($PrintQty / 2);

        $DivideArry = explode(".", $DivideValue);
        
        $DivideResult = array_values($DivideArry)[0];

        $ModValue = fmod($PrintQty, 2);


        if($DivideResult > 0){

            $Print = '';
            $Print1 =htmlspecialchars('<xpml><page quantity="0" pitch="25.0 mm"></xpml>SIZE 80.5 mm, 25 mm');

            $Print2 = 'DIRECTION 0,0</br>
            REFERENCE 0,0</br>
            OFFSET 0 mm</br>
            SET PEEL OFF</br>
            SET CUTTER OFF</br>
            SET PARTIAL_CUTTER OFF</br>';

            $Print3 =  htmlspecialchars(' <xpml></page></xpml><xpml><page quantity="1" pitch="25.0 mm"></xpml>SET TEAR ON');
            $Print4 = 'CLS</br>
            CODEPAGE 1252</br>
            TEXT 599,187,"0",180,8,8,"TECHSTOP"</br>
            TEXT 621,155,"0",180,8,8,"'.$ProductBrand.'"</br>
            TEXT 621,129,"0",180,8,8,"'.$ProductName.'"</br>
            TEXT 371,40,"0",90,7,7,"'.$ProductColor.'"</br>
            BARCODE 621,102,"128M",35,0,180,1,2,"!104'.$BarcodeFirst.'!099'.$BarcodeLast.'"</br>
            TEXT 621,62,"0",180,7,7,"'.$ProductBarcode.'"</br>
            TEXT 621,33,"0",180,8,8,"MRP:'.$ProductMrp.'"</br>
            TEXT 468,33,"0",180,8,8,"SP:'.$ProductSP.'"</br>
            TEXT 271,187,"0",180,8,8,"TECHSTOP"</br>
            TEXT 293,155,"0",180,8,8,"'.$ProductBrand.'"</br>
            TEXT 293,129,"0",180,8,8,"'.$ProductName.'"</br>
            TEXT 43,40,"0",90,7,7,"'.$ProductColor.'"</br>
            BARCODE 293,102,"128M",35,0,180,1,2,"!104'.$BarcodeFirst.'!099'.$BarcodeLast.'"</br>
            TEXT 293,62,"0",180,7,7,"'.$ProductBarcode.'"</br>
            TEXT 293,33,"0",180,8,8,"MRP:'.$ProductMrp.'"</br>
            TEXT 140,33,"0",180,8,8,"SP:'.$ProductSP.'"</br>
            PRINT 1,'.$DivideResult.'</br>';
            
            $Print5 = htmlspecialchars('<xpml></page></xpml><xpml><end/></xpml>');
            
            $Print .= $Print1.'<br>'.$Print2.$Print3.'<br>'.$Print4.$Print5;

            echo $Print;

        }


        if($ModValue > 0){

            $Print = '';
            $Print1 =htmlspecialchars('<xpml><page quantity="0" pitch="25.0 mm"></xpml>SIZE 80.5 mm, 25 mm');

            $Print2 = 'DIRECTION 0,0</br>
            REFERENCE 0,0</br>
            OFFSET 0 mm</br>
            SET PEEL OFF</br>
            SET CUTTER OFF</br>
            SET PARTIAL_CUTTER OFF</br>';

            $Print3 =  htmlspecialchars(' <xpml></page></xpml><xpml><page quantity="1" pitch="25.0 mm"></xpml>SET TEAR ON');
            $Print4 = 'CLS</br>
            CODEPAGE 1252</br>
            TEXT 599,187,"0",180,8,8,"TECHSTOP"</br>
            TEXT 621,155,"0",180,8,8,"'.$ProductBrand.'"</br>
            TEXT 621,129,"0",180,8,8,"'.$ProductName.'"</br>
            TEXT 371,40,"0",90,7,7,"'.$ProductColor.'"</br>
            BARCODE 621,102,"128M",35,0,180,1,2,"!104'.$BarcodeFirst.'!099'.$BarcodeLast.'"</br>
            TEXT 621,62,"0",180,7,7,"'.$ProductBarcode.'</br>
            TEXT 621,33,"0",180,8,8,"MRP:'.$ProductMrp.'"</br>
            TEXT 468,33,"0",180,8,8,"SP:'.$ProductSP.'"</br>
            PRINT 1,1</br>';
            
            $Print5 = htmlspecialchars('<xpml></page></xpml><xpml><end/></xpml>');
            
            $Print .= $Print1.'<br>'.$Print2.$Print3.'<br>'.$Print4.$Print5;
            
            echo $Print;

        }




    }












?>