<!-- requires PHP $tIndex and $entries[$index] to be predefined in caller page -->

<div id='transac_<?php echo $tIndex; ?>'>
	<p>Transaction:</p>
	<label for='transacPerson_<?php echo $tIndex; ?>'>Person:</label>
	<input type='text' id='transacPerson_<?php echo $tIndex; ?>' name='transacPerson_<?php echo $tIndex; ?>' value='<?php if (!empty($entries[$index]->transactions[$tIndex]->person)) echo $entries[$index]->transactions[$tIndex]->person; ?>' />
	<label for='transacType_<?php echo $tIndex; ?>'>Type:</label>
	<input type='text' id='transacType_<?php echo $tIndex; ?>' name='transacType_<?php echo $tIndex; ?>' value='<?php if (!empty($entries[$index]->transactions[$tIndex]->type)) echo $entries[$index]->transactions[$tIndex]->type; ?>' pattern='origination|modification' required />
	<label for='transacDate_<?php echo $tIndex; ?>'>Date:</label>
	<input type='text' id='transacDate_<?php echo $tIndex; ?>' name='transacDate_<?php echo $tIndex; ?>' value='<?php if (!empty($entries[$index]->transactions[$tIndex]->date)) echo $entries[$index]->transactions[$tIndex]->date; ?>' pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}' />
	<label for='transacTarget_<?php echo $tIndex; ?>'>Target:</label>
	<input type='text' id='transacTarget_<?php echo $tIndex; ?>' name='transacTarget_<?php echo $tIndex; ?>' value='<?php if (!empty($entries[$index]->transactions[$tIndex]->target)) echo $entries[$index]->transactions[$tIndex]->target; ?>' />
</div>
