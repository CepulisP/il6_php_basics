<?php

include 'core.php';

echo '<br>';
echo 'The Game';
echo '<br>';

$tools = [
    TOOL_ROCK => 'Rock',
    TOOL_PAPER => 'Paper',
    TOOL_SCISSORS => 'Scissors',
];

echo '<form action="http://localhost/pamokos/thegame/index.php" method="POST">';
    echo '<select name="tool">';
        foreach ($tools as $key => $tool){
            echo '<option value="'.$key.'">'.$tool.'</option>';
        }
    echo '</select>';
    echo '<br>';
    echo '<input type="submit" value="Play" name="play">';
echo '</form>';

$outcomes = readFromCsv('outcomes.csv');
echo '<h3>Game history</h3>';
echo '<table>';
    foreach ($outcomes as $outcome){
        echo '<tr>';
        echo '<td><b>Player played: </b>'.$outcome[0].' </td>';
        echo '<td><b>PC played: </b>'.$outcome[1].'</td>';
        echo '<td><b>Game outcome: </b>'.$outcome[2].'</td>';
        echo '</tr>';
    }
echo '</table>';
echo '<h3>Last 10 games</h3>';

$data = array_reverse($outcomes);
$counter = 0;
$rez = [1 => 0, 2 => 0];

foreach ($data as $row){
    if (!empty($row)){
        if ($row[2] == 'Player_won'){
            $rez[1]++;
        }elseif ($row[2] == 'Player_lost'){
            $rez[2]++;
        }
        $counter++;
        if ($counter > 9){
            break;
        }
    }
}

echo 'Player '. $rez[1] . ':' . $rez[2] . ' PC';

echo '<br>';

if ($rez[1] > $rez[2]){
    echo 'Player wins';
}elseif($rez[1] < $rez[2]){
    echo 'PC wins';
}else{
    echo 'Draw';
}