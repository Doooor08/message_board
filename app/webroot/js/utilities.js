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
})