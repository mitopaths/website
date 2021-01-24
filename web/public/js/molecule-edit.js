$(function () {
    $('#molecule-edit-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        var name = $('#molecule-edit-form-name').val();

        $.post('/mitopaths/API/molecule/' + name, $(this).serialize(), function (data, status) {
            if (data === true) {
                Alert.success("Changes saved.");
            }
            else {
                Alert.error("Could not save changes. Please check system log.");
            }
        });
    });
    
    
    
    $('#molecule-edit-form-add-attribute').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        var container = $('#molecule-edit-form-attributes-container');

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
    
    
    
    $('#molecule-edit-form-remove-attribute').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $('#molecule-edit-form-attributes-container')
        .children().slice(-2).remove();
    });
    
    
    
    $('#molecule-delete-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        var name = $('#molecule-delete-form-name').val();

        $.post('/mitopaths/API/molecule/' + name, $(this).serialize(), function (data, status) {
            if (data === true) {
                Alert.success("Molecule deleted.");
            }
            else {
                Alert.error("Could not delete molecule. Please check system log.");
            }
        });
    });
});
