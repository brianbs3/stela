<div class="container-fluid">
    <div class="row">
        <div class="col-2">
            <div id="datepicker"></div>
        </div>
        <div class="col-10 appointments-right">
            <div id=scheduleMain></div>
            <table width="100%">
                <thead><th>Time</th>
                <?php
                    foreach($stylists as $s)
                        echo"<th>{$s['lastName']}</th>";
                ?>
                </th></thead>

            </table>
        </div>
</div>




<script>
  $( function() {
    $( "#datepicker" ).datepicker({
     numberOfMonths: [2,1],
     showButtonPanel: true,
     dateFormat: 'yy-mm-dd',
     onSelect: function(d){
        updateScheduleMain(d);
//        $('#scheduleMain').html(d);
     },
//     changeMonth: true,
//     changeYear: true
    });
  } );
  </script>
