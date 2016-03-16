<?php

/**
4chan Threads Crawler Written in PHP
https://github.com/ynef/4chan-threads-crawler-written-in-php
**/

$urlToCrawl	= "http://boards.4chan.org/b"; // URL to crawl. For 4chan/b it has to be boards sub-domain
$wordToFind	= ""; //What word should the script be looking for? Example: ylyl
$rootFolder	= ""; //URL where the script runs without forward slash. Example: http://www.example.com/4chan
$siteTitle	= ""; // Crawler's title
$siteMeta	= ""; // Optional message under the $siteTitle
?>