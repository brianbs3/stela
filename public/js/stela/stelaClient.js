function clientClick()
{
  $.ajax({
    type: 'GET',
    url: 'index.php/clients/clientList',
    //dataType: 'json',
    data: {},
    success: function(data){
      $('#stelaMain').html(data);
      // toastr.success('Customer List Loaded');
    },
    error: function(jqXHR, textStatus, errorThrown){
      console.log(jqXHR);
      // if(jqXHR.status === 403)
      //   alert('403');
      // if(jqXHR.readyState == 0)
      //   window.location.replace(global_site_redirect);
    }
  });
}

function showClientNotes(id){
    console.log('show notes for: ' + id);
    $.ajax({
        type: 'GET',
        url: 'index.php/clients/getClientNotes',
        dataType: 'json',
        data: {id:id},
        success: function(data){
            console.log(data);
            var title = (data['firstName']) ? 'Notes for ' + data['firstName'] + ' ' + data['lastName'] : 'No Notes for this client';
            $('#clientNotes').html('');
            var notes = "";
            var noteTable = $('<table>').addClass('table').addClass('table-striped');
            // var noteThead = $('<thead class="thead-dark"><th>Time</th><th>Note</th>');
            // noteTable.append(noteThead);

            $.each(data['notes'], function(k, v){
                var noteTr = $('<tr>');
                var tsTd = $('<td>').text(moment(v['ts']).format('MMMM Do YYYY - h:mm:ss A'));
                var noteTd = $('<td>').text(v['note']);
                noteTr.append(tsTd);
                noteTr.append(noteTd);
                noteTable.append(noteTr);
                // $('#appointmentClientNotes').append(v['ts'] + " - " + v['note'] + "<br>");
            });
            $('#clientNotes').html(noteTable);
            $('#clientNotes').append("<br><br><hr><textarea rows='5' cols='50'></textarea>");
            dialog = $( "#clientNotes" ).dialog({
                title: title,
                height: 500,
                width: 1000,
                modal: false,
                buttons: {
                    "Add Note": addNote,
                    Close: function () {
                        dialog.dialog("close");
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