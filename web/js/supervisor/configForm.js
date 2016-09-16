/**
 * Created by nkmathew on 20/09/2016.
 */
$(document).ready(function () {
    var config = {
        template: false,
        showInputs: false,
        minuteStep: 5,
        maxHours: 24,
        explicitMode: true,
        showMeridian: false
    };
    $('#starting-hour').timepicker(config);
    $('#closing-hour').timepicker(config);
});
