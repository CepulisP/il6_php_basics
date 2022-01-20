<!DOCTYPE html>
    <html>
    <head>
        <title>Random stuff</title>
    </head>
    <body>
        <table>
            <tr>
            <?php
            for ($i = 1; $i < 32; $i++) {
                echo '<td>'.$i . '</td>';
                if ($i % 7 == 0) {
                    echo '</tr><tr>';
                }
            }
            ?>
            </tr>
        </table>
    </body>
</html>