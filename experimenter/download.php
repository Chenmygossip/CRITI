<?php

if (!empty($_POST['exportTermbase']))
{
	$termbase = new termbase();
	$termbase->loadFromId($_POST['baseId']);
	
	$termbase->exportToFile();
}
?>
