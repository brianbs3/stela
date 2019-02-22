function productClick(term = '')
{
  $.ajax({
    type: 'GET',
    url: 'index.php/Product/productList',
    //dataType: 'json',
    data: {term:term},
    success: function(data){
      $('#stelaMain').html(data);
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

function addProduct(){
    generateProductForm(null);
}

function editProduct(id){
    generateProductForm(id);
}

function generateProductForm(c){
    $.ajax({
        type: 'GET',
        url: 'index.php/product/generateProductForm',
        // dataType: 'json',
        data: {productID: c},
        success: function (data) {
            var dialog = $('#productFormDiv').html(data)
                .dialog({
                    title: 'Add/Update Product',
                    height: 600,
                    width: 1000,
                    modal: true,
                    buttons: {
                        "Add/Update Product": doProductUpdate,
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

function doProductUpdate(){
    $.ajax({
        type: 'POST',
        url: 'index.php/product/processProductForm',
        dataType: 'json',
        data: {productForm: $('#productForm').serializeArray()},
        success: function (data) {
            var update = data['existing'];
            if(!data['existing'] && data['insertID']) {
                $('#producttFormProductID').val(data['insertID']);
                toastr.success('New Product Added!');
            }
            else if(data['existing'] && data['insertID'])
                toastr.success('Product data has been updated.');
            else
                toastr.warning('Nothing Changed');
            //re-draw the product table
            productClick();
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

function filterProduct(){
    const term = $('#productFilter').val();
    productClick(term);
}

function setupProductFilter(){
    $('#productFilter').change(function(){
        productClick($(this).val());
    });
}

function productBarcodePDF(){
    const url = '/stela/index.php/PDF/productBarcodes';
    const win = window.open(url, '_blank');
    win.focus();
}
