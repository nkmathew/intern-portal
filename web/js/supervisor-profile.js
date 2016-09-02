/**
 * Created by nkmathew on 05/07/2016.
 */

$(document).ready(function () {
    $("#supervisorprofile-form").submit(function (e) {
        console.log('HERE');
        $("#btn-submit-profile").spin(BIG_SPINNER);
        var url = '/site/supervisor-profile';
        $.ajax({
            type: 'POST',
            url: url,
            data: $("#supervisorprofile-form").serialize(),
            success: function (data) {
                // Remove spinner
                $("#btn-submit-profile").spin(false);
                // Remove green outline colouring when validation passes
                setTimeout(function () {
                    $('.has-success').each(function () {
                        $(this).removeClass('has-success');
                    })
                }, 5000);
            },
            error: function (xhr, status, error) {
                $("#btn-submit-profile").spin(false);
                $('.alert-box .msg').html('<h4>' + error + '</h4><br/>' + xhr.responseText);
                $('.alert-box').addClass('alert-danger');
                $('.alert-box').show();
            },
        });
        e.preventDefault();
    });
});
