/**
 * Created by nkmathew on 05/07/2016.
 */

var source = $("#email-list-template").html();

function addEmailToList() {
    var inputboxVal = $('#email-input-box').val();
    if (inputboxVal.trim() == '') {
        $('#email-input-box').focus();
        return;
    }
    var email    = inputboxVal + '@students.jkuat.ac.ke';
    var template = Handlebars.compile(source);
    var html     = template({email: email});
    $('#email-list-section').append(html);

    $('.email-delete-btn').click(function () {
        $(this).closest('.email-line').remove();
    });
    $(this).val('');
}

$(document).ready(function () {

    $("#email-input-box").keyup(function (e) {
        var template = Handlebars.compile(source);
        if (e.keyCode == 13) {
            addEmailToList();
        }
    });

    $('#btn-add-email').click(addEmailToList);

    $("#btn-invite-sender").click(function () {
        var emailList = [];
        $('.email-address a').each(function () {
            emailList.push($(this).html());
        });
        if (emailList.length == 0) {
            $('#email-input-box').focus();
            return;
        }
        $("#btn-invite-sender").spin({color: 'black'});
        $.ajax({
            type: 'POST',
            url: '/site/send-signup-links',
            data: {
                'email-list': JSON.stringify(emailList),
            },
            success: function () {
                alertSuccess('Signup links sent successfully');

                // Remove spinner
                $("#btn-invite-sender").spin(false);

                // Clear list
                $('.email-line').remove();
            },
            error: function (xhr, status, error) {
                $("#btn-invite-sender").spin(false);
                $('.alert-box .msg').html('<h4>' + error + '</h4><br/>' + xhr.responseText);
                $('.alert-box').addClass('alert-danger');
                $('.alert-box').css('text-align', 'left');
                $('.alert-box').show();
            },
        });
    });

    $("#profile-form").submit(function (e) {
        $("#btn-submit-profile").spin({color: 'grey'});
        var url = '/site/profile';
        $.ajax({
            type: 'POST',
            url: url,
            data: $("#profile-form").serialize(),
            success: function (data) {
                // Remove spinner
                $("#btn-submit-profile").spin(false);
            },
            error: function (xhr, status, error) {
                $("#btn-invite-sender").spin(false);
                $('.alert-box .msg').html('<h4>' + error + '</h4><br/>' + xhr.responseText);
                $('.alert-box').addClass('alert-danger');
                $('.alert-box').show();
            },
        });
        e.preventDefault();
    });

    $('#btn-refresh-sent-invites').click(function () {
        $('#content-sent-invites').load('/site/list-sent-invites');
        $('#content-sent-invites').spin(BIG_SPINNER);
    })
});
