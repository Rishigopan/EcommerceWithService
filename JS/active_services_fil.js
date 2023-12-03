//Display active services
function active_services(query) {
    var active_service = 'fetch_data';
    var mode = get_filter('delmode');

    $.ajax({
        method: "POST",
        url: "ActiveServicesData.php",
        data: { query: query, active_service: active_service, mode: mode },
        success: function(data) {
            $('#active_service').html(data);
        }
    });
}




function get_filter(class_name) {
    var filter = [];
    $("." + class_name + ":checked").each(function() {
        filter.push($(this).val())
    });
    return filter;
}



$('.comm_select').click(function() {
    active_services();
});