$(function () {
    $('#pathway-edit-form-add-step').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        var container = $('#pathway-edit-form-steps-container');
        var n = container.children().length / 2;

        var body_container = $('<div>').addClass('col-sm-6');
        var body = $('<input>')
        .attr('type', 'text')
        .attr('name', 'step_body[' + n + ']')
        .addClass('form-control')
        .addClass('mitopaths-expression')
        .attr('placeholder', 'Step body');
        body_container.append(body);

        var head_container = $('<div>').addClass('col-sm-6');
        var input_group = $('<div>').addClass('input-group mb-3');
        var head_prepend = $('<div>').addClass('input-group-prepend');
        $('<span>')
        .addClass('input-group-text')
        .html('&rArr;').appendTo(head_prepend);
        var head = $('<input>')
        .attr('type', 'text')
        .attr('name', 'step_head[' + n + ']')
        .addClass('form-control')
        .addClass('mitopaths-expression')
        .attr('placeholder', 'Step head');
        input_group.append(head_prepend).append(head);
        head_container.append(input_group);

        container.append(body_container).append(head_container);
    });
    
    
    
    $('#pathway-edit-form-remove-step').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $('#pathway-edit-form-steps-container').children().slice(-2).remove();
    });
    
    
    
    $('#pathway-edit-form-add-process').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        var container = $('#pathway-edit-form-processes-container');
        var n = container.children().length / 2;
        var id = 'pathway-edit-form-process-' + n;

        var select_container = $('<div>').addClass('col-sm-6');
        var select = $('<select>')
        .attr('name', 'mitochondrial_processes[]')
        .attr('id', id)
        .addClass('form-control');
        select_container.append(select);

        var input_container = $('<div>')
        .addClass('col-sm-6')
        .addClass('mb-3');
        var input = $('<input>')
        .attr('type', 'text')
        .addClass('form-control')
        .addClass('ajax-search')
        .attr('data-target', '#' + id)
        .attr('data-filter', 'type:category')
        .attr('placeholder', 'Type mitochondrial process name here...');
        input_container.append(input);

        container.append(input_container).append(select_container);
    });
    
    
    
    $('#pathway-edit-form-remove-process').click(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $('#pathway-edit-form-processes-container').children().slice(-2).remove();
    });
    
    
    
    $('#pathway-edit-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        var name = $('#pathway-edit-form-name').val();
        var data = new FormData($('#pathway-edit-form')[0]);

        $.ajax({
              type: 'POST',
              enctype: 'multipart/form-data',
              processData: false,
              contentType: false,
              cache: false,
              data: data,
              url: '/mitopaths/API/pathway/' + name.replace('/', '---0').replace('+', '---1'),
              success: function (data, status) {
            if (data === true) {
                Alert.success("Changes saved.");
            }
            else {
                Alert.error("Could not save changes. Please check system log.");
            }
        }});
    });
    
    
    
    $('#pathway-delete-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();

        $.post('/mitopaths/API/pathway/' + name, $(this).serialize(), function (data, status) {
            if (data === true) {
                Alert.success("Pathway deleted.");
            }
            else {
                Alert.error("Could not delete pathway. Please check system log.");
            }
        });
    });
});
