//Categories List
function get_type_select() {
    var selectType = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "ProductExtras.php",
        data: { selectType: selectType },
        success: function(data) {
            //console.log(data);
            $('#SelectType').html(data);
        }
    });
}


//brand select on type
function get_brand_select() {
    var selectBrand = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "ProductExtras.php",
        data: { selectBrand: selectBrand },
        success: function(data) {
            //console.log(data);
            $('#SelectBrand').html(data);
        }
    });
}


//Product Type List
function get_product_type_select() {
    var selectProductType = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "ProductExtras.php",
        data: { selectProductType: selectProductType },
        success: function(data) {
            //console.log(data);
            $('#SelectProductType').html(data);
        }
    });
}



//Show Items in DropDown Single Master Table
function ShowItemsInDropdown(SelectorClass, Url, OptionValue, OptionName, DefaultName, ColumnName, ShowConsole, MakeDefaultValue = 0) {
    var ShowDataInDropDown = 'fetch_data';
    $.ajax({
        method: "POST",
        url: Url + ".php",
        data: {
            ShowDataInDropDown: ShowDataInDropDown,
            OptionValue: OptionValue,
            OptionName: OptionName,
            DefaultName: DefaultName,
            ColumnName: ColumnName
        },
        success: function(data) {
            $('.' + SelectorClass).html(data);
            if(MakeDefaultValue != 0){
                $('.' + SelectorClass).val(MakeDefaultValue).change();
            }
            if (ShowConsole == 'YES') {
                console.log(data);
            }
        }
    });
}




//Depended DropDown Single Tier
function DependedDropDownSingle(SelectorClass,Url, DefaultName, OptionValue, OptionName, ColumnName, ShowConsole, WhereColumn, WhereColumnValue, MakeDefaultValue = 0) {
    var DependedDropDownSingle = 'fetch_data';
    $.ajax({
        method: "POST",
        url: Url + ".php",
        data: {
            DependedDropDownSingle: DependedDropDownSingle,
            OptionValue: OptionValue,
            OptionName: OptionName,
            DefaultName: DefaultName,
            ColumnName: ColumnName,
            WhereColumn: WhereColumn,
            WhereColumnValue: WhereColumnValue
        },
        success: function(data) {
            $('.' + SelectorClass).html(data);
            if (MakeDefaultValue != 0) {
                $('.' + SelectorClass).val(MakeDefaultValue).change();
            }
            if (ShowConsole == 'YES') {
                console.log(data);
            }
        }
    });
}


