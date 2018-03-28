function productClick()
{
  $.ajax({
    type: 'GET',
    url: 'index.php/products/productList',
    //dataType: 'json',
    data: {},
    success: function(data){
      $('#stelaMain').html(data);
    //  toastr.success('Customer List Loaded');
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
