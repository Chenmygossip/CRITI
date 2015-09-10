<!-- requires PHP $lIndex and $entries[$index] to be predefined in caller page -->

<div id='language_<?php echo $lIndex; ?>'>
	<p>Language:</p>
	<label for='langCode_<?php echo $lIndex; ?>'>Code:</label>
	<input type='text' id='langCode_<?php echo $lIndex; ?>' name='langCode_<?php echo $lIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->code)) echo $entries[$index]->languages[$lIndex]->code; ?>' required />
	<?php
		if (!empty($entries[$index]->languages[$lIndex]->definitions)):
			for ($dIndex = 0; $dIndex < count($entries[$index]->languages[$lIndex]->definitions); $dIndex++)
			{
				include "LanguageContent/definitions.php";
			}
		endif;
		if (!empty($entries[$index]->languages[$lIndex]->transactions)):
			for ($tIndex = 0; $tIndex < count($entries[$index]->languages[$lIndex]->transactions); $tIndex++)
			{
				include "LanguageContent/transactions.php";
			}
		endif;
		if (!empty($entries[$index]->languages[$lIndex]->terms)):
			for ($termIndex = 0; $termIndex < count($entries[$index]->languages[$lIndex]->terms); $termIndex++)
			{
				include "LanguageContent/terms.php";
			}
		endif;
	?>
</div>
