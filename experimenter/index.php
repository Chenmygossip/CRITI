<?php

$output = "nothing yet";

if (!empty($_POST))
{
	echo "POSTED<br>";
	
	
	if (!empty($_FILES['tbxFile']))
	{
		
		echo "ATTEMPTING UPLOAD <br>";
		$isTBX = 0;
		
		$tmpFile = $_FILES['tbxFile']['tmp_name'];
		$fileName = basename($_FILES['tbxFile']['name']);
		
		$tbxi = new tbxImporter($tmpFile, $fileName);
		
		$output = $tbxi->post();
		
	}
	else if (!empty($_POST['btnListTermbases']))
	{
		$termbases = new termbases();
		
		$output = $termbases->get();
	}
	else if (!empty($_POST['baseId']))
	{
		$termbase = new termbase();
		$termbase->loadFromId($_POST['baseId']);

		if (!empty($_POST['showPeople']))
		{
			$output = $termbase->getPeople();
		}
		else if (!empty($_POST['editTermbase']))
		{
			header("Location: currentTermbase.php?id=".$_POST['baseId']);
		}
		else if (!empty($_POST['deleteTermbase']))
		{
			$output = $termbase->delete();
		}
		else
		{
			$output = $termbase->getEntries();
		}
	}
	else if (!empty($_POST['searchTermSubmit']))
	{
		$numberOfMatches = 0;
		if (!empty($_POST['searchTerm']) && $_POST['searchTerm'] != "")
		{
			$matches = array();
			
			$termbases = new termbases();
			$termbaseList = json_decode($termbases->get());
			
			$x = 0;
			
			foreach($termbaseList as $t)
			{
				$termbase = new termbase();
				$termbase->loadFromId($t->id);
				$entries = json_decode($termbase->getEntries());
				
				$i = 0;
				foreach($entries as $entry)
				{
					
					foreach ($entry->languages as $lang)
					{
						foreach ($lang->terms as $term)
						{
							if (preg_match('/'.$_POST['searchTerm'].'/i', $term->term))
							{
								$matchInfo = (object) array('id'=>$entry->id, 'baseId'=>$termbase->baseId, 'index'=>$i, 'term'=>$term->term);
								array_push($matches, $matchInfo);
								$numberOfMatches++;
							}
						}
					}
					$i++;
				}
				$x++;
			}
		}
	}
}


?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Experiment CRITI API</title>
	</head>
	<body>
		<div>
			<form action='' enctype="multipart/form-data" method='post'>
				<input type='file' name='tbxFile' id='tbxFile' required/>
				<input type='submit' name='importTBX' id='importTBX' value='Import TBX File' />
			</form>
			<form action='' enctype="multipart/form-data" method='post'>
				<input type='submit' id='btnListTermbases' name='btnListTermbases' value='List Termbases'/>
			</form>
			<form action='' enctype="multipart/form-data" method='post'>
				<label for='baseId'>Input Termbase Id</label>
				<input type='text' id='baseId' name='baseId' placeholder='termbase id' required />
				<input type='submit' id='findTermbase' name='findTermbase' value='Find Termbase'/>
				<input type='submit' id='editTermbase' name='editTermbase' value='Edit Termbase'/>
				<input type='submit' formaction='download.php' id='exportTermbase' name='exportTermbase' value='Export Termbase' />
				<input type='submit' id='showPeople' name='showPeople' value='Show People'/>
				<input type='submit' id='deleteTermbase' name='deleteTermbase' value='Delete Termbase' />
			</form>
			<form action='' enctype="multipart/form-data" method='post'>
				<label for='searchTerms'>Search for entries containing a term:</label>
				<input type='text' id='searchTerm' name='searchTerm' />
				<input type='submit' id='searchTermSubmit' name='searchTermSubmit' formnovalidate="formnovalidate" value='Search for Term' />
				<?php
					if (!empty($matches))
					{ 
						echo "<p>The following entries seem to contain matches:</p>
								<input type='hidden' name='numberOfMatches' value='".$numberOfMatches."' />";
						$i = 0;
						foreach ($matches as $match)
						{
							echo "<div>
									<label for='match_".$i."'>Termbase: ". $match->baseId ." - Entry: ".$match->id." - Term: ". $match->term ."</label>
									<input type='submit' formaction='currentTermbase.php?id=".$match->baseId."' formnovalidate='formnovalidate' name='match_".$match->index."' value='View this Entry' />
								</div>";
						}
					}
				?>
			</form>
		</div>
		<div id="output">
			<?php
				if ($output == "") $output = "Result was Empty String";
				echo $output;
			?>
		</div>
	</body>
</html>
