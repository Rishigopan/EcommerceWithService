//Display tech services
function tech_services(query) {
    var device_list = 'fetch_data';
    var mode = get_filter('delmode');
    var progress = get_filter('techprogress');
    $.ajax({
        method: "POST",
        url: "tech_services_data.php",
        data: { query: query, device_list: device_list, mode: mode, progress: progress },
        success: function(data) {
            $('#all_devices').html(data);
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
    tech_services();
});