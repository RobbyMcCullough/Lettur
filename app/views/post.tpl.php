<?php
$click_fortunes = array(
'Do you like clicking things?',
'Every click means an angel gets its wings.',
'A click is an egg\'s way of making another click.',
'A graceful click is worth a thousand pokes.',
'A hard click is no infallible protection against a soft click.',
'A little click sometimes saves tons of explanation.',
'A man can succeed at almost anything for which he has unlimited enthusiasm.',
'A man can\'t be too careful in the choice of his clicks.',
'A man should be greater than some of his clicks.',
'A narcissist is someone better-at-clicking than you are.',
'A person starts to live when he can click outside himself.',
'A positive click may not solve all your problems, but it will annoy enough people to make it worth the effort.',
'A professional is someone who can do his best clicking when he doesn\'t feel like it.',
'A click is a hell of a lot better than some of the stuff that nature replaces it with.',
'A verbal click isn\'t worth the paper it\'s written on.',
'Advertising is the rattling of a click inside a swill bucket.',
'After I\'m dead I\'d rather have people ask why I have no clicks than why I have one.',
'All that is needed for evil to prevail is for good men to not click.'

);

$fortune = $click_fortunes[rand(0, count($click_fortunes))];

?>
<div id="outterContainer">
    <h1><?php echo $tmpl['post_title']; ?></h1>

    <div class="innerContainer" id="postShare">
        <span class="st_twitter_large button" displayText="Twitter" title="Tweet This"></span>
        <span class="st_facebook_large button" displayText="Facebook" title="Share on Facebook"></span>
        <span class="st_reddit_large button" displayText="Reddit" title="Share on Reddit"></span>
        <span class="st_email_large button" displayText="E-Mail" title="E-Mail This"></span>
        <span class="st_aim_large button" displayText="Aim" title="AIM"></span>
        <span class="st_sharethis_large button" displayText="ShareThis"></span>
    </div>
    
    <div class="innerContainer" id="postViews">
        <h2>
            <span class="label">Date:</span>
            <span class="count"><?=makeTime($tmpl['post_date'])?></span>
            <span class="label">Views:</span>
            <span class="count"><?=number_format($tmpl['post_views'])?></span>
        </h2>
    </div>
    <div style="clear:both;"></div>
    <div class="innerContainer postContent">
        <?php echo $tmpl['post_content']; ?>
        <div style="clear: both;"></div>
    </div>
    
    <!-- 
    <div style="width: 290px; padding: 0px 14px 16px; float:right; text-align: center; zoom: 90%;" class="innerContainer">
		<h3 style="margin: 10px 0px; font-size:22px;"><?php echo $fortune ?></h3>
		<span class="st_reddit_vcount" displayText="Reddit"></span>
		<span class="st_stumbleupon_vcount" displayText="Stumble"></span>
		<span class="st_twitter_vcount" displayText="Tweet"></span>
		<span class="st_facebook_vcount" displayText="Share"></span>
	</div>
	-->
	<div style="clear:both;"></div>
</div>

<hr style="border: 1px solid #272727; margin: 20px;" />
<div style="margin: 40px; text-align: center;"><a href="<?=WEBROOT?>" title="Lettur - Simple Anonymous Publishing"><img src="images/write-on-lettur.png" /></a></div>
	
