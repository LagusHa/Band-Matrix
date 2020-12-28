<?php
function writeToTxt($matrix, $count){
    $file = 'optMatrix.txt';
    $lines = [];
    for ($i = 1; $i < $count + 1; $i++){
        foreach ($matrix[$i] as $k => $v){
            if ($v == 0){
                unset($matrix[$i][$k]);
            }
        }
    }
    for ($i = 1; $i < $count + 1; $i++){
        foreach ($matrix[$i] as $k => $v){
            if ("{$i}" . '-' ."{$k}" != "{$k}" . '-' ."{$i}")
            $lines[0][]= "{$i}" . '-' ."{$k}";
            $lines[1][] = $i;
            $lines[2][] = $k;

        }
    }
    for ($i = 0; $i < count($lines[1]); $i++){
        if (array_search($lines[2][$i] . "-" . $lines[1][$i], $lines[0])){
            unset($lines[0][$i]);
        }
    }
    unset($lines[1]);
    unset($lines[2]);
    //$data = serialize($lines[0]);
    file_put_contents($file, implode(PHP_EOL, $lines[0]));
}