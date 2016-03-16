# 4chan-threads-crawler-written-in-php
Looks for threads on 4chan that contain user specified keywords (settings.php) using php simple html dom parser.

If thread is found, downloads images and saves the thread as a responsive pinterest style gallery.

Features:

* Each thread gets their own folder with thread ID as its name
* Dynamically generates index.php files
* No database (flat files)
* Sorts newest threads on top
* Updates already existing thread if it finds it again

How to use:

* Change variables in settings.php according to your needs
* Upload files to your server
* Create a cron job to call pull.php or browse to it manually in your web browser
* Wait for threads to appear

Additional info:

You can specify keywords in the settings.php, for example "YLYL" will try to find the word YLYL inside of OP's post. If it finds a match the script will "dig deeper" by fetching the rest of the thread.

Currently it works on index pages like http://boards.4chan.org/b and not the catalog (didn't get it to work for some reason)

It is capable of fetching webm-s too, but saves them as .jpg. If you want to see them, just rename to .webm

To do-s:

* Figure out a way to fetch threads from catalog
* Recognize webm-s and rename them properly (not .jpg)
