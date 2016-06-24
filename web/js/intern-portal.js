/**
 * Created by nkmathew on 23/06/2016.
 */

$(document).ready(function () {
    var source   = $("#email-list-template").html();
    var template = Handlebars.compile(source);

    var html = template({email: 'ngetich.kipkoech@students.jkuat.ac.ke'});
    $('#email-list-section').append(html);

    $("#email-input-box").keyup(function (e) {
        if (e.keyCode == 13) {
            var email = $('#email-input-box').val() + '@students.jkuat.ac.ke';
            var html  = template({email: email});
            $('#email-list-section').append(html);

            $('.email-delete-btn').click(function () {
                $(this).closest('.email-line').remove();
            });
            $(this).val('');
        }
    });

    var spinnerOptions = {
        color: '#000'
        //etc etc
    };

    $("#invite-button").click(function () {
        $("#invite-button").spin(spinnerOptions);
        var emailList = [];
        $('.email-address').each(function () {
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
                $('.alert-box').addClass('alert-success fade in');
                $('.alert-box').css('display', 'block');

                $("#invite-button").spin(false);

                // Clear list
                console.log('Emails sent!!!')
                $('.email-line').remove();
            },
            error: function (xhr, status, error) {
                $("#invite-button").spin(false);
                $('.alert-box .msg').html('<h4>' + error + '</h4><br/>' + xhr.responseText);
                $('.alert-box').addClass('alert-danger fade in');
                $('.alert-box').css('display', 'block');
            },
        });
    });

});
