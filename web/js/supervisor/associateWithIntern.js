/**
 * Created by nkmathew on 03/09/2016.
 */
var ASSOC_TEMPLATE = $("#association-template").html();

function sendAssociationLink(email) {
    $.ajax({
        type: 'POST',
        url: '/site/association-link',
        data: {email: email},
        success: function (data) {
            alertMessage(data);
        },
        error: function (xhr, status, error) {
            $('.alert-box .msg').html('<h4>' + error + '</h4><br/>' + xhr.responseText);
            $('.alert-box').addClass('alert-danger');
            $('.alert-box').show();
        },
    });
}

$(document).ready(function () {
    ASSOC_TEMPLATE = Handlebars.compile(ASSOC_TEMPLATE);

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
            var html = ASSOC_TEMPLATE(json);
            $('#results').html(html);
           console.log(json);
        });
        e.preventDefault();
    });
});
