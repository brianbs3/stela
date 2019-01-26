/* 
*   stela js file
*/

var $loading = null;

$(document).ready(function(){
    $loading = $('#spinner').hide();
})
.ajaxSend(function(event, jqxhr, settings){
    $loading.show();
})
.ajaxStop(function() {
    $loading.hide();
});

$(window).resize(function(){
   //setupAppointmentPortlet();
});
let token='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6ImJyaWFuYnMzQGdtYWlsLmNvbSIsInBhc3MiOiJiZ3MiLCJpYXQiOjE1NDc3ODU1NTAsImV4cCI6MTU0Nzg3MTk1MH0.3_GuyUsCWwEwcSpDVxri8RlpHMG9fwOz9O2OQguNUvM';
