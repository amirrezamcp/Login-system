<?php
function ClassAutoloader($className) {
    $baseDir = __DIR__ . DIRECTORY_SEPARATOR . "Models" . DIRECTORY_SEPARATOR;
    $className = trim($className,'\\');
    $className = explode('\\',$className)[1];
    $filePath = $baseDir . $className . ".php";
    if(file_exists($filePath)) {
        include_once $filePath;
    }
}
spl_autoload_register("ClassAutoloader");