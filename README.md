# 4chan-threads-crawler-written-in-php
Looks for threads on 4chan that contain specified keywords (settings.php) using php simple html dom parser.

If thread is found, downloads images and saves the thread as a responsive pinterest style gallery.

You can specify keywords in the settings.php, for example "YLYL" will try to find the word YLYL inside of OP's post. If it finds a match the script will "dig deeper" by fetching the rest of the thread.

Currently it works on index pages like http://boards.4chan.org/b and not the catalog (didn't get it to work for some reason)

It is capable of fetching webm-s too, but saves them as .jpg. If you want to see them, just rename to .webm
