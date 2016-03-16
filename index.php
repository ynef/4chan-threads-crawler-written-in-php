<?php 

/**
4chan Threads Crawler Written in PHP
https://github.com/ynef/4chan-threads-crawler-written-in-php
**/

include "settings.php"; 
$start = microtime(true);
?>
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='utf-8'>
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<title><?php echo $siteTitle; ?></title>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<link href='<?php echo $rootFolder; ?>/styles.css' rel='stylesheet' media='all'>
</head>
<body>
<div class='wrapper'>
<section>
<header class="siteHeader">
<h1><?php echo $siteTitle; ?></h1>
<p><?php echo $siteMeta; ?></p>
</header>
<hr>
<div class="links">
<?php

/* Scan directory for folders excluding items in $blacklist array */
if ($handle = opendir('.')) {
    $blacklist = array('.', '..', 'index.php', 'simple_html_dom.php', 'styles.css', 'pull.php', 'default.jpg', 'settings.php', 'readme.txt', 'error_log', 'LICENSE', 'README.md');
    while (false !== ($file = readdir($handle))) {
        if (!in_array($file, $blacklist)) {
			$folders[] = $file; // Create array of folders for processing
        }
    }
	
	if (!empty($folders)) {
	
		/* Sort folders and echo their thumbnails */
		rsort($folders); // Newer ones on top
		foreach ($folders as $folder) {
			
		/* Generate HTML for thumbnail */
		echo '<figure>
		<a href="'.$folder.'" target="_blank"><img src="'.$folder.'/img/0.jpg"/></a>
		<figcaption>Thread ID: '.$folder.'</figcaption>
		</figure>
		';
		}
	
	} else {
		echo "<p>No threads discovered yet...</p>";
		}
    closedir($handle);
}
?>
</div>
<footer>
<hr>
<?php
$end = microtime(true);
$creationtime = ($end - $start);
echo "<p>Page generated in $creationtime seconds.</p>";
?>
</footer>
</section>
</div>
</body>
</html>