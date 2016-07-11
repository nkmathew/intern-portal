/**
 * Created by nkmathew on 05/07/2016.
 */

$(document).ready(function () {
    $('#container-logbook-date').datepicker({
        format: "dd/mm/yyyy",
        maxViewMode: 2,
        todayBtn: true,
        todayHighlight: true,
        beforeShowDay: function (date) {
            if (date.getDay() == 0) {
                // Colour Sundays as red
                return { classes: 'sunday' }
            }
        },
        beforeShowMonth: function (date) {
            if (date.getMonth() == 8) {
                return false;
            }
        },
        datesDisabled: ['07/06/2016', '07/21/2016'],
        toggleActive: true
    });
})
