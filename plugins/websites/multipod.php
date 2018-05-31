#!/usr/bin/env php
<?php
/*
Parameters:
config (required)
autoconf (optional - used by munin-config)
Magick markers (optional - used by munin-config and some installation scripts):
%# family=manual
%# capabilities=autoconf
*/
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 30/05/18
 * Time: 16:37
 */

/* we only run from the command line */
if (strcasecmp(PHP_SAPI, 'cli') != 0) {
    print $argv[0] . ": may only be run from the cli!\n";
    exit(1);
}

$website = 'Multipod';
$url = 'http://www.multipod-studio.com/';
$guzzle_params = ['verify' => false];
$type = 'GET';

require 'WebsiteTest.php';
if (($argc > 1) && isset($argv[1]) && !empty($argv[1])) {
    new WebsiteTest($website, $url, $type, $guzzle_params, null, $argv[1]);
}
else
    new WebsiteTest($website, $url, $type, $guzzle_params);

