/**
 * Created by nkmathew on 08/08/2016.
 */

var PREV_TEMPLATE = $("#logbook-preview-template").html();

// Displays all the entries for a certain week
function displayWeek(week) {
    $('#entry-list').data('week', week);
    var url = '/site/preview-logbook?week=' + week;
    $("#entry-list").spin({color: 'black'});
    $.getJSON(url, function (json) {
        entryDays = [];
        startDate = json.start;
        $.each(json.entryList, function (index, val) {
            day = moment(val.entry_for).day();
            entryDays[day] = val;
        });
        entries = '';
        console.log(startDate)
        for (i = 0; i < 6; i++) {
            val = entryDays[i];
            if (val != undefined) {
                val.entry_for = moment(val.entry_for).format(FMT);
                var html      = PREV_TEMPLATE(val);
                entries += html
            } else {
               var html = PREV_TEMPLATE({
                   entry_class: 'missing-entry',
                   entry_for: moment(startDate).add(i, 'day').format(FMT),
                   entry: 'No Entry Found!',
                   center_class: 'centered-text',
                   entry_text_class: 'entry-text-centered'
               });
               entries += html;
            }
        }
        $("#entry-list").spin(false);
        $('#entry-list').html(entries);
        $('#week-number').html('Week ' + json.week);
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
    displayWeek(-1);
});
