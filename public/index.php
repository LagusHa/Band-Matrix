<?php
require_once 'file.php';
require_once 'outputToTxt.php';
require_once 'algoritm.php';
error_reporting(0);
?>
<form action="index.php" method="post">
    <p><b>Напишите название файла с вершинами</b></p>
    <input type="text" name="name" value="19x19.txt">
    <input type="submit">
</form>
<?php

if (!empty($_POST['name'])){
    $data = $_POST['name'];
    $matrix = getMatrix($data);
    $count = count(array_unique(array_merge($matrix[0],$matrix[1])));
    $mass = createMatrix($matrix,$count);
    $output = createNewMatrix($mass, $count);
    writeToTxt($output,$count);
}else{
    echo 'файл не выбран!';
}



