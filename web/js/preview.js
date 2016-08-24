/**
 * Created by nkmathew on 08/08/2016.
 */

var PREV_TEMPLATE = $("#logbook-preview-template").html();

// Displays all the entries for a certain week
function displayWeek(week) {
    $('#entry-list').data('week', week);
    $('#week-number').html(week);
    var url = '/site/preview-logbook?week=' + week;
    $("#entry-list").spin({color: 'black'});
    $.getJSON(url, function (json) {
        entries = ''
        $.each(json, function (index, val) {
            val.entry_for = moment(val.entry_for).format(FMT);
            var html = PREV_TEMPLATE(val);
            entries += html
        });
        $("#entry-list").spin(false);
        $('#entry-list').html(entries);
    });
}

function nextWeek() {
    curr = $('#entry-list').data('week');
    displayWeek(++curr);
}

function prevWeek() {
    curr = $('#entry-list').data('week');
    displayWeek(--curr);
}

$(document).ready(function () {
    PREV_TEMPLATE = Handlebars.compile(PREV_TEMPLATE);
    displayWeek(-2);
});
