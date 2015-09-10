<?php

require_once('globals.php');
requireAllFromDir(APICALLS_DIR);
requireAllFromDir(CLASSES_DIR);


function requireAllFromDir($dir)
{
	foreach(glob($dir.'*.php') as $file)
	{
		require_once($file);
	}
}


?>
