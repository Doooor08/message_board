$(document).ready(function() {
    // Update user profile
    $('#profile_form').on('submit', function(e) {
        e.preventDefault();
        
        const data = new FormData(e.target);
        // data.append('name', e.currentTarget.name.value);
        // data.append('birthdate', e.currentTarget.birthdate.value);
        // data.append('gender', e.currentTarget.gender.value);
        // data.append('description', e.currentTarget.description.value);
        data.set('photo', $('input[name="photo"]')[0].files[0]);
        console.log($('input[name="photo"]')[0].files[0])
        console.log([...data.entries()])

        $.ajax({
            type: 'POST',
            url: `${BASE_URL}profile/update`,
            data: data,
            contentType: false,
            processData: false,
            success: function(res) {
                console.log(res)
            },
            error: function(res) {
                console.log(res);
            },
        });
    });
});