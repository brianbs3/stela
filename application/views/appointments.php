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
                <tbody>
                <?php
                    $startHour = 8;
                    $endHour = 16;
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
                                        $tbl .= "<td>{$s['firstName']}</td>";
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
