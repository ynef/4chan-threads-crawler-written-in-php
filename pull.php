<?php

/**
4chan Threads Crawler Written in PHP
https://github.com/ynef/4chan-threads-crawler-written-in-php
**/

include		"simple_html_dom.php";
include		"settings.php";
$html		= file_get_html($urlToCrawl);
$postsFile 	= "posts.php";
$indexFile	= "index.php";
$date		= date("Y-m-d(H:i:s)");
$isFound	= 0;
$n			= 0;

foreach($html->find('div.thread') as $thread) {
	
		/** Checking for $wordToFind **/
		if (stripos($thread->find('blockquote.postMessage', 0)->plaintext, $wordToFind) !== false) {
			// Set new parameters because $wordToFind is found within content
			$threadURL		= $thread->find('a.replylink', 0)->href; //Where OP's link points to
			$deepHtml		= file_get_html($urlToCrawl.'/'.$threadURL); //New dataset based on OP's link
			$isFound		= 1; //To activate the next if
			$postID			= preg_replace("/[^0-9,.]/", "", $thread->find('blockquote.postMessage', 0)->id); //Removes the 'm' leaving us a numerical ID
		}
}

/** Process this if we found what we were looking for **/
if ($isFound == 1) {
	
	/** Let's dig deeper into the thread we found **/
	foreach($deepHtml->find('div.postContainer') as $post) {
		$item['name'] 	= $post->find('span.name', 0)->plaintext; // Name of poster. Usually Anonymous
		$item['date'] 	= $post->find('span.dateTime', 0)->plaintext; // Date of post
		$item['thumb'] 	= $post->find('img', 0)->src; // Thumbnail's src
		$item['image'] 	= $post->find('a.fileThumb', 0)->href; // Link to the bigger picture
		$item['meta'] 	= $post->find('img', 0)->alt; // Alt tag for the image
		$item['body'] 	= $post->find('blockquote.postMessage', 0)->plaintext; // Content of post
		$posts[]		= $item;
	}
	
	/** Look for folder with our postID and create it if not present **/
	if(is_dir($postID) === false) {
	
	mkdir($postID);
	mkdir($postID.'/img'); // Sub-folder for images
	
	$file = fopen($postID . '/' . $postsFile,"a+");

	foreach ($posts as $entry) {
		
		// Check if thumbnail exists
		if (!empty($entry['thumb'])) {
		$input = 'http:'.$entry['thumb'];
		$output =$postID.'/img/'.$n.'.jpg';
		file_put_contents($output, file_get_contents($input));
		$thumb = $output;
		} else {
			$thumb = 'default.jpg';
			}
		
		// Check if big image exists
		if (!empty($entry['image'])) {
			// Create folder for big images
			if(is_dir($postID.'/big') === false) {
			mkdir($postID.'/big');
			}
			$imageURL = 'http:'.$entry['image'];
			$output = $postID.'/big/'.$n.'.jpg';
			file_put_contents($output, file_get_contents($imageURL));
			$bigImage = 'big/'.$n.'.jpg';
		} else {
			$bigImage = 'index.php';
		}

/** Generate the HTML code for posts **/
$content = "<article>
<header>
<h1>".$entry['name']."</h1>
<p>".$entry['date']."</p>
</header>
<figure class='posts_figure'>
<a href='$bigImage'>
<img src=".$rootFolder . '/' .$thumb." alt='".$entry['meta']."'/>
</a>
</figure>
<figcaption class='posts_figcaption'>".$entry['body']."</figcaption>
</article>
";
		fwrite($file, $content); // Writes the HTML above to file
		$n++;
	}

	fclose($file);

	$file = fopen($postID . '/' . $indexFile,"w");
$indexHtml = "<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='utf-8'>
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<title>Archive for post ID: $postID</title>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<link href='$rootFolder/styles.css' rel='stylesheet' media='all'>
</head>
<body>
<div class='wrapper'>
<section>
<header class='siteHeader'>
<h1><a href='../'>$siteTitle</a></h1>
<p>Thread found on $date</p>
</header>
<hr>
<?php include 'posts.php'; ?>
<footer>
<hr>
<p>Return to <a href='../'>index</a></p>
</footer>
</section>
</div>
</body>
</html>
";
	fwrite($file, $indexHtml); // Write the HTML for index page
	fclose($file);
	
	}
	
	/** Look for folder with our postID and update it **/
	if(is_dir($postID) === true) {
		
	// Reset the posts file, not sure if it's the most efficient way to eliminate duplicate content?
	$file = fopen($postID . '/' . $postsFile,"w");
	$content = "";
	fwrite($file, $content);
	fclose($file);
	
	$file = fopen($postID . '/' . $postsFile,"a+"); // Open file again for updated list of posts

	foreach ($posts as $entry) {
		
		// Check if thumbnail exists
		if (!empty($entry['thumb'])) {
		$input = 'http:'.$entry['thumb'];
		$output =$postID.'/img/'.$n.'.jpg';
		file_put_contents($output, file_get_contents($input));
		$thumb = $output;
		} else {
			$thumb = 'default.jpg';
			}
		
		// Check if big image exists
		if (!empty($entry['image'])) {
			// Create folder for big images
			if(is_dir($postID.'/big') === false) {
			mkdir($postID.'/big');
			}
			$imageURL = 'http:'.$entry['image'];
			$output = $postID.'/big/'.$n.'.jpg';
			file_put_contents($output, file_get_contents($imageURL));
			$bigImage = 'big/'.$n.'.jpg';
		} else {
			$bigImage = 'index.php';
		}

/** Generate the HTML code for posts **/
$content = "<article>
<header>
<h1>".$entry['name']."</h1>
<p>".$entry['date']."</p>
</header>
<figure class='posts_figure'>
<a href='$bigImage'>
<img src=".$rootFolder . '/' .$thumb." alt='".$entry['meta']."'/>
</a>
</figure>
<figcaption class='posts_figcaption'>".$entry['body']."</figcaption>
</article>
";
		fwrite($file, $content);
		$n++;
	}

	fclose($file);

	$newDate = date("Y-m-d(H:i:s)"); // Time of update
	$file = fopen($postID . '/' . $indexFile,"w");
$indexHtml = "<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='utf-8'>
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<title>Archive for post ID: $postID</title>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<link href='$rootFolder/styles.css' rel='stylesheet' media='all'>
</head>
<body>
<div class='wrapper'>
<section>
<header class='siteHeader'>
<h1><a href='../'>$siteTitle</a></h1>
<p>Thread found on $date - Last updated on $newDate</p>
</header>
<hr>
<?php include 'posts.php'; ?>
<footer>
<hr>
<p>Return to <a href='../'>index</a></p>
</footer>
</section>
</div>
</body>
</html>
";
	fwrite($file, $indexHtml); // Write the HTML for index page
	fclose($file);
	
	}
	
	echo "Found ' $wordToFind ' ... Threads have been pulled!";
	die();

} else {
	echo "Couldn't find ' $wordToFind ' right now... Try again later!";
	die();
}
?>