function customerClick()
{
  $.ajax({
    type: 'GET',
    url: 'index.php/customers/list',
    //dataType: 'json',
    data: {},
    success: function(data){
      $('#stelaMain').html(data);
    //  $.each(data, function(k, v) {
     //   $('#stelaMain').append(`${v.firstName} ${v.lastName}<br>`);
      //});
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

function productClick()
{
  $('#stelaMain').html('clicked on products');
}
