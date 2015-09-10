<div>
	<label for='entryId'>Entry ID:</label>
	<input type='text' id='entryId' name='entryId' value='<?php if (!empty($entries[$index]->id)) echo $entries[$index]->id; ?>' readonly />
	<label for='entrySubjectField'>Subject Field:</label>
	<input type='text' id='entrySubjectField' name='entrySubjectField' value='<?php if (!empty($entries[$index]->subject_field)) echo $entries[$index]->subject_field; ?>' />
	<?php
		if (!empty($entries[$index]->references)):
			for ($rIndex = 0; $rIndex < count($entries[$index]->references); $rIndex++)
			{
				include "EntryContent/references.php";
			}
		endif;
		if (!empty($entries[$index]->transactions)):
			for ($tIndex = 0; $tIndex < count($entries[$index]->transactions); $tIndex++)
			{
				include "EntryContent/transactions.php";
			}
		endif;
		if (!empty($entries[$index]->definitions)):
			for ($dIndex = 0; $dIndex < count($entries[$index]->definitions); $dIndex++)
			{
				include "EntryContent/definitions.php";
			}
		endif;
		if (!empty($entries[$index]->notes)):
			for ($nIndex = 0; $nIndex < count($entries[$index]->notes); $nIndex++)
			{
				include "EntryContent/notes.php";
			}
		endif;
		if (!empty($entries[$index]->external_references)):
			for ($extrIndex = 0; $extrIndex < count($entries[$index]->external_references); $extrIndex++)
			{
				include "EntryContent/external_references.php";
			}
		endif;
		if (!empty($entries[$index]->images)):
			for ($imgIndex = 0; $imgIndex < count($entries[$index]->images); $imgIndex++)
			{
				include "EntryContent/images.php";
			}
		endif;
		if (!empty($entries[$index]->languages)):
			for ($lIndex = 0; $lIndex < count($entries[$index]->languages); $lIndex++)
			{
				include "EntryContent/languages.php";
			}
		endif;
	?>	
</div>
