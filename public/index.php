<?php
require_once 'file.php';
error_reporting(0);
function debug($arr, $die = false){
    echo '<pre>' . print_r($arr, true) . '</pre>';
    if ($die) die();
}
?>
<form action="index.php" method="post">
    <p><b>Выберите файл с матрицей</b></p>
    <input type="text" name="name" value="19x19.txt">
    <input type="submit">
</form>
<?php

if (!empty($_POST['name'])){
    $data = $_POST['name'];
    $matrix = getMatrix($data);
    $mass = createMatrix($matrix);
    $avC = getNeighbor($mass);
    createNewMatrix($mass);
}
//$matrix = [
////    [1 => 2,1,3,5,5,5,5,5,5,5,5,5,5,5,5,5,5,7],
////    [1 => 5,5,5,4,8,6,9,10,11,12,13,14,15,16,17,18,19,6],
//    [1 => 2,1,3,4,4,4,4,4,4,4,4,4,4,4,4,4,4,6],
//    [1 => 4,4,4,5,7,8,9,10,11,12,13,14,15,16,17,18,19,8],
//];
//


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
//Можно сделать лучше (отрефакторить)
function createNewMatrix($matrix){
    $i = 0;
    $mass = $matrix;
    $av = getNeighbor($matrix);
    foreach ($mass as $k => $v){
       $stack[$i][$k] = $k;
    }
    array_pop($stack[$i]);
    sort($stack[$i]);
    $c = 0;
    $d = 1;
    $a = $stack[$i][$c];
    $b = $stack[$i][$d];
    $empiricalСycle = round(3 + count($stack[1])/100, 0);
    while ($i < $empiricalСycle) {
        while ($b < count($stack[$i])) {
            $mass = switchRowsAndColumns($mass, $a, $b);
            $lengt = getNeighbor($mass);
            if ($av > $lengt) {
                $av = $lengt;
                $matrix = $mass;
                $stack[$i+1][] = $b;
                //array_push($stack[$i+1], $b);
                $d++;
                $b = $stack[$i][$d];
            } else {
                $mass = $matrix;
                $stack[$i+1][] = $a;
                //array_push($stack[$i+1], $a);
                $a = $b;
                $d++;
                $b = $stack[$i][$d];
            }
        }
    $stack[$i+1][] = $a;
    $stack[$i+1][] = $b;
    $c = 0;
    $d = 1;
    $a = $stack[$i+1][$c];
    $b = $stack[$i+1][$d];
    $i++;
    }
    echo "<br>";
    showMatrix($mass);
    echo $lengt;
}

