$(document).ready(function() {
    $.ajaxSetup({
        type: 'POST',
        cache: false, 
        contentType: 'application/json', 
        dataType: 'json',
        error: function (a, b, c) {
            console.log(a, b, c);       
        }
    }); 
    
});