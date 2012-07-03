<?php

// MySQL DATABASE INFO
define(DBHOST, '');
define(DBUSER, '');
define(DBPASS, '');
define(DBNAME, '');


// Open database connection
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

// Globals 
define(ROOT, dirname(__FILE__));      		// Root directory
define(WEBROOT, '/lettur/');          		// Web Root
define(TIMEFORMAT, "m/j/Y");          		// Time Format
define(SECONDS_DAY, 38000);           		// Seconds in a day
define(SECONDS_WEEK, SECONDS_DAY * 7);  	// Seconds in a week
define(SECONDS_YEAR, SECONDS_DAY * 365);	// Seconds in a year
define(PADUP, 5);                       	// Default number of chars for URLs



// Grab helper functions
require_once(ROOT . '/app/helpers/functions.php');
require_once(ROOT . '/app/models/post.php');


// Instanciate Objects
$post = Post::getInstance();

define(DAILYCOUNT, count($post->readFromDate(0)));

$meta['meta_title'] = 'Lettur - Simple Anonymous Blogging';
$meta['meta_desc'] = 'Lettur is the easiest way to publish your thoughts and writings online. Think of Lettur like an anonymous blog where anyone can be an author.';
$meta['meta_keywords'] = 'Lettur, Anonymous Blogging, Anonymous Publishing';

?>