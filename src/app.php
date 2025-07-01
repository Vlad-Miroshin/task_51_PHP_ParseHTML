<?php

require_once('iter.php');

//--- прочитать и вывести значения указанных тегов

$source_file = 'page.html';

$iter = new ElementIterator($source_file);

echo PHP_EOL;
foreach ($iter as $key => $val) {
    echo $key . ': ' . $val . PHP_EOL;
}
echo PHP_EOL;

