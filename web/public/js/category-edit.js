$(function () {
    $('#category-edit-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        var name = $('#category-edit-form-name').val();

        $.post('API/category/' + name, $(this).serialize(), function (data, status) {
            if (data === true) {
                Alert.success("Changes saved.");
            }
            else {
                Alert.error("Could not save changes. Please check system log.");
            }
        });
    });
    
    
    
    $('#category-delete-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        var name = $('#category-delete-form-name').val();

        $.post('API/category/' + name, $(this).serialize(), function (data, status) {
            if (data === true) {
                Alert.success("Category deleted.");
            }
            else {
                Alert.error("Could not delete category. Please check system log.");
            }
        });
    });
});
