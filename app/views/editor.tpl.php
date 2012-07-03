<div id="editorContainer">
    <div id="toolBarBase"></div>
    <form id="postForm" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <h1 id="titleLabel">Title:</h1><input type="text" name="title" value="" id="titleInput" />
        <textarea id="CLEditor" name="content">
        </textarea><br />
        <div id="check" class="publishButton"></div>
        <div style="clear: both;"></div>
        
        
		<div id="postConfirm">
		   <div id="lightBox"></div>
		   <div id="postMessage">
		     <h2>Set a password to edit your post?</h2>
		     <h3 id="note">To be able to edit your post, you must set a password:</h3>
		     <input type="password" name="password" id="passwordInput" />
		     <div id="warning"></div>
		     <div style="clear:both;"></div>
		     <div id="buttonContainer">
		       <div id="submitPost" class="publishButton"></div>
		       <div id="edit" class="editButton"></div>
		     </div>
		   </div>
		</div>
		
    </form>
</div>
<div id="welcome">
	<span class="Apple-style-span">
		Lettur is the easiest way to publish your thoughts and writings online.
		Think of Lettur like an anonymous blog where anyone can be an author.
	</span>
	<div>Lettur supports
		<span class="Apple-style-span" style="font-family: Garamond; color: rgb(204, 51, 204); font-size: -webkit-xxx-large; ">multiple</span>
		<span class="Apple-style-span" style="font-family: 'Arial Black'; color: rgb(51, 204, 255); font-size: xx-large;">fonts</span>
		<span class="Apple-style-span" style="color: white; "> and <span class="Apple-style-span" style="font-weight: bold; font-style: italic; text-decoration: underline;">text styling options</span>.</span>
	</div>
	<div>
		<span class="Apple-style-span" style="color: white;">Don’t you have </span>
		<span class="Apple-style-span" style="font-size: -webkit-xxx-large; color: rgb(255, 204, 51); font-family: Tahoma;">something</span>
		<span class="Apple-style-span" style="color: white;"> to say?</span><br />
		<span class="Apple-style-span" style="font-size: x-large; color:#5590df;">Click here</span><span class="Apple-style-span" style="color: rgb(225, 225, 225);"> to begin writing.</span>
	</div>
</div>

