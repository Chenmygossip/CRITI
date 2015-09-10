<!-- requires PHP $dIndex and $entries[$index] to be predefined in caller page -->

<div id='definition_<?php echo $dIndex; ?>'>
	<p>Definition:</p>
	<label for='definitionContent_<?php echo $dIndex; ?>'>Content:</label>
	<input type='text' id='definitionContent_<?php echo $dIndex; ?>' name='definitionContent_<?php echo $dIndex; ?>' value='<?php if (!empty($entries[$index]->definitions[$dIndex]->content)) echo $entries[$index]->definitions[$dIndex]->content; ?>' required />
	<label for='definitionSource_<?php echo $dIndex; ?>'>Source:</label>
	<input type='text' id='definitionSource_<?php echo $dIndex; ?>' name='definitionSource_<?php echo $dIndex; ?>' value='<?php if (!empty($entries[$index]->definitions[$dIndex]->source)) echo $entries[$index]->definitions[$dIndex]->source; ?>' />
</div>
