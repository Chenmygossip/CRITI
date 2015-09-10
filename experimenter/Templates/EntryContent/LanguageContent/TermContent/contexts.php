<!-- requires PHP $contIndex and $entries[$index] to be predefined in caller page -->

<div id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex ?>_context_<?php echo $contIndex; ?>'>
	<p>Context:</p>
	<label for='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex ?>_contextContent_<?php echo $contIndex; ?>'>Content:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex ?>_contextContent_<?php echo $contIndex; ?>' name='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex ?>_contextContent_<?php echo $contIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->contexts[$contIndex]->content)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->contexts[$contIndex]->content; ?>' required />
	<label for='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex ?>_contextSource_<?php echo $contIndex; ?>'>Content:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex ?>_contextSource_<?php echo $contIndex; ?>' name='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex ?>_contextSource_<?php echo $contIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->contexts[$contIndex]->source)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->contexts[$contIndex]->source; ?>' />
</div>
