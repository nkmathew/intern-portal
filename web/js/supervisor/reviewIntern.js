/**
 * Created by nkmathew on 18/09/2016.
 */

function displayReview(id, type, dateRange) {
    $('#modal-reviewForm').spin();
    $('.modal-body').html('');
    url = '/site/fetch-review?id=' + id + '&' + type + '&dateRange=' + dateRange;
    // $('.modal-body').load('/site/fetch-review?id=' + id + '&' + type + '&dateRange=' + dateRange);
    $.ajax({
        type: 'GET',
        url: url,
        success: function (data) {
            $('#modal-reviewForm').spin(false);
            $('.modal-body').html(data);
            bindSubmitButton();
        },
    });
}

function bindSubmitButton() {
    $("#review-form").submit(function (e) {
        $("#btn-submit-profile").spin(BIG_SPINNER);
        var url = '/site/save-review';
        $.ajax({
            type: 'POST',
            url: url,
            data: $("#review-form").serialize(),
            success: function (data) {
                alertMessage(data);
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
}

$(document).ready(function () {
});
