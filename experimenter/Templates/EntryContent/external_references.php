<!-- requires PHP $extrIndex and $entries[$index] to be predefined in caller page -->

<div id='extReference_<?php echo $extrIndex; ?>'>
	<p>External Reference:</p>
	<label for='extReferenceContent_<?php echo $extrIndex; ?>'>Content:</label>
	<input type='text' id='extReferenceContent_<?php echo $extrIndex; ?>' name='extReferenceContent_<?php echo $extrIndex; ?>' value='<?php if (!empty($entries[$index]->external_references[$extrIndex]->content)) echo $entries[$index]->external_references[$extrIndex]->content; ?>' required />
	<label for='extReferenceTarget_<?php echo $extrIndex; ?>'>Target:</label>
	<input type='text' id='extReferenceTarget_<?php echo $extrIndex; ?>' name='extReferenceTarget_<?php echo $extrIndex; ?>' value='<?php if (!empty($entries[$index]->external_references[$extrIndex]->target)) echo $entries[$index]->external_references[$extrIndex]->target; ?>' required />
</div>
