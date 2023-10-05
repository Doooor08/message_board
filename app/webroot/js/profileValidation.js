$(document).ready(function() {
    // Update user profile
    $('#profile_form').on('submit', function(e) {
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

        const data = new FormData(e.target);
        data.set('photo', $('input[name="photo"]')[0].files[0]);
        data.delete('confirm_pass');
        console.log([...data.entries()])
        $.ajax({
            type: 'POST',
            url: `${BASE_URL}profile/update`,
            data: data,
            contentType: false,
            processData: false,
            success: function(res) {
                console.log(res);
                if(res.status == 200) {
                    window.location.href = `${BASE_URL}profile`;
                }
            },
            error: function(res) {
                console.log(res);
            },
        });
    });
});