/**
 * Created by nkmathew on 05/07/2016.
 */

$(document).ready(function () {
    $('#sandbox-container div').datepicker({
        format: "dd/mm/yyyy",
        maxViewMode: 2,
        // todayBtn: true,
        // daysOfWeekDisabled: "2,3,4",
        // daysOfWeekHighlighted: "2,4",
        calendarWeeks: true,
        todayHighlight: true,
        beforeShowDay: function (date){
            if (date.getMonth() == (new Date()).getMonth())
                switch (date.getDate()){
                    case 4:
                        return {
                            tooltip: 'Example tooltip',
                            // classes: 'active'
                        };
                    case 8:
                        return false;
                    case 12:
                        return "green";
                }
        },
        beforeShowMonth: function (date){
            if (date.getMonth() == 8) {
                return false;
            }
        },
        datesDisabled: ['07/06/2016', '07/21/2016'],
        toggleActive: true
    });
})
