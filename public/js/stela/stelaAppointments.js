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