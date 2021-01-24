$(function () {
    $('#user-edit-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        var id = $('#user-edit-form-id').val();

        $.post('/mitopaths/API/user/' + id, $(this).serialize(), function (data, status) {
            if (data === true) {
                Alert.success("Changes saved.");
            }
            else {
                Alert.error("Could not save changes. Please check system log.");
            }
        });
    });
    
    
    
    $('#user-delete-form').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        var id = $('#user-edit-form-id').val();

        $.post('API/user/' + id, $(this).serialize(), function (data, status) {
            if (data === true) {
                Alert.success("User deleted.");
            }
            else {
                Alert.error("Could not delete user. Please check system log.");
            }
        });
    });
});
