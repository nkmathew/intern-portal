/**
 * Created by nkmathew on 23/06/2016.
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

    // Initialize bootstrap tooltip plugin
    $('[data-toggle="tooltip"]').tooltip();

    $("#email-input-box").keyup(function (e) {
        var template = Handlebars.compile(source);
        if (e.keyCode == 13) {
            addEmailToList();
        }
    });

    $('#btn-add-email').click(addEmailToList);

    $("#invite-button").click(function () {
        $("#invite-button").spin({color: 'grey'});
        var emailList = [];
        $('.email-address a').each(function () {
            emailList.push($(this).html());
        });
        $.ajax({
            type: 'POST',
            url: '/site/send-signup-links',
            data: {
                'email-list': JSON.stringify(emailList),
            },
            success: function () {
                $('.alert-box .msg').html('Signup links sent successfully');
                $('.alert-box').addClass('alert-success');
                $('.alert-box').show();
                $("#alert-box").fadeTo(3000, 500).slideUp(500, function () {
                    $("#alert-box").hide();
                });

                // Remove spinner
                $("#invite-button").spin(false);

                // Clear list
                $('.email-line').remove();
            },
            error: function (xhr, status, error) {
                $("#invite-button").spin(false);
                $('.alert-box .msg').html('<h4>' + error + '</h4><br/>' + xhr.responseText);
                $('.alert-box').addClass('alert-danger');
                $('.alert-box').show();
            },
        });
    });

    $('a[data-toggle="tab"]').click(function (e) {
        // Save the latest tab using a cookie
        Cookies.set('last_tab', $(e.target).attr('href'));
    });

    // Opens the last tab before the page reload
    var lastTab = Cookies.get('last_tab');
    if (lastTab) {
        $('a[href=' + lastTab + ']').click();
    }

});
