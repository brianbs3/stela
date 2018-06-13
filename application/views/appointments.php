<br><h1 align="center">Appointments</h1><br>
<div class="container-fluid">
    <div class="row">
        <div class="col-2">
            <div id="datepicker"></div>
        </div>
        <div class="col-10 appointments-right">
            <div id="selectedDay">Select a day...</div>
            <div id=scheduleMain></div>
            <div class=scheduleToolbar id="scheduleToolbar">Appointments Toolbar Goes Here...</div>
            <br>
      <!--      <table class='table table-striped'>
                <thead class='thead-dark'> -->
                <table width="100%" border="1">
                    <thead align="center" class="appointmentsThead">
            <th>Time</th>
                <?php
                    foreach($stylists as $s) {
                        $fInitial = substr($s['firstName'],0,1);
                        echo "<th>{$s['lastName']} $fInitial</th>";
                    }
                ?>
                </th></thead>
                <tbody>
                <?php
                    $startHour = 8;
                    $endHour = 17;
                    $minChunk = 15;
                    $showAMPM = true;
                    $tod = "";
                    $tbl = "";
                    for($i = $startHour; $i <= $endHour; $i++) {
                        $h = ($i > 12) ? $i - 12 : $i;
                        for($j = 0; $j <= 45; $j++) {
                            if ($j % $minChunk == 0) {
                                $m = ($j == 0) ? "00" : $j;
                                if($showAMPM)
                                    $tod = ($i > 12) ? "PM" : "AM";
                                if($h != 16 && $m != 45)
                                {
                                    $tbl .= "
                                    <tr>
                                        <td width=\"10%\" align=\"center\">$h:$m $tod</td>
                                        ";
                                    foreach($stylists as $s){
                                        $tbl .= "<td id='{$h}_{$m}_{$tod}_{$s['id']}'></td>";
                                    }
                                    $tbl .= "</tr>";

                                }
                            }
                        }
                    }
                echo $tbl;
                ?>

                </tbody>
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
