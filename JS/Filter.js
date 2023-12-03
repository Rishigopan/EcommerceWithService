//function to filter data

function filter_data(query) {
    var status = get_filter('status');
    var action = 'fetch_data';

    $.ajax({
        method: "POST",
        url: "OrderHandling.php",
        data: { query: query, action: action, status: status },
        success: function(data) {
            $('#results').html(data);
        }
    });
}

//function to get checkbox values

function get_filter(class_name) {
    var filter = [];
    $("." + class_name + ":checked").each(function() {
        filter.push($(this).val())
    });
    return filter;
}

$('.comm_select').click(function() {
    filter_data();
});