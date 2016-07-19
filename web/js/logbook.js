/**
 * Created by nkmathew on 05/07/2016.
 */

var TEMPLATE = $("#logbook-template").html();
var FMT = 'dddd, MMMM Do YYYY';

function renderLogbookEntry(json, template) {
    json.updated = moment(parseFloat(json.updated)).fromNow();
    json.created = moment(parseFloat(json.created)).fromNow();
    json.entryDate = moment(json.entry_for).format(FMT);
    var html     = template(json);
    $('#container-logbook').html(html);

    // Turn textarea into a rich text editor
    CKEDITOR.replace('logbook-editor');

    $('[data-toggle="tooltip"]').tooltip(); // Initialize description tooltips
}

function prevWeekDay() {
    // Find a weekday preceding today
    var today = moment();
    while (today.day() == 0 || today.day() == 6) {
        today = today.add(-1, 'd');
    }
    return today;
}

function showLogbook(date) {
    // Checks and shows the logbook entry for the specified date and if not found
    // shows a prompt for creating a new entry
    var url = '/site/show-logbook';
    if (date == undefined) {
        // Display the entry of a previous weekday day if a date is not supplied
        date = prevWeekDay().format('Y-M-D');
    }
    url += '?entryDate=' + date;
    $(".active.day").spin({color:'white',length:0,speed:1.4});
    $.getJSON(url, function (json) {
        $(".active.day").spin(false);
        console.log(url, json)
        if (!jQuery.isEmptyObject(json)) {
            $('#new-entry-prompt').hide();
            $('.entry-stats').show();
            $('#logbook-entry-area').show();
            renderLogbookEntry(json, TEMPLATE);
            $('#btn-delete-logbook').confirmation({
                onConfirm: function (event) {
                    var entryFor = $('#logbook-entry-area').data('entry-for')
                    var url = '/site/show-logbook?action=delete&entryDate=' + entryFor;
                    $.getJSON(url, function (json) {
                        alertSuccess(json.message);
                        var date = moment().format('Y-M-D');
                        showLogbook(date);
                    })
                },
            });
        } else {
            // Show the button for creating a new entry
            $('.entry-stats').hide();
            $('#new-entry-prompt').removeClass('hidden');
            $('#new-entry-prompt').show();
            $('#logbook-entry-area').hide();
            CKEDITOR.instances['logbook-editor'].updateElement();
            CKEDITOR.instances['logbook-editor'].destroy();
        }
    });
}

function prepareForNewEntry() {
    var html = TEMPLATE();
    $('#container-logbook').html(html);
    $('[data-toggle="tooltip"]').tooltip(); // Initialize description tooltips
    $('.entry-stats').hide();
    $('#new-entry-prompt').hide();
    $('#logbook-editor').hide();
    $('#logbook-entry-area').show();
    CKEDITOR.replace('logbook-editor');
    var selectedDate = $('#container-logbook-date').data('datepicker').viewDate;
    var date = moment(selectedDate).format(FMT)
    $('#btn-save-logbook-label').text('Create entry for ' + date);
}

function saveLogbookEntry() {
    var url          = '/site/show-logbook?action=save';
    var content      = CKEDITOR.instances['logbook-editor'].getData()
    var time         = new Date().getTime();
    var selectedDate = $('#container-logbook-date').data('datepicker').viewDate;
    selectedDate     = moment(selectedDate).format('Y-M-D');
    $("#logbook-entry-area").spin({color: 'black'});
    $.ajax({
        type: 'POST',
        url: url + '&entryDate=' + selectedDate,
        data: {
            entry: content,
            created: time,
            updated: time,
            entry_for: selectedDate
        },
        success: function (data) {
            // Remove spinner
            $("#logbook-entry-area").spin(false);
            showLogbook(selectedDate);
        },
        error: function (xhr, status, error) {
            $('.alert-box .msg').html('<h4>' + error + '</h4><br/>' + xhr.responseText);
            $('.alert-box').addClass('alert-danger');
            $('.alert-box').show();
            $("#logbook-entry-area").spin(false);
        },
    });
}

$(document).ready(function () {

    $('[data-toggle="popover"]').popover();

    $('#selected-date').html(prevWeekDay().format(FMT));

    TEMPLATE = Handlebars.compile(TEMPLATE);

    CKEDITOR.config.toolbar = [
        {
            name: 'basicstyles',
            items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']
        }, {
            name: 'paragraph',
            items: [
                'NumberedList', 'BulletedList', '-',
                'Outdent', 'Indent', '-', 'Blockquote',
                'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter',
                'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']
        }, {
            name: 'links',
            items: ['Link', 'Unlink', 'Anchor']
        },
    ];
    CKEDITOR.config.contentsCss = '/css/logbook.css';

    showLogbook();

    $('#container-logbook-date').datepicker({
        format: "dd/mm/yyyy",
        maxViewMode: 2,
        endDate: '0',
        todayBtn: true,
        todayHighlight: true,
        startDate: '-3m',
        beforeShowDay: function (date) {
            if (date.getDay() == 0 ||
                date.getDay() == 6) {
                // Disable weekends
                return false;
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
        if (event.target.id == 'container-logbook-date') {
            var date = event.date;
            $('#selected-date').html(moment(date).format(FMT));
            date = moment(date).format('Y-M-D');
            showLogbook(date);
        }
    });

    $('#save-logbook').click(function (event) {
    });

});
