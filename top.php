<?php
$phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

$path_parts = pathinfo($phpSelf);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SOPO Brewing Company</title>

        <meta charset="utf-8">
        <meta name="author" content="Aidan Siegel">
        <meta name="description" content="Somers Point Brewing Company Website including a menu, map, email list sign-up.">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="custom.css?version=<php print time(); ?>">
<?php

 $domain = '//';       
 
 $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, 'UTF-8');       
        
 $domain.= $server;       
        
if ($debug) {
    print '<p>php Shelf: ' . $phpSelf;
    print '<p>domain: ' . $domain;
    print '<p>Path Parts<pre>';
    print_r($path_parts);
    print '</pre></p>';
}


print PHP_EOL . '<!-- include libraries -->' . PHP_EOL;

require_once 'lib/security.php';

include_once 'lib/validation-functions.php';

include_once 'lib/mail-message.php';

print '<body id="' . $path_parts['filename'] . '">';

include 'header.php';
print PHP_EOL;
            
include 'nav.php';
print PHP_EOL;
?>

