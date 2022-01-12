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
echo '<h2>Game history</h2>';
echo '<table>';
    foreach ($outcomes as $outcome){
        echo '<tr>';
        echo '<td><b>Player played: </b>'.$outcome[0].' </td>';
        echo '<td><b>PC played: </b>'.$outcome[1].'</td>';
        echo '<td><b>Game outcome: </b>'.$outcome[2].'</td>';
        echo '</tr>';
    }
echo '</table>';
