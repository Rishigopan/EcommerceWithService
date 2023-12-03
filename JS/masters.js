//brand select
function get_brand_select() {
    var selectBrand = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "MasterExtras.php",
        data: { selectBrand: selectBrand },
        success: function(data) {
            //console.log(data);
            $('.brand_update_options').html(data);
        }
    });
}



//series select
function get_series_select(brand) {
    var selectSeries = brand;
    $.ajax({
        method: "POST",
        url: "MasterExtras.php",
        data: { selectSeries: selectSeries },
        success: function(data) {
            //console.log(data);
            $('.series_update_options').html(data);
        }
    });
}



//series select on edit
function get_series_select_edit() {
    var selectSeriesEdit = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "MasterExtras.php",
        data: { selectSeriesEdit: selectSeriesEdit },
        success: function(data) {
            //console.log(data);
            $('#update_series_m').html(data);
        }
    });
}



//////////////////////////////////////////////////  SERVICE SECTION   //////////////////////////////////////////////////////////////////

//Get brands
function GetServiceSelectBrand() {
    var FindServiceBrand = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "ServiceMasterExtras.php",
        data: { FindServiceBrand: FindServiceBrand },
        success: function(data) {
            //console.log(data);
            $('.brand_service_options').html(data);
        }
    });
}


//Get Services
function GetServiceSelectService() {
    var FindService = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "ServiceMasterExtras.php",
        data: { FindService: FindService },
        success: function(data) {
            //console.log(data);
            $('.ShowService').html(data);
        }
    });
}


//Find series
function GetSeriesSelectBrand(brand_name) {
    var FindServiceSeries = brand_name;
    $.ajax({
        method: "POST",
        url: "ServiceMasterExtras.php",
        data: { FindServiceSeries: FindServiceSeries },
        success: function(data) {
            //console.log(data);
            $('.ShowSeries').html(data);

        }
    });
}


//Find model
function GetModelSelectSeries(series_name) {
    var FindServiceModel = series_name;
    $.ajax({
        method: "POST",
        url: "ServiceMasterExtras.php",
        data: { FindServiceModel: FindServiceModel },
        success: function(data) {
            //console.log(data);
            $('.ShowModel').html(data);

        }
    });
}


//Get Series for edit
function GetEditSeriesService() {
    var FindSeriesEdit = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "ServiceMasterExtras.php",
        data: { FindSeriesEdit: FindSeriesEdit },
        success: function(data) {
            //console.log(data);
            $('#edit_select_series_services').html(data);
        }
    });
}

//Get Model for edit
function GetEditModelService() {
    var FindModelEdit = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "ServiceMasterExtras.php",
        data: { FindModelEdit: FindModelEdit },
        success: function(data) {
            //console.log(data);
            $('#edit_select_model_service').html(data);
        }
    });
}