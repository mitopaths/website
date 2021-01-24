$(function () {
    var pathologies = [];
    $.get('API/pathologies', function (data) {
        pathologies = data;
    });

    var functions = [];
    $.get('API/functions', function (data) {
        functions = data;
    });


    if (window.location.hash == '#suggest') {
       $('#suggest').collapse('show');
    }


    $('#contact-us-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();

        var message = $('#contact-us-input').val();
        if (message) {
            $.post('API/contact-us', $(this).serialize(), function (data, status) {
                Alert.success("Successfully sent.");
            });
        }
    });


    $('#logout-button').click(function () {
        $.post('API/me', { _method: 'delete' }, function (data, status) {
            if (data === true) {
                window.location.replace("");
            }
        });
    });

    $('#account-update').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $.post('API/me', $(this).serialize(), function (data, status) {
            if (data === true) {
                window.location.replace("my-account");
            }
        });
    });

    $('#account-delete').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $.post('API/user/<?= $user->getId() ?>', $(this).serialize(), function (data, status) {
            if (data === true) {
                $.post('API/me', { _method: 'delete' }, function () {
                    window.location.replace("");
                });
            }
        });
    });


    $('#molecule-insert-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $.post('API/molecules', $(this).serialize(), function (data, status) {
            if (data === true) {
                Alert.success("Successfully inserted.");
            }
            else {
                Alert.error("Could not insert molecule. Please check system log.");
            }
        });
    });

    $('#molecule-insert-form-type').change(function () {
        var value = $(this).val();
        var original_container = $('#molecule-insert-form-original-container');
        var function_container = $('#molecule-insert-form-function');
        var pathology_container = $('#molecule-insert-form-pathology');

        if (value === 'mutated_protein') {
            original_container.removeClass('d-none');
            function_container.removeClass('d-none');
            pathology_container.removeClass('d-none');
        }
        else {
            original_container.addClass('d-none');
            function_container.addClass('d-none');
            pathology_container.addClass('d-none');
        }
    });

    $('#molecule-insert-form-add-attribute').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        var container = $('#molecule-insert-form-attributes');
        var n = container.children().length / 2;
        var id = 'molecule-insert-form-attribute-' + n;

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

    $('#molecule-insert-form-remove-attribute').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $('#molecule-insert-form-attributes')
        .children().slice(-2).remove();
    });


    $('#molecule-insert-form-add-pathology').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        var container = $('#molecule-insert-form-pathologies');

        var select = $('<select>')
        .attr('name', 'pathologies[]')
        .addClass('form-control');

        for (var i = 0; i < pathologies.length; ++i) {
            var option = $('<option>')
            .attr('value', pathologies[i].name)
            .html(pathologies[i].name)
            .appendTo(select);
        }

        select.appendTo(container);
    });

    $('#molecule-insert-form-remove-pathology').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $('#molecule-insert-form-pathologies')
        .children().slice(-1).remove();
    });




    $('#molecule-insert-form-add-function-gain').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        var container = $('#molecule-insert-form-functions');

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

    $('#molecule-insert-form-add-function-loss').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        var container = $('#molecule-insert-form-functions');

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

    $('#molecule-insert-form-remove-function').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $('#molecule-insert-form-functions')
        .children().slice(-1).remove();
    });




























    $('#pathway-insert-form-add-step').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        var container = $('#pathway-insert-form-steps');
        var n = container.children().length / 2;

        var body_container = $('<div>').addClass('col-sm-6');
        var body = $('<input>').attr('type', 'text').attr('name', 'step_body[' + n + ']').addClass('form-control').addClass('mitopaths-expression').attr('placeholder', 'Step body');
        body_container.append(body);

        var head_container = $('<div>').addClass('col-sm-6');
        var input_group = $('<div>').addClass('input-group mb-3');
        var head_prepend = $('<div>').addClass('input-group-prepend');
        $('<span>').addClass('input-group-text').html('&rArr;').appendTo(head_prepend);
        var head = $('<input>').attr('type', 'text').attr('name', 'step_head[' + n + ']').addClass('form-control').addClass('mitopaths-expression').attr('placeholder', 'Step head');
        input_group.append(head_prepend).append(head);
        head_container.append(input_group);

        container.append(body_container).append(head_container);
    });

    $('#pathway-insert-form-remove-step').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $('#pathway-insert-form-steps').children().slice(-2).remove();
    });




    $('#pathway-insert-form-add-process').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        var container = $('#pathway-insert-form-processes');
        var n = container.children().length / 2;
        var id = 'pathway-insert-form-process-' + n;

        var select_container = $('<div>').addClass('col-sm-6');
        var select = $('<select>').attr('name', 'mitochondrial_processes[]').attr('id', id).addClass('form-control');
        select_container.append(select);

        var input_container = $('<div>').addClass('col-sm-6');
        var input = $('<input>').attr('type', 'text').addClass('form-control').addClass('ajax-search').attr('data-target', '#' + id).attr('data-filter', 'type:category').attr('placeholder', 'Type mitochondrial process name here...');
        input_container.append(input);

        container.append(input_container).append(select_container);
    });

    $('#pathway-insert-form-remove-process').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $('#pathway-insert-form-processes').children().slice(-2).remove();
    });


    $('#pathway-insert-form-type').change(function () {
        var value = $(this).val();
        var container = $('#pathway-insert-form-original-container');

        value === 'mutated_pathway' ? container.removeClass('d-none') : container.addClass('d-none');
    });


    $('#pathway-insert-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        $.post('API/pathways', $(this).serialize(), function (data, status) {
            data === true ? Alert.success("Successfully inserted.") : Alert.error("Could not insert pathway. Please check system log.");
        });
    });








    $('#process-insert-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $.post('API/categories', $(this).serialize(), function (data, status) {
            data === true ? Alert.success("Successfully inserted.") : Alert.error("Could not insert mitochondrial process. Please check system log.");
        });
    });





    $('#function-insert-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $.post('API/functions', $(this).serialize(), function (data, status) {
            data === true ? Alert.success("Successfully inserted.") : Alert.error("Could not insert function. Please check system log.");
        });
    });





    $('#pathology-insert-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $.post('API/pathologies', $(this).serialize(), function (data, status) {
            data === true ? Alert.success("Successfully inserted.") : Alert.error("Could not insert pathology. Please check system log.");
        });
    });
    
    
    
    
    
    
    
    
    
    
    $('#users-manage-form-id').change(function () {
        $('#users-manage-form')
        .attr('action', 'users/' + $(this).val() + '/edit');
    });
    $('#users-manage-form-id').change();
});
