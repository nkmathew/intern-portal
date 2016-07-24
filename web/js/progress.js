/**
 * Created by nkmathew on 24/07/2016.
 */

var fmt = 'D/M/Y';

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
function showInternshipCalendar(weeks, startDate) {
    startDate    = moment(startDate, fmt);
    var endDate  = moment(startDate).add(weeks, 'w');
    var endDate1 = moment(endDate).add(1, 'd');
    var date     = moment(startDate);
    var months   = [];
    while (date.isBefore(endDate1)) {
        var start = moment(date).startOf('month');
        var end   = moment(date).endOf('month');
        var arr = [start.format(fmt), end.format(fmt)];
        date1 = moment(date)
        date.add(1, 'd');
        if (!indexOfArray(arr, months)) {
            months.push(arr);
        }
    }
    for (var id = 1; id <= months.length; id++) {
        var start = moment(months[id-1][0], fmt),
            end = moment(months[id-1][1], fmt);
        if (start.isBefore(startDate)) {
            start = moment(startDate);
        }
        var dateOptions = {
                maxViewMode: 2,
                todayHighlight: true,
                startDate: start.toDate(),
                endDate: end.toDate(),
                beforeShowDay: function (date) {
                    var mdate = moment(date);
                    if (mdate.isBefore(endDate1)) {
                        if (date.getDay() == 0) {
                            return {classes: 'intern-day sunday'};
                        } else if (mdate.isSame(startDate)) {
                            return {classes: 'terminal-start-day'}
                        } else if (mdate.isSame(endDate)) {
                            return {classes: 'terminal-end-day'}
                        } else {
                            return {classes: 'intern-day'};
                        }
                    } else {
                        if (date.getDay() == 0) {
                            return {classes: 'sunday'};
                        }
                    }
                }
                ,
                toggleActive: true
            }
            ;

        $('#calendar-month-' + id).datepicker(dateOptions);
    }
}

$(document).ready(function () {
    showInternshipCalendar(10, '27/04/2016')
});
