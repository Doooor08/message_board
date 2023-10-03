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

    // Recipient sselect 2 plugin
    $('#recipient').select2({
        ajax: {
            url: 'https://api.github.com/search/repositories',
            dataType: 'json',
            processResults: function (data) {
                // Process the data received from the AJAX request here
                // You need to format the data into Select2's expected format
                // Typically, this involves creating an array of objects with 'id' and 'text' properties
    
                var formattedData = data.items.map(function(item) {
                    return {
                        id: item.id,
                        text: item.name  // You can customize this based on your data structure
                    };
                });
    
                return {
                    results: formattedData
                };
            },
            cache: true
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
          }
    });
})