//Display service delivery
function service_delivery(query) {
    var all_service = 'fetch_data';
    var type = get_filter('deltype');
    $.ajax({
        method: "POST",
        url: "service_delivery_data.php",
        data: { query: query, all_service: all_service, type: type },
        success: function(data) {
            $('#service').html(data);
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
    service_delivery();
});