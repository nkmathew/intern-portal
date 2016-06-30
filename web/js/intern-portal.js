/**
 * Created by nkmathew on 23/06/2016.
 */

$(document).ready(function () {
    var source = $("#email-list-template").html();

    $("#email-input-box").keyup(function (e) {
        var template = Handlebars.compile(source);
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

});
