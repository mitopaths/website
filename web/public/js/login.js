$(function () {
    $('#error-login').hide();

    $('#form-login').submit(function (event) {
        $('#error-login').hide();

        $.post('API/me', $(this).serialize(), function (data, status) {
            if (data === true) {
                window.location.replace("my-account");
            }
            else {
                $('#error-login').show();
            }
        });

        event.preventDefault();
        return false;
    });
});
