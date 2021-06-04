<?php

function writeVirtualHostFile($domain, $webmaster, $serverName, $port) {
   $filename=$domain.'.conf';	
   $virtualHostFile = fopen($filename, "w") or die("Unable to open file!");
   
   $fileContents = '<VirtualHost *:' . $port . '>' . PHP_EOL;
   $fileContents = $fileContents . '   ServerName ' . $domain . PHP_EOL;
   $fileContents = $fileContents . '   ServerAlias www.'. $domain . PHP_EOL;
   $fileContents = $fileContents . '   ServerAdmin '. $webmaster . PHP_EOL;
   $fileContents = $fileContents . '   DocumentRoot /var/www/' . $domain . PHP_EOL;
   $fileContents = $fileContents . '   ErrorLog ${APACHE_LOG_DIR}/error.log' . PHP_EOL;
   $fileContents = $fileContents . '   CustomLog ${APACHE_LOG_DIR}/access.log combined' . PHP_EOL;
   $fileContents = $fileContents . '</VirtualHost>' . PHP_EOL;

   fwrite($virtualHostFile, $fileContents);
   fclose($virtualHostFile);
}

$domain='';
$webmaster='';
$serverName='';
$port=0;


$options = getopt("d:w:n:p:");
$serverName = "";
if (!is_array($options) ) {
   print "There was a problem reading in the options.\n\n";
   exit(1);
}
$errors = array();

$count=0;
foreach($options as $option) {
   echo $option;
   if($count==0) {
     $domain = $option;
   }
   if($count==1) {
     $webmaster = $option;
   }
   if($count==2) {
     $serverName = $option;
   }
   if($count==3) {
     $port = $option;
   }
   $count = $count + 1;
}

writeVirtualHostFile($domain, $webmaster, $serverName, $port);
