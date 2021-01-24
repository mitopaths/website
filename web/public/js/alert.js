var Alert = function () {
    this.setMessage = function (message) {
        alert.html(message);
        return self;
    }
    
    this.show = function (classname) {
        alert.addClass('alert-' + classname);
        alert.removeClass('d-none');
        setTimeout(function () {
            alert.removeClass('alert-' + classname);
            alert.addClass('d-none');
        }, 2500);
        
        return self;
    }
    
    this.success = function (message) {
        self.setMessage(message);
        self.show('success');
    }
    
    this.error = function (message) {
        self.setMessage(message);
        self.show('danger');
    }
    
    var self = this;
    var alert = $('#alert');
    
    return this;
}();