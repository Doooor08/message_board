$(document).ready(function() {
    function getAllMessages() {
        $.ajax({
            type: 'GET',
            url: `${BASE_URL}message/all`,
            success: function(res) {
                // console.log(res)
                // console.log(res.data.length)
                
                // If User has no messages received
                if(res.data.length == 0) {
                    return appendNoMessage();
                }
                var imgsrc = `${BASE_URL}img/avatars/`;
                res.data.forEach(el => {
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
    // If message .message-head clicks, redirect to message details
    $(document).on('click', '.message-head', function() {
        var getID = $(this).data('id');
        console.log(`${BASE_URL}message/view/${getID}`)
        $.ajax({
            type: 'GET',
            url: `${BASE_URL}message/view/${getID}`,
            success: function(res) {
                console.log(res);
            },
            error: function(res) {
                console.log(res);
            },
        })
    })

    // Create message-body dynamic
    function appendMessage(message) {
        var $messageItem = $("<li>").addClass("message-head").attr("data-id", message.message_id);
        var $messageContainer = $("<div>").addClass("d-flex flex-row border-bottom border-dark");
        var $imageContainer = $("<div>").addClass("user-icon p-2");
        var $image = $("<img>").attr({
            src: message.photo,
            alt: "Img",
            class: "img-fluid",
            width: 100
        });
    
        var $messageContent = $("<div>").addClass("d-flex justify-content-start flex-column mx-2 my-auto flex-fill");
        var $userName = $("<h5>").addClass("h5").text(message.name); // Username h5
        var $messageBody = $("<p>").addClass("mb-1").text(message.message_body); // Message text
        var $dateContainer = $("<div>").addClass("d-flex justify-content-end align-self-stretch mx-2 my-1");
        var $date = $("<span>").addClass("align-self-end").text(message.created_at); // Date

        $dateContainer.append($date);
        $imageContainer.append($image);
        $messageContent.append($userName, $messageBody, $dateContainer);
        $messageContainer.append($imageContainer, $messageContent);
        $messageItem.append($messageContainer);
    
        $("#message-container").append($messageItem);
    }

    function appendNoMessage() {
        var $messageContainer = $("<div>").addClass("d-flex justify-content-center");
        var $messageContent = $("<h5>").addClass("h5 my-3").text("You have no messages");

        $messageContainer.append($messageContent);
    
        $("#message-container").append($messageContainer);
    }

    getAllMessages();
});