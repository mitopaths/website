$(function () {
    var pathologies = [];
    $.get('https://web.math.unipd.it/mitopaths/API/pathologies', function (data) {
        pathologies = data;
    });

    var functions = [];
    $.get('https://web.math.unipd.it/mitopaths/API/functions', function (data) {
        functions = data;
    });
    
    
    
    $('#mutated-protein-edit-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        var name = $('#mutated-protein-edit-form-name').val();

        $.post('https://web.math.unipd.it/mitopaths/API/molecule/' + name, $(this).serialize(), function (data, status) {
            if (data === true) {
                Alert.success("Changes saved.");
            }
            else {
                Alert.error("Could not save changes. Please check system log.");
            }
        });
    });
    
    
    
    $('#mutated-protein-edit-form-add-attribute').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        var container = $('#mutated-protein-edit-form-attributes-container');

        var name_container = $('<div>').addClass('col-sm-4');
        var name_input = $('<input>')
        .attr('type', 'text')
        .attr('name', 'attributes_names[]')
        .addClass('form-control')
        .attr('placeholder', 'Attribute name');
        name_container.append(name_input);

        var value_container = $('<div>').addClass('col-sm-8');
        var value_input = $('<input>')
        .attr('name', 'attributes_values[]')
        .attr('type', 'text')
        .addClass('form-control')
        .attr('placeholder', 'Attribute value');
        value_container.append(value_input);

        container.append(name_container).append(value_container);
    });
    
    
    
    $('#mutated-protein-edit-form-remove-attribute').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $('#mutated-protein-edit-form-attributes-container')
        .children().slice(-2).remove();
    });



    $('#molecule-edit-form-add-function-gain').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        var container = $('#molecule-edit-form-functions-container');

        var input_group = $('<div>')
        .addClass('input-group')
        .addClass('mb-3');

        var prepend = $('<div>')
        .addClass('input-group-prepend');

        var label = $('<label>')
        .addClass('input-group-text')
        .html('Gain');

        var select = $('<select>')
        .attr('name', 'gained_functions[]')
        .addClass('form-control');

        for (var i = 0; i < functions.length; ++i) {
            var option = $('<option>')
            .attr('value', functions[i].name)
            .html(functions[i].name)
            .appendTo(select);
        }

        label.appendTo(prepend);
        prepend.appendTo(input_group);
        select.appendTo(input_group);
        input_group.appendTo(container);
    });
    
    
    
    $('#molecule-edit-form-add-function-loss').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        var container = $('#molecule-edit-form-functions-container');

        var input_group = $('<div>')
        .addClass('input-group')
        .addClass('mb-3');

        var prepend = $('<div>')
        .addClass('input-group-prepend');

        var label = $('<label>')
        .addClass('input-group-text')
        .html('Loss');

        var select = $('<select>')
        .attr('name', 'lost_functions[]')
        .addClass('form-control');

        for (var i = 0; i < functions.length; ++i) {
            var option = $('<option>')
            .attr('value', functions[i].name)
            .html(functions[i].name)
            .appendTo(select);
        }

        label.appendTo(prepend);
        prepend.appendTo(input_group);
        select.appendTo(input_group);
        input_group.appendTo(container);
    });
    
    
    
    $('#molecule-edit-form-remove-function').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $('#molecule-edit-form-functions-container')
        .children().slice(-1).remove();
    });
    
    
    
    $('#molecule-edit-form-add-pathology').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        var container = $('#molecule-edit-form-pathologies-container');

        var select = $('<select>')
        .attr('name', 'pathologies[]')
        .addClass('form-control')
        .addClass('mb-3');

        for (var i = 0; i < pathologies.length; ++i) {
            var option = $('<option>')
            .attr('value', pathologies[i].name)
            .html(pathologies[i].name)
            .appendTo(select);
        }

        select.appendTo(container);
    });
    
    
    
    $('#molecule-edit-form-remove-pathology').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $('#molecule-edit-form-pathologies-container')
        .children().slice(-1).remove();
    });
    
    
    
    $('#mutated-protein-delete-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        var name = $('#mutated-protein-delete-form-name').val();

        $.post('https://web.math.unipd.it/mitopaths/API/molecule/' + name, $(this).serialize(), function (data, status) {
            if (data === true) {
                Alert.success("Protein variant deleted.");
            }
            else {
                Alert.error("Could not delete protein variant. Please check system log.");
            }
        });
    });
});
