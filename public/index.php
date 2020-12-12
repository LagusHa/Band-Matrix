<?php
error_reporting(0);
function debug($arr, $die = false){
    echo '<pre>' . print_r($arr, true) . '</pre>';
    if ($die) die();
}
$matrix = [
    [1 => 2,1,3,4,4,4,4,4,4,4,4,4,4,4,4,4,4,6],
    [1 => 4,4,4,5,7,8,9,10,11,12,13,14,15,16,17,18,19,8],
];

function createMatrix($matrix)
{
    for ($i = 1; $i < 20; $i++) {
        for ($j = 1; $j < 20; $j++) {
            $mass[$i][$j] = 0;
            $mass[$matrix[0][$j]][$matrix[1][$j]] = 1;
            $mass[$matrix[1][$j]][$matrix[0][$j]] = 1;
        }
    }
    echo "<br>";
    for ($i = 1; $i < 20; $i++) {
        for ($j = 1; $j < 20; $j++) {
            echo $mass[$i][$j] . " ";
        }
        echo "<br>";
    }
    debug($mass);
}
createMatrix($matrix);
