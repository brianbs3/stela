function clientClick()
{
  $.ajax({
    type: 'GET',
    url: 'http://localhost:8080/clients',
    crossDomain: true,
    //url: 'index.php/clients/clientList',
    dataType: 'json',
    data: {token:token},
    success: function(data){
      $.each(data, function(k, v){
        $('#stelaMain').append('k: ' + k);
        $('#stelaMain').append('v: ' + v['firstName']);
      });
      $('#stelaMain').append('hey');
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
            var noteTable = $('<table id="noteTable">').addClass('table').addClass('table-striped');
            // var noteThead = $('<thead class="thead-dark"><th>Time</th><th>Note</th>');
            // noteTable.append(noteThead);

            $.each(data['notes'], function(k, v){
                var noteTr = $('<tr>');
                var tsTd = $('<td>').text(moment(v['ts']).format('MMMM Do YYYY - h:mm:ss A'));
                var noteTd = $('<td>').text(v['note']);
                noteTr.append(tsTd);
                noteTr.append(noteTd);
                noteTable.append(noteTr);
            });

            $('#clientNotes').html(noteTable);
            $('#clientNotes')
                .append("<hr><textarea id=noteTextArea rows='5' cols='50'></textarea>")
                .append("<input type=hidden id=noteClientId value=" + id + ">");
            dialog = $( "#clientNotes" ).dialog({
                title: title,
                height: 500,
                width: 1000,
                modal: true,
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

function addNote(){
  var id = $('#noteClientId').val();
  var note = $('#noteTextArea').val();
  if(note) {
      $.ajax({
          type: 'POST',
          url: 'index.php/clients/addClientNote',
          dataType: 'json',
          data: {clientId: id, note: note},
          success: function (data) {
              if (data['insert']) {
                  toastr.success('Customer Note Added');

                  var noteTr = $('<tr>');
                  var tsTd = $('<td>').text('Just Now');
                  var noteTd = $('<td>').text(data['note']);
                  noteTr.append(tsTd);
                  noteTr.append(noteTd);
                  $('#noteTable').append(noteTr);
                  $('#noteTextArea').val('');
              }
              else {
                  toastr.error('Customer Note Was Not Added');
              }
          },
          error: function (jqXHR, textStatus, errorThrown) {
              console.log(jqXHR);
              // if(jqXHR.status === 403)
              //   alert('403');
              // if(jqXHR.readyState == 0)
              //   window.location.replace(global_site_redirect);
          }
      });
  }
  else
      toastr.error('You must type in something.');
}

function generateClientForm(c){


    $.ajax({
        type: 'POST',
        url: 'index.php/clients/generateClientForm',
        // dataType: 'json',
        // data: {clientId: id, note: note},
        success: function (data) {
            var dialog = $('#clientFormDiv').html(data)
                .dialog({
                  title: 'Add/Update Client',
                  height: 500,
                  width: 1000,
                  modal: true,
                  buttons: {
                      "Add Client": doClientUpdate,
                      Close: function () {
                          dialog.dialog("close");
                      }
                  },
              });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            // if(jqXHR.status === 403)
            //   alert('403');
            // if(jqXHR.readyState == 0)
            //   window.location.replace(global_site_redirect);
        }
    });
}

function addClient(){
  generateClientForm(null);
}

function doClientUpdate()
{
  $.ajax({
    type: 'POST',
    url: 'index.php/clients/processClientForm',
    // dataType: 'json',
    data: {clientForm: $('#clientForm').serializeArray()},
    success: function (data) {
      console.log(data);
    },
    error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR);
        // if(jqXHR.status === 403)
        //   alert('403');
        // if(jqXHR.readyState == 0)
        //   window.location.replace(global_site_redirect);
    }
  });
}
