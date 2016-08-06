/**
 * Created by nkmathew on 05/07/2016.
 */

var TEMPLATE = $("#logbook-template").html();

function renderLogbookEntry(json, template) {
    json.updated1 = moment(parseFloat(json.updated)).fromNow();
    json.created1 = moment(parseFloat(json.created)).fromNow();
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
            $('#selected-date').html(moment(date).format(FMT));
            $("#selected-date").fadeIn(500).fadeOut(500).fadeIn(1000);
            $('#selected-date').data('requestedDate', moment(date).format('Y-M-D'));
            $('#logbook-entry-area').hide();
            if (CKEDITOR.instances['logbook-editor'] != undefined) {
                CKEDITOR.instances['logbook-editor'].updateElement();
                CKEDITOR.instances['logbook-editor'].destroy();
            }
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
    var requestedDate = $('#selected-date').data('requestedDate');
    var date = moment(requestedDate).format(FMT)
    $('#btn-save-logbook-label').text('Create entry for ' + date);
}

function saveLogbookEntry() {
    var url          = '/site/show-logbook?action=save';
    var content      = CKEDITOR.instances['logbook-editor'].getData()
    var time         = new Date().getTime();
    var selectedDate = $('#selected-date').data('requestedDate');
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
    CKEDITOR.config.wordcount = {
        showCharCount: true
    }

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
    });

    // When a different date is clicked in the calendar
    $(this).on('changeDate', function (event) {
        if (event.target.id == 'container-logbook-date') {
            var date = event.date;
            date = moment(date).format('Y-M-D');
            showLogbook(date);
        }
    });

   window.setInterval(function () {
       var created = $('#logbook-entry-area').data('created');
       var updated = $('#logbook-entry-area').data('updated');
       $('#entry-created').text(moment(created).fromNow());
       $('#entry-updated').text(moment(updated).fromNow());
   }, 1000);
});
