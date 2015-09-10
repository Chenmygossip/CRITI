<!-- requires PHP $tIndex and $entries[$index] to be predefined in caller page -->

<div id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_transac_<?php echo $tIndex; ?>'>
	<p>Transaction:</p>
	<label for='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_transacPerson_<?php echo $tIndex; ?>'>Person:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_transacPerson_<?php echo $tIndex; ?>' name='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_transacPerson_<?php echo $tIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->transactions[$tIndex]->person)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->transactions[$tIndex]->person; ?>' />
	<label for='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_transacType_<?php echo $tIndex; ?>'>Type:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_transacType_<?php echo $tIndex; ?>' name='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_transacType_<?php echo $tIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->transactions[$tIndex]->type)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->transactions[$tIndex]->type; ?>' pattern='origination|modification' required />
	<label for='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_transacDate_<?php echo $tIndex; ?>'>Date:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_transacDate_<?php echo $tIndex; ?>' name='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_transacDate_<?php echo $tIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->transactions[$tIndex]->date)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->transactions[$tIndex]->date; ?>' pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}' />
	<label for='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_transacTarget_<?php echo $tIndex; ?>'>Target:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_transacTarget_<?php echo $tIndex; ?>' name='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>_transacTarget_<?php echo $tIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->transactions[$tIndex]->target)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->transactions[$tIndex]->target; ?>' />
</div>
