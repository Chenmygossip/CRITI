<?php

if (empty($_POST) && empty($_GET))
{
	header("Location: index.php");
}

$baseId = (!empty($_POST['baseId']))? $_POST['baseId'] : $_GET['id'];

$termbase = new termbase();
$termbase->loadFromId($baseId);
echo print_r($termbase, true);
$people = json_decode($termbase->getPeople());
$result = "No action yet taken.";

if (!empty($_POST['submit']))
{
	$person = new person();
	$person->createFromValues($_POST['id'],$_POST['email'],$_POST['fn'],$_POST['role']);
	$result = $termbase->updatePerson($person);

	header("Location: editPeople.php?id=".$baseId);
}
else if (!empty($_POST['delete']))
{
	$person = new person();
	$person->createFromValues($_POST['id'],$_POST['email'],$_POST['fn'],$_POST['role']);
	$result = $termbase->deletePerson($person);

	header("Location: editPeople.php?id=".$baseId);
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<title>Edit People</title>
	</head>
	<body>
		
		
			<?php
			
				foreach ($people as $p)
				{
					$person = new person();
					$person->createFromObject($p);
					
					echo "
						<form action='' method='post' enctype='multipart/form-data'>
							<label for='id'>ID:</label>
							<input type='text' value='". $person->id ."' id='id' name='id'/>
							<label for='email'>Email:</label>
							<input type='text' value='". $person->email ."' id='email' name='email'/>
							<label for='fn'>Full Name:</label>
							<input type='text' value='". $person->fn ."' id='fn' name='fn'/>
							<label for='role'>Role:</label>
							<input type='text' value='". $person->role ."' id='role' name='role'/>
							<input type='hidden' value='". $baseId ."' name='baseId' />
							<input type='submit' value='Save Changes' name='submit' id='submit' />
							<input type='submit' value='Delete Person' name='delete' />
						</form>
					";
				}
			
			?>
			
		<div>
			<p>
				<?php echo $result; ?>
			</p>
		</div>
	</body>
</html>
