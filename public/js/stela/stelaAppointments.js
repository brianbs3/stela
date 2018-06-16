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
                .prepend("<span class=\"ui-icon ui-icon-minusthick portlet-toggle asdf\"></span>");

            $('.portlet').each(function(){
                var id = $(this).attr('id');
                var time = $('#' + id + '_time').val().split(' ')[1];
                var stylistID = $('#' + id + '_stylist').val();
                var hour = parseInt(time.split(':')[0]);
                var tod = (hour > 12) ? 'PM' : 'AM';
                hour = (hour <= 12) ? hour : hour - 12;
                var minute = time.split(':')[1];
                var append_to = hour + '_' + minute + '_' + tod + '_' + stylistID;

                // console.log('hour: ' + hour);
                // console.log('tod: ' + tod);
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

    var axis = $(aptID).attr('axis');
    if(axis === 'notCheckedIn') {
        $.ajax({
            type: 'GET',
            url: 'index.php/appointments/updateCheckIn',
            dataType: 'json',
            data: {id:id, checkinVal:1},
            success: function(data){
                console.log(data);
                if(data['insert'])
                    toastr.success('Check In Successful!');
                else
                    toastr.error('Check In Failed!');
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
                if(jqXHR.status === 403)
                    alert('403');
                if(jqXHR.readyState == 0)
                    window.location.replace(global_site_redirect);
            }
        });
        $(aptID).removeClass('appointmentNotCheckedIn').addClass('appointmentCheckedIn');
        $('#checkin_' + id).removeClass('ui-icon-check').addClass('ui-icon-circle-check');
        $(aptID).attr('axis', 'checkedIn');
    }
    else if(axis === 'checkedIn'){
        $(aptID).removeClass('appointmentCheckedIn').addClass('appointmentCheckedOut');
        $('#checkin_' + id).removeClass('ui-icon-check').addClass('ui-icon-circle-cross');
        $.ajax({
            type: 'GET',
            url: 'index.php/appointments/updateCheckIn',
            dataType: 'json',
            data: {id:id, checkinVal:2},
            success: function(data){
                console.log(data);
                if(data['insert'])
                    toastr.success('Check Out Successful!');
                else
                    toastr.error('Check Out Failed!');
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
    console.log('app id: ' + aptID);

}