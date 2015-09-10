<!-- requires PHP $pIndex and $entries[$index] to be predefined in caller page -->

<div id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex ?>_project_<?php echo $pIndex; ?>'>
	<p>Project:</p>
	<label for='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex ?>_projectItem_<?php echo $pIndex; ?>'>Content:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex ?>_projectItem_<?php echo $pIndex; ?>' name='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex ?>_projectItem_<?php echo $pIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->projects[$pIndex])) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->projects[$pIndex]; ?>' required />
</div>
