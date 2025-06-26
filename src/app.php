<?php

require_once('lib.php');

//--- прочитать и вывести значения указанных тегов

$source_file = 'page.html';
$target_file = 'page_clean.html';

$values = parse_html_file($source_file);

echo PHP_EOL;
foreach ($values as $key => $val) {
    echo $key . ': ' . $val . PHP_EOL;
}

//--- удалить указанные теги из исходного html и сохранить результат

remove_tags($source_file, $target_file);

echo PHP_EOL;
echo 'Tags is removed. Target file: ' . $target_file;
