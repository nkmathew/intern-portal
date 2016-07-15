/**
 * Created by nkmathew on 05/07/2016.
 */

var TEMPLATE = $("#logbook-template").html();

function renderLogbookEntry(json, template) {
    json.updated = moment(parseFloat(json.updated)).fromNow();
    json.created = moment(parseFloat(json.created)).fromNow();
    var html     = template(json);
    $('#container-logbook').html(html);
    $('[data-toggle="tooltip"]').tooltip(); // Initialize description tooltips
}

function showLogbook(date) {
    // Checks and shows the logbook entry for the specified date and if not found
    // shows a prompt for creating a new entry
    var url = '/site/show-logbook';
    if (date !== undefined) {
        url += '?entryDate=' + date;
    }
    $.getJSON(url, function (json) {
        console.log(url, json)
        if (!jQuery.isEmptyObject(json)) {
            $('#new-entry-prompt').hide();
            $('.entry-stats').show();
            $('#logbook-entry-area').show();
            renderLogbookEntry(json, TEMPLATE)
        } else {
            $('.entry-stats').hide();
            $('#new-entry-prompt').removeClass('hidden');
            $('#new-entry-prompt').show();
            $('#logbook-entry-area').hide();
        }
    });
}

function promptForNewEntry() {
    var html = TEMPLATE();
    $('#container-logbook').html(html);
    $('[data-toggle="tooltip"]').tooltip(); // Initialize description tooltips
    $('.entry-stats').hide();
    $('#new-entry-prompt').hide();
    $('#logbook-entry-area').show();
    var selectedDate = $('#container-logbook-date').data('datepicker').viewDate;
    var date = moment(selectedDate).format('dddd, MMMM Do YYYY')
    $('#btn-save-logbook-label').text('Create entry for ' + date);
}

function saveLogbookEntry() {
    console.log('Saving logbook')
    $('#btn-save-logbook').confirmation({
        onConfirm: function () {
            console.log('Confirmed')
            alert('Confirmed')
        }
    });
    var url          = '/site/show-logbook?action=save';
    var txt          = $('#logbook-text').val();
    var time         = new Date().getTime();
    var selectedDate = $('#container-logbook-date').data('datepicker').viewDate;
    selectedDate     = moment(selectedDate).format('Y-M-D');
    $("#btn-save-logbook").spin({color: 'black'});
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
}

$(document).ready(function () {

    $('[data-toggle="popover"]').popover();

    TEMPLATE = Handlebars.compile(TEMPLATE);

    showLogbook();

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

    // When a different date is clicked in the calendar
    $(this).on('changeDate', function (event) {
        var date = event.date;
        date     = moment(date).format('Y-M-D');
        showLogbook(date);
    });

    $('#save-logbook').click(function (event) {
    });

});
