/**
 * Created by nkmathew on 24/07/2016.
 */

// var fmt = 'D/M/Y';
var fmt = 'Y-M-D';

function indexOfArray(val, array) {
    var hash = {}, i;
    for (i = 0; i < array.length; i++) {
        hash[array[i]] = i;
    }
    return hash.hasOwnProperty(val);
};

/*
 * Displays a calendar showing the start, finish of the internship and
 * highlights the days in between
 *
 * @param weeks Number of weeks
 * @param startDate A date of format dd/mm/yyyy
 */
function showInternshipCalendar(weeks, startDate, fmt) {
    fmt          = (fmt == undefined) ? 'D/M/Y' : fmt;
    startDate    = moment(startDate, fmt);
    var endDate  = moment(startDate).add(weeks, 'w');
    var endDate1 = moment(endDate).add(1, 'd');
    var date     = moment(startDate);
    var months   = [];
    var entryDates = $.ajax({url:'/site/progress?list-entry-dates', async:false}).responseJSON;
    while (date.isBefore(endDate1)) {
        var start = moment(date).startOf('month');
        var end   = moment(date).endOf('month');
        var arr   = [start.format(fmt), end.format(fmt)];
        date1     = moment(date)
        date.add(1, 'd');
        if (!indexOfArray(arr, months)) {
            months.push(arr);
        }
    }
    for (var id = 1; id <= months.length; id++) {
        var start = moment(months[id - 1][0], fmt),
            end   = moment(months[id - 1][1], fmt);
        if (start.isBefore(startDate)) {
            start = moment(startDate);
        }
        var dateOptions = {
            maxViewMode: 2,
            todayHighlight: true,
            startDate: start.toDate(),
            endDate: end.toDate(),
            beforeShowDay: function (date) {
                var mdate     = moment(date);
                var className = '';
                if (mdate.isBefore(endDate1)) {
                    if (date.getDay() == 0) {
                        className = 'intern-day sunday';
                    } else if (mdate.isSame(startDate)) {
                        className = 'terminal terminal-start-day';
                    } else if (mdate.isSame(endDate)) {
                        className = 'terminal terminal-end-day';
                    } else {
                        className = 'intern-day';
                    }
                } else {
                    if (date.getDay() == 0) {
                        className = 'sunday';
                    }
                }
                if (className.indexOf('intern-day') != -1) {
                    // Colour completed internship days
                    if (mdate.isBefore(moment())) {
                        className += ' completed-intern-day';
                    }
                    if (entryDates.indexOf(mdate.format('Y-MM-DD')) != -1) {
                        className += ' date-with-entry';
                    }
                }
                return {classes: className};
            },
        }
        $('#calendar-month-' + id).datepicker(dateOptions);
    }
}

/*
 * Shows a checkmark beside every date with an associated entry
 */
function revealEntries() {
    if ($('.date-with-entry').hasClass('date-with-entry-hl')) {
        $('.date-with-entry').removeClass('date-with-entry-hl');
        $('#btn-reveal-entries .label').text('Reveal Entries');
        $('#btn-reveal-entries div').removeClass('glyphicon-eye-close');
        $('#btn-reveal-entries div').addClass('glyphicon-eye-open');
    } else {
        $('#btn-reveal-entries .label').text('Hide Entries');
        $('.date-with-entry').addClass('date-with-entry-hl');
        $('#btn-reveal-entries div').removeClass('glyphicon-eye-open');
        $('#btn-reveal-entries div').addClass('glyphicon-eye-close');
    }
}

$(document).ready(function () {
    var startDate = $('#internship-calendars').data('startdate'),
        duration  = $('#internship-calendars').data('duration');
    showInternshipCalendar(duration, startDate, fmt);
    // Prevent days from being clicked
    $("#internship-calendars .day").bind('click', false);
});
