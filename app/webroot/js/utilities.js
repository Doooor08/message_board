$(document).ready(function() {
    $('.dropdown-toggle').dropdown();

    // Click event for create message
    $('#new-message').on('click', function() {

    });

    // User Profile Edit
    // Auto preview image after selecting
    $("#profileUpload").click(function() {
        $("#imageInput").click();
    });
    $("#imageInput").change(function() {
        var input = this;

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                // Display the selected image in the img element
                $("#imagePreview").attr("src", e.target.result);
                $("#imagePreview").show(); // Show the image preview
            }

            reader.readAsDataURL(input.files[0]);
        }
    });
    
    // Date Picker
    $('#birthdate').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true
    });

    // Recipient select 2 plugin
    $('#recipient').select2({
        ajax: {
            url: `${BASE_URL}user/all`,
            dataType: 'json',
            processResults: function (item) {
                // console.log(item.data)
                var imgsrc = `${BASE_URL}img/avatars/`;
                item.data.forEach(el => {
                    if(el.photo != null) {
                        el.photo = imgsrc + el.photo;
                    } else {
                        el.photo = `${imgsrc}profile_default.png`
                    }
                });
                var formattedData = item.data.map(function(el) {
                    return {
                        id: el.user_id,
                        text: el.name,
                        photo: el.photo,
                    };
                });
                console.log(formattedData);

    
                return {
                    results: formattedData
                };
            },
            cache: true,
        },
        templateResult: formatDisplay,
    });

    function formatDisplay (user) {
        var $format = $(
            '<div class="user-option">' +
            '<img src="' + user.photo + '" class="img-fluid mr-2" width="40"/>' +
            '<span class="user-name">' + user.text + '</span>' +
            '</div>'
        );
        return $format;
    };    
});