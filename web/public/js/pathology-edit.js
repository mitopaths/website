$(function () {
    $('#pathology-edit-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        var name = $('#pathology-edit-form-name').val();

        $.post('API/pathology/' + name, $(this).serialize(), function (data, status) {
            if (data === true) {
                Alert.success("Changes saved.");
            }
            else {
                Alert.error("Could not save changes. Please check system log.");
            }
        });
    });
    
    
    
    $('#pathology-delete-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        var name = $('#pathology-delete-form-name').val();

        $.post('API/pathology/' + name, $(this).serialize(), function (data, status) {
            if (data === true) {
                Alert.success("Pathology deleted.");
            }
            else {
                Alert.error("Could not delete pathology. Please check system log.");
            }
        });
    });
});
