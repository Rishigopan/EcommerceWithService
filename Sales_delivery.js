//Display sales delivery
function sales_delivery(query) {
    var all = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "delivery_data.php",
        data: { query: query, all: all },
        success: function(data) {
            $('#home').html(data);
        }
    });
}



