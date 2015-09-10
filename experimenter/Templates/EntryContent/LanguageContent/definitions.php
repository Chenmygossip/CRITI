<!-- requires PHP $dIndex and $entries[$index] to be predefined in caller page -->

<div id='lang_<?php echo $lIndex; ?>_definition_<?php echo $dIndex; ?>'>
	<p>Definition:</p>
	<label for='lang_<?php echo $lIndex; ?>_definitionLContent_<?php echo $dIndex; ?>'>Content:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_definitionLContent_<?php echo $dIndex; ?>' name='lang_<?php echo $lIndex; ?>_definitionLContent_<?php echo $dIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->definitions[$dIndex]->content)) echo $entries[$index]->languages[$lIndex]->definitions[$dIndex]->content; ?>' required />
	<label for='lang_<?php echo $lIndex; ?>_definitionLContent_<?php echo $dIndex; ?>'>Source:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_definitionLContent_<?php echo $dIndex; ?>' name='lang_<?php echo $lIndex; ?>_definitionLContent_<?php echo $dIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->definitions[$dIndex]->source)) echo $entries[$index]->languages[$lIndex]->definitions[$dIndex]->source; ?>' />
</div>
