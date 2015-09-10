<!-- requires PHP $rIndex and $entries[$index] to be predefined in caller page -->

<div id='reference_<?php echo $rIndex; ?>'>
	<p>Reference:</p>
	<label for='referenceContent_<?php echo $rIndex; ?>'>Content:</label>
	<input type='text' id='referenceContent_<?php echo $rIndex; ?>' name='referenceContent_<?php echo $rIndex; ?>' value='<?php if (!empty($entries[$index]->references[$rIndex]->content)) echo $entries[$index]->references[$rIndex]->content; ?>' required />
	<label for='referenceTarget_<?php echo $rIndex; ?>'>Target:</label>
	<input type='text' id='referenceTarget_<?php echo $rIndex; ?>' name='referenceTarget_<?php echo $rIndex; ?>' value='<?php if (!empty($entries[$index]->references[$rIndex]->target)) echo $entries[$index]->references[$rIndex]->target; ?>' required />
</div>
