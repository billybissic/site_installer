<?php

function writeMOTDFile($serverName) {

   $fileName="01-Custom";
   $motdFile = fopen($fileName, "w") or die("Unable to open file!");

   $fileContents = '#!/bin/sh' . PHP_EOL;
   $fileContents = $fileContents . 'echo "CURRENT WEATHER"' . PHP_EOL;
   $fileContents = $fileContents . 'echo' . PHP_EOL;
   $fileContents = $fileContents . '#Show weahter information. Change the city name to fit your location' . PHP_EOL;
   $fileContents = $fileContents . '#ansiweather -F ' . PHP_EOL;
   $fileContents = $fileContents . 'WEATHER=`curl wttr.in`' . PHP_EOL;
   $fileContents = $fileContents . 'echo "${WEATHER}"' . PHP_EOL;
   $fileContents = $fileContents . 'echo' . PHP_EOL;
   $fileContents = $fileContents . 'BANNER=`figlet "' . $serverName . '"`' . PHP_EOL;
   $fileContents = $fileContents . 'echo "${BANNER}"' . PHP_EOL;
   $fileContents = $fileContents . 'echo' . PHP_EOL;
   $fileContents = $fileContents . 'echo "SYSTEM INFORMATION"' . PHP_EOL;
   $fileContents = $fileContents . '/usr/bin/screenfetch' . PHP_EOL;
   $fileContents = $fileContents . 'echo' . PHP_EOL;
   $fileContents = $fileContents . 'echo "SYSTEM DISK USAGE"' . PHP_EOL;
   $fileContents = $fileContents . 'export TERM=xterm; inxi -D' . PHP_EOL;
   $fileContents = $fileContents . 'echo' . PHP_EOL;
   $fileContents = $fileContents . 'UNAME=`whoami`' . PHP_EOL;
   $fileContents = $fileContents . 'echo "Welcome, ${UNAME}!"' . PHP_EOL;

   fwrite($motdFile, $fileContents);
   fclose($motdFile);
}

$options = getopt("n:");
$serverName = "";
    if (!is_array($options) ) {
        print "There was a problem reading in the options.\n\n";
        exit(1);
    }
    $errors = array();

    foreach($options as $option) {
       echo $option;
       $serverName = $option;
    }

    writeMOTDFile($serverName);
