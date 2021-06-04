<?php

function writeDirConf() {
$fileName="dir.conf";

$configFile = fopen($fileName, "w") or die("Unable to open file!");

$fileContents = "<IfModule mod_dir.c>" . PHP_EOL;
$fileContents = $fileContents . "        DirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm" . PHP_EOL;
$fileContents = $fileContents . "</IfModule>" . PHP_EOL;

fwrite($configFile, $fileContents);
fclose($configFile);

}

writeDirConf();
