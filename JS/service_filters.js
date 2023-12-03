function service_bookings(query) {
    var services = 'fetch_data';
    var mode = get_filter('delmode');

    $.ajax({
        method: "POST",
        url: "ServiceBookingsData.php",
        data: { query: query, services: services, mode: mode },
        success: function(data) {
            $('#door_delivery').html(data);
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
    service_bookings();
});