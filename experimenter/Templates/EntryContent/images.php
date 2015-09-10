<!-- requires PHP $imgIndex and $entries[$index] to be predefined in caller page -->

<div id='image_<?php echo $imgIndex; ?>'>
	<p>Image:</p>
	<label for='imageContent_<?php echo $imgIndex; ?>'>Content:</label>
	<input type='text' id='imageContent_<?php echo $imgIndex; ?>' name='imageContent_<?php echo $imgIndex; ?>' value='<?php if (!empty($entries[$index]->images[$imgIndex]->content)) echo $entries[$index]->images[$imgIndex]->content; ?>' required />
	<label for='imageTarget_<?php echo $imgIndex; ?>'>Target:</label>
	<input type='text' id='imageTarget_<?php echo $imgIndex; ?>' name='imageTarget_<?php echo $imgIndex; ?>' value='<?php if (!empty($entries[$index]->images[$imgIndex]->target)) echo $entries[$index]->images[$imgIndex]->target; ?>' required />
</div>
