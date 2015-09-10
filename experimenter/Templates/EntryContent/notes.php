<!-- requires PHP $nIndex and $entries[$index] to be predefined in caller page -->

<div id='note_<?php echo $nIndex; ?>'>
	<p>Note:</p>
	<label for='noteItem_<?php echo $nIndex; ?>'>Content:</label>
	<input type='text' id='noteItem_<?php echo $nIndex; ?>' name='noteItem_<?php echo $nIndex; ?>' value='<?php if (!empty($entries[$index]->notes[$nIndex])) echo $entries[$index]->notes[$nIndex]; ?>' required />
</div>
