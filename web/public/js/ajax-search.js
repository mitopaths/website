$(function () {
    $('body').on('keyup', '.ajax-search', function () {
        var value = $(this).val();
        var target = $($(this).attr('data-target'));
        target.empty();
        
        if (value.length < 3) {
            return false;
        }
        
        // Prepares query parameters
        var parameters = {};
        parameters.q = value;        
        if ($(this).attr('data-filter')) {
            parameters['filters[]'] = $(this).attr('data-filter');
        }
        
        // Runs query
        $.get('https://web.math.unipd.it/mitopaths/API/search', parameters, function (data) {
            var results = data.items.map(function (item) { return item.name; });
            for (var i = 0; i < results.length; ++i) {
                var name = results[i];
                
                var option = $('<option>').attr('value', name).html(name);
                option.appendTo(target);
            }
        });
    });
})
