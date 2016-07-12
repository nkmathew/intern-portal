/**
 * Created by nkmathew on 05/07/2016.
 */

var template = $("#logbook-template").html();

$(document).ready(function () {

    template = Handlebars.compile(template);

    $.getJSON('/site/show-logbook', function (json) {
        json.updated = moment.unix(json.updated).fromNow();
        json.created = moment.unix(json.created).fromNow();
        var html = template(json);
        $('#container-logbook').append(html);
    })

    $('#container-logbook-date').datepicker({
        format: "dd/mm/yyyy",
        maxViewMode: 2,
        todayBtn: true,
        todayHighlight: true,
        beforeShowDay: function (date) {
            if (date.getDay() == 0) {
                // Colour Sundays as red
                return {classes: 'sunday'}
            }
        },
        beforeShowMonth: function (date) {
            if (date.getMonth() == 8) {
                return false;
            }
        },
        datesDisabled: ['07/06/2016', '07/21/2016'],
        toggleActive: true
    })

    .on('changeDate', function (event) {
        console.log('Event: ' + JSON.stringify(event));
    });

    $('#btn-save-logbook').click(function (event) {
        $("#btn-save-logbook").spin({color: 'black'});
        var url = '/site/show-logbook?action=save';
        var txt = $('#logbook-text').val();
        var time = new Date().getTime();
        var selectedDate = $('#container-logbook-date').data('datepicker').viewDate;
        selectedDate = moment(selectedDate).format('Y-M-D');
        $.ajax({
            type: 'POST',
            url: url + '&entryDate=' + selectedDate,
            data: {
                entry: txt,
                created: time,
                updated: time,
                entry_for: selectedDate
            },
            success: function (data) {
                // Remove spinner
                $("#btn-save-logbook").spin(false);
            },
            error: function (xhr, status, error) {
                $("#btn-save-logbook").spin(false);
                $('.alert-box .msg').html('<h4>' + error + '</h4><br/>' + xhr.responseText);
                $('.alert-box').addClass('alert-danger');
                $('.alert-box').show();
            },
        });
    });
});
