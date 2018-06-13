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
    console.log('updateScheduleMain(d)' + d);
    $.ajax({
        type: 'GET',
        url: 'index.php/appointments/getAppointmentsForDay',
        //dataType: 'json',
        data: {date:d},
        success: function(data){
            $('#scheduleMain').html(data);
            $( '.portlet' )
                .addClass( 'ui-widget ui-widget-content ui-helper-clearfix ui-corner-all' )
                .find( '.portlet-header' )
                .addClass( 'ui-widget-header ui-corner-all' )
                .prepend( "<span class='ui-icon ui-icon-minusthick portlet-toggle'></span>");
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