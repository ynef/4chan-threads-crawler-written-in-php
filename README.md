# 4chan-threads-crawler-written-in-php
Looks for threads that contain specified keyword from 4chan using php simple html dom parser.

If thread is found, downloads images and saves the thread as a responsive pinterest style gallery.

You can specify keywords in the settings.php, for example "YLYL" will try to find the word YLYL inside OP's post. If finds a match the script will "dig deeper" by fetching the rest of the thread.
