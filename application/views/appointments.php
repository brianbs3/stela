<div class="container-fluid">
    <div class="row">
        <div class="col-sm appointments-left">
        </div>
        <div class="col-lg appointments-right">
            col 2
        </div>
</div>
<br><br><hr><br>
<div id='calendar'></div>
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
