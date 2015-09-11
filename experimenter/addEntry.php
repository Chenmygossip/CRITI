<?php
session_start();

if (empty($_POST['baseId']))
{
	header("Location: index.php");
}

$termbase = new termbase();
$termbase->loadFromId($_POST['baseId']);

$result = "Entry not yet submitted.";
if (!empty($_POST['createNew']))
{
	$term1 = new term($_POST['term1']);
	$term2 = new term($_POST['term2']);
	
	$language1 = new language($_POST['langCode1'], array($term1));
	$language2 = new language($_POST['langCode2'], array($term2));
	$languages = array($language1, $language2);
	
	$entry = new entry($languages);
	
	$result = $termbase->addEntry($entry);
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'/>
		<title>Add New Entry</title>
	</head>
	<body>
		<a href="index.php">Return Home</a>
		<a href="currentTermbase.php?id=<?php echo $termbase->baseId; ?>">Return to Termbase</a>
		<p>Adding Entry to Termbase: <?php echo $termbase->baseId; ?></p>
		<p>Note, this API exerciser only asks for the minimum for validation in order to demonstrate a simple Entry creation.</p>
		<p>The exception is that it asks for two language sets for testing.</p>
		
		<form action='' enctype='multipart/form-data' method='post'>
			<div>
				<label for='entryId'>Entry ID:</label>
				<input type='text' id='entryId' name='entryId' required />
			</div>
			<div>
				<label for='subjectField'>Subject Field:</label>
				<input type='text' id='subjectField' name='subjectField' />
			</div>
			<div>
				<br>
				<p>First Language</p>
				<div>
					<label for='langCode1'>Language Code:</label>
					<input type='text' id='langCode1' name='langCode1' required />
				</div>
				<div>
					<label for='term1'>Term:</label>
					<input type='text' id='term1' name='term1' required />
				</div>
				<br>
				<p>Second Language</p>
				<div>
					<label for='langCode2'>Language Code:</label>
					<input type='text' id='langCode2' name='langCode2' required />
				</div>
				<div>
					<label for='term2'>Term:</label>
					<input type='text' id='term2' name='term2' required />
				</div>
			</div>
			<input type='hidden' id='baseId' name='baseId' value='<?php echo $termbase->baseId; ?>' required />
			<input type='submit' name='createNew' value='Create Entry' />
		</form>
		<div>
			<p><?php echo $result; ?></p>
		</div>
	</body>
</html>
