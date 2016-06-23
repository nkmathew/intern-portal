/**
 * Created by nkmathew on 23/06/2016.
 */

$(document).ready(function () {
    var source   = $("#email-list-template").html();
    var template = Handlebars.compile(source);

    var html = template({email: 'ngetich.kipkoech@students.jkuat.ac.ke'});
    $('#email-list-section').append(html);
});
