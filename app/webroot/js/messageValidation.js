$(document).ready(function() {
    function getAllMessages() {
        $.ajax({
            type: 'GET',
            url: `${BASE_URL}message/all`,
            success: function(res) {
                console.log(res.data);
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
});