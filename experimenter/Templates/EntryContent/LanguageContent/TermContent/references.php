<!-- requires PHP $rIndex and $entries[$index] to be predefined in caller page -->

<div id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_reference_<?php echo $rIndex; ?>'>
	<p>Reference:</p>
	<label for='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_referenceContent_<?php echo $rIndex; ?>'>Content:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_referenceContent_<?php echo $rIndex; ?>' name='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_referenceContent_<?php echo $rIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->references[$rIndex]->content)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->references[$rIndex]->content; ?>' required />
	<label for='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_referenceTarget_<?php echo $rIndex; ?>'>Target:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_referenceTarget_<?php echo $rIndex; ?>' name='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_referenceTarget_<?php echo $rIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->references[$rIndex]->target)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->references[$rIndex]->target; ?>' required />
</div>
