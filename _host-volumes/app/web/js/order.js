//sender FORMS
var sender = {
    'validate': function(form){
        var er = 0;
        //var form=$(this).parents('form');
        $.each(form.find('.req'), function(index, val) {
            if ($(this).attr('name') == 'email' || $(this).hasClass('email')) {
                if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test($(this).val()))) {
                    er++;
                    $(this).addClass('err');
                    if ($(this).data('error') && $(this).data('error') != '' && $(this).parent().find('.form__error').length == 0) {
                        $(this).parent().append('<div class="form__error">' + $(this).data('error') + '</div>');
                    }
                } else {
                    $(this).removeClass('err');
                    $(this).parent().find('.form__error').remove();
                }
            } else {
                if ($(this).val() == '' || $(this).val() == $(this).attr('data-value')) {
                    er++;
                    if ($(this).parents('.select-block').length > 0) {
                        $(this).parents('.select-block').addClass('err');
                    } else {
                        $(this).addClass('err');
                        $(this).parent().addClass('err');
                        if ($(this).data('error') && $(this).data('error') != '' && $(this).parent().find('.form__error').length == 0) {
                            $(this).parent().append('<div class="form__error">' + $(this).data('error') + '</div>');
                        }
                    }
                } else {
                    if ($(this).parents('.select-block').length > 0) {
                        $(this).parents('.select-block').removeClass('err');
                    } else {
                        $(this).removeClass('err');
                        $(this).parent().removeClass('err');
                        $(this).parent().find('.form__error').remove();
                    }
                }
            }

            if ($(this).attr('type') == 'checkbox') {
                if ($(this).prop('checked') == true) {
                    $(this).removeClass('err').parent().removeClass('err');
                } else {
                    er++;
                    $(this).addClass('err').parent().addClass('err');
                    $(this).parent().append('<div class="form__error">' + $(this).data('error') + '</div>');
                }
            }
        });
        if (form.find('.pass').eq(0).val() != form.find('.pass').eq(1).val()) {
            er++;
            form.find('.pass').addClass('err');
        } else {
            form.find('.pass').removeClass('err');
        }
        if (er == 0) {
            return true;
        } else {
            return false;
        }
    },
    'error': function(form, error) {
        $.each(error, function(index, val) {
            if (index == 'message' || index == 'comment' || index == 'enquiry') {
                form.find('textarea[name=' + index + ']').addClass('err');
                form.find('textarea[name=' + index + ']').after('<div class="form__error">' + val + '</div>');
                form.find('textarea[name=' + index + ']').parents('div').addClass('err');
            } else if (index == 'theme_id') {
                form.find('select[name=' + index + ']').addClass('err');
                form.find('select[name=' + index + ']').after('<div class="form__error">' + val + '</div>');
                form.find('select[name=' + index + ']').parents('div').addClass('err');
            } else {
                form.find('input[name=' + index + ']').after('<div class="form__error">' + val + '</div>');
                form.find('input[name=' + index + ']').parents('div').addClass('err');
            }
        });
    },
    'clean': function(form, message) {
        form.parent().html(message);
    }
}

$(document).on('click', function(e){
    e.stopPropagation();

    $("#popup-like").removeClass('active');
});

$(document).on('click', '.make-order-preview', function (e) {
    e.preventDefault();

    let id = $(this).data('id');
    let user_id = $(this).data('user-id');
    $.ajax({
        url: '/user/order/preview',
        data: {id: id, user_id: user_id},
        type: 'GET',
        success: function (res) {
            if (!res) alert('Ошибка!!!');
            $('#popup-like').html(res);
            $("#popup-like").addClass('active');
        },
        error: function () {
            console.log('Error');
        }
    });
});

$('#popup-like').on('click', '.make-order', function (e) {
    e.preventDefault();

    let id = $(this).data('id');
    let user_id = $(this).data('user-id');
    $.ajax({
        url: '/user/order/index',
        data: {id: id, user_id: user_id},
        type: 'GET',
        success: function (res) {
            if (!res) alert('Ошибка!!!');
            windowLoaderFunk(res);
        },
        error: function () {
            console.log('Error');
        }
    });
});

$(document).on('click', '#checkout_service', function (e) {
    e.preventDefault();
    let form = $(this).parents('form');
    if (sender.validate(form)) {
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function () {
                $(form).prepend('<span id="loading">loading......</span>');
            },
            complete: function () {
                $(form).find('#loading').remove();
            },
            success: function (json) {
                if (json['redirect']) {
                    location.href = json['redirect'];
                }
                if (json['error']) {
                    $(form).prepend('<div class="alert alert-danger">' + json['error'] + '</div>');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
});
