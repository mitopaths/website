$(function () {
    $('#browse-categories-form').submit(function () {
        var category = $('#browse-categories-form-name').val();
        $(this).attr('action', '/mitopaths/category/' + category);
    });
});
