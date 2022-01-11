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
