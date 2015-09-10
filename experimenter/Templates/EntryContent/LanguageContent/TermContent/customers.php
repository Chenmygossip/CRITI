<!-- requires PHP $cIndex and $entries[$index] to be predefined in caller page -->

<div id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_customer_<?php echo $cIndex; ?>'>
	<p>Customer:</p>
	<label for='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_customerItem_<?php echo $cIndex; ?>'>Customer:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_customerItem_<?php echo $cIndex; ?>' name='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_customerItem_<?php echo $cIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->customers[$cIndex])) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->customers[$cIndex]; ?>' required />
</div>
