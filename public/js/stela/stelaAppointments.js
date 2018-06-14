function appointmentsClick()
{
    $.ajax({
        type: 'GET',
        url: 'index.php/appointments',
        //dataType: 'json',
        data: {},
        success: function(data){
            $('#stelaMain').html(data);
            // toastr.success('Appointments List Loaded');
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(jqXHR);
            if(jqXHR.status === 403)
                alert('403');
            if(jqXHR.readyState == 0)
                window.location.replace(global_site_redirect);
        }
    });
}

function updateScheduleMain(d){
    $('.appointmentPortlet').remove();
    $.ajax({
        type: 'GET',
        url: 'index.php/appointments/getAppointmentsForDay',
        //dataType: 'json',
        data: {date:d},
        success: function(data){
            $('#scheduleMain').html(data);
            var a = moment(d).format('MMMM Do YYYY');

            $('#selectedDay').html("<h3>" + a + "</h3>");

            $('.portlet').draggable({snap: false})
                .addClass('ui-widget ui-widget-content ui-helper-clearfix ui-corner-all')
                .find('.portlet-header')
                .addClass('ui-widget-header ui-corner-all')
                .prepend("<span class='ui-icon ui-icon-minusthick portlet-toggle'></span>");

            $('.portlet').each(function(){
                var id = $(this).attr('id');
                var time = $('#' + id + '_time').val().split(' ')[1];
                var stylistID = $('#' + id + '_stylist').val();
                var hour = parseInt(time.split(':')[0]);
                var tod = (hour > 12) ? 'PM' : 'AM';
                hour = (hour <= 12) ? hour : hour - 12;
                var minute = time.split(':')[1];
                var append_to = hour + '_' + minute + '_' + tod + '_' + stylistID;

                console.log('hour: ' + hour);
                console.log('tod: ' + tod);
                $($(this)).detach().appendTo('#' + append_to);
            });
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(jqXHR);
            if(jqXHR.status === 403)
                alert('403');
            if(jqXHR.readyState == 0)
                window.location.replace(global_site_redirect);
        }
    });
}

function checkIn(id){
    var aptID = '#appointment_' + id;
    $(aptID).css('background-color', 'red');
    $('#checkin_' + id).removeClass('ui-icon-check').addClass('ui-icon-circle-check');
    console.log('app id: ' + aptID);

}