<?php
function getMatrix($data)
{
    if (!empty($data)) {
        $file = fopen('19x19.txt', 'r');
        while (!feof($file)) {
            $line = fgets($file);
            $line = trim($line);
            $lines[] = $line;
        }
        fclose($file);
        $matrix = [];
        foreach ($lines as $string) {
            $row = explode(" ", $string);
            array_push($matrix, $row);
        }
        array_unshift($matrix[0], ' ');
        array_unshift($matrix[1], ' ');
        unset($matrix[0][0]);
        unset($matrix[1][0]);
        return $matrix;
    }
}