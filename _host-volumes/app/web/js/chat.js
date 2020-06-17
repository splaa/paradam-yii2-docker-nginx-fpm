function confirmTask(elem, order_id, type, action) {
    $.ajax({
        url: action,
        type: 'post',
        data: 'order_id=' + order_id + '&type=' + type,
        dataType: 'json',
        beforeSend: function () {
            $(elem).prop('disabled');
        },
        success: function (json) {
            if (json['success']) {
                $(elem).parent().html('<b>' + json['success'] + '</b>');
            }
            if (json['error']) {
                $(elem).parent().html('<b>' + json['error'] + '</b>');
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}