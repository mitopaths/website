$(function () {
    $('#browse-pathways-form').submit(function () {
        var pathway = $('#browse-pathways-form-name').val();
        $(this).attr('action', 'pathway/' + pathway);
    });
});
