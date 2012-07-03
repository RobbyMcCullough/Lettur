<?php
//require_once('config/config.php');

// ALTER TABLE  `posts_meta` ADD  `post_password` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER  `post_fulltext`

// Process Post Variables
if (!empty($_POST)) {
    if (!empty($_POST['title']) &&
        !empty($_POST['content']))
    {
        $post->create($_POST['title'], $_POST['content'], $_POST['excerpt'], $_POST['password']);
        header('Location: ' . WEBROOT . $post->url);
        exit();
    }
}

	
// Process URL and display pages.
switch ($_GET['url']) {
    // DEFAULT - Show Editor
    case '':
        build('editor');
        break;
    // LISTS - list of posts by date.
    case 'now/':
		$meta['meta_title'] = 'Lettur - Posts From Now';
        build('list', $post->readFromNow());
        break;
    case 'day/':
		$meta['meta_title'] = 'Lettur - Posts From Today';
        build('list', $post->readFromDate(0));
        break;
    case 'week/':
		$meta['meta_title'] = 'Lettur - Posts From This Week';
        build('list', $post->readFromDate(SECONDS_WEEK));
        break;
    case 'year/':
		$meta['meta_title'] = 'Lettur - Posts From Year';
        build('list', $post->readFromDate(SECONDS_YEAR));
        break;
    case 'xbbbc':
		$postId = alphaID($_GET['url'], true, PADUP);
		if ($tmpl = $post->readIdUnfiltered($postId)) {
        	$meta['meta_title'] = 'Lettur - ' . $tmpl['post_title'];
			$meta['meta_desc'] = 'Lettur - ' . $tmpl['post_excerpt'];
            build('post', $tmpl);
        }
        break;
}

// POST VIEW
if ($post->validUrl($_GET['url'])) {
    $postId = alphaID($_GET['url'], true, PADUP);
    if ($tmpl = $post->readId($postId)) {
    	$meta['meta_title'] = 'Lettur - ' . $tmpl['post_title'];
		$meta['meta_desc'] = $tmpl['post_excerpt'];
		$meta['url'] = $_GET['url'];
		
        build('post', $tmpl);
    }

// POST EDIT
} else if (substr($_GET['url'], 0, 5) == 'edit/') {
	echo 'edit page';

// ERROR PAGE
} else {
    // DISPLAY ERROR PAGE
}

?>
