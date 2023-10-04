$(document).ready(function() {
    function getAllMessages() {
        $.ajax({
            type: 'GET',
            url: `${BASE_URL}message/all`,
            success: function(res) {
                console.log(res.data)
                var imgsrc = `${BASE_URL}img/avatars/`;
                res.data.forEach(el => {
                    console.log(el);
                    if(el.photo != null) {
                        el.photo = imgsrc + el.photo;
                    } else {
                        el.photo = `${imgsrc}profile_default.png`
                    }
                    appendMessage(el);
                });
            },
            error: function(res) {
                console.log(res);
            },
        })
    }

    $('#new-message').on('submit', function(e) {
        e.preventDefault();
        const data = {
            recipient: e.currentTarget.recipient.value,
            message_body: e.currentTarget.message.value,
        }

        $.ajax({
            type: 'POST',
            url: `${BASE_URL}message/store`,
            data: JSON.stringify(data),
            success: function(res) {
                console.log(res);
            },
            error: function(res) {
                console.log(res);
            },
        })
    });
    getAllMessages();

    // Create message-body dynamic
    function appendMessage(message) {
        
        var $messageContainer = $("<div>").addClass("d-flex flex-row border-bottom border-dark message-head");
        var $imageContainer = $("<div>").addClass("user-icon p-2");
        var $image = $("<img>").attr({
            src: message.photo,
            alt: "Img",
            class: "img-fluid",
            width: 120
        });
    
        var $messageContent = $("<div>").addClass("d-flex justify-content-start flex-column mx-2");
        var $userName = $("<h5>").addClass("h5").text(message.name); // Username h5
        var $messageBody = $("<p>").addClass("mb-1").text(message.message_body); // Message text
        var $dateContainer = $("<div>").addClass("d-flex justify-content-end mx-2 my-1");
        var $date = $("<span>").addClass("align-self-end").text(message.created_at); // Date

        $dateContainer.append($date);
        $imageContainer.append($image);
        $messageContent.append($userName, $messageBody, $dateContainer);
        $messageContainer.append($imageContainer, $messageContent);
    
        $("#message-container").append($messageContainer);
    }
});