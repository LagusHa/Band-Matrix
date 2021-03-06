<?php
function debug($arr, $die = false){
    echo '<pre>' . print_r($arr, true) . '</pre>';
    if ($die) die();
}

function createMatrix($matrix, $count)
{
    for ($i = 1; $i < $count + 1; $i++) {
        for ($j = 1; $j < $count + 1; $j++) {
            $mass[$i][$j] = 0;
            $mass[$matrix[0][$j]][$matrix[1][$j]] = 1;
            $mass[$matrix[1][$j]][$matrix[0][$j]] = 1;
        }
    }
    showMatrix($mass, $count);
    echo getNeighbor($mass, $count) . "<br>";
    return $mass;
}
?>
<?php
function showMatrix($matrix, $count){
    for ($i = 1; $i < $count + 1; $i++) {
        for ($j = 1; $j < $count + 1; $j++) {
            echo $matrix[$i][$j] . " ";
        }
        echo "<br>";
    }
}
?>
<?php
function getNeighbor($matrix, $count){
    for ($i = 1; $i < $count + 1; $i++){
        foreach ($matrix[$i] as $k => $v){
            if ($v == 0){
                unset($matrix[$i][$k]);
            }
        }
    }
    $avC = getAverageCount($matrix, $count);
    return $avC;
}

function getAverageCount($matrix, $count){
    for ($i = 1; $i < $count + 1; $i++) {
        foreach ($matrix[$i] as $k => $v) {
            $absCount[$i][$k] = abs($i - $k);
        }
    }
    for ($i = 1; $i < $count + 1; $i++) {
        $avCount[$i] = max($absCount[$i]);
    }
    $averageCount = round(array_sum($avCount)/count($avCount), 5);
    return $averageCount;
}

function switchRowsAndColumns($mass, $a, $b, $count)
{
    $tmp = $mass[$a];
    $mass[$a] = $mass[$b];
    $mass[$b] = $tmp;
    for ($i = 1; $i < $count + 1; $i++) {
        $tmp = $mass[$i][$a];
        $mass[$i][$a] = $mass[$i][$b];
        $mass[$i][$b] = $tmp;
    }
    return $mass;
}
//Можно сделать лучше (отрефакторить)
function createNewMatrix($matrix, $count){
    $i = 0;
    $mass = $matrix;
    $av = getNeighbor($matrix, $count);
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
            $mass = switchRowsAndColumns($mass, $a, $b, $count);
            $lengt = getNeighbor($mass, $count);
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
    showMatrix($mass, $count);
    echo $lengt;
    return $mass;
}