$(document).ready(function() {
    function getAllMessages() {
        $.ajax({
            type: 'GET',
            url: `${BASE_URL}message/all`,
            success: function(res) {
                console.log(res)
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
                    appendConvo(el);
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
    // If message .message-head clicks, display conversation dynamic
    $(document).on('click', '.message-head', function() {
        var getID = $(this).data('id');
        var getRecipient = $(this).data('user');
        $.ajax({
            type: 'GET',
            url: `${BASE_URL}message/view/${getID}`,
            success: function(res) {
                console.log(res.data);
                var imgsrc = `${BASE_URL}img/avatars/`;
                res.data.forEach(el => {
                    if(el.photo != null) {
                        el.photo = imgsrc + el.photo;
                    } else {
                        el.photo = `${imgsrc}profile_default.png`
                    }
                    appendMessage(el);
                });
                replyForm(getID, getRecipient);
            },
            error: function(res) {
                console.log(res);
            },
        })
    })

    // Post reply
    $(document).on('submit', '#message-reply', function(e) {
        e.preventDefault();
        var message_id = e.currentTarget.msg_id.value;
        const data = {
            message_body: e.currentTarget.reply.value,
            recipient: e.currentTarget.r_id.value,
        }
        
        $.ajax({
            type: 'POST',
            url: `${BASE_URL}message/reply/${message_id}`,
            data: JSON.stringify(data),
            success: function(res) {
                console.log(res);
            },
            error: function(res) {
                console.log(res);
            },
        })
    })

    // Create message-body dynamic
    function appendConvo(message) {
        var $messageItem = $("<li>").addClass("message-head mb-2").attr({
            "data-id": message.message_id,
            "data-user": message.user_id,
        });
        var $messageContainer = $("<div>").addClass("d-flex flex-row bg-light rounded-lg message-link");
        var $imageContainer = $("<div>").addClass("user-icon p-2");
        var $image = $("<img>").attr({
            src: message.photo,
            alt: "Img",
            class: "img-fluid rounded-circle border",
            width: 70
        });
    
        var $messageContent = $("<div>").addClass("d-flex justify-content-start flex-column mx-2 flex-fill");
        var $userName = $("<h5>").addClass("h5").text(message.name); // Username h5
        var $messageBody = $("<p>").addClass("mb-1").text(message.message_body); // Message text
        var $dateContainer = $("<div>").addClass("d-flex justify-content-end align-self-stretch mx-2 my-1");
        var $date = $("<span>").addClass("align-self-end mr-3 small").text(message.created_at); // Date

        $dateContainer.append($date);
        $imageContainer.append($image);
        $messageContent.append($userName, $messageBody, $dateContainer);
        $messageContainer.append($imageContainer, $messageContent);
        $messageItem.append($messageContainer);
    
        $("#convo-container").append($messageItem);
    }

    function appendMessage(message) {
        var $messageItem = $("<li>").addClass("mb-1").attr({
            "data-id": message.message_id,
            "data-user": message.user_id,
        });
        var $messageContainer = $("<div>").addClass("d-flex flex-row bg-light rounded-lg message-link");
        var $imageContainer = $("<div>").addClass("user-icon p-2");
        var $image = $("<img>").attr({
            src: message.photo,
            alt: "Img",
            class: "img-fluid rounded-circle border",
            width: 70
        });
    
        var $messageContent = $("<div>").addClass("d-flex justify-content-start flex-column flex-fill w-75");
        var $userName = $("<h5>").addClass("h5").text(message.name); // Username h5
        var $messageBody = $("<p>").addClass("mb-1").text(message.message_body); // Message text
        console.log(message.message_body.length);
        if (message.message_body.length > 80) {
            var $textSpan = $("<span>").text(message.message_body.substr(0, 80));
            var $ellipsisSpan = $("<span>").addClass("ellipsis").html("&hellip;"); // Ellipsis span
            $messageBody.append($textSpan, $ellipsisSpan);
            $messageBody.on("click", ".ellipsis", function () {
                // Toggle between full text and ellipsis on click
                var $this = $(this);
                $this.prev().remove(); // Remove the text span
                $this.remove(); // Remove the ellipsis span
                $messageBody.append(message.message_body); // Show full text
            });
        } else {
            $messageBody.text(message.message_body); // Show the full text
        }

        var $dateContainer = $("<div>").addClass("d-flex justify-content-end align-self-stretch mx-2 my-1");
        var $date = $("<span>").addClass("align-self-end mr-3 small").text(message.created_at); // Date

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

    function replyForm(msg_id, recipient) {
        // Create a div element with the form and its contents
        var $formContainer = $("<div>").addClass("d-flex justify-content-end");
        var $form = $("<form>").attr({
            id: "message-reply",
            enctype: "multipart/form-data"
        });
        var $msgIDHidden = $("<input>").attr({
            type: "hidden",
            name: "msg_id",
            value: msg_id
        });
        var $recipientHidden = $("<input>").attr({
            type: "hidden",
            name: "r_id",
            value: recipient
        });
        var $textarea = $("<textarea>").attr({
            name: "reply",
            id: "reply",
            cols: "90",
            rows: "2",
            class: "form-control"
        });
        var $buttonContainer = $("<div>").addClass("d-flex justify-content-end align-items-start");
        var $submitButton = $("<button>").attr({
            type: "submit",
            class: "btn btn-primary ml-1"
        }).text("Reply");

        $form.append($msgIDHidden, $recipientHidden, $textarea, $buttonContainer.append($submitButton));
        $formContainer.append($form);

        $("#reply-container").empty().append($formContainer);

    }

    getAllMessages();
});