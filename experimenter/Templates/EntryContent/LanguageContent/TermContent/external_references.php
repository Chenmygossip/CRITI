<!-- requires PHP $extrIndex and $entries[$index] to be predefined in caller page -->

<div id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_extReference_<?php echo $extrIndex; ?>'>
	<p>External Reference:</p>
	<label for='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_extReferenceContent_<?php echo $extrIndex; ?>'>Content:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_extReferenceContent_<?php echo $extrIndex; ?>' name='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_extReferenceContent_<?php echo $extrIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->external_references[$extrIndex]->content)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->external_references[$extrIndex]->content; ?>' required />
	<label for='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_extReferenceTarget_<?php echo $extrIndex; ?>'>Target:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_extReferenceTarget_<?php echo $extrIndex; ?>' name='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_extReferenceTarget_<?php echo $extrIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->external_references[$extrIndex]->target)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->external_references[$extrIndex]->target; ?>' required />
</div>
