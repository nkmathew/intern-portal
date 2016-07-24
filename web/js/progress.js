/**
 * Created by nkmathew on 24/07/2016.
 */

var fmt = 'D/M/Y';

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
    var id       = 0;
    while (date.isBefore(endDate1)) {
        id++;
        var start = moment(date).startOf('month');
        var end   = moment(date).endOf('month');

        if (start.isBefore(startDate)) {
            start = moment(startDate);
        }

        date.add(1, 'M');

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
    showInternshipCalendar(10, '14/06/2016')
});
