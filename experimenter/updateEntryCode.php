<?php

$languages = array();
	
	for ($lIndex = 0; $lIndex < count($entries[$index]->languages); $lIndex++)
	{
		if (!empty($_POST['langCode_'.$lIndex]))
		{
			$terms = array();
			for ($termIndex = 0; $termIndex < count($entries[$index]->languages[$lIndex]->terms); $termIndex++)
			{
				if (!empty($_POST['lang_'.$lIndex.'_termTerm_'.$termIndex])) $term = new term($_POST['lang_'.$lIndex.'_termTerm_'.$termIndex]);
				
				if (!empty($_POST['lang_'.$lIndex.'_termGender_'.$termIndex])) $term->gender = $_POST['lang_'.$lIndex.'_termGender_'.$termIndex];
				if (!empty($_POST['lang_'.$lIndex.'_termSource_'.$termIndex])) $term->source = $_POST['lang_'.$lIndex.'_termSource_'.$termIndex];
				if (!empty($_POST['lang_'.$lIndex.'_termStatus_'.$termIndex])) $term->status = $_POST['lang_'.$lIndex.'_termStatus_'.$termIndex];
				if (!empty($_POST['lang_'.$lIndex.'_termType_'.$termIndex])) $term->type = $_POST['lang_'.$lIndex.'_termType_'.$termIndex];
				if (!empty($_POST['lang_'.$lIndex.'_termGeo_'.$termIndex])) $term->geo = $_POST['lang_'.$lIndex.'_termGeo_'.$termIndex];
				if (!empty($_POST['lang_'.$lIndex.'_termPos_'.$termIndex])) $term->pos = $_POST['lang_'.$lIndex.'_termPos_'.$termIndex];
				if (!empty($_POST['lang_'.$lIndex.'_termLocation_'.$termIndex])) $term->location = $_POST['lang_'.$lIndex.'_termLocation_'.$termIndex];
				if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->projects)):
					for ($pIndex = 0; $pIndex < count($entries[$index]->languages[$lIndex]->terms[$termIndex]->projects); $pIndex++)
					{
						if (!empty($_POST['lang_'.$lIndex.'_term_'.$termIndex.'_projectItem_'.$pIndex])) array_push($term->projects, $_POST['lang_'.$lIndex.'_term_'.$termIndex.'_projectItem_'.$pIndex]);
					}
				endif;
				if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->customers)):
					for ($cIndex = 0; $cIndex < count($entries[$index]->languages[$lIndex]->terms[$termIndex]->customers); $cIndex++)
					{
						if (!empty($_POST['lang_'.$lIndex.'_term_'.$termIndex.'_customerItem_'.$cIndex])) array_push($term->customers, $_POST['lang_'.$lIndex.'_term_'.$termIndex.'_customerItem_'.$cIndex]);
					}
				endif;
				if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->external_references)):
					for ($extrIndex = 0; $extrIndex < count($entries[$index]->languages[$lIndex]->terms[$termIndex]->external_references); $extrIndex++)
					{
						if (!empty($_POST['lang_'.$lIndex.'_term_'.$termIndex.'_extReferenceContent_'.$extrIndex]) && !empty($_POST['lang_'.$lIndex.'_term_'.$termIndex.'_extReferenceTarget_'.$extrIndex]))
						{
							$ext_ref = new external_reference(
											$_POST['lang_'.$lIndex.'_term_'.$termIndex.'_extReferenceContent_'.$extrIndex],
											$_POST['lang_'.$lIndex.'_term_'.$termIndex.'_extReferenceTarget_'.$extrIndex]
										);
							array_push($term->external_references, $ext_ref);
						}
					}
				endif;
				if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->references)):
					for ($rIndex = 0; $rIndex < count($entries[$index]->languages[$lIndex]->terms[$termIndex]->references); $rIndex++)
					{
						if (!empty($_POST['lang_'.$lIndex.'_term_'.$termIndex.'_referenceContent_'.$rIndex]) && !empty($_POST['lang_'.$lIndex.'_term_'.$termIndex.'_referenceTarget_'.$rIndex]))
						{
							$ref = new reference(
											$_POST['lang_'.$lIndex.'_term_'.$termIndex.'_referenceContent_'.$rIndex],
											$_POST['lang_'.$lIndex.'_term_'.$termIndex.'_referenceTarget_'.$rIndex]
										);
							array_push($term->references, $ref);
						}
					}
				endif;
				if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->transactions)):
					for ($tIndex = 0; $tIndex < count($entries[$index]->languages[$lIndex]->terms[$termIndex]->transactions); $tIndex++)
					{
						$transaction = new transaction();
						if (!empty($_POST['lang_'.$lIndex.'_term_'.$termIndex.'_transacPerson_'.$tIndex])) $transaction->person = $_POST['lang_'.$lIndex.'_term_'.$termIndex.'_transacPerson_'.$tIndex];
						if (!empty($_POST['lang_'.$lIndex.'_term_'.$termIndex.'_transacType_'.$tIndex])) $transaction->type = $_POST['lang_'.$lIndex.'_term_'.$termIndex.'_transacType'.$tIndex];
						if (!empty($_POST['lang_'.$lIndex.'_term_'.$termIndex.'_transacDate_'.$tIndex])) $transaction->date = $_POST['lang_'.$lIndex.'_term_'.$termIndex.'_transacDate_'.$tIndex];
						if (!empty($_POST['lang_'.$lIndex.'_term_'.$termIndex.'_transacTarget_'.$tIndex])) $transaction->target = $_POST['lang_'.$lIndex.'_term_'.$termIndex.'_transacTarget_'.$tIndex];
						
						array_push($term->transactions, $transaction);
					}
				endif;
				if (!empty($entries[$index]->languages[$lIndex]->terms[$termIndex]->contexts)):
					for ($contIndex = 0; $contIndex < count($entries[$index]->languages[$lIndex]->terms[$termIndex]->contexts); $contIndex++)
					{
						if (!empty($_POST['lang_'.$lIndex.'_term_'.$termIndex.'_contextContent_'.$contIndex]))
						{ 
							$context = new context($_POST['lang_'.$lIndex.'_term_'.$termIndex.'_contextContent_'.$contIndex]);
						
							if (!empty($_POST['lang_'.$lIndex.'_term_'.$termIndex.'_contextSource_'.$contIndex])) $context->source = $_POST['lang_'.$lIndex.'_term_'.$termIndex.'_contextSource_'.$contIndex];
						
							array_push($term->contexts, $context);
						}
					}
				endif;
				
				array_push($terms, $term);
			}
			
			
			
			$language = new language($_POST['langCode_'.$lIndex], $terms);
			
			if (!empty($entries[$index]->languages[$lIndex]->transactions)):
				for ($tIndex = 0; $tIndex < count($entries[$index]->languages[$lIndex]->transactions); $tIndex++)
				{
					$transaction = new transaction();
					if (!empty($_POST['lang_'.$lIndex.'_transacPerson_'.$tIndex])) $transaction->person = $_POST['lang_'.$lIndex.'_transacPerson_'.$tIndex];
					if (!empty($_POST['lang_'.$lIndex.'_transacType_'.$tIndex])) $transaction->type = $_POST['lang_'.$lIndex.'_transacType'.$tIndex];
					if (!empty($_POST['lang_'.$lIndex.'_transacDate_'.$tIndex])) $transaction->date = $_POST['lang_'.$lIndex.'_transacDate_'.$tIndex];
					if (!empty($_POST['lang_'.$lIndex.'_transacTarget_'.$tIndex])) $transaction->target = $_POST['lang_'.$lIndex.'_transacTarget_'.$tIndex];
					
					array_push($language->transactions, $transaction);
				}
			endif;
			if (!empty($entries[$index]->languages[$lIndex]->definitions)):
				for ($dIndex = 0; $dIndex < count($entries[$index]->languages[$lIndex]->definitions); $dIndex++)
				{
					if (!empty($_POST['lang_'.$lIndex.'_definitionContent_'.$dIndex]))
					{ 
						$definition = new definition($_POST['lang_'.$lIndex.'_definitionContent_'.$dIndex]);
					
						if (!empty($_POST['lang_'.$lIndex.'_definitionSource_'.$dIndex])) $definition->source = $_POST['lang_'.$lIndex.'_definitionSource_'.$dIndex];
					
						array_push($language->definitions, $definition);
					}
				}
			endif;
			
			array_push($languages, $language);
		}
	}
	
	
	$entry = new entry($languages);
	
	if (!empty($entries[$index]->images)):
		for ($imgIndex = 0; $imgIndex < count($entries[$index]->images); $imgIndex++)
		{
			if (!empty($_POST['imageContent_'.$imgIndex]) && !empty($_POST['imageTarget_'.$imgIndex]))
			{
				$image = new image(
								$_POST['imageContent_'.$imgIndex],
								$_POST['imageTarget_'.$imgIndex]
							);
				array_push($entry->images, $image);
			}
		}
	endif;
	if (!empty($entries[$index]->external_references)):
		for ($extrIndex = 0; $extrIndex < count($entries[$index]->external_references); $extrIndex++)
		{
			if (!empty($_POST['extReferenceContent_'.$extrIndex]) && !empty($_POST['extReferenceTarget_'.$extrIndex]))
			{
				$ext_ref = new external_reference(
								$_POST['extReferenceContent_'.$extrIndex],
								$_POST['extReferenceTarget_'.$extrIndex]
							);
				array_push($entry->external_references, $ext_ref);
			}
		}
	endif;
	if (!empty($entries[$index]->notes)):
		for ($nIndex = 0; $nIndex < count($entries[$index]->notes); $nIndex++)
		{
			if (!empty($_POST['noteItem_'.$nIndex])) array_push($entry->notes, $_POST['noteItem_'.$nIndex]);
		}
	endif;
	if (!empty($entries[$index]->definitions)):
		for ($dIndex = 0; $dIndex < count($entries[$index]->definitions); $dIndex++)
		{
			if (!empty($_POST['definitionContent_'.$dIndex]))
			{ 
				$definition = new definition($_POST['definitionContent_'.$dIndex]);
			
				if (!empty($_POST['definitionSource_'.$dIndex])) $definition->source = $_POST['definitionSource_'.$dIndex];
			
				array_push($entry->definitions, $context);
			}
		}
	endif;
	if (!empty($entries[$index]->transactions)):
		for ($tIndex = 0; $tIndex < count($entries[$index]->transactions); $tIndex++)
		{
			$transaction = new transaction();
			if (!empty($_POST['transacPerson_'.$tIndex])) $transaction->person = $_POST['transacPerson_'.$tIndex];
			if (!empty($_POST['transacType_'.$tIndex])) $transaction->type = $_POST['transacType'.$tIndex];
			if (!empty($_POST['transacDate_'.$tIndex])) $transaction->date = $_POST['transacDate_'.$tIndex];
			if (!empty($_POST['transacTarget_'.$tIndex])) $transaction->target = $_POST['transacTarget_'.$tIndex];
			
			array_push($entry->transactions, $transaction);
		}
	endif;
	if (!empty($entries[$index]->references)):
		for ($rIndex = 0; $rIndex < count($entries[$index]->references); $rIndex++)
		{
			if (!empty($_POST['referenceContent_'.$rIndex]) && !empty($_POST['referenceTarget_'.$rIndex]))
			{
				$ref = new reference(
								$_POST['referenceContent_'.$rIndex],
								$_POST['referenceTarget_'.$rIndex]
							);
				array_push($entry->references, $ref);
			}
		}
	endif;
	
	if (!empty($_POST['entrySubjectField'])) $entry->subject_field = $_POST['entrySubjectField'];
	if (!empty($_POST['entryId'])) $entry->id = $_POST['entryId'];
