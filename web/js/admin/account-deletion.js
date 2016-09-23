/**
 * Created by nkmathew on 03/09/2016.
 */
var DEL_TEMPLATE = $("#deletion-template").html();

function promoteToCoordinator(email) {
    $.ajax({
        type: 'POST',
        url: '/site/supervisor-to-coordinator',
        data: {email: email},
        success: function (data) {
            alertMessage(data);
        },
        error: function (xhr, status, error) {
            $('.alert-box .msg').html('<h4>' + error + '</h4><br/>' + xhr.responseText);
            $('.alert-box').addClass('alert-danger');
            $('.alert-box').css('text-align', 'left');
            $('.alert-box').show();
        },
    });
}

function deleteUser(email) {
    $.ajax({
        type: 'POST',
        url: '/site/delete-user',
        data: {email: email},
        success: function (data) {
            alertSuccess('User deleted successfully');
        },
        error: function (xhr, status, error) {
            $('.alert-box .msg').html('<h4>' + error + '</h4><br/>' + xhr.responseText);
            $('.alert-box').addClass('alert-danger');
            $('.alert-box').css('text-align', 'left');
            $('.alert-box').show();
        },
    });
}

$(document).ready(function () {
    DEL_TEMPLATE = Handlebars.compile(DEL_TEMPLATE);

    $("#deletion-form").submit(function (e) {
        var email = $('#input-email').val();
        if (email.trim() == '') {
            $('#input-email').focus();
            return;
        }
        $('#results').spin();
        $.getJSON('/site/fetch-user?email=' + email, function (json) {
            $('#results').spin(false);
            json.created_at = moment.unix(json.created_at).fromNow();
            var html = DEL_TEMPLATE(json);
            $('#results').html(html);
           console.log(json);
        });
        e.preventDefault();
    });
});
