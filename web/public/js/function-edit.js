$(function () {
    $('#function-edit-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        var name = $('#function-edit-form-name').val();

        $.post('API/function/' + name, $(this).serialize(), function (data, status) {
            if (data === true) {
                Alert.success("Changes saved.");
            }
            else {
                Alert.error("Could not save changes. Please check system log.");
            }
        });
    });
    
    
    
    $('#function-delete-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        var name = $('#function-delete-form-name').val();

        $.post('API/function/' + name, $(this).serialize(), function (data, status) {
            if (data === true) {
                Alert.success("Protein variant deleted.");
            }
            else {
                Alert.error("Could not delete protein variant. Please check system log.");
            }
        });
    });
});
