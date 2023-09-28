$(document).ready(function() {
    $('#auth_register').on('submit', function(e) {
        e.preventDefault();
        
        let pass = e.currentTarget.pass.value;
        let conf_pass =  e.currentTarget.confirm_pass.value;

        if(pass !== conf_pass) {
            $('#error_message').removeClass('invisible').text('Passwords do not match');
            return;
        }

        if(pass.length < 6) {
            $('#error_message').removeClass('invisible').text('Enter at least 6 characters');
            return;
        }

        const data = {
            name: e.currentTarget.name.value,
            email: e.currentTarget.email.value,
            password: e.currentTarget.pass.value,
        }

        $.ajax({
            type: 'POST',
            url: `${BASE_URL}register/store`,
            data: JSON.stringify(data),
            success: function(res) {
                console.log(res);
            },
            error: function(res) {
                console.log(res);
            },
        })
    });

    $('#auth_login').on('submit', function(e) {
        e.preventDefault();
        console.log(e.currentTarget);
    });

    function validateCredentials() {

    }
});