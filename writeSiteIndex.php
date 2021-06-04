<?php

function writeIndexFile($domain) {
   $fileName = "index.html";
   $indexFile = fopen($fileName, "w") or die("Unable to open file!");

   $fileContents = "<html>" . PHP_EOL;
   $fileContents = $fileContents . "  <head>" . PHP_EOL;
   $fileContents = $fileContents . "      <title>" . $domain . "</title>" . PHP_EOL;
   $fileContents = $fileContents . "  </head>" . PHP_EOL;
   $fileContents = $fileContents . "  <body>" . PHP_EOL;
   $fileContents = $fileContents . "      <h1>Hello World!</h1>" . PHP_EOL;
   $fileContents = $fileContents . PHP_EOL;
   $fileContents = $fileContents . "      <p>This is the landing page of <strong>" . $domain . "</strong>.</p>" . PHP_EOL;
   $fileContents = $fileContents . "  </body>" . PHP_EOL;
   $fileContents = $fileContents . "</html>" . PHP_EOL;

   fwrite($indexFile, $fileContents);
   fclose($indexFile);
}

$options = getopt("d:");
$domain = "";
    if (!is_array($options) ) {
        print "There was a problem reading in the options.\n\n";
        exit(1);
    }
    $errors = array();
    //print_r($options);

    foreach($options as $option) {
       echo $option;
       $domain = $option;
    }

    writeIndexFile($domain);
