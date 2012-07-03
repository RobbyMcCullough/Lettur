<div id="outterContainer">
<ul id="postList" class="innerContainer">

    <?php for ($i=0; $i<count($tmpl['post_title']); $i++) : ?>
    
    <li>
    	<div class="eyeHolder">
    		<img src="<?=WEBROOT?>images/eye.png" /><br />
    		<?=$tmpl['post_views'][$i]?></p>
        </div>
        <a href="<?=WEBROOT . $tmpl['post_url'][$i];?>"><?=$tmpl['post_title'][$i];?></a>
        <p class="postMeta"><?=makeTime($tmpl['post_date'][$i]);?>
        	<p class="postExcerpt"><?=$tmpl['post_excerpt'][$i];?></p>
        <div style="clear: both;">
    </li>
    <?php endfor; ?>
    
</ul>
</div>
