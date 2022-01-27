<!DOCTYPE html>
<html>
    <head>
        <title>Random stuff</title>
    </head>
    <body>
        <table>
            <tr>
                <?php

                $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

                foreach ($days as $day) {
                    echo '<td>' . $day . '</td>';
                }
                
                echo '</tr><tr>';
                $month = 'January';
                echo '<h2>'.$month.'</h2>';
                $startDay = date('N', strtotime($month . " 1"));
                $endDay = cal_days_in_month(CAL_GREGORIAN, 1, 2022);

                for ($i = 1; $i < $startDay; $i++) {
                    echo '<td></td>';
                }

                for ($i = 1; $i <= $endDay; $i++) {
                    echo '<td>' . $i . '</td>';
                    if (($i + $startDay) % 7 == 1) {
                        echo '</tr><tr>';
                    }
                }

                ?>
            </tr>
        </table>
    </body>
</html>