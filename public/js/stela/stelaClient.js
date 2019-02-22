function clientClick(term='')
{
  $.ajax({
    type: 'GET',
    //url: 'http://localhost:8080/clients',
    //crossDomain: true,
    url: 'index.php/clients/clientList',
    //dataType: 'json',
    data: {term:term},
    success: function(data){
      $('#stelaMain').html(data);
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
        type: 'GET',
        url: 'index.php/clients/generateClientForm',
        // dataType: 'json',
        data: {clientID: c},
        success: function (data) {
            var dialog = $('#clientFormDiv').html(data)
                .dialog({
                  title: 'Add/Update Client',
                  height: 800,
                  width: 1000,
                  modal: true,
                  buttons: {
                      "Add/Update Client": doClientUpdate,
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

function editClient(id){
  generateClientForm(id);
}

function doClientUpdate(dialog)
{
    $.ajax({
        type: 'POST',
        url: 'index.php/clients/processClientForm',
        dataType: 'json',
        data: {clientForm: $('#clientForm').serializeArray()},
        success: function (data) {
            var update = data['existing'];
            if(!data['existing'] && data['insertID']) {
                $('#clientFormClientID').val(data['insertID']);  
                toastr.success('New Client Added!');
            }
            else if(data['existing'] && data['insertID'])
                  toastr.success('Client data has been updated.');
            else
                toastr.warning('Nothing Changed');
        //re-draw the client table
            clientClick();
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

function editClientProfile(id){
    generateClientProfileForm(id);
}

function generateClientProfileForm(c){
    $.ajax({
        type: 'GET',
        url: 'index.php/clients/generateClientProfileForm',
        // dataType: 'json',
        data: {clientID: c},
        success: function (data) {
            var dialog = $('#clientProfileFormDiv').html(data)
                .dialog({
                    title: 'Add/Update Client Profile',
                    height: 800,
                    width: 1000,
                    modal: true,
                    buttons: {
                        "Add/Update Profile": doClientProfileUpdate,
                        "PDF": clientProfilePDF,
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

function doClientProfileUpdate(){
    $.ajax({
        type: 'POST',
        url: 'index.php/clients/processClientProfileForm',
        dataType: 'json',
        data: {clientProfileForm: $('#clientProfileForm').serializeArray()},
        success: function (data) {
            var update = data['existing'];
            if(!data['existing'] && data['insertID']) {
                $('#clientProfileFormClientID').val(data['insertID']);
                toastr.success('New Client Profile Added!');
            }
            else if(data['existing'] && data['insertID'])
                toastr.success('Client Profile data has been updated.');
            else
                toastr.warning('Nothing Changed');
            //re-draw the client table
            // clientClick();
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

function clientProfilePDF(){
    const id=$('#clientProfileFormClientID').val();
    const url = '/stela/index.php/PDF/clientProfilePDF?clientID=' + id;
    const win = window.open(url, '_blank');
    win.focus();
}

function clientDataForm(){
    const id = 0;
    const url = '/stela/index.php/PDF/clientProfilePDF?clientID=' + id;
    const win = window.open(url, '_blank');
    win.focus();
}

function filterClients(){
    const term = $('#clientFilter').val();
    clientClick(term);
}

function setupClientFilter(){
    $('#clientFilter').change(function(){
        clientClick($(this).val());
    });
}

function setupSignedFormInputs(){
    $('#signedClientFormDate').datepicker(
        {
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true
        }
    );
}