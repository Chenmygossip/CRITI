<!-- requires PHP $termIndex and $entries[$index] to be predefined in caller page -->

<div id='lang_<?php echo $lIndex; ?>_term_<?php echo $termIndex; ?>'>
	<p>Term:</p>
	<label for='lang_<?php echo $lIndex; ?>_termTerm_<?php echo $termIndex; ?>'>Term:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_termTerm_<?php echo $termIndex; ?>' name='lang_<?php echo $lIndex; ?>_termTerm_<?php echo $termIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->term)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->term; ?>' required />
	<label for='lang_<?php echo $lIndex; ?>_termGender_<?php echo $termIndex; ?>'>Gender:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_termGender_<?php echo $termIndex; ?>' name='lang_<?php echo $lIndex; ?>_termGender_<?php echo $termIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->gender)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->gender; ?>' pattern='masculine|feminine|neuter|other' />
	<label for='lang_<?php echo $lIndex; ?>_termSource_<?php echo $termIndex; ?>'>Source:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_termSource_<?php echo $termIndex; ?>' name='lang_<?php echo $lIndex; ?>_termSource_<?php echo $termIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->source)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->source; ?>' />
	<label for='lang_<?php echo $lIndex; ?>_termStatus_<?php echo $termIndex; ?>'>Status:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_termStatus_<?php echo $termIndex; ?>' name='lang_<?php echo $lIndex; ?>_termStatus_<?php echo $termIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->status)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->status; ?>' pattern='preferredTerm-admn-sts|admittedTerm-admn-sts|deprecatedTerm-admn-sts|supersededTerm-admn-sts' />
	<label for='lang_<?php echo $lIndex; ?>_termType_<?php echo $termIndex; ?>'>Type:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_termType_<?php echo $termIndex; ?>' name='lang_<?php echo $lIndex; ?>_termType_<?php echo $termIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->type)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->type; ?>' pattern='fullForm|acronym|abbreviation|shortForm|variant|phrase' />
	<label for='lang_<?php echo $lIndex; ?>_termGeo_<?php echo $termIndex; ?>'>Geo:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_termGeo_<?php echo $termIndex; ?>' name='lang_<?php echo $lIndex; ?>_termGeo_<?php echo $termIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->geo)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->geo; ?>' />
	<label for='lang_<?php echo $lIndex; ?>_termPos_<?php echo $termIndex; ?>'>Part of Speech:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_termPos_<?php echo $termIndex; ?>' name='lang_<?php echo $lIndex; ?>_termPos_<?php echo $termIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->pos)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->pos; ?>' pattern='noun|verb|adverb|adjective|properNoun|other' />
	<label for='lang_<?php echo $lIndex; ?>_termLocation_<?php echo $termIndex; ?>'>Location:</label>
	<input type='text' id='lang_<?php echo $lIndex; ?>_termLocation_<?php echo $termIndex; ?>' name='lang_<?php echo $lIndex; ?>_termLocation_<?php echo $termIndex; ?>' value='<?php if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->location)) echo $entries[$index]->languages[$lIndex]->terms[$termIndex]->location; ?>' />
	<?php
		if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->projects)):
			for ($pIndex = 0; $pIndex < count($entries[$index]->languages[$lIndex]->terms[$termIndex]->projects); $pIndex++)
			{
				include "TermContent/projects.php";
			}
		endif;
		if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->customers)):
			for ($cIndex = 0; $cIndex < count($entries[$index]->languages[$lIndex]->terms[$termIndex]->customers); $cIndex++)
			{
				include "TermContent/customers.php";
			}
		endif;
		if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->external_references)):
			for ($extrIndex = 0; $extrIndex < count($entries[$index]->languages[$lIndex]->terms[$termIndex]->external_references); $extrIndex++)
			{
				include "TermContent/external_references.php";
			}
		endif;
		if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->references)):
			for ($rIndex = 0; $rIndex < count($entries[$index]->languages[$lIndex]->terms[$termIndex]->references); $rIndex++)
			{
				include "TermContent/references.php";
			}
		endif;
		if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->transactions)):
			for ($tIndex = 0; $tIndex < count($entries[$index]->languages[$lIndex]->terms[$termIndex]->transactions); $tIndex++)
			{
				include "TermContent/references.php";
			}
		endif;
		if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->contexts)):
			for ($contIndex = 0; $contIndex < count($entries[$index]->languages[$lIndex]->terms[$termIndex]->contexts); $contIndex++)
			{
				include "TermContent/contexts.php";
			}
		endif;
	?>
</div>
