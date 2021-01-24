$(function () {
    $('#error-register').hide();
    $('#thank-you').hide();

    $('#form-register').submit(function (event) {
        $('#error-register').hide();

        $.post('API/users', $(this).serialize(), function (data, status) {
            if (data === true) {
                $('#form-register').hide();
                $('#thank-you').show();
            }
            else {
                $('#error-register').show();
            }
        });

        event.preventDefault();
        return false;
    });
});
