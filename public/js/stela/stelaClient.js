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

$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  console.log(recipient)
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)

  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})