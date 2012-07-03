<!doctype html>  
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    
    <title><?=$meta['meta_title']?></title>
    <link href='http://fonts.googleapis.com/css?family=puritan' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="<?=WEBROOT ?>css/style.css?ver=1.0" />
    <link rel="shortcut icon" href="http://lettur.com/images/favicon.ico" />
     
    <meta name="title" content="<?=$meta['meta_title']?>">
    <meta name="description" content="<?=$meta['meta_desc']?>">
    <meta name="keywords" content="<?=$meta['meta_keywords']?>">
    <meta property="og:image" content="http://lettur.com/images/siteLogo.png"/>
  </head>
<body>

<ul id="nav">
	<li><a href="<?=WEBROOT?>">write</a></li>
	<li><a href="" id="drop">read <span class="downArrow">&#9660;</span></a>
		<ul id="readMenu">
			<li><a href="<?=WEBROOT?>now/">most recent</a></li>
			<li class="label">popular</li>
			<?php if (DAILYCOUNT > 0) : ?><li><a href="<?=WEBROOT?>day/">today</a></li><?php endif; ?>
		    <li><a href="<?=WEBROOT?>week/">this week</a></li>
		    <li><a href="<?=WEBROOT?>year/">this year</a></li>
		</ul>
	</li>
	
	<li><a href="http://lettur.com/gdbbc">about</a></li>
	<li><a href="http://twitter.com/lettur">twitter</a></li>
</ul>

<div id="header">
    <a href="<?=WEBROOT?>" title="Lettur - Simple Anonymouse Publishing"><img src="<?=WEBROOT ?>images/header.png" /></a>
</div>

<div id="container">
