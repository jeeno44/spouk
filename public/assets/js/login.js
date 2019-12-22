(function ($) {
    $('input.input-mask').inputmask();
    $('#register-form').submit(function (e) {

        if ($('input[name=new_college]').val() == 1) {
            var checked = $(".sub-systems:checked").length;
            if(!checked) {
                $('#edu-systems').addClass('has-error').find('.help-block').text('Выберите минимум 1 значение');
                e.preventDefault();
            } else {
                $('#edu-systems').removeClass('has-error').find('.help-block').text('');
            }
        }
    })
}(jQuery));