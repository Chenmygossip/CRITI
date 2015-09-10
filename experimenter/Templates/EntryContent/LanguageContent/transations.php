<!-- requires PHP $tIndex and $entries[$index] to be predefined in caller page -->

<div id='lang_<?php echo $lIndex; ?>_transac_<?php echo $tIndex; ?>'>
	<p>Transaction:</p>
	<label for='lang_<?php echo $lIndex; ?>_transacLPerson_<?php echo $tIndex; ?>'>Person:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_transacLPerson_<?php echo $tIndex; ?>' name='lang_<?php echo $lIndex; ?>_transacPerson_<?php echo $tIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->transactions[$tIndex]->person)) echo $entries[$index]->languages[$lIndex]->transactions[$tIndex]->person; ?>' />
	<label for='lang_<?php echo $lIndex; ?>_transacLType_<?php echo $tIndexL; ?>'>Type:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_transacLType_<?php echo $tIndex; ?>' name='lang_<?php echo $lIndex; ?>_transacType_<?php echo $tIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->transactions[$tIndex]->type)) echo $entries[$index]->languages[$lIndex]->transactions[$tIndex]->type; ?>' pattern='origination|modification' required />
	<label for='lang_<?php echo $lIndex; ?>_transacLDate_<?php echo $tIndexL; ?>'>Date:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_transacLDate_<?php echo $tIndex; ?>' name='lang_<?php echo $lIndex; ?>_transacDate_<?php echo $tIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->transactions[$tIndex]->date)) echo $entries[$index]->languages[$lIndex]->transactions[$tIndex]->date; ?>' pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}' />
	<label for='lang_<?php echo $lIndex; ?>_transacLTarget_<?php echo $tIndexL; ?>'>Target:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_transacLTarget_<?php echo $tIndex; ?>' name='lang_<?php echo $lIndex; ?>_transacTarget_<?php echo $tIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->transactions[$tIndex]->target)) echo $entries[$index]->languages[$lIndex]->transactions[$tIndex]->target; ?>' />
</div>
