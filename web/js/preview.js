/**
 * Created by nkmathew on 08/08/2016.
 */

var PREV_TEMPLATE = $("#logbook-preview-template").html();

// Displays all the entries for a certain week
function displayWeek(week) {
    var url = '/site/preview-logbook?week=' + week;
    $.getJSON(url, function (json) {
        console.log(json)
        $.each(json, function (index, val) {
            val.entry_for = moment(val.entry_for).format(FMT);
            var html = PREV_TEMPLATE(val);
            $('#entry-list').append(html);
        })
    });
}

$(document).ready(function () {
    PREV_TEMPLATE = Handlebars.compile(PREV_TEMPLATE);
    displayWeek();
});
