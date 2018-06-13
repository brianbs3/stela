<div class="container-fluid">
    <div class="row">
        <div class="col-2">
        <div id='calendar'></div>
        </div>
        <div class="col-10 appointments-right">
            Appointment Details here...
        </div>
</div>
<br><br><hr><br>

<script type=text/javascript>
$('#calendar').fullCalendar({
    defaultView: 'month',

    header: {
      center: 'addEventButton'
    },

    customButtons: {
      addEventButton: {
        text: 'add event...',
        click: function() {
          var dateStr = prompt('Enter a date in YYYY-MM-DD format');
          var date = moment(dateStr);

          if (date.isValid()) {
            $('#calendar').fullCalendar('renderEvent', {
              title: 'dynamic event',
              start: date,
              allDay: true
            });
            alert('Great. Now, update your database...');
          } else {
            alert('Invalid date.');
          }
        }
      }
    }
  });
</script>
