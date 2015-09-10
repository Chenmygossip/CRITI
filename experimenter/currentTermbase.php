<?php
session_start();
if (empty($_GET) && empty($_POST))
{
	header("Location: index.php");
}

$baseId = (!empty($_POST['baseId']))? $_POST['baseId'] : $_GET['id'];

$result = (!empty($_SESSION['result'])) ? json_encode($_SESSION['result']) : "No action requested yet.";
$index = (!empty($_POST['currentIndex'])) ? $_POST['currentIndex'] : 0;

$termbase = new termbase();
$termbase->loadFromId($baseId);

if (!empty($_POST['updateTermbase']))
{
	$termbase->baseId = $_POST['baseIdSet'];
	$termbase->working_language = $_POST['workingLanguage'];
	$termbase->name = $_POST['termbaseName'];
	$result = $termbase->update();
	
	if ($termbase->baseId != $baseId)
	{
		$termbase->loadFromId($termbase->id);
	}
}
else if (!empty($_POST['deleteTermbase']))
{
	$output = $termbase->delete();
	header("Location: index.php");
}
$termbaseInfo = $termbase->get();
$entries = json_decode($termbase->getEntries());

if (!empty($_POST['numberOfMatches']))
{
	for ($i = 0; $i < $_POST['numberOfMatches']; $i++)
	{
		if (!empty($_POST['match_'.$i]))
		{
			$index = $i;
			break;
		}
	}
}
else if (!empty($_POST['searchTermSubmit']))
{
	if (!empty($_POST['searchTerm']) && $_POST['searchTerm'] != "")
	{
		$matches = array();
		
		$i = 0;
		foreach($entries as $entry)
		{
			foreach ($entry->languages as $lang)
			{
				foreach ($lang->terms as $term)
				{
					if (preg_match('/'.$_POST['searchTerm'].'/i', $term->term))
					{
						$matchInfo = (object) array('id'=>$entry->id, 'index'=>$i, 'term'=>$term->term);
						array_push($matches, $matchInfo);
					}
				}
			}
			$i++;
		}
	}
}
else if (!empty($_POST['previousEntry']))
{
	if ($index - 1 < 0)
	{
		$index = count($entries) - 1;
	}
	else
	{
		$index--;
	}
}
else if (!empty($_POST['nextEntry']))
{
	if ($index + 1 > count($entries) - 1)
	{
		$index = 0;
	}
	else
	{
		$index++;
	}
}
else if (!empty($_POST['updateEntry']))
{
	include "updateEntryCode.php";
	
	$result = $termbase->updateEntry($entry);
	
	$entries = json_decode($termbase->getEntries()); //refresh entries
}
else if (!empty($_POST['deleteEntry']))
{
	$result = $termbase->deleteEntry($_POST['entryId']);
	
	$entries = json_decode($termbase->getEntries()); //refresh entries
	$index = 0; //reset index
}


?>

<!DOCTYPE html />
<html>
	<head>
		<meta charset="UTF-8">
		<title>Current Termbase</title>
	</head>
	<body>
		<a href="index.php">Return Home</a>
		<?php
		
			echo $result;
		
		?>
		<form action='' enctype="multipart/form-data" method='post'>
			<div id='divEditPeople'>
				<input type='submit' formaction='editPeople.php' name='editPeople' value='Edit People'/>
			</div>
			<div id='divTermbaseInfo'>
				<input type='hidden' id='baseId' name='baseId' value='<?php echo $baseId; ?>' required />
				<label for='baseId'>Termbase Id:</label>
				<input type='text' id='baseIdSet' name='baseIdSet' value='<?php echo $baseId; ?>' required readonly />
				<label for='workingLanguage'>Working Language:</label>
				<input type='text' id='workingLanguage' name='workingLanguage' value='<?php echo $termbase->working_language; ?>' required />
				<label for='termbaseName'>Termbase Name</label>
				<input type='text' id='termbaseName' name='termbaseName' value='<?php echo $termbase->name; ?>' required />
				<input type='submit' id='updateTermbase' name='updateTermbase' value='Update Termbase Info' />
				<input type='submit' id='deleteTermbase' name='deleteTermbase' value='Delete Termbase' />
				<input type='submit' formaction='download.php' formnovalidate="formnovalidate" id='exportTermbase' name='exportTermbase' value='Export Termbase' />
			</div>
			<div id='entries'>
				<label for='searchTerms'>Search for entries containing a term:</label>
				<input type='text' id='searchTerm' name='searchTerm' />
				<input type='submit' id='searchTermSubmit' name='searchTermSubmit' formnovalidate="formnovalidate" value='Search for Term' />
				<?php
					if (!empty($matches))
					{ 
						echo "<p>The following entries seem to contain matches:</p>
								<input type='hidden' name='numberOfMatches' value='".count($matches)."' />";
						$i = 0;
						foreach ($matches as $match)
						{
							echo "<div>
									<label for='match_".$i."'>Entry: ".$match->id." - Term: ". $match->term ."</label>
									<input type='submit' formnovalidate='formnovalidate' name='match_".$match->index."' value='View this Entry' />
								</div>";
						}
					}
				?>
				<p>There are <?php echo count($entries); ?> entries.</p>
				<input type='submit' formnovalidate="formnovalidate" value='Previous Entry' name='previousEntry' />
				<input type='submit' formnovalidate="formnovalidate" value='Next Entry' name='nextEntry' />
				<input type='submit' value='Update Entry Changes' name='updateEntry' />
				<input type='submit' formnovalidate="formnovalidate" value='Delete Entry' name='deleteEntry' />
				<input type='submit' formnovalidate='formnovalidate' formaction='addEntry.php' name='addEntry' value='Add New Entry' />
				<input type='hidden' name='currentIndex' value='<?php echo $index; ?>' />
				<?php
					include "Templates/entries.php";
				?>
				
			</div>
		</form>
	</body>
</html>
