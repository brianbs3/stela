/* 
*   stela js file
*/

$('document').ready(function(){
    setupMainPageLogin();
});
let token='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6ImJyaWFuYnMzQGdtYWlsLmNvbSIsInBhc3MiOiJiZ3MiLCJpYXQiOjE1NDc3ODU1NTAsImV4cCI6MTU0Nzg3MTk1MH0.3_GuyUsCWwEwcSpDVxri8RlpHMG9fwOz9O2OQguNUvM';

function handle_ajax_error(err) {
alert(jqXHR);
/*
    if(jqXHR.status === 403)
        alert('403');
    else if(jqHR.status === 511){
        alert('login has expired, need to handle this...');
    }
    else if(jqXHR.readyState == 0)
        window.location.replace(global_site_redirect);
*/
}

function doLogin() {
    let pin = $('#loginPin');
}

function setupMainPageLogin(){
    $('#loginPin').change(function(){
        let pin = $('#loginPin').val();
        $.ajax({
            type: 'POST',
            url: 'index.php/login/doLogin',
            dataType: 'json',
            data: {pin:pin},
            success: function(data){
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
                if(jqXHR.status === 403)
                    alert('403');
                if(jqXHR.readyState == 0)
                    window.location.replace(global_site_redirect);
            }
        });
    });

}
