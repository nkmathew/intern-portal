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
            var html = template({email: email});
            $('#email-list-section').append(html);
        }
    });

    $('.email-delete-btn').click(function () {
        $(this).closest('.email-line').remove();
    })
});
