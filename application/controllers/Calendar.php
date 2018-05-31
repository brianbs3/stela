<?php
require_once('Stela.php');


class Calendar extends Stela {
    public function index()
    {
        echo"calendar";
    }

    public function printCalendar($month=0,$year=0){

        echo"<table border=1><thead>";
        $dowArr = array('Sun', 'Mon', 'Tue','Wed', 'Thur', 'Fri', 'Sat');
        foreach($dowArr as $dow) {
            echo "<th>$dow</th>";
        }
        echo"</thead>";
        echo"<tr>";
        for($day = 0; $day < 31; $day++) {
            echo"<td>$day</td>";
            for ($w = 0; $w < 6; $w++) {
                echo"</tr><tr>";
            }
        }
        echo"</tr>";
        echo"</table>";

    }
}