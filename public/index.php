<?php
error_reporting(0);
function debug($arr, $die = false){
    echo '<pre>' . print_r($arr, true) . '</pre>';
    if ($die) die();
}
$matrix = [
//    [1 => 2,1,3,5,5,5,5,5,5,5,5,5,5,5,5,5,5,7],
//    [1 => 5,5,5,4,8,6,9,10,11,12,13,14,15,16,17,18,19,6],
    [1 => 2,1,3,4,4,4,4,4,4,4,4,4,4,4,4,4,4,6],
    [1 => 4,4,4,5,7,8,9,10,11,12,13,14,15,16,17,18,19,8],
];

$mass = createMatrix($matrix);
$avC = getNeighbor($mass);
createNewMatrix($mass);

function createMatrix($matrix)
{
    for ($i = 1; $i < 20; $i++) {
        for ($j = 1; $j < 20; $j++) {
            $mass[$i][$j] = 0;
            $mass[$matrix[0][$j]][$matrix[1][$j]] = 1;
            $mass[$matrix[1][$j]][$matrix[0][$j]] = 1;
        }
    }
    showMatrix($mass);
    echo getNeighbor($mass) . "<br>";
    return $mass;
}

function showMatrix($matrix){
    for ($i = 1; $i < 20; $i++) {
        for ($j = 1; $j < 20; $j++) {
            echo $matrix[$i][$j] . " ";
        }
        echo "<br>";
    }
}

function getNeighbor($matrix){
    for ($i = 1; $i < 20; $i++){
        foreach ($matrix[$i] as $k => $v){
            if ($v == 0){
                unset($matrix[$i][$k]);
            }
        }
    }
    $avC = getAverageCount($matrix);
    return $avC;
}

function getAverageCount($matrix){
    for ($i = 1; $i < 20; $i++) {
        foreach ($matrix[$i] as $k => $v) {
            $absCount[$i][$k] = abs($i - $k);
        }
    }
    for ($i = 1; $i < 20; $i++) {
        $avCount[$i] = max($absCount[$i]);
    }
    $averageCount = round(array_sum($avCount)/count($avCount), 5);
    return $averageCount;
}

function switchRowsAndColumns($mass, $a, $b)
{
    $tmp = $mass[$a];
    $mass[$a] = $mass[$b];
    $mass[$b] = $tmp;
    for ($i = 1; $i < 20; $i++) {
        $tmp = $mass[$i][$a];
        $mass[$i][$a] = $mass[$i][$b];
        $mass[$i][$b] = $tmp;
    }
    return $mass;
}

function createNewMatrix($matrix){
    $a = 1;
    $b = 2;
    $i = 0;
    $mass = $matrix;
    $av = getNeighbor($matrix);
    while ($i <3) {
        while ($b < 20) {
            $mass = switchRowsAndColumns($mass, $a, $b);
            $lengt = getNeighbor($mass);
            echo "<br>";
            showMatrix($mass);
            echo $lengt;
            if ($av > $lengt) {
                $av = $lengt;
                $matrix = $mass;
                $b++;
            } else {
                $mass = $matrix;
                $a = $b;
                $b++;
            }
        }
        $a = 1;
        $b = 2;
        $i++;
        echo "<br>";echo "<br>";echo "<br>";echo "<br>";
    }
}