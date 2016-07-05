/**
 * Created by nkmathew on 05/07/2016.
 */

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
