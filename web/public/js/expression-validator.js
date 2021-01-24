$(function () {
    $('body').on('change', '.mitopaths-expression', function() {
        var expression = $(this).val();
        var container = $(this);

        container.attr('data-toggle', 'tooltip').attr('data-placement', 'top').tooltip();

        $.post('https://web.math.unipd.it/mitopaths/API/expression/syntax-checker', { '_method': 'get', 'expression': expression }, function (data) {
            container.addClass('border').removeClass('border-success').removeClass('border-danger');
            if (data.status === 'OK') {
                container.addClass('border-success').attr('data-original-title', 'No syntax errors');
            }
            else {
                container.addClass('border-danger').attr('data-original-title', data.error);
            }
        })
    });
});
