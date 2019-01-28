function appointmentsClick()
{
    $.ajax({
        type: 'GET', url: 'index.php/appointments',
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


function addAppointment(){
    let f = $('#newAppointmentForm').serializeArray();
    let d = $('#selectedAppointmentDate').val();
    $.ajax({
        type: 'POST',
        url: 'index.php/appointments/newAppointment',
        data: {form:f,date:d},
        success: function(data){
            console.log(data);
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
function clicked_appointment_chunk(chunk) {
    var stylistId = chunk.attr('id').split('_')[3];
    var date = $('#selectedDay').find('h3').html();
    $.ajax({
        type: 'GET',
        url: 'index.php/appointments/newAppointmentForm',
        data: {stylistId:stylistId, chunk:chunk.attr('id'), date:date},
        success: function(data){
          $('#newAppointment').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(jqXHR);
            if(jqXHR.status === 403)
                alert('403');
            if(jqXHR.readyState == 0)
                window.location.replace(global_site_redirect);
        }
    });
    
            dialog = $( "#newAppointment" ).dialog({
                title: 'Add Appointment',
                height: 400,
                width: 400,
                modal: true,
                buttons: {
                    "Add Appointment": addAppointment,
                    Close: function () {
                        dialog.dialog("close");
                    }
                },
            });
}

function clicked_existing_appointment(appt) {
  alert('clicked an existing appointment: ' + appt.attr('id'));
}
function updateScheduleMain(d){
    $('.appointmentPortlet').remove();
    $.ajax({
        type: 'GET',
        url: 'index.php/appointments/getAppointmentsForDay',
        //dataType: 'json',
        data: {date:d},
        success: function(data){
            $('#scheduleMain').html(data).append('<input type=hidden id=selectedAppointmentDate name=selectedAppointmentDate value="'+d+'">');;
            $('#appointmentsTableDiv').css('display', 'inline');
            var a = moment(d).format('MMMM Do YYYY');

            $('#selectedDay').html("<h3>" + a + "</h3>");
            $('.appointment_chunk').dblclick(function(){
              clicked_appointment_chunk($(this));
            });

            setupAppointmentPortlet()
            $('.appointmentPortlet').dblclick(function(){
                console.log($(this).offset);
              clicked_existing_appointment($(this));
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
        $('#checkin_' + id).removeClass('ui-icon-circle-check').addClass('ui-icon-locked');
        $(aptID).attr('axis', 'checkedOut');
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
        $.ajax({
            type: 'GET',
            url: 'index.php/appointments/checkoutReceipt',
            //dataType: 'json',
            data: {id:id},
            success: function(data){
                $('#appointmentReceiptDiv').html(data)
                .dialog({
                    title: 'Appointment Receipt',
                    height: 400,
                    width: 400,
                    modal: true,
                    buttons: {
                        "Print Receipt": printAppointmentReceipt,
                        Close: function () {
                            $(this).dialog("close");
                        }
                    },
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
    else if(axis === 'checkedOut'){
        $(aptID).removeClass('appointmentCheckedIn').addClass('appointmentCheckedOut');
        $(aptID).removeClass('appointmentCheckedOut');
        $('#checkin_' + id).removeClass('ui-icon-circle-check').addClass('ui-icon-check');
        $(aptID).attr('axis', 'notCheckedIn');
        $.ajax({
            type: 'GET',
            url: 'index.php/appointments/updateCheckIn',
            dataType: 'json',
            data: {id:id, checkinVal:0},
            success: function(data){
                console.log(data);
                if(data['insert'])
                    toastr.success('Reset Checkin Status!');
                else
                    toastr.error('Reset Checkin Status Failed!');
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
}

function updateCheckinStatus(id) {
    $.ajax({
        type: 'GET',
        url: 'index.php/appointments/getCheckinStatus',
        dataType: 'json',
        data: {id:id},
        success: function(data){
            console.log(data);
            setTimeout(function(){
                getCheckinStatus($this);
            }, 3000);
        },
        error: function(jqXHR, textStatus, errorThrown){
            if(jqXHR.status === 403)
                alert('403');
            if(jqXHR.readyState == 0)
                window.location.replace(global_site_redirect);
        }
    });
    
}

function setupAppointmentPortlet() {
    var tallest = 0;
    $('.appointmentPortlet').each(function(){ 
        var height = $(this).height();
        tallest = (tallest < height) ? height : tallest;
    });
    $('.appointment_chunk').height(tallest);
    $('.appointmentPortlet').each(function(){
        var id = $(this).attr('id');
        var apptId = id.split('_')[1];
        var duration = $('#appointment_' + apptId + '_duration').val();
        var time = $('#' + id + '_time').val().split(' ')[1];
        var stylistID = $('#' + id + '_stylist').val();
        var hour = parseInt(time.split(':')[0]);
        var tod = (hour > 12) ? 'PM' : 'AM';
        hour = (hour <= 12) ? hour : hour - 12;
        var minute = time.split(':')[1];
        var append_to = hour + '_' + minute + '_' + tod + '_' + stylistID;
        $($(this)).detach().appendTo('#' + append_to);
        $(this)
        .css('z-index', 5)
        .css('position', 'absolute')
        .position({
            my: 'left top',
            at: 'left top',
            of: $('#' + append_to)
        })
        .height(tallest * duration)
        .addClass('ui-widget ui-widget-content ui-helper-clearfix ui-corner-all')
        .find('.portlet-header')
        .addClass('ui-widget-header ui-corner-all')
        .prepend("<span class=\"ui-icon ui-icon-minusthick portlet-toggle asdf\"></span>");
    
    });

/*
    $('.appointmentPortlet').each(function(){
        var $this = $(this);
            setTimeout(function(){
                getCheckinStatus($this);
            }, 3000);
    });
*/
/*
    $('.appointmentPortlet').each(function(){
        var id = $(this).attr('id');
        var apptId = id.split('_')[1];
        $(this).height(tallest * duration);
    });
*/

}

function getCheckinStatus(id) {
    var apptId = id.attr('id').split('_')[1];
    updateCheckinStatus(apptId);
}

function printAppointmentReceipt()
{
    var productCost = $('#appointmentReceiptProductCost').val();
    var serviceCost = $('#appointmentReceiptServiceCost').val();
    var apptID = $('#appointmentReceiptID').val();
            // $('#appointmentReceiptPDFDiv').html('<iframe src="index.php/PDF/appointmentReceiptPDF?productCost=' + productCost + '&appointmentID=' + apptID + '&serviceCost=' + serviceCost + '" width=400 height=400></iframe>');  // This send to an iframe inline, can't print easily...
    var url = "index.php/PDF/appointmentReceiptPDF?productCost=" + productCost + '&appointmentID=' + apptID + '&serviceCost=' + serviceCost;
    window.open(url);
}
