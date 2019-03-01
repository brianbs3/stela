/* 
*   stela js file
*/


var $loading = null;


$(document).ready(function(){
    $loading = $('#spinner').hide();
})
.ajaxSend(function(event, jqxhr, settings){
    // Exclude checkin status checks from triggering the spinner, for sanity purposes
    if(settings.url.includes('getCheckinStatus')) return;
    $loading.show();
})
.ajaxStop(function() {
    $loading.hide();
});

$(window).resize(function(){
   //setupAppointmentPortlet();
});
let token='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6ImJyaWFuYnMzQGdtYWlsLmNvbSIsInBhc3MiOiJiZ3MiLCJpYXQiOjE1NDc3ODU1NTAsImV4cCI6MTU0Nzg3MTk1MH0.3_GuyUsCWwEwcSpDVxri8RlpHMG9fwOz9O2OQguNUvM';


function checkInForm(){
    const id = 0;
    const url = '/stela/index.php/CheckIn';
    const win = window.open(url, '_blank');
    win.focus();
}


function printElecLabels(){
    const url = '/stela/index.php/Labels/miniLabels/E';
    const win = window.open(url, '_blank');
    win.focus();
}