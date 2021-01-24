$(function () {
    $('#main-search-form').submit(function () {
        var form = $(this);
        var add_filter = function (name) {
            $('<input>')
            .attr('type', 'hidden')
            .attr('name', 'filter_type[]')
            .val(name)
            .appendTo(form);
        }

        if ($('#search-proteins').prop('checked')) {
            add_filter('protein');
            add_filter('mutated_protein');
        }

        if ($('#search-pathways').prop('checked')) {
            add_filter('pathway');
            add_filter('mutated_pathway');
        }

        if ($('#search-processes').prop('checked')) {
            add_filter('category');
        }
    });
});