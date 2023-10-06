$(document).ready(function() {
    // Update user profile
    $('#profile_form').on('submit', async function(e) {
        e.preventDefault();
        
        const data = new FormData(e.target);
        data.set('photo', $('input[name="photo"]')[0].files[0]);

        if (!$('input[name="photo"]')[0].files[0]) {
            // Set default image
            const photo = await setDefaultPhoto();
            data.set('photo', photo);
        }

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

    // Toggle disabled attribute on confirm password if password has data
    $("#pass").on("input", function() {
        if($("#pass").val().length == 0) {
            $("#conf_pass").val('').attr('disabled', true);
            console.log($("#conf_pass"))
            return;
        }
        $("#conf_pass").attr('disabled', false);
    });

    // Update User Account
    $("#account_form").on('submit', function(e) {
        e.preventDefault();
        
        var data = {
            email: e.currentTarget.email.value
        }
        
        let pass = e.currentTarget.pass.value;
        let conf_pass =  e.currentTarget.confirm_pass.value;
        
        if(pass.length !== 0) {

            if(pass !== conf_pass) {
                $('#error_message').removeClass('invisible').text('Passwords do not match');
                return;
            }
    
            if(pass.length < 6) {
                $('#error_message').removeClass('invisible').text('Enter at least 6 characters');
                return;
            }

            data.password = pass;
        }

        $.ajax({
            type: 'POST',
            url: `${BASE_URL}account/update`,
            data: JSON.stringify(data),
            success: function(res) {
                console.log(res);
            },
            error: function(res) {
                console.log(res);
            },
        });
    });

    function setDefaultPhoto() {
        return fetch(`${BASE_URL}img/avatars/profile_default.png`)
            .then(response => response.blob())
            .then(blob => new File([blob], 'profile_default.png'))
            .catch(error => {
                console.error('Failed to fetch the default image:', error);
                return null; // Return null or handle the error as needed
            });
    }
    
});