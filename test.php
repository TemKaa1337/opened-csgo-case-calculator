<?php

require __DIR__.'/vendor/autoload.php';

use TemKaa1337\CSGOCasesCalculator\OpenedCaseCounter;

$cookie = json_decode(file_get_contents(__DIR__.'/cookie.json'), true);
$savePath = __DIR__.'/files/';

$calulator = new OpenedCaseCounter(cookie: $cookie['cookie'], savePath: $savePath);
$calulator->calculate();