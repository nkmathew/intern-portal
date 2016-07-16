/**
 * Created by nkmathew on 05/07/2016.
 */

$(document).ready(function () {
    $("#profile-form").submit(function (e) {
        $("#btn-submit-profile").spin(BIG_SPINNER);
        var url = '/site/profile';
        $.ajax({
            type: 'POST',
            url: url,
            data: $("#profile-form").serialize(),
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
                $("#btn-invite-sender").spin(false);
                $('.alert-box .msg').html('<h4>' + error + '</h4><br/>' + xhr.responseText);
                $('.alert-box').addClass('alert-danger');
                $('.alert-box').show();
            },
        });
        e.preventDefault();
    });

    $('#profileform-startdate').datepicker({
        format: "dd/mm/yyyy",
        maxViewMode: 2,
        calendarWeeks: true,
        todayHighlight: true,
        endDate: '0',
        toggleActive: true,
        orientation: 'auto',
        todayBtn: true,
        beforeShowDay: function (date) {
            if (date.getDay() == 0 ||
                date.getDay() == 6) {
                // Disable weekends
                return false;
            }
        },
        startDate: '-3m'
    });
});
